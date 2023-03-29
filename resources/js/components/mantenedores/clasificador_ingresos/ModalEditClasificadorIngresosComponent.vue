<template>
    <div class="modal fade xd2" id="modalProcesoEditClasificadorIngresos"  tabindex="-1" role="dialog"
          data-keyboard="false" data-backdrop="static">
          <page-loader v-if="loading==true"/>
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center">CREAR CLASIFICADOR DE INGRESOS</h5>
                </div>
                <div class="modal-body">
                    <form  @submit.prevent="editarClasificadorIngresos">
                        <div class="row">
                            <div class="mb-3 col-12 col-md-2">
                                <label class="form-label" for="lname">Año:</label>
                                <select id="2" class="form-control" v-model="clasificador.anio" readonly>
                                    <option value="" :selected="true">Seleccionar:</option>
                                    <option v-for="(year, index) in years" :key="index" :value="year">{{ year }}</option>
                                </select>
                                <div v-if="enviado && !$v.clasificador.anio.required" class="mensajeError">
                                    Debe seleccionar el año.
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-5">
                                <label class="form-label" for="lname">Código Presupuestal:</label>
                                <input type="text"  class="form-control" v-model="clasificador.codigo_presupuestal" >
                                <div v-if="enviado && (!$v.clasificador.codigo_presupuestal.required)" class="mensajeError">
                                    Debe rellenar el código presupuestal.
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-5">
                                <label class="form-label" for="lname">Descripción:</label>
                                <input type="text"  class="form-control" v-model="clasificador.descripcion" >
                                <div v-if="enviado && (!$v.clasificador.descripcion.required)" class="mensajeError">
                                    Debe rellenar la descripción.
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-12 col-md-6">
                                <label class="form-label" for="lname">Cta Contable:</label>
                                <input type="text"  class="form-control" v-model="clasificador.contable" >
                            </div>
                            <div class="mb-3 col-12 col-md-6">
                                <label class="form-label" for="lname">Cta Ant Contable:</label>
                                <input type="text"  class="form-control" v-model="clasificador.contableant" >
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
                                    class="btn btn-danger btn-pill"  @click="closeModalEditarClasificadorIngresosOut()"
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
                clasificador:{
                    anio:'',
                    codigo:'',
                    codigo_presupuestal:'',
                    descripcion:'',
                    contable:'',
                    contableant:''
                },

                loading:false,
                enviado:false,
                validado:'',

                selectEditClasificadorIngresos:''
            }
        },
        methods:{
            //ACTUALIZAR REGISTRO
            editarClasificadorIngresos(){
                this.loading=true;
                this.enviado=true;
                this.$v.$touch();
                if (this.$v.$invalid) {
                    this.loading=false;
                    return;
                }else{
                    let formData = new FormData()
                    formData.append('anio',this.clasificador.anio)
                    formData.append('codigo',this.clasificador.codigo)
                    formData.append('codigo_presupuestal',this.clasificador.codigo_presupuestal)
                    formData.append('descripcion',this.clasificador.descripcion)
                    formData.append('contable',this.clasificador.contable)
                    formData.append('contableant',this.clasificador.contableant)
                    var request ={
                        url:`${this.variableGlobal}/update-data-clasificador-ingresos`,
                        method:'post',
                        data:formData
                    }
                    axios(request).then(({data}) => {
                        if (data) {
                            this.$swal.fire({
                                icon: 'success',
                                title: 'GUARDADO!',
                                text: "Se actualizó exitosamente",
                                showConfirmButton: false,
                                timer: 2500
                            })
                        }
                    });
                    this.loading=false;
                    this.closeModalEditarClasificadorIngresos();
                }
            },
            //CERRAR MODAL CON RENDERIZADO DE LISTADO
            closeModalEditarClasificadorIngresos(){
                $('#modalProcesoEditClasificadorIngresos').modal('hide');
                Bus.$emit("DetalleEditarClasificadorIngresos");
            },

            //CERRAR MODAL SIN ACCIONES
            closeModalEditarClasificadorIngresosOut(){
                $('#modalProcesoEditClasificadorIngresos').modal('hide');
            },
            //OBTENER DATOS A EDITAR
            getDataClasificadorIngresos(id){
                axios.get(`${this.variableGlobal}/datos-clasificador-ingresos-edit/`+id).then(({data}) => {
                    this.clasificador.anio = data[0].clai_anio;
                    this.clasificador.codigo = data[0].clai_codigo;
                    this.clasificador.descripcion = data[0].clai_descripcion;
                    this.clasificador.codigo_presupuestal = data[0].clai_presupuesto;
                    this.clasificador.contable = data[0].clai_contable;
                    this.clasificador.contableant = data[0].clai_contableant;
                    this.loading=false;
                }).catch((error) => {
                    console.log(error);
                });
            }
        },
        created() {
            //OBTENER ID DE LA FILA
            Bus.$on("modalEditarClasificadorIngresos", (data) => {
                this.loading=true;
                this.selectEditClasificadorIngresos=data;
                this.getDataClasificadorIngresos(this.selectEditClasificadorIngresos);
            });
        },
        validations () {
            return {
                    clasificador:{
                        anio:{ required },
                        codigo:{required},
                        codigo_presupuestal:{ required },
                        descripcion:{required}
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


