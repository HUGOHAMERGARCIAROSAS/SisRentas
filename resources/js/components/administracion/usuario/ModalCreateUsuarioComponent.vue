<template>
    <div class="modal fade xd2" id="modalCrearUsuario"  tabindex="10000" role="dialog"
          data-keyboard="false" data-backdrop="static">
          <page-loader v-if="loading==true"/>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center">CREAR USUARIO</h5>
                </div>
                <div class="modal-body">
                    <form  @submit.prevent="guardarUsuario">
                        <div class="row">
                            <div class="mb-3 col-12 col-md-6">
                                <label class="form-label" for="lname">Apellidos y Nombres:</label>
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
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Login:</label>
                                <input type="text"  class="form-control" v-model="usuario.login" >
                                <div v-if="enviado && (!$v.usuario.login.required)" class="mensajeError">
                                    Debe rellenar el usuario
                                </div>
                            </div>
                             <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Password:</label>
                                <input type="password"  class="form-control" v-model="usuario.password">
                                 <div v-if="enviado && (!$v.usuario.password.required || !$v.usuario.password.minLength)" class="mensajeError">
                                    El número de documento debe tener mínimo 8 caracteres.
                                </div>
                            </div>
                        </div>
                        <div class="row" style="padding:10px">
                            <div class="col-sm-5">
                            </div>
                            <div class="col-sm-7">
                                <button type="submit" 
                                    class="btn btn-primary btn-pill"><i class="fa fa-save nav-icon" aria-hidden="true" ></i>
                                    Grabar
                                </button>
                                <button type="button"
                                    class="btn btn-danger btn-pill"  @click="closeModalAgregarUsuario()"
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


<script>
    import 'vue-select/dist/vue-select.css';
    import axios from 'axios'
    import { required, email , minLength } from "vuelidate/lib/validators";
    import VueSweetalert2 from 'vue-sweetalert2';
    Vue.use(VueSweetalert2);
    import 'sweetalert2/dist/sweetalert2.min.css';
    import vSelect from 'vue-select'
    Vue.component('v-select', vSelect)
    

    export default {
        data(){
            return{
                usuario:{
                    login:'',
                    persona_id:'',
                    password:''
                },

                loading:false,
                enviado:false,
                validado:'',
                options: [],
                persona:{
                    persona_id:'',
                    nombres:''
                },
                selectPersona:''
            }
        },
        methods:{
            guardarUsuario(){
                this.loading=true;
                this.enviado=true;
                this.$v.$touch();
                if (this.$v.$invalid) {
                    this.loading=false;
                    return;
                }else{
                    if(this.selectPersona){
                        this.usuario.persona_id=this.selectPersona.persona_ID;
                        let formData = new FormData()
                        formData.append('login',this.usuario.login)
                        formData.append('persona_id',this.usuario.persona_id)
                        formData.append('password',this.usuario.password)
                        var request ={
                            url:`${this.variableGlobal}/store-data-usuario`,
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
                        this.closeModalAgregarUsuario();
                    }
                    this.loading=false;
                }
            },
            closeModalAgregarUsuario(){
                this.limpiarUsuario();
                $('#modalCrearUsuario').modal('hide');
                Bus.$emit("DetalleCreatePersona");
            },
            limpiarUsuario(){
                    this.usuario.login='',
                    this.usuario.persona_id='',
                    this.usuario.password=''
            },
            onSearch(search, loading) {
                if(search.length>3) {
                    loading(true);
                    this.search(loading, search, this);
                }
            },
            search(loading, search, vm){
                this.persona.nombres=search;
                axios.post(`${this.variableGlobal}/lista-administracion-persona-select-search/`,this.persona).then(({data}) => {
                this.options=data;
                   loading(false);
                }).catch((error) => {
                    console.log(error);
                });
            }   
        },
        created() {
        },
        validations () {
            return {
                usuario:{
                    login:{ required },
                    password:{ required , minLength: minLength(8) },
                }
            }
        }
    }
</script>





