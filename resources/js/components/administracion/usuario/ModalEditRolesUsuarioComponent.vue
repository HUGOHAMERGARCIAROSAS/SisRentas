<template>
    <div class="modal fade xd2" id="modalProcesoEditRolesUsuario"  tabindex="10000" role="dialog"
          data-keyboard="false" data-backdrop="static">
          <page-loader v-if="loading==true"/>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center">Asignar Roles</h5>
                </div>
                <div class="modal-body">
                    <form  @submit.prevent="editarRolesUsuario">
                        <div class="row">
                            <div class="mb-3 col-12 col-md-4">
                                <label class="form-label" for="lname">Login:</label>
                                <input type="text"  class="form-control" v-model="usuario.login" disabled>
                            </div>
                            <div class="mb-3 col-12 col-md-4">
                                <label class="form-label" for="lname">Nombres:</label>
                                <input type="text"  class="form-control" v-model="usuario.texto" disabled>
                            </div>
                            <div class="mb-3 col-12 col-md-4">
                                <label class="form-label" for="lname">Roles:</label>
                                 <v-select  label="text" v-model="selectRoles" :filterable="false" :options="options" @search="onSearch" required>
                                    <template slot="no-options">
                                    Escriba el rol
                                    </template>
                                    <template slot="option" slot-scope="option">
                                    <div class="d-center">
                                        {{ option.text}} 
                                        </div>
                                    </template>
                                </v-select>
                            </div>
                        </div>
                        <div class="row" style="padding:10px">
                            <div class="col-sm-5">
                            </div>
                            <div class="col-sm-7">
                                <button type="submit" v-if="selectRoles"
                                    class="btn btn-primary btn-pill"><i class="fa fa-save nav-icon" aria-hidden="true" ></i>
                                    Grabar
                                </button>
                                <button type="button"
                                    class="btn btn-danger btn-pill"  @click="closeModalEditarRolesUsuario()"
                                    ><i class="icon-close"></i>
                                    Cerrar
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">#</th>
                                        <th scope="col" class="text-center">ELIMINAR</th>
                                        <th scope="col" class="text-center">ROL</th>
                                        <th scope="col" class="text-center">ESTADO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in rolesUsuarioList" :key="index">
                                        <td scope="row" class="text-center">{{index+1}}</td>
                                        <td v-if="item.activo==1" class="text-center"><span v-if="$can('administracion.usuario.delete')"><button  type="button" @click="deleteDataRolesUsuario(item.urol_id)" data-type="confirm" class="btn btn-danger js-sweetalert" title="Anular Roles Usuario"><i class="fa fa-trash-o"></i></button></span></td>
                                        <td v-if="item.activo==0" class="text-center"><span v-if="$can('administracion.usuario.active')"><button  type="button" @click="ActiveDataRolesUsuario(item.urol_id)" data-type="confirm" class="btn btn-success js-sweetalert" title="Activar Roles Usuario"><i class="fa fa-check"></i></button></span></td>
                                        <td class="text-center">{{item.texto}}</td>
                                        <td class="text-center" >
                                            <span class="badge badge-success" v-if="item.activo==1">{{item.estadod}}</span>
                                            <span class="badge badge-danger" v-if="item.activo==0">{{item.estadod}}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script >
    import axios from 'axios'
    import { required } from "vuelidate/lib/validators";
    
    export default {
        data(){
            return{
                loading:false,
                enviado:false,
                validado:'',
                options: [],
                
                usuario:{
                    texto:'',
                    persona_ID:'',
                    login:'',
                    rol_id:''
                },
                usuarioRol:{
                    persona_ID:'',
                    rol_id:''
                },
                roles:{
                    rol_id:'',
                    text:''
                },
                selectEditUsuario:'',
                selectRoles:'',
                rolesUsuarioList:[],
                validateRolUser:''
            }
        },
        methods:{
            editarRolesUsuario(){
                this.usuarioRol.rol_id=this.selectRoles.rol_id;
                this.usuarioRol.persona_ID=this.selectEditUsuario;

                this.loading=true;
                this.enviado=true;
                this.$v.$touch();
                if (this.$v.$invalid) {
                    this.loading=false;
                    return;
                }else{
                    axios.get(`${this.variableGlobal}/datos-validate-roles-usuario/`+this.usuarioRol.rol_id+'/'+this.usuarioRol.persona_ID).then(({data}) => {
                        this.validateRolUser = data[0].num;
                        if(this.validateRolUser>0){
                            this.$swal.fire({
                                icon: 'warning',
                                title: '¡Este usuario ya tiene este Rol!',
                                text: "Si es necesario activa el rol",
                                showConfirmButton: false,
                                timer: 2500
                            })
                        }else{
                            let formData = new FormData()
                            formData.append('rol_id',this.usuarioRol.rol_id)
                            formData.append('persona_id',this.usuarioRol.persona_ID)
                            var request ={
                                url:`${this.variableGlobal}/store-data-roles-usuario`,
                                method:'post',
                                data:formData
                            }
                            axios(request).then(({data}) => {
                            if (data) {
                                    this.$swal.fire({
                                        icon: 'success',
                                        title: 'CREADO!',
                                        text: "Se creó exitosamente",
                                        showConfirmButton: false,
                                        timer: 3500
                                    })
                                }
                            });
                        }
                        this.loading=false;
                        this.limpiarRolesUsuario();
                        this.getDataRolesUsuario(this.selectEditUsuario);
                    }).catch((error) => {
                        console.log(error);
                    });

                    
                    
                }
            },
            closeModalEditarRolesUsuario(){
                $('#modalProcesoEditRolesUsuario').modal('hide');
                 Bus.$emit("ProcesoEditRolesUsuario");
                 this.limpiarUsuarioRol();
            },
            getDataUsuario(id){
                axios.get(`${this.variableGlobal}/datos-usuario-edit/`+id).then(({data}) => {
                    this.usuario = data[0];
                    this.loading=false;
                }).catch((error) => {
                    console.log(error);
                });
            },
            onSearch(search, loading) {
                    loading(true);
                    this.search(loading, search, this);
            },
            search(loading, search, vm){
                this.roles.text=search;
                axios.post(`${this.variableGlobal}/lista-administracion-roles-select-search/`,this.roles).then(({data}) => {
                this.options=data;
                   loading(false);
                }).catch((error) => {
                    console.log(error);
                });
            },
            limpiarUsuarioRol(){
                    this.usuarioRol.persona_ID='',
                    this.usuarioRol.rol_id=''
            },
            getDataRolesUsuario(id){
                axios.get(`${this.variableGlobal}/datos-roles-usuario-list/`+id).then(({data}) => {
                    this.rolesUsuarioList = data;
                    this.loading=false;
                }).catch((error) => {
                    console.log(error);
                });
            },
            limpiarRolesUsuario(){
                this.selectRoles=''
            },
            deleteDataRolesUsuario(id){
                this.loading=true;
                this.$swal.fire({
                    title: '¿Desea desactivar este rol?',
                    text: "Dejará de tener acceso al sistema.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Si, desactivar!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let formData = new FormData()
                        formData.append('urol_id',id)
                        var request ={
                            url:`${this.variableGlobal}/delete-roles-usuario`,
                            method:'post',
                            data:formData
                        }
                        axios(request).then(({data}) => {
                            if (data) {
                                this.$swal.fire({
                                    icon: 'success',
                                    title: 'GUARDADO!',
                                    text: "Se eliminó exitosamente",
                                    showConfirmButton: false,
                                    timer: 2500
                                })
                            }
                        });   
                    }
                    this.loading=false;
                    this.getDataRolesUsuario(this.selectEditUsuario);
                })
            },
            ActiveDataRolesUsuario(id){
                this.loading=true;
                this.$swal.fire({
                    title: '¿Desea Activar este rol?',
                    text: "Volverá a tener todas las tareas pertenecientes.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Si, activar!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let formData = new FormData()
                            formData.append('urol_id',id)
                            var request ={
                                url:`${this.variableGlobal}/active-roles-usuario`,
                                method:'post',
                                data:formData
                            }
                            axios(request).then(({data}) => {
                                if (data) {
                                    this.$swal.fire({
                                        icon: 'success',
                                        title: 'GUARDADO!',
                                        text: "Se activó exitosamente",
                                        showConfirmButton: false,
                                        timer: 2500
                                    })
                                }
                            });
                        }
                        this.loading=false;
                        this.getDataRolesUsuario(this.selectEditUsuario); 
                })
            },
            editDataRolesUsuario(){

            }
        },
        created() {
            Bus.$on("modalEditarRolesUsuario", (data) => {
                this.loading=true;
                this.selectEditUsuario=data;
                this.getDataUsuario(this.selectEditUsuario);
                this.getDataRolesUsuario(this.selectEditUsuario);
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

