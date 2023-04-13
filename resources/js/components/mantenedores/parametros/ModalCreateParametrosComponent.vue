<template>
    <div class="modal fade xd2" id="modalCrearParametros"  tabindex="-1" role="dialog"
          data-keyboard="false" data-backdrop="static">
          <page-loader v-if="loading==true"/>
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center">CREAR PARAMETROS</h5>
                </div>
                <div class="modal-body">
                    <form  @submit.prevent="guardarParametros">
                        <div class="row">
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Año:</label>
                                <select id="2" class="form-control" v-model="parametro.anio" >
                                    <option value="" :selected="true">Seleccionar:</option>
                                    <option v-for="(year, index) in years" :key="index" :value="year">{{ year }}</option>
                                </select>
                                <div v-if="enviado && !$v.parametro.anio.required" class="mensajeError">
                                    Debe seleccionar el año.
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Código:</label>
                                <input type="text"  class="form-control" v-model="parametro.codigo" >
                                <div v-if="enviado && (!$v.parametro.codigo.required)" class="mensajeError">
                                    Debe rellenar el código
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Descripción:</label>
                                <input type="text"  class="form-control" v-model="parametro.descripcion" >
                                <div v-if="enviado && (!$v.parametro.descripcion.required)" class="mensajeError">
                                    Debe rellenar la descripcion
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Valor:</label>
                                <input type="text"  class="form-control" v-model="parametro.valor" >
                                <div v-if="enviado && (!$v.parametro.valor.required)" class="mensajeError">
                                    Debe rellenar el valor
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
                                    class="btn btn-danger btn-pill"  @click="closeModalAgregarParametro()"
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

                parametro:{
                    anio:'',
                    codigo:'',
                    descripcion:'',
                    valor:'',
                },

                loading:false,
                enviado:false,
                validado:''
            }
        },
        methods:{
            guardarParametros(){
                this.loading=true;
                this.enviado=true;
                this.$v.$touch();
                if (this.$v.$invalid) {
                    this.loading=false;
                    return;
                }else{
                    let formData = new FormData()
                    formData.append('anio',this.parametro.anio)
                    formData.append('codigo',this.parametro.codigo)
                    formData.append('descripcion',this.parametro.descripcion)
                    formData.append('valor',this.parametro.valor)
                    var request ={
                        url:`${this.variableGlobal}/store-data-parametros`,
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
                                    icon: 'error',
                                    title: 'NO GUARDADO!',
                                    text: "Error al registrar, ya existe un registro con ese código y el año.",
                                    showConfirmButton: false,
                                    timer: 3500
                                })
                        }
                    });
                    this.loading=false;
                    this.closeModalAgregarParametro();
                }
            },
            closeModalAgregarParametro(){
                this.limpiarParametro();
                $('#modalCrearParametros').modal('hide');
                Bus.$emit("DetalleCreateParametro");
            },
            closeModalAgregarParametroOut(){
                this.limpiarParametro();
                $('#modalCrearParametros').modal('hide');
            },
            limpiarParametro(){
                    this.parametro.anio='',
                    this.parametro.codigo=''
                    this.parametro.descripcion='',
                    this.parametro.valor=''
            },
        },
        created() {
        },
        validations () {
            return {
                parametro:{
                    anio:{ required },
                    codigo:{required},
                    descripcion:{ required },
                    valor:{required}
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


