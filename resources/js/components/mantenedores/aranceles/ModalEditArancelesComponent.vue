<template>
    <div class="modal fade xd2" id="modalProcesoEditAranceles"  tabindex="-1" role="dialog"
          data-keyboard="false" data-backdrop="static">
          <page-loader v-if="loading==true"/>
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center">EDITAR ARANCEL</h5>
                </div>
                <div class="modal-body">
                    <form  @submit.prevent="editarAranceles">
                        <div class="row">
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Año:</label>
                                <input type="text"  class="form-control" v-model="arancel.anio" readonly>
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
                                    class="btn btn-danger btn-pill"  @click="closeModalEditarArancelesOut()"
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
                    junta_via:'',
                    arancel_id:''
                },

                loading:false,
                enviado:false,
                validado:'',
                selectEditArancel:''
            }
        },
        methods:{
            editarAranceles(){
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
                    formData.append('arancel_id',this.arancel.arancel_id)
                    var request ={
                        url:`${this.variableGlobal}/update-data-aranceles`,
                        method:'post',
                        data:formData
                    }
                    axios(request).then(({data}) => {
                        if (data) {
                                this.$swal.fire({
                                    icon: 'success',
                                    title: 'ACTUALIZADO!',
                                    text: "Se actualizó exitosamente",
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
                $('#modalProcesoEditAranceles').modal('hide');
                Bus.$emit("DetalleUpdateAranceles");
            },
            closeModalEditarArancelesOut(){
                $('#modalProcesoEditAranceles').modal('hide');
            },

            getDataAranceles(id){
                axios.get(`${this.variableGlobal}/datos-aranceles-edit/`+id).then(({data}) => {
                    this.arancel = data[0];
                    this.arancel.junta_via=data[0].jv_valor;
                    this.arancel.importe=data[0].arancel_monto;
                    this.arancel.arancel_id=this.selectEditArancel;
                    this.loading=false;
                }).catch((error) => {
                    console.log(error);
                });
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
            Bus.$on("modalEditarAranceles", (data) => {
                this.loading=true;
                this.selectEditArancel=data;
                this.getDataAranceles(this.selectEditArancel);
            });
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
        }
    }
</script>


