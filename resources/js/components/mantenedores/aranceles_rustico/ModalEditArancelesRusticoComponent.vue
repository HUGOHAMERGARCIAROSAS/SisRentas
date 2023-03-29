<template>
    <div class="modal fade xd2" id="modalProcesoEditArancelesRusticos"  tabindex="-1" role="dialog"
          data-keyboard="false" data-backdrop="static">
          <page-loader v-if="loading==true"/>
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center">EDITAR ARANCEL RUSTICO</h5>
                </div>
                <div class="modal-body">
                    <form  @submit.prevent="editarArancelesRustico">
                        <div class="row">
                            <div class="mb-3 col-12 col-md-4">
                                <label class="form-label" for="lname">Año:</label>
                                <select id="2" class="form-control" v-model="arancelr.anio" >
                                    <option value="" :selected="true">Seleccionar:</option>
                                    <option v-for="(year, index) in years" :key="index" :value="year">{{ year }}</option>
                                </select>
                                <div v-if="enviado && !$v.arancelr.anio.required" class="mensajeError">
                                    Debe seleccionar el año.
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-8">
                                <label class="form-label" for="lname">Clasificación:</label>
                                <select id="2" class="form-control" v-model="arancelr.clasificacion" >
                                    <option value="" :selected="true">Seleccionar:</option>
                                    <option v-for="(item, index) in todostipoclasificacion" :key="index" :value="item.valor">{{ item.descripcion }}</option>
                                </select>
                                 <div v-if="enviado && !$v.arancelr.clasificacion.required" class="mensajeError">
                                    Debe seleccionar el clasificación.
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-12 col-md-4">
                                <label class="form-label" for="lname">Importe:</label>
                                <input type="text"  class="form-control" v-model="arancelr.importe" >
                                <div v-if="enviado && (!$v.arancelr.importe.required)" class="mensajeError">
                                    Debe rellenar el importe.
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-8">
                                <label class="form-label" for="lname">Categoría:</label>
                                <select id="2" class="form-control" v-model="arancelr.categoria" >
                                    <option value="" :selected="true">Seleccionar:</option>
                                    <option v-for="(item, index) in todostipocategoria" :key="index" :value="item.valor">{{ item.descripcion }}</option>
                                </select>
                                <div v-if="enviado && (!$v.arancelr.categoria.required)" class="mensajeError">
                                    Debe seleccionar la categoría.
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
                                    class="btn btn-danger btn-pill"  @click="closeModalAgregarArancelesRusticosOut()"
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

                todostipoclasificacion:[],
                todostipocategoria:[],

                arancelr:{
                    anio:'',
                    importe:'',
                    clasificacion:'',
                    categoria:'',
                    ararustico_ID:''
                },

                loading:false,
                enviado:false,
                validado:'',
                selectEditArancelRustico:''
            }
        },
        methods:{
            // EDITAR  ARANCEL RUSTICO
            editarArancelesRustico(){
                this.loading=true;
                this.enviado=true;
                this.$v.$touch();
                if (this.$v.$invalid) {
                    this.loading=false;
                    return;
                }else{
                    let formData = new FormData()
                    formData.append('anio',this.arancelr.anio)
                    formData.append('importe',this.arancelr.importe)
                    formData.append('clasificacion',this.arancelr.clasificacion)
                    formData.append('categoria',this.arancelr.categoria)
                    formData.append('arancelr_id',this.arancelr.ararustico_ID)
                    var request ={
                        url:`${this.variableGlobal}/update-data-aranceles-rustico`,
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
                        }
                    });
                    this.loading=false;
                    this.closeModalAgregarArancelesRusticos();
                }
            },
            //CERRAR MODAL CON ACCION
            closeModalAgregarArancelesRusticos(){
                $('#modalProcesoEditArancelesRusticos').modal('hide');
                Bus.$emit("DetalleEditarArancelesRusticos");
            },

            //CERRAR MODAL SIN ACCION
            closeModalAgregarArancelesRusticosOut(){
                $('#modalProcesoEditArancelesRusticos').modal('hide');
            },
            // OBTENER CLASIFICACION DE ARANCEL RUSTICO
            getTipoClasificacion(){
                axios.get(`${this.variableGlobal}/lista-tipoclasificacion-arancelrustico-text`).then(({data}) => {
                    this.todostipoclasificacion = data;
                }).catch((error) => {
                    console.log(error);
                });
            },

            // OBTENER CATEGORIA DE ARANCEL RUSTICO
            getTipoCategoria(){
                axios.get(`${this.variableGlobal}/lista-tipocategoria-arancelrustico-text`).then(({data}) => {
                    this.todostipocategoria = data;
                }).catch((error) => {
                    console.log(error);
                });
            },
            //OBTENER LOS DATOS A EDITAR
            getArancelesRusticos(id){
                axios.get(`${this.variableGlobal}/datos-aranceles-rusticos-edit/`+id).then(({data}) => {
                    this.arancelr.anio=data[0].anio;
                    this.arancelr.ararustico_ID=data[0].ararustico_ID;
                    this.arancelr.categoria=data[0].tp_valor1;
                    this.arancelr.clasificacion=data[0].tp_valor;
                    this.arancelr.importe=data[0].valor;
                    this.loading=false;
                }).catch((error) => {
                    console.log(error);
                });
            },
        },
        created() {
            Bus.$on("modalEditarClasificadorIngresos", (data) => {
                this.loading=true;
                this.selectEditArancelRustico=data;
                this.getTipoClasificacion();
                this.getTipoCategoria();
                this.getArancelesRusticos(this.selectEditArancelRustico);
            });
        },
        validations () {
            return {
                arancelr:{
                    anio:{ required },
                    importe:{required},
                    clasificacion:{ required },
                    categoria:{required},
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


