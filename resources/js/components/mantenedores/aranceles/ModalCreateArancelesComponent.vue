<template>
    <div class="modal fade xd2" id="modalCrearArancel"  tabindex="-1" role="dialog"
          data-keyboard="false" data-backdrop="static">
          <page-loader v-if="loading==true"/>
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center">CREAR ARANCEL</h5>
                </div>
                <div class="modal-body">
                    <form  @submit.prevent="guardarAranceles">
                        <div class="row">
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Año:</label>
                                <select id="2" class="form-control" v-model="arancel.anio" >
                                    <option value="" :selected="true">Seleccionar:</option>
                                    <option v-for="(year, index) in years" :key="index" :value="year">{{ year }}</option>
                                </select>
                                <div v-if="enviado && !$v.arancel.anio.required" class="mensajeError">
                                    Debe seleccionar el año.
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Número:</label>
                                <input type="text"  class="form-control" v-model="arancel.numero" >
                                <div v-if="enviado && (!$v.arancel.numero.required)" class="mensajeError">
                                    Debe rellenar el número
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Cuadra:</label>
                                <input type="text"  class="form-control" v-model="arancel.cuadra" >
                                <div v-if="enviado && (!$v.arancel.cuadra.required)" class="mensajeError">
                                    Debe rellenar la cuadra
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Importe:</label>
                                <input type="text"  class="form-control" v-model="arancel.importe" >
                                <div v-if="enviado && (!$v.arancel.importe.required)" class="mensajeError">
                                    Debe rellenar el importe
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-12 col-md-4">
                                <label class="form-label" for="lname">Lado:</label>
                                <select id="2" class="form-control" v-model="arancel.lado" >
                                    <option value="" :selected="true">Seleccionar:</option>
                                    <option v-for="(item, index) in todostipolado" :key="index" :value="item.valor">{{ item.descripcion }}</option>
                                </select>
                                 <div v-if="enviado && !$v.arancel.lado.required" class="mensajeError">
                                    Debe seleccionar el lado.
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-8">
                                <label class="form-label" for="lname">Vía - Junta:</label>
                                <select id="2" class="form-control" v-model="arancel.junta_via" >
                                    <option value="" :selected="true">Seleccionar:</option>
                                    <option v-for="(item, index) in todostipojunta" :key="index" :value="item.jv_valor">{{ item.jv_descripcion }}</option>
                                </select>
                                <div v-if="enviado && (!$v.arancel.junta_via.required)" class="mensajeError">
                                    Debe seleccionar la Vía - Junta
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                            </div>
                            <div class="mb-3 col-12 col-md-4" style="margin-top:2%">
                                <button type="submit" 
                                    class="btn btn-primary btn-pill"><i class="fa fa-save nav-icon" aria-hidden="true" ></i>
                                    Grabar
                                </button>
                                <button type="button"
                                    class="btn btn-danger btn-pill"  @click="closeModalAgregarAranceles()"
                                    ><i class="icon-close"></i>
                                    Cerrar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</template>


<script lang="js">
    import axios from 'axios'
    import { required, email , minLength } from "vuelidate/lib/validators";

    export default {
        data(){
            return{

                todostipolado:[],
                todostipojunta:[],

                arancel:{
                    anio:'',
                    numero:'',
                    cuadra:'',
                    importe:'',
                    lado:'',
                    junta_via:''
                },

                loading:false,
                enviado:false,
                validado:''
            }
        },
        methods:{
            guardarAranceles(){
                this.loading=true;
                this.enviado=true;
                this.$v.$touch();
                if (this.$v.$invalid) {
                    this.loading=false;
                    return;
                }else{
                    let formData = new FormData()
                    formData.append('anio',this.arancel.anio)
                    formData.append('numero',this.arancel.numero)
                    formData.append('cuadra',this.arancel.cuadra)
                    formData.append('importe',this.arancel.importe)
                    formData.append('lado',this.arancel.lado)
                    formData.append('junta_via',this.arancel.junta_via)
                    var request ={
                        url:`${this.variableGlobal}/store-data-aranceles`,
                        method:'post',
                        data:formData
                    }
                    axios(request).then(({data}) => {
                    if (data) {
                            this.$swal.fire({
                                icon: 'success',
                                title: 'GUARDADO!',
                                text: "Se registro exitosamente",
                                showConfirmButton: false,
                                timer: 2500
                            })
                    }else{
                        this.$swal.fire({
                            icon: 'warning',
                            title: '¡Error!',
                            text: `Ya existe registro con este código.`,
                            showConfirmButton: false,
                            timer: 2500
                        })
                    }
                    });
                    this.loading=false;
                    this.closeModalAgregarAranceles();
                }
            },
            closeModalAgregarAranceles(){
                this.limpiarAranceles();
                $('#modalCrearArancel').modal('hide');
                Bus.$emit("DetalleCreateAranceles");
            },

            limpiarAranceles(){
                    this.arancel.anio='',
                    this.arancel.numero=''
                    this.arancel.cuadra='',
                    this.arancel.importe=''
                    this.arancel.lado='',
                    this.arancel.junta_via=''
            },

            getTipoLado(){
                axios.get(`${this.variableGlobal}/lista-tipolado-text`).then(({data}) => {
                    this.todostipolado = data;
                }).catch((error) => {
                    console.log(error);
                });
            },
            getTipoJunta(){
                axios.get(`${this.variableGlobal}/lista-tipojunta-text`).then(({data}) => {
                    this.todostipojunta = data;
                }).catch((error) => {
                    console.log(error);
                });
            }
        },
        created() {
            this.getTipoLado();
            this.getTipoJunta();
        },
        validations () {
            return {
                arancel:{
                    anio:{ required },
                    numero:{required},
                    cuadra:{ required },
                    importe:{required},
                    lado:{ required },
                    junta_via:{required},
                }
            }
        },
        computed:{
            //ARRAY DE AÑOS
            years () {
                const year = new Date().getFullYear()
                return Array.from({length: year - 2010}, (value, index) => 2011 + index).reverse();
            }
        }
    }
</script>


