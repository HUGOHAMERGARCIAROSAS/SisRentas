<template>
    <div class="modal fade xd2" id="modalCrearFechaVencimientos"  tabindex="-1" role="dialog"
          data-keyboard="false" data-backdrop="static">
          <page-loader v-if="loading==true"/>
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center">CREAR FECHA DE VENCIMIENTO</h5>
                </div>
                <div class="modal-body">
                    <form  @submit.prevent="guardarfechasVencimiento">
                        <div class="row">
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Año:</label>
                                <select id="2" class="form-control" v-model="fechaVencimiento.anio" >
                                    <option v-for="(year, index) in years" :key="index" :value="year">{{ year }}</option>
                                </select>
                                <div v-if="enviado && !$v.fechaVencimiento.anio.required" class="mensajeError">
                                    Debe seleccionar el año.
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Mes:</label>
                               <select id="2" class="form-control" v-model="fechaVencimiento.mes" >
                                    <option value="" :selected="true">Seleccionar:</option>
                                    <option v-for="(mes, index) in meses" :key="index" :value="mes.valor">{{ mes.descripcion }}</option>
                                </select>
                                <div v-if="enviado && (!$v.fechaVencimiento.mes.required)" class="mensajeError">
                                    Debe seleccionar el mes.
                                </div>
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
                                    class="btn btn-danger btn-pill"  @click="closeModalAgregarFechaVencimientoOut()"
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
                    vpredial:''
                },
                loading:false,
                enviado:false,
                validado:''
            }
        },
        methods:{
            // GUARDAR FECHAS DE VENCIMIENTO
            guardarfechasVencimiento(){
                this.loading=true;
                this.enviado=true;
                this.$v.$touch();
                if (this.$v.$invalid) {
                    this.loading=false;
                    return;
                }else{
                    let formData = new FormData()
                    formData.append('anio',this.fechaVencimiento.anio)
                    formData.append('mes',this.fechaVencimiento.mes)
                    formData.append('varbitrios',this.fechaVencimiento.varbitrios)
                    formData.append('vpredial',this.fechaVencimiento.vpredial)
                    var request ={
                        url:`${this.variableGlobal}/store-data-fecha-vencimientos`,
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
                            this.closeModalAgregarFechaVencimiento();
                        }else{
                            this.$swal.fire({
                                icon: 'error',
                                title: '¡Error!',
                                text: "Existe un registro con este mes.",
                                showConfirmButton: false,
                                timer: 2500
                            })
                            this.loading=false;
                        }
                    });

                }
            },
            //CERRAR MODAL CON ACCCION
            closeModalAgregarFechaVencimiento(){
                this.limpiarFechaVencimiento();
                $('#modalCrearFechaVencimientos').modal('hide');
                Bus.$emit("DetalleCreateFechaVencimiento");
            },
            //CERRAR MODAL SIN ACCION
            closeModalAgregarFechaVencimientoOut(){
                this.limpiarFechaVencimiento();
                $('#modalCrearFechaVencimientos').modal('hide');
            },
            //LIMPIEAR CAMPOS
            limpiarFechaVencimiento(){
                    this.fechaVencimiento.mes=''
                    this.fechaVencimiento.varbitrios='',
                    this.fechaVencimiento.vpredial=''
            },
            //OBTENER AÑO ACTUAL
            getAnioActual(){
                let anioActual = new Date().getFullYear()
                this.fechaVencimiento.anio=anioActual;
            },
            //OBTENER MESES
            getMeses(){
                 axios.get(`${this.variableGlobal}/lista-general-combos-meses`).then(({data}) => {
                    this.meses = data;
                }).catch((error) => {
                    console.log(error);
                });
            }
        },
        created() {
            this.getAnioActual();
            this.getMeses();

        },
        validations () {
            return {
                fechaVencimiento:{
                    anio:{ required },
                    mes:{required},
                    varbitrios:{required},
                    vpredial:{required}
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


