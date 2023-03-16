<template>
    <div class="modal fade xd2" id="modalCrearPersona"  tabindex="10000" role="dialog"
          data-keyboard="false" data-backdrop="static">
          <page-loader v-if="loading==true"/>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center">REGISTRAR PERSONA</h5>
                </div>
                <div class="modal-body">
                    <form  @submit.prevent="guardarPersona">
                        <div class="row">
                            <div class="mb-3 col-12 col-md-3">
                            <label>Tipo:</label>
                                <select id="2" class="form-control" v-model="persona.tipo_persona" >
                                    <option value="" :selected="true">Seleccionar</option>
                                    <option v-for="(item, index) in todostipopersona" :key="index" v-bind:value="item.valor">{{item.descripcion}}</option>
                                </select>
                                <div v-if="enviado && !$v.persona.tipo_persona.required" class="mensajeError">
                                    Debe seleccionar el tipo.
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Nombres:</label>
                                <input type="text"  class="form-control mayus" v-model="persona.nombres" maxlength="50">
                                
                            </div>
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Ape. Paterno / Empresa:</label>
                                <input type="text"  class="form-control mayus" v-model="persona.ape_paterno" maxlength="150">
                                <div v-if="enviado && !$v.persona.ape_paterno.required" class="mensajeError">
                                    Debe escribir algo.
                                </div>
                            </div>
                             <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Ape. Materno:</label>
                                <input type="text"  class="form-control mayus" v-model="persona.ape_materno" maxlength="50">
                            </div>
                        </div>
                         <div class="row">
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Fecha Registro:</label>
                                <input type="date"  class="form-control"  v-model="persona.fecha_registro">
                                <div v-if="enviado && !$v.persona.fecha_registro.required" class="mensajeError">
                                    Debe seleccionar la fecha de registro.
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Fecha Nac. :</label>
                                <input type="date"  class="form-control" v-model="persona.fecha_nac">
                                <div v-if="enviado && !$v.persona.fecha_registro.required" class="mensajeError">
                                    Debe seleccionar la fecha de nacimiento.
                                </div>
                            </div>
                             <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Tipo Doc. :</label>
                                <select id="2" class="form-control" v-model="persona.tipo_doc" >
                                    <option value="" :selected="true">Seleccionar</option>
                                    <option v-for="(item, index) in todostipodocumento" :key="index" v-bind:value="item.valor">{{item.descripcion}}</option>
                                </select>
                                <div v-if="enviado && !$v.persona.tipo_doc.required" class="mensajeError">
                                    Debe seleccionar el tipo de documento.
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">N° Doc:</label>
                                <input type="text"  class="form-control mayus" v-model="persona.num_doc" maxlength="15" v-on:change="validarDato()">
                                <div v-if="enviado && (!$v.persona.num_doc.required || !$v.persona.num_doc.minLength)" class="mensajeError">
                                    El número de documento debe tener mínimo 8 caracteres.
                                </div>
                                <div v-if="validateDni==1" class="mensajeError">
                                    Ya existe un usuario con este documento.
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Sexo :</label>
                                <select id="2" class="form-control" v-model="persona.sexo" >
                                    <option value="" :selected="true">Seleccionar</option>
                                    <option v-for="(item, index) in todostiposexo" :key="index" v-bind:value="item.valor">{{item.descripcion}}</option>
                                </select>
                            </div>
                             <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Departamento :</label>
                                <select id="2" class="form-control" v-model="persona.id_departamento"   @change="changeProvincia($event)">
                                    <option value="" :selected="true">Seleccionar</option>
                                    <option v-for="(item, index) in todostipodepartamento" :key="index" v-bind:value="item.valor">{{item.descripcion}}</option>
                                </select>
                            </div>
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Provincia :</label>
                                <select id="2" class="form-control" v-model="persona.id_provincia" @change="changeDistrito($event)" >
                                    <option value="" :selected="true">Seleccionar</option>
                                    <option v-for="(item, index) in todostipoprovincia" :key="index" v-bind:value="item.valor">{{item.descripcion}}</option>
                                </select>
                            </div>
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Distrito :</label>
                                <select id="2" class="form-control" v-model="persona.id_distrito" @change="changeJunta($event)" >
                                    <option value="" :selected="true">Seleccionar</option>
                                    <option v-for="(item, index) in todostipodistrito" :key="index" v-bind:value="item.valor">{{item.descripcion}}</option>
                                </select>
                            </div>
                        </div>
                         <div class="row">
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Junta :</label>
                                <select id="2" class="form-control" v-model="persona.junta" @change="changeCalle($event)" >
                                    <option value="" :selected="true">Seleccionar</option>
                                    <option v-for="(item, index) in todostipojunta" :key="index" v-bind:value="item.valor">{{item.descripcion}}</option>
                                </select>
                            </div>
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Calle :</label>
                                <select id="2" class="form-control" v-model="persona.calle" >
                                    <option value="" :selected="true">Seleccionar</option>
                                    <option v-for="(item, index) in todostipocalle" :key="index" v-bind:value="item.valor">{{item.descripcion}}</option>
                                </select>
                                <div v-if="enviado && !$v.persona.calle.required" class="mensajeError">
                                    Debe seleccionar la calle.
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">N° via :</label>
                                <input type="text"  class="form-control mayus" v-model="persona.n_via" maxlength="5">
                            </div>
                             <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Interior  :</label>
                                <input type="text"  class="form-control mayus" v-model="persona.interior" maxlength="5">
                            </div>
                         </div>
                         <div class="row">
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Mz:</label>
                                <input type="text"  class="form-control mayus" v-model="persona.mz" maxlength="5">
                            </div>
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Lote :</label>
                                <input type="text"  class="form-control mayus" v-model="persona.lote" maxlength="5">
                            </div>
                             <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Edificio :</label>
                                <input type="text"  class="form-control mayus" v-model="persona.edificio" maxlength="5">
                            </div>
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Piso :</label>
                                <input type="text"  class="form-control mayus" v-model="persona.piso" maxlength="5">
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Dpto :</label>
                                <input type="text"  class="form-control mayus" v-model="persona.dpto" maxlength="11">
                            </div>
                             <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Tienda :</label>
                                <input type="text"  class="form-control mayus" v-model="persona.tienda" maxlength="5">
                            </div>
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Fono Domicilio :</label>
                                <input type="text"  class="form-control mayus" v-model="persona.fono_domicilio" maxlength="10">
                            </div>
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Fono Oficina :</label>
                                <input type="text"  class="form-control mayus" v-model="persona.fono_oficina" maxlength="10">
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-12 col-md-6">
                                <label class="form-label" for="lname">Direccion Completa :</label>
                                <input type="text"  class="form-control mayus" v-model="persona.direccion_completa" maxlength="200">
                                <div v-if="enviado && !$v.persona.direccion_completa.required" class="mensajeError">
                                    Debe escribir la dirección completa.
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Celular :</label>
                                <input type="text"  class="form-control mayus" v-model="persona.celular" maxlength="11">
                            </div>
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Email :</label>
                                <input type="text"  class="form-control" v-model="persona.email" maxlength="40">
                                <div v-if="enviado && (!$v.persona.email.email || !$v.persona.email.required)" class="mensajeError">
                                    Debe llenar un correo válido.
                                </div>
                            </div>
                        </div>
                        <div class="row" style="padding:10px">
                            <div class="col-sm-5">
                            </div>
                            <div class="col-sm-7">
                                <button type="submit" class="btn btn-primary btn-pill" v-if="validateDni==0">
                                    <i class="fa fa-save nav-icon" aria-hidden="true" ></i>
                                     Grabar
                                </button>
                                <button type="button"
                                    class="btn btn-danger btn-pill"  @click="closeModalAgregarPersona()"
                                    > <i class="icon-close"></i>
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
    import axios from 'axios'
    import { required, email , minLength } from "vuelidate/lib/validators";
    import VueSweetalert2 from 'vue-sweetalert2';
    Vue.use(VueSweetalert2);
    import 'sweetalert2/dist/sweetalert2.min.css';

    export default {
        data(){
            return{
                persona:{
                    tipo_persona:'',
                    fecha_registro:'',
                    ape_paterno:'',
                    ape_materno:'',
                    nombres:'',
                    fecha_nac:'',
                    tipo_doc:'',
                    num_doc:'',
                    sexo:'',
                    id_departamento:'',
                    id_provincia:'',
                    id_distrito:'',
                    junta:'',
                    calle:'',
                    n_via:'',
                    interior:'',
                    mz:'',
                    lote:'',
                    edificio:'',
                    piso:'',
                    dpto:'',
                    tienda:'',
                    fono_domicilio:'',
                    direccion_completa:'',
                    fono_oficina:'',
                    celular:'',
                    email:'',
                    
                },
                todostipopersona:[],
                todostipodocumento:[],
                todostipodepartamento:[],
                todostipoprovincia:[],
                todostipodistrito:[],
                todostipojunta:[],
                todostipocalle:[],
                todostiposexo:[],
                loading:false,
                enviado:false,
                validado:'',
                validateDni:''
            }
        },
        methods:{
            guardarPersona(){
                this.loading=true;
                this.enviado=true;
                this.$v.$touch();
                if (this.$v.$invalid) {
                    this.loading=false;
                    return;
                }else{
                    let materno = this.persona.ape_materno ? this.persona.ape_materno.toUpperCase() : 'null';
                    let nombres = this.persona.nombres ? this.persona.nombres.toUpperCase() : 'null';
                    let formData = new FormData()
                    formData.append('tipo_persona',this.persona.tipo_persona)
                    formData.append('fecha_registro',this.persona.fecha_registro)
                    formData.append('ape_paterno',this.persona.ape_paterno.toUpperCase())
                    formData.append('ape_materno',materno)
                    formData.append('nombres',nombres)
                    formData.append('fecha_nac',this.persona.fecha_nac)
                    formData.append('tipo_doc',this.persona.tipo_doc)
                    formData.append('num_doc',this.persona.num_doc)
                    formData.append('sexo',this.persona.sexo)
                    formData.append('calle',this.persona.calle)
                    formData.append('n_via',this.persona.n_via)
                    formData.append('interior',this.persona.interior)
                    formData.append('mz',this.persona.mz)
                    formData.append('lote',this.persona.lote)
                    formData.append('edificio',this.persona.edificio)
                    formData.append('piso',this.persona.piso)
                    formData.append('dpto',this.persona.dpto)
                    formData.append('tienda',this.persona.tienda)
                    formData.append('fono_domicilio',this.persona.fono_domicilio)
                    formData.append('direccion_completa',this.persona.direccion_completa.toUpperCase())
                    formData.append('fono_oficina',this.persona.fono_oficina)
                    formData.append('celular',this.persona.celular)
                    formData.append('email',this.persona.email)
                    let value=this.persona.num_doc.trim();
                            var request ={
                                url:`${this.variableGlobal}/store-data-persona`,
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
                                }
                            });
                            this.loading=false;
                            this.closeModalAgregarPersona();
                    
                    
                }
            },
            getTipoPersona(){
                axios.get(`${this.variableGlobal}/lista-tipopersona-text`).then(({data}) => {
                    this.todostipopersona = data;
                }).catch((error) => {
                    console.log(error);
                });
            },
            getTipoDocumento(){
                axios.get(`${this.variableGlobal}/lista-tipodocumento-text`).then(({data}) => {
                    this.todostipodocumento = data;
                }).catch((error) => {
                    console.log(error);
                });
            },
            getTipoDepartamento(){
                axios.get(`${this.variableGlobal}/lista-tipodepartamento-text`).then(({data}) => {
                    this.todostipodepartamento = data;
                }).catch((error) => {
                    console.log(error);
                });
            },
            changeProvincia(){
                this.loading=true;
                let value=this.persona.id_departamento;
                axios.get(`${this.variableGlobal}/lista-tipoprovincia-text/`+ value).then(({data}) => {
                    this.todostipoprovincia = data;
                    this.loading=false;
                }).catch((error) => {
                    console.log(error);
                });
            },
            changeDistrito(){
                let value=this.persona.id_provincia;
                axios.get(`${this.variableGlobal}/lista-tipodistrito-text/`+ value).then(({data}) => {
                    this.todostipodistrito = data;
                    this.loading=false;
                }).catch((error) => {
                    console.log(error);
                });
            },
            changeJunta(){
                this.loading=true;
                let value=this.persona.id_distrito;
                axios.get(`${this.variableGlobal}/lista-tipojunta-text/`+ value).then(({data}) => {
                    this.todostipojunta = data;
                    this.loading=false;
                }).catch((error) => {
                    console.log(error);
                });
            },
            changeCalle(){
                this.loading=true;
                let value=this.persona.junta;
                axios.get(`${this.variableGlobal}/lista-tipocalle-text/`+ value).then(({data}) => {
                    this.todostipocalle = data;
                    this.loading=false;
                }).catch((error) => {
                    console.log(error);
                });
            },
            getTipoSexo(){
                axios.get(`${this.variableGlobal}/lista-tiposexo-text`).then(({data}) => {
                    this.todostiposexo = data;
                }).catch((error) => {
                    console.log(error);
                });
            },
            closeModalAgregarPersona(){
                this.limpiarPersona();
                $('#modalCrearPersona').modal('hide');
                Bus.$emit("DetalleCreatePersona");
            },
            limpiarPersona(){
                    this.persona.tipo_persona='',
                    this.persona.fecha_registro='',
                    this.persona.ape_paterno='',
                    this.persona.ape_materno='',
                    this.persona.nombres='',
                    this.persona.fecha_nac='',
                    this.persona.tipo_doc='',
                    this.persona.num_doc='',
                    this.persona.sexo='',
                    this.persona.id_departamento='',
                    this.persona.id_provincia='',
                    this.persona.id_distrito='',
                    this.persona.junta='',
                    this.persona.calle='',
                    this.persona.n_via='',
                    this.persona.interior='',
                    this.persona.mz='',
                    this.persona.lote='',
                    this.persona.edificio='',
                    this.persona.piso='',
                    this.persona.dpto='',
                    this.persona.tienda='',
                    this.persona.fono_domicilio='',
                    this.persona.direccion_completa='',
                    this.persona.fono_oficina='',
                    this.persona.celular='',
                    this.persona.email=''
            },
            validarDato(){
                axios.get(`${this.variableGlobal}/dvalidate-dni-create-person/`+this.persona.num_doc).then(({data}) => {
                    let vtot = data[0].tot;
                    if(vtot>0){
                        this.validateDni=1;
                    }else{
                        this.validateDni=0;
                    }
                }).catch((error) => {
                    console.log(error);
                });
                
            }
        },
        created() {
            this.getTipoPersona();
            this.getTipoDocumento();
            this.getTipoDepartamento();
            this.getTipoSexo();
        },
        validations () {
            return {
                persona:{
                    tipo_persona:{ required },
                    fecha_registro:{ required },
                    ape_paterno:{ required },
                    fecha_nac:{ required },
                    tipo_doc:{ required },
                    num_doc:{ required , minLength: minLength(8) },
                    calle:{ required },
                    direccion_completa:{ required },
                    email:{ required, email },   
                }
            }
        }
    }
</script>





