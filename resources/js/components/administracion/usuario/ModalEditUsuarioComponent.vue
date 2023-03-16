<template>
    <div class="modal fade xd2" id="modalProcesoEditUsuario"  tabindex="10000" role="dialog"
          data-keyboard="false" data-backdrop="static">
          <page-loader v-if="loading==true"/>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center">EDITAR USUARIO</h5>
                </div>
                <div class="modal-body">
                    <form  @submit.prevent="editarUsuario">
                        <div class="row">
                            <div class="mb-3 col-12 col-md-6">
                                <label class="form-label" for="lname">Login:</label>
                                <input type="text"  class="form-control" v-model="usuario.login" >
                                <div v-if="enviado && (!$v.usuario.login.required)" class="mensajeError">
                                    Debe rellenar el usuario
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-6">
                                <label class="form-label" for="lname">Nombres:</label>
                                <input type="text"  class="form-control" v-model="usuario.texto" disabled>
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
                                    class="btn btn-danger btn-pill"  @click="closeModalEditarUsuario()"
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
    import axios from 'axios'
    import { required } from "vuelidate/lib/validators";
    
    export default {
        data(){
            return{
                areas:[],

                loading:false,
                enviado:false,
                validado:'',
                
                usuario:{
                    texto:'',
                    persona_ID:'',
                    login:''
                },
                selectEditUsuario:''
            }
        },
        methods:{
            editarUsuario(){
                this.loading=true;
                this.enviado=true;
                this.$v.$touch();
                if (this.$v.$invalid) {
                    this.loading=false;
                    return;
                }else{
                    this.usuario.persona_ID=this.selectEditUsuario;
                    let formData = new FormData()
                    formData.append('login',this.usuario.login)
                    formData.append('persona_id',this.usuario.persona_ID)

                    var request ={
                        url:`${this.variableGlobal}/update-data-usuario`,
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
                    this.closeModalEditarUsuario();
                }
            },
            closeModalEditarUsuario(){
                $('#modalProcesoEditUsuario').modal('hide');
                 Bus.$emit("ProcesoEditUsuario");
            },
            getDataUsuario(id){
                axios.get(`${this.variableGlobal}/datos-usuario-edit/`+id).then(({data}) => {
                    this.usuario = data[0];
                    this.loading=false;
                }).catch((error) => {
                    console.log(error);
                });
            }
        },
        created() {
            Bus.$on("modalEditarUsuario", (data) => {
                this.loading=true;
                this.selectEditUsuario=data;
                this.getDataUsuario(this.selectEditUsuario);
            }); 
        },
        validations () {
            return {
                usuario:{
                    login:{ required },
                }
            }
        }
    }
</script>


