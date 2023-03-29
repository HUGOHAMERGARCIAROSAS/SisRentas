<template>
    <div class="modal fade xd2" id="modalCrearClasificadorIngresos"  tabindex="-1" role="dialog"
          data-keyboard="false" data-backdrop="static">
          <page-loader v-if="loading==true"/>
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center">CREAR CLASIFICADOR DE INGRESOS</h5>
                </div>
                <div class="modal-body">
                    <form  @submit.prevent="guardarClasificadorIngresos">
                        <div class="row">
                            <div class="mb-3 col-12 col-md-2">
                                <label class="form-label" for="lname">Año:</label>
                                <select id="2" class="form-control" v-model="clasificador.anio" >
                                    <option value="" :selected="true">Seleccionar:</option>
                                    <option v-for="(year, index) in years" :key="index" :value="year">{{ year }}</option>
                                </select>
                                <div v-if="enviado && !$v.clasificador.anio.required" class="mensajeError">
                                    Debe seleccionar el año.
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-2">
                                <label class="form-label" for="lname">Código:</label>
                                <input type="text"  class="form-control" v-model="clasificador.codigo" >
                                <div v-if="enviado && (!$v.clasificador.codigo.required)" class="mensajeError">
                                    Debe rellenar el código.
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-4">
                                <label class="form-label" for="lname">Código Presupuestal:</label>
                                <input type="text"  class="form-control" v-model="clasificador.codigo_presupuestal" >
                                <div v-if="enviado && (!$v.clasificador.codigo_presupuestal.required)" class="mensajeError">
                                    Debe rellenar el código presupuestal.
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-4">
                                <label class="form-label" for="lname">Descripción:</label>
                                <input type="text"  class="form-control" v-model="clasificador.descripcion" >
                                <div v-if="enviado && (!$v.clasificador.descripcion.required)" class="mensajeError">
                                    Debe rellenar la descripción.
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
                                    class="btn btn-danger btn-pill"  @click="closeModalAgregarClasificadorIngresosOut()"
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
                    descripcion:''
                },

                loading:false,
                enviado:false,
                validado:''
            }
        },
        methods:{
            guardarClasificadorIngresos(){
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
                    var request ={
                        url:`${this.variableGlobal}/store-data-clasificador-ingresos`,
                        method:'post',
                        data:formData
                    }
                    axios(request).then(({data}) => {
                        if (data) {
                            this.$swal.fire({
                                icon: 'success',
                                title: 'GUARDADO!',
                                text: "Se registró exitosamente",
                                showConfirmButton: false,
                                timer: 2500
                            })
                        }
                    });
                    this.loading=false;
                    this.closeModalAgregarClasificadorIngresos();
                }
            },
            closeModalAgregarClasificadorIngresos(){
                this.limpiarClasificadorIngresos();
                $('#modalCrearClasificadorIngresos').modal('hide');
                Bus.$emit("DetalleCreateClasificadorIngresos");
            },
            closeModalAgregarClasificadorIngresosOut(){
                this.limpiarClasificadorIngresos();
                $('#modalCrearClasificadorIngresos').modal('hide');
            },
            limpiarClasificadorIngresos(){
                this.clasificador.anio='',
                this.clasificador.codigo='',
                this.clasificador.codigo_presupuestal='',
                this.clasificador.descripcion=''
            }
        },
        // created() {
        // },
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


