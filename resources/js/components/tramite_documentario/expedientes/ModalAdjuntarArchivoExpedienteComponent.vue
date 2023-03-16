<template>
    <div class="modal fade xd2" id="modalProcesoAdjuntarArchivoExpediente"  tabindex="10000" role="dialog"
          data-keyboard="false" data-backdrop="static">
          <page-loader v-if="loading==true"/>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">EDITAR EXPEDIENTE</h5>
                </div>
                <div class="modal-body">
                    <form  @submit.prevent="editarExpediente">
                        <div class="row">
                            <div class="mb-3 col-12 col-md-1">
                                <label>Fecha :</label>
                            </div>
                            <div class="mb-3 col-12 col-md-2">
                                <label>  <i class="fa fa-calendar"></i> {{expediente.fecha}} </label>  
                            </div>
                            <div class="mb-3 col-12 col-md-1">
                            </div>
                            <div class="mb-3 col-12 col-md-4"> 
                            </div>
                            <div class="mb-3 col-12 col-md-4">
                                <label>Expediente :</label>
                                <label>  {{expediente.coddocumento}}  - {{expediente.anio}}</label>  
                            </div>
                        </div>
                         <div class="row">
                            <div class="mb-3 col-12 col-md-12">
                                <label>Archivo:</label>
                                <input type="file" class=" form-control" name="doc_capacitacion" v-on:change="fileUpdateCapacitacion"  :key="fileInputKey" accept="pdf"  required>
                            
                                <div v-if="enviado && (!$v.expediente.archivo.required)" class="mensajeError">
                                    Debe seleccionar el archivo.
                                </div>
                            </div>
                         </div>
                          
                        <div class="row" style="padding:10px">
                            <div class="col-sm-5">
                            </div>
                            <div class="col-sm-7">
                                <button type="submit" 
                                    class="btn btn-primary btn-pill"><i class="fe fe-save nav-icon" aria-hidden="true" ></i>
                                    Grabar
                                </button>
                                <button type="button"
                                    class="btn btn-danger btn-pill"  @click="closeModalAdjuntarArchivoExpediente()"
                                    >
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


<script>
    import 'vue-select/dist/vue-select.css';
    import axios from 'axios'
    import { required } from "vuelidate/lib/validators";
    import VueSweetalert2 from 'vue-sweetalert2';
    Vue.use(VueSweetalert2);
    import 'sweetalert2/dist/sweetalert2.min.css';

    export default {
        data(){
            return{
                areas:[],

                loading:false,
                enviado:false,
                validado:'',
                
                expediente:{
                    numero:'',
                    anio:'',
                    asunto:'',
                    codcontri:'',
                    coddocumento:'',
                    descdocumento:'',
                    descripcion:'',
                    estado:'',
                    expediente:'',
                    fecha:'',
                    folios:'',
                    hora:'',
                    nro_dias:'',
                    referencia:'',
                    remitente:'',
                    texto:'',
                    tipodoc:'',
                    tipotramite:'',
                    tptra_id:'',
                    archivo:''
                },
                options: [],
                persona:{
                    persona_id:'',
                    nombres:''
                },
                fileInputKey: 0
            }
        },
        methods:{
            fileUpdateCapacitacion(e){
                this.expediente.archivo = e.target.files[0]
            },
            editarExpediente(){
                this.loading=true;
                this.enviado=true;
                this.$v.$touch();
                if (this.$v.$invalid) {
                    this.loading=false;
                    return;
                }else{
                    let formData = new FormData()
                    formData.append('numero',this.expediente.coddocumento)
                    formData.append('anio',this.expediente.anio)
                    formData.append('archivo',this.expediente.archivo)
                    var request ={
                        url:`${this.variableGlobal}/update-tramite_documentario-adjuntar-archivo-expediente`,
                        method:'post',
                        data:formData
                    }
                    axios(request).then(({data}) => {
                    if (data) {
                            this.$swal.fire({
                                icon: 'success',
                                title: 'ARCHIVO ADJUNTADO!',
                                text: "Se adjuntó el archivo exitosamente",
                                showConfirmButton: false,
                                timer: 2500
                            })
                        }
                    });
                    this.loading=false;
                    this.closeModalAdjuntarArchivoExpediente();
                }
            },
            closeModalAdjuntarArchivoExpediente(){
                this.limpiar();
                $('#modalProcesoAdjuntarArchivoExpediente').modal('hide');
            },
            limpiar(){
                this.fileInputKey++;
            },
            getDataExpediente(id,anio){
                axios.get(`${this.variableGlobal}/datos-tramite_documentario-expediente-edit/`+id+`/`+anio).then(({data}) => {
                    this.expediente = data[0];
                    this.expediente.estado=data[0].estado==1 ? true : false;
                    this.loading=false;
                }).catch((error) => {
                    console.log(error);
                });
            }
        },
        created() {
            Bus.$on("modalAdjuntarArchivoExpediente", (data) => {
                this.loading=true;
                this.expediente.numero=data.numero;
                this.expediente.anio=data.anio;
                this.getDataExpediente(this.expediente.numero,this.expediente.anio);
            }); 
        },
        validations () {
            return {
                expediente:{
                    archivo:{ required }
                }
            }
        }
    }
</script>


<style>
    .modal-footer{
        border-top:0px solid #e9ecef!important;
    }

    @media (min-width: 576px){
        .modal-dialog {
            max-width: 1200px;
            margin: 1.75rem auto;
        }
    }
    .mensajeError{
        color: red;
        font-size: 11px;;
    }
    .mayus{
        text-transform:uppercase
    }
    
</style>


