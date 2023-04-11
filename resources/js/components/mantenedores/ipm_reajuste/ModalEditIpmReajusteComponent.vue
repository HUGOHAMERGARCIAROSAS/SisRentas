<template>
    <div class="modal fade xd2" id="modalProcesoEditIpmReajuste"  tabindex="-1" role="dialog"
          data-keyboard="false" data-backdrop="static">
          <page-loader v-if="loading==true"/>
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center">EDITAR IPM REAJUSTE</h5>
                </div>
                <div class="modal-body">
                    <form  @submit.prevent="editarIpmReajuste">
                        <div class="row">
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Año:</label>
                                <input type="text"  class="form-control" v-model="ipm_reajuste.anio" readonly >
                            </div>
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Mes:</label>
                                <input type="text"  class="form-control" v-model="ipm_reajuste.mes" readonly >
                            </div>
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">V MENSUAL:</label>
                                <input type="text"  class="form-control" v-model="ipm_reajuste.mensual" >
                                <div v-if="enviado && (!$v.ipm_reajuste.mensual.required)" class="mensajeError">
                                    Debe rellenar el importe mensual
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">V ACUMULADO:</label>
                                <input type="text"  class="form-control" v-model="ipm_reajuste.acumulado" >
                                <div v-if="enviado && (!$v.ipm_reajuste.acumulado.required)" class="mensajeError">
                                    Debe rellenar el importe acumulado
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
                                    class="btn btn-danger btn-pill"  @click="closeModalEditarIpmReajusteOut()"
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
                ipm_reajuste:{
                    anio:'',
                    mes:'',
                    mensual:'',
                    acumulado:'',
                    idipm:''
                },

                loading:false,
                enviado:false,
                validado:'',
                selectEditIpmReajuste:''
            }
        },
        methods:{
            editarIpmReajuste(){
                this.loading=true;
                this.enviado=true;
                this.$v.$touch();
                if (this.$v.$invalid) {
                    this.loading=false;
                    return;
                }else{
                    let formData = new FormData()
                    formData.append('mensual',this.ipm_reajuste.mensual)
                    formData.append('acumulado',this.ipm_reajuste.acumulado)
                    formData.append('idipm',this.ipm_reajuste.idipm)
                    var request ={
                        url:`${this.variableGlobal}/update-data-ipm-reajuste`,
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
                    this.closeModalEditarIpmReajuste();
                }
            },
            closeModalEditarIpmReajuste(){
                $('#modalProcesoEditIpmReajuste').modal('hide');
                Bus.$emit("ProcesoEditIpmReajuste");
            },
            closeModalEditarIpmReajusteOut(){
                $('#modalProcesoEditIpmReajuste').modal('hide');
            },

            getDataIpmReajuste(id){
                axios.get(`${this.variableGlobal}/datos-ipm-reajuste-edit/`+id).then(({data}) => {
                    this.ipm_reajuste.idipm=this.selectEditIpmReajuste;
                    this.ipm_reajuste.mensual=data[0].vmensual;
                    this.ipm_reajuste.acumulado=data[0].vacumulada;
                    this.ipm_reajuste.mes=data[0].descripcion;
                    this.ipm_reajuste.anio=data[0].anio;
                    this.loading=false;
                }).catch((error) => {
                    console.log(error);
                });
            }
        },
        created() {
            Bus.$on("modalEditarIpmReajuste", (data) => {
                this.loading=true;
                this.selectEditIpmReajuste=data;
                this.getDataIpmReajuste(this.selectEditIpmReajuste);
            });
        },
        validations () {
            return {
                    ipm_reajuste:{
                        mensual:{ required },
                        acumulado:{required}
                }
            }
        }
    }
</script>


