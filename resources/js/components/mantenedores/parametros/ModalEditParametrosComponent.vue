<template>
    <div class="modal fade xd2" id="modalProcesoEditParametros"  tabindex="-1" role="dialog"
          data-keyboard="false" data-backdrop="static">
          <page-loader v-if="loading==true"/>
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center">EDITAR PARAMETROS</h5>
                </div>
                <div class="modal-body">
                    <form  @submit.prevent="editarParametros">
                        <div class="row">
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Año:</label>
                                <input type="text"  class="form-control" v-model="parametro.anio" readonly>
                            </div>
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Código:</label>
                                <input type="text"  class="form-control" v-model="parametro.codigo" readonly>
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
                                    class="btn btn-danger btn-pill"  @click="closeModalEditarParametrosOut()"
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
                    valor:'',
                    descripcion:'',
                    parametros_id:''
                },

                loading:false,
                enviado:false,
                validado:'',
                selectEditParametro:''
            }
        },
        methods:{
            editarParametros(){
                this.loading=true;
                this.enviado=true;
                this.$v.$touch();
                if (this.$v.$invalid) {
                    this.loading=false;
                    return;
                }else{
                    let formData = new FormData()
                    formData.append('valor',this.parametro.valor)
                    formData.append('descripcion',this.parametro.descripcion)
                    formData.append('parametros_id',this.parametro.parametros_id)
                    var request ={
                        url:`${this.variableGlobal}/update-data-parametros`,
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
                    this.closeModalEditarParametros();
                }
            },
            closeModalEditarParametros(){
                $('#modalProcesoEditParametros').modal('hide');
                Bus.$emit("ProcesoEditParametros");
            },
            closeModalEditarParametrosOut(){
                $('#modalProcesoEditParametros').modal('hide');
            },

            getDataParametros(id){
                axios.get(`${this.variableGlobal}/datos-parametros-edit/`+id).then(({data}) => {
                    this.parametro.parametros_id=this.selectEditParametro;
                    this.parametro.descripcion=data[0].descripcion;
                    this.parametro.valor=data[0].valor;
                    this.parametro.anio=data[0].anio;
                    this.parametro.codigo=data[0].codigo;
                    this.loading=false;
                }).catch((error) => {
                    console.log(error);
                });
            }
        },
        created() {
            Bus.$on("modalEditarParametros", (data) => {
                this.loading=true;
                this.selectEditParametro=data;
                this.getDataParametros(this.selectEditParametro);
            });
        },
        validations () {
            return {
                    parametro:{
                        descripcion:{ required },
                        valor:{required}
                }
            }
        }
    }
</script>


