<template>
    <div class="modal fade xd2" id="modalProcesoEditPasswordUsuario"  tabindex="10000" role="dialog"
          data-keyboard="false" data-backdrop="static">
          <page-loader v-if="loading==true"/>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center">EDITAR PASSWORD</h5>
                </div>
                <div class="modal-body">
                    <form  @submit.prevent="editarUsuarioPassword">
                        <div class="row">
                            <div class="mb-3 col-12 col-md-6">
                                <label class="form-label" for="lname">Password:</label>
                                <input type="text"  class="form-control" v-model="usuario.password" >
                                <div v-if="enviado && !$v.usuario.password.minLength" class="mensajeError">
                                    Debe tener minimo 8 caracteres.
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-6">
                                <label class="form-label" for="lname">Nuevo Password:</label>
                                <input type="text"  class="form-control" v-model="usuario.new_password" >
                                <div v-if="enviado && ( !$v.usuario.new_password.sameAsPassword || !$v.usuario.new_password.required )" class="mensajeError">
                                    La contraseña no coincide.
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
                                    class="btn btn-danger btn-pill"  @click="closeModalEditarUsuarioPassword()"
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
    import { required,sameAs,minLength } from "vuelidate/lib/validators";
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
                
                usuario:{
                    password:'',
                    new_password:'',
                    persona_ID:''

                },
                selectEditUsuario:''
            }
        },
        methods:{
            editarUsuarioPassword(){
                this.loading=true;
                this.enviado=true;
                this.$v.$touch();
                if (this.$v.$invalid) {
                    this.loading=false;
                    return;
                }else{
                    this.usuario.persona_ID=this.selectEditUsuario;
                    let formData = new FormData()
                    formData.append('password',this.usuario.password)
                    formData.append('persona_id',this.usuario.persona_ID)
                    var request ={
                        url:`${this.variableGlobal}/update-data-usuario-password`,
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
                    this.closeModalEditarUsuarioPassword();
                }
            },
            closeModalEditarUsuarioPassword(){
                $('#modalProcesoEditPasswordUsuario').modal('hide');
                Bus.$emit("ProcesoEditPasswordUsuario");
            },
            getDataUsuarioPassword(id){
                axios.get(`${this.variableGlobal}/datos-usuario-edit-password/`+id).then(({data}) => {
                    this.usuario = data[0];
                    this.loading=false;
                }).catch((error) => {
                    console.log(error);
                });
            }
        },
        created() {
            Bus.$on("modalEditarPasswordUsuario", (data) => {
                this.loading=true;
                this.selectEditUsuario=data;
                this.getDataUsuarioPassword(this.selectEditUsuario);
            }); 
        },
        validations () {
            return {
                usuario:{
                    password:{ required,minLength: minLength(8) },
                    new_password:{ required,sameAsPassword: sameAs('password') },
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


