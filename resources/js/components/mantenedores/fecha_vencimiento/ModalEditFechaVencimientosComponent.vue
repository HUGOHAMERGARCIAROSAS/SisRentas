<template>
    <div class="modal fade xd2" id="modalProcesoEditFechaVencimientos"  tabindex="-1" role="dialog"
          data-keyboard="false" data-backdrop="static">
          <page-loader v-if="loading==true"/>
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center">EDITAR FECHA DE VENCIMIENTO</h5>
                </div>
                <div class="modal-body">
                    <form  @submit.prevent="editarfechasVencimiento">
                        <div class="row">
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Año:</label>
                                <input type="text"  class="form-control" v-model="fechaVencimiento.anio" readonly>
                            </div>
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Mes:</label>
                                <input type="text"  class="form-control" v-model="fechaVencimiento.mes" readonly>
                            </div>
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Vence Arbitrios:</label>
                                <input type="date"  class="form-control" v-model="fechaVencimiento.varbitrios" >
                                <div v-if="enviado && (!$v.fechaVencimiento.varbitrios.required)" class="mensajeError">
                                    Debe rellenar la la fecha de vencimiento de arbitrios.
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Vence Predial:</label>
                                <input type="date"  class="form-control" v-model="fechaVencimiento.vpredial" >
                                <div v-if="enviado && (!$v.fechaVencimiento.vpredial.required)" class="mensajeError">
                                    Debe rellenar la la fecha de vencimiento del predial.
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
                                    class="btn btn-danger btn-pill"  @click="closeModalEditarFechaVencimientoOut()"
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
                meses:[],
                fechaVencimiento:{
                    anio:'',
                    mes:'',
                    varbitrios:'',
                    vpredial:'',
                    parametro_mes_ID:''
                },
                loading:false,
                enviado:false,
                validado:'',

                selectEditFechaVencimiento:''
            }
        },
        methods:{
            // GUARDAR FECHAS DE VENCIMIENTO
            editarfechasVencimiento(){
                this.loading=true;
                this.enviado=true;
                this.$v.$touch();
                if (this.$v.$invalid) {
                    this.loading=false;
                    return;
                }else{
                    let formData = new FormData()
                    formData.append('varbitrios',this.fechaVencimiento.varbitrios)
                    formData.append('vpredial',this.fechaVencimiento.vpredial)
                    formData.append('parametro_mes_ID',this.fechaVencimiento.parametro_mes_ID)
                    var request ={
                        url:`${this.variableGlobal}/update-data-fecha-vencimientos`,
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
                            this.loading=false;
                            this.closeModalEditarFechaVencimiento();
                        }
                    });

                }
            },
            //CERRAR MODAL CON ACCCION
            closeModalEditarFechaVencimiento(){
                $('#modalProcesoEditFechaVencimientos').modal('hide');
                Bus.$emit("DetalleUpdateFechaVencimiento");
            },
            //CERRAR MODAL SIN ACCION
            closeModalEditarFechaVencimientoOut(){
                $('#modalProcesoEditFechaVencimientos').modal('hide');
            },
            //OBTENER OBJETO A EDITAR
            getFechaVencimiento(){
                 axios.get(`${this.variableGlobal}/datos-fecha-vencimientos-edit/`+this.selectEditFechaVencimiento).then(({data}) => {
                    this.fechaVencimiento = data[0];
                    this.loading=false;
                }).catch((error) => {
                    console.log(error);
                });
            }
        },
        created() {
            Bus.$on("modalEditarFechaVencimientos", (data) => {
                this.loading=true;
                this.selectEditFechaVencimiento=data;
                this.getFechaVencimiento(this.selectEditFechaVencimiento);
            });

        },
        validations () {
            return {
                fechaVencimiento:{
                    varbitrios:{required},
                    vpredial:{required}
                }
            }
        }
    }
</script>


