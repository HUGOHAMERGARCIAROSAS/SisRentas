<template>
    <div class="modal fade xd2" id="modalProcesoEditIpmAlcabala"  tabindex="-1" role="dialog"
          data-keyboard="false" data-backdrop="static">
          <page-loader v-if="loading==true"/>
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center">EDITAR IPM ALCABALA</h5>
                </div>
                <div class="modal-body">
                    <form  @submit.prevent="editarIpmAlcabala">
                        <div class="row">
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Año:</label>
                                <input type="text"  class="form-control" v-model="ipm_alcabala.anio" readonly >
                            </div>
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Mes:</label>
                                <input type="text"  class="form-control" v-model="ipm_alcabala.mes" readonly >
                            </div>
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">V MENSUAL:</label>
                                <input type="text"  class="form-control" v-model="ipm_alcabala.mensual" >
                                <div v-if="enviado && (!$v.ipm_alcabala.mensual.required)" class="mensajeError">
                                    Debe rellenar el importe mensual
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">V ACUMULADO:</label>
                                <input type="text"  class="form-control" v-model="ipm_alcabala.acumulado" >
                                <div v-if="enviado && (!$v.ipm_alcabala.acumulado.required)" class="mensajeError">
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
                                    class="btn btn-danger btn-pill"  @click="closeModalEditarIpmAlcabalaOut()"
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
                ipm_alcabala:{
                    anio:'',
                    mes:'',
                    mensual:'',
                    acumulado:'',
                    idipm:''
                },

                loading:false,
                enviado:false,
                validado:'',
                selectEditIpmAlcabala:''
            }
        },
        methods:{
            editarIpmAlcabala(){
                this.loading=true;
                this.enviado=true;
                this.$v.$touch();
                if (this.$v.$invalid) {
                    this.loading=false;
                    return;
                }else{
                    let formData = new FormData()
                    formData.append('mensual',this.ipm_alcabala.mensual)
                    formData.append('acumulado',this.ipm_alcabala.acumulado)
                    formData.append('idipm',this.ipm_alcabala.idipm)
                    var request ={
                        url:`${this.variableGlobal}/update-data-ipm-alcabala`,
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
                    this.closeModalEditarIpmAlcabala();
                }
            },
            closeModalEditarIpmAlcabala(){
                $('#modalProcesoEditIpmAlcabala').modal('hide');
                Bus.$emit("ProcesoEditIpmAlcabala");
            },
            closeModalEditarIpmAlcabalaOut(){
                $('#modalProcesoEditIpmAlcabala').modal('hide');
            },

            getDataIpmAlcabala(id){
                axios.get(`${this.variableGlobal}/datos-ipm-alcabala-edit/`+id).then(({data}) => {
                    this.ipm_alcabala.idipm=this.selectEditIpmAlcabala;
                    this.ipm_alcabala.mensual=data[0].vmensual;
                    this.ipm_alcabala.acumulado=data[0].vacumulada;
                    this.ipm_alcabala.mes=data[0].descripcion;
                    this.ipm_alcabala.anio=data[0].anio;
                    this.loading=false;
                }).catch((error) => {
                    console.log(error);
                });
            }
        },
        created() {
            Bus.$on("modalEditarIpmAlcabala", (data) => {
                this.loading=true;
                this.selectEditIpmAlcabala=data;
                this.getDataIpmAlcabala(this.selectEditIpmAlcabala);
            });
        },
        validations () {
            return {
                    ipm_alcabala:{
                        mensual:{ required },
                        acumulado:{required}
                }
            }
        }
    }
</script>


