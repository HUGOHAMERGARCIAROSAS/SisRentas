<template>
    <div class="modal fade xd2" id="modalProcesoEditRoles"  tabindex="-1" role="dialog"
          data-keyboard="false" data-backdrop="static">
          <page-loader v-if="loading==true"/>
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center">EDITAR ROLES</h5>
                </div>
                <div class="modal-body">
                    <form  @submit.prevent="editarRoles">
                        <div class="row">
                            <div class="mb-3 col-12 col-md-6">
                                <label class="form-label" for="lname">Rol:</label>
                                <input type="text"  class="form-control mayus" v-model="rol.rol_nombre" >
                                <div v-if="enviado && (!$v.rol.rol_nombre.required)" class="mensajeError">
                                    Debe rellenar el rol
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-6">
                                <label class="form-label" for="lname">Descripción:</label>
                                <input type="text"  class="form-control" v-model="rol.rol_descripcion" >
                                <div v-if="enviado && (!$v.rol.rol_descripcion.required)" class="mensajeError">
                                    Debe rellenar la descripción
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
                                    class="btn btn-danger btn-pill"  @click="closeModalEditarRoles()"
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
                rol:{
                    rol_nombre:'',
                    rol_descripcion:'',
                    rol_id:''
                },

                loading:false,
                enviado:false,
                validado:'',
                selectEditRoles:''
            }
        },
        methods:{
            editarRoles(){
                this.loading=true;
                this.enviado=true;
                this.$v.$touch();
                if (this.$v.$invalid) {
                    this.loading=false;
                    return;
                }else{
                    let formData = new FormData()
                    formData.append('rol_nombre',this.rol.rol_nombre.toUpperCase())
                    formData.append('rol_descripcion',this.rol.rol_descripcion)
                    formData.append('rol_id',this.rol.rol_id)
                    var request ={
                        url:`${this.variableGlobal}/update-data-roles`,
                        method:'post',
                        data:formData
                    }
                    axios(request).then(({data}) => {
                    if (data) {
                            this.$swal.fire({
                                icon: 'success',
                                title: 'GUARDADO!',
                                text: "Se actualizó exitosamente",
                                showConfirmButton: false,
                                timer: 2500
                        })
                    }else{
                    this.$swal.fire({
                        icon: 'warning',
                        title: '¡Error!',
                        text: `Ya existe este Rol.`,
                        showConfirmButton: false,
                        timer: 2500
                    })
                    }
                    });
                    this.loading=false;
                    this.closeModalEditarRoles();
                }
            },
            closeModalEditarRoles(){
                this.limpiarRoles();
                $('#modalProcesoEditRoles').modal('hide');
                Bus.$emit("ProcesoEditRol");
            },
            limpiarRoles(){
                    this.rol.rol_nombre='',
                    this.rol.rol_descripcion=''
            },
            getDataRoles(id){
                axios.get(`${this.variableGlobal}/datos-roles-edit/`+id).then(({data}) => {
                    this.rol = data[0];
                    this.loading=false;
                }).catch((error) => {
                    console.log(error);
                });
            }
        },
        created() {
            Bus.$on("modalEditarRoles", (data) => {
                this.loading=true;
                this.selectEditRoles=data;
                this.getDataRoles(this.selectEditRoles);
            }); 
        },
        validations () {
            return {
                rol:{
                    rol_nombre:{ required },
                    rol_descripcion:{required}
                }
            }
        }
    }
</script>



