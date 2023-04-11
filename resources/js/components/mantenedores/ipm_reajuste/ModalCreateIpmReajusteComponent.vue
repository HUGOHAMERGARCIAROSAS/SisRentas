<template>
    <div class="modal fade xd2" id="modalCrearIpmReajuste"  tabindex="-1" role="dialog"
          data-keyboard="false" data-backdrop="static">
          <page-loader v-if="loading==true"/>
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center">CREAR IPM REAJUSTE</h5>
                </div>
                <div class="modal-body">
                    <form  @submit.prevent="guardarIpmReajuste">
                        <div class="row">
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Año:</label>
                                <select id="2" class="form-control" v-model="ipm_reajuste.anio" >
                                    <option value="" :selected="true">Seleccionar:</option>
                                    <option v-for="(year, index) in years" :key="index" :value="year">{{ year }}</option>
                                </select>
                                <div v-if="enviado && !$v.ipm_reajuste.anio.required" class="mensajeError">
                                    Debe seleccionar el año.
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Mes:</label>
                                <select id="2" class="form-control" v-model="ipm_reajuste.mes" >
                                    <option value="" :selected="true">Seleccionar:</option>
                                    <option v-for="(mes, index) in todos_meses" :key="index" :value="mes.valor">{{ mes.descripcion }}</option>
                                </select>
                                <div v-if="enviado && !$v.ipm_reajuste.anio.required" class="mensajeError">
                                    Debe seleccionar el mes.
                                </div>
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
                                    class="btn btn-danger btn-pill"  @click="closeModalAgregarIpmReajusteOut()"
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

                todos_meses:[],

                ipm_reajuste:{
                    anio:'',
                    mes:'',
                    mensual:'',
                    acumulado:'',
                },

                loading:false,
                enviado:false,
                validado:''
            }
        },
        methods:{
            guardarIpmReajuste(){
                this.loading=true;
                this.enviado=true;
                this.$v.$touch();
                if (this.$v.$invalid) {
                    this.loading=false;
                    return;
                }else{
                    let formData = new FormData()
                    formData.append('anio',this.ipm_reajuste.anio)
                    formData.append('mes',this.ipm_reajuste.mes)
                    formData.append('mensual',this.ipm_reajuste.mensual)
                    formData.append('acumulado',this.ipm_reajuste.acumulado)
                    var request ={
                        url:`${this.variableGlobal}/store-data-ipm-reajuste`,
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
                                    text: "Error al registrar, ya existe un registro con el año y mes seleccionado.",
                                    showConfirmButton: false,
                                    timer: 3500
                                })
                        }
                    });
                    this.loading=false;
                    this.closeModalAgregarIpmReajuste();
                }
            },
            closeModalAgregarIpmReajuste(){
                this.limpiarIpmReajuste();
                $('#modalCrearIpmReajuste').modal('hide');
                Bus.$emit("DetalleCreateIpmReajuste");
            },
            closeModalAgregarIpmReajusteOut(){
                this.limpiarIpmReajuste();
                $('#modalCrearIpmReajuste').modal('hide');
            },
            limpiarIpmReajuste(){
                    this.ipm_reajuste.anio='',
                    this.ipm_reajuste.mes=''
                    this.ipm_reajuste.mensual='',
                    this.ipm_reajuste.acumulado=''
            },
            getMeses(){
                axios.get(`${this.variableGlobal}/lista-general-combos-meses`).then(({data}) => {
                    this.todos_meses = data;
                }).catch((error) => {
                    console.log(error);
                });
            }
        },
        created() {
            this.getMeses();
        },
        validations () {
            return {
                ipm_reajuste:{
                    anio:{ required },
                    mes:{required},
                    mensual:{ required },
                    acumulado:{required}
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


