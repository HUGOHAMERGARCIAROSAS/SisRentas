<template>
    <div class="modal fade xd2" id="modalProcesoEditExpediente"  tabindex="10000" role="dialog"
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
                                <label>Hora :</label>
                            </div>
                            <div class="mb-3 col-12 col-md-4">
                                <label>    <i class="fa fa-clock-o"></i>  {{expediente.hora}}</label>  
                            </div>
                            <div class="mb-3 col-12 col-md-4">
                                <label>Expediente :</label>
                                <label>  {{expediente.coddocumento}}  - {{expediente.anio}}</label>  
                            </div>
                        </div>
                         <div class="row">
                            <div class="mb-3 col-12 col-md-3">
                                <label>Tipo Expediente:</label>
                                <select id="2" class="form-control" v-model="expediente.tipodoc" >
                                    <option value="" :selected="true">Seleccionar</option>
                                    <option v-for="(item, index) in todostipoexpediente" :key="index" v-bind:value="item.valor">{{item.descripcion}}</option>
                                </select>
                                <div v-if="enviado && (!$v.expediente.tipodoc.required)" class="mensajeError">
                                    Debe seleccionar el tipo de expediente.
                                </div>
                            </div>
                             <div class="mb-3 col-12 col-md-6">
                                <label>Remitente :</label>
                                 <input type="text"  class="form-control mayus" v-model="expediente.remitente">
                                 <div v-if="enviado && (!$v.expediente.remitente.required)" class="mensajeError">
                                    Debe rellenar el remitente.
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-1">
                                <label>Folios :</label>
                                 <input type="text"  class="form-control mayus" v-model="expediente.folios">
                                 <div v-if="enviado && (!$v.expediente.folios.required)" class="mensajeError">
                                    Debe rellenar el número de folios.
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-2">
                                <input class="form-check-input" type="checkbox" name="estado" id="flexCheckDefault"  v-model="expediente.estado" 
                                true-value="true"  false-value="false">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Estado
                                </label>
                            </div>
                         </div>
                         <div class="row">
                            <div class="mb-3 col-12 col-md-6">
                                <label class="form-label" for="lname">Contribuyente:</label>
                                 <v-select  label="full_name" v-model="selectPersona" :filterable="false" :options="options" @search="onSearch">
                                    <template slot="no-options">
                                    Escriba apellidos y nombres
                                    </template>
                                    <template slot="option" slot-scope="option">
                                    <div class="d-center">
                                        {{ option.full_name}}  - Cod: {{option.persona_ID }}
                                        </div>
                                    </template>
                                </v-select>
                            </div>
                            <div class="mb-3 col-12 col-md-6">
                                <label>Tipo Trámite:</label>
                                <select id="2" class="form-control" v-model="expediente.tptra_id" >
                                    <option value="" :selected="true">Seleccionar</option>
                                    <option v-for="(item, index) in todostipotramite" :key="index" v-bind:value="item.valor">{{item.descripcion}}</option>
                                </select>
                            </div>
                         </div>
                          <div class="row">
                            <div class="mb-3 col-12 col-md-4">
                                <label>Descripción :</label>
                                <textarea v-model="expediente.descdocumento" rows="4" cols="30"></textarea> 
                            </div>
                            <div class="mb-3 col-12 col-md-4">
                                <label>Asunto :</label>
                                <textarea v-model="expediente.asunto" rows="4" cols="30"></textarea>
                                <div v-if="enviado && (!$v.expediente.asunto.required)" class="mensajeError">
                                    Debe rellenar el asunto.
                                </div> 
                            </div>
                            <div class="mb-3 col-12 col-md-4">
                                <label>Referencia  :</label>
                                <textarea v-model="expediente.referencia" rows="4" cols="30"></textarea> 
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
                                    class="btn btn-danger btn-pill"  @click="closeModalEditarExpediente()"
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
    import vSelect from 'vue-select'
    Vue.component('v-select', vSelect)

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
                    tptra_id:''
                },
                selectEditUsuario:'',
                todostipoexpediente:[],
                todostipotramite:[],
                options: [],
                persona:{
                    persona_id:'',
                    nombres:''
                },
                selectPersona:''
            }
        },
        methods:{
            editarExpediente(){
                this.loading=true;
                this.enviado=true;
                this.$v.$touch();
                if (this.$v.$invalid) {
                    this.loading=false;
                    return;
                }else{
                    if(this.selectPersona){
                        this.expediente.codcontri=this.selectPersona.persona_ID;
                    }
                    let formData = new FormData()
                    formData.append('numero',this.expediente.coddocumento)
                    formData.append('anio',this.expediente.anio)
                    formData.append('tipodoc',this.expediente.tipodoc)
                    formData.append('remitente',this.expediente.remitente)
                    formData.append('folios',this.expediente.folios)
                    formData.append('estado',this.expediente.estado)
                    formData.append('codcontri',this.expediente.codcontri)
                    formData.append('tptra_id',this.expediente.tptra_id)
                    formData.append('descdocumento',this.expediente.descdocumento)
                    formData.append('asunto',this.expediente.asunto)
                    formData.append('referencia',this.expediente.referencia)

                    var request ={
                        url:`${this.variableGlobal}/update-tramite_documentario-data-expediente`,
                        method:'post',
                        data:formData
                    }
                    axios(request).then(({data}) => {
                    if (data) {
                            this.$swal.fire({
                                icon: 'success',
                                title: 'ACTUALIZADA!',
                                text: "Se actualizó exitosamente",
                                showConfirmButton: false,
                                timer: 2500
                            })
                        }
                    });
                    this.loading=false;
                    this.closeModalEditarExpediente();
                }
            },
            getTiposExpediente(){
                axios.get(`${this.variableGlobal}/lista-tipo_expediente-text`).then(({data}) => {
                    this.todostipoexpediente = data;
                }).catch((error) => {
                    console.log(error);
                });
            },
            getTiposTramite(){
                axios.get(`${this.variableGlobal}/lista-tipo_tramite-text`).then(({data}) => {
                    this.todostipotramite = data;
                }).catch((error) => {
                    console.log(error);
                });
            },
            closeModalEditarExpediente(){
                $('#modalProcesoEditExpediente').modal('hide');
            },
            getDataExpediente(id,anio){
                axios.get(`${this.variableGlobal}/datos-tramite_documentario-expediente-edit/`+id+`/`+anio).then(({data}) => {
                    this.expediente = data[0];
                    this.expediente.estado=data[0].estado==1 ? true : false;
                    this.loading=false;
                }).catch((error) => {
                    console.log(error);
                });
            },
            onSearch(search, loading) {
                if(search.length>8) {
                    loading(true);
                    this.search(loading, search, this);
                }
            },
            search(loading, search, vm){
                this.persona.nombres=search;
                axios.post(`${this.variableGlobal}/lista-tramite_documentario-persona-select-search/`,this.persona).then(({data}) => {
                this.options=data;
                   loading(false);
                }).catch((error) => {
                    console.log(error);
                });
            } 
        },
        created() {
            Bus.$on("modalEditarExpediente", (data) => {
                this.loading=true;
                this.expediente.numero=data.numero;
                this.expediente.anio=data.anio;
                this.getDataExpediente(this.expediente.numero,this.expediente.anio);
                this.getTiposExpediente();
                this.getTiposTramite();
            }); 
        },
        validations () {
            return {
                expediente:{
                    tipodoc:{ required },
                    asunto:{ required },
                    folios:{ required },
                    remitente:{ required },
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


