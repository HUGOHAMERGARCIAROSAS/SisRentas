<template>
    <div>
         <page-loader v-if="loading==true"/> 
         <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header text-center">
                            <h2>ADMINISTRACIÓN DE USUARIOS</h2>
                        </div>
                        <div class="body">
                            <div class="row">
                                <div class="col-md-4" >
                                    <input type="text"  class="form-control" placeholder="Ingrese apellidos y nombres" v-model="buscador.nombres" @keyup.enter="searchUsuario()">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" placeholder="Ingrese Código" v-model="buscador.codigo" @keyup.enter="searchUsuario()">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" placeholder="Ingrese documento" v-model="buscador.documento" @keyup.enter="searchUsuario()">
                                </div>
                                <div class="col-md-4">
                                    <button type="button" @click="searchUsuario()" class="btn mb-1 btn-simple btn-sm btn-secondary btn-filter" data-target="all"><i class="fa fa-search">  Buscar</i></button>
                                    <button type="button" @click="limpiar()" class="btn mb-1 btn-simple btn-sm btn-default btn-filter" data-target="approved"><i class="icon-refresh">  Limpiar</i></button>
                                    <button type="button" v-if="$can('administracion.usuario.store')" @click="AbriModalCrearUsuario()" class="btn mb-1 btn-simple btn-sm btn-success btn-filter" data-target="blocked"><i class="fa fa-plus-square-o">  Nuevo</i></button>
                                </div>
                            </div>
                        </div>
                        <div class="body">
                            <div class="table-responsive" v-if="usuarios.length==0">
                                <table class="table table-hover m-b-0 c_list">
                                    <thead>
                                        <tr>        
                                            <th class="text-center">#</th>                           
                                            <th class="text-center">Código</th>
                                            <th class="text-center">Persona</th>
                                            <th class="text-center">Login</th>
                                            <th class="text-center">Fecha Cre.</th>
                                            <th class="text-center">Fecha Cese.</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center">Opciones</th>
                                        </tr>
                                    </thead>
                                        <tbody v-if="usuarios.length==0">
                                            <tr><td colspan="7">No se encontraron registros.</td></tr>
                                        </tbody>
                                </table>
                            </div>
                            <div class="table-responsive" v-else>
                                <table class="table table-hover m-b-0 c_list">
                                    <thead>
                                        <tr>                                 
                                            <th class="text-center">Código</th>
                                            <th class="text-center">Persona</th>
                                            <th class="text-center">Login</th>
                                            <th class="text-center">Fecha Cre.</th>
                                            <th class="text-center">Fecha Cese.</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center">Opciones</th>
                                        </tr>
                                    </thead>
                                        <tbody>
                                            <tr v-for="(item, index) in usuarios" :key="index">
                                                <td class="text-center">
                                                    <p class="c_name">{{item.persona_id}}</p>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.texto}}</span>
                                                </td> 
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.per_login}}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.fecha_creacion}}</span>
                                                </td> 
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.fecha_cese}}</span>
                                                </td> 
                                                <td class="text-center" >
                                                    <span class="badge badge-success" v-if="item.estado==1">{{item.estadod}}</span>
                                                    <span class="badge badge-danger" v-if="item.estado==0">{{item.estadod}}</span>
                                                </td>
                                                <td class="text-center">  
                                                    <button v-if="$can('administracion.roles_usuario.store')" type="button" class="btn btn-secondary" @click="editDataRolesUsuario(item.persona_id)" title="Asignar Roles"><i class="fa fa-tasks"></i></button>                                          
                                                    <button v-if="$can('administracion.usuario.edit.password')" type="button" class="btn btn-warning" @click="editDataPasswordUsuario(item.persona_id)" title="Cambiar Contraseña"><i class="fa fa-lock"></i></button>                                          
                                                    <button v-if="$can('administracion.usuario.update')" type="button" class="btn btn-info" @click="editDataUsuario(item.persona_id)" title="Editar Usuario"><i class="fa fa-edit"></i></button>
                                                    <span v-if="$can('administracion.usuario.delete')"><button v-if="item.estado==1" type="button" @click="deleteDataUsuario(item.persona_id)" data-type="confirm" class="btn btn-danger js-sweetalert" title="Anular Usuario"><i class="fa fa-trash-o"></i></button></span>
                                                    <span v-if="$can('administracion.usuario.active')"><button v-if="item.estado==0" type="button" @click="ActiveDataUsuario(item.persona_id)" data-type="confirm" class="btn btn-success js-sweetalert" title="Activar Usuario"><i class="fa fa-check"></i></button></span>
                                                </td>
                                            </tr>
                                        </tbody>
                                </table>
                                <br>
                                <pagination-view :total-pages="total_pages"
                                                        :total="total"
                                                        :per-page="per_page"
                                                        :current-page="currentPage"
                                                        @pagechanged="onPageChange"></pagination-view>
                            </div>
                        </div>
                    </div>
                </div>
         </div>

        <!-- MODAL PARA CREAR USUARIO     -->
         <modal-crear-administracion-usuario></modal-crear-administracion-usuario>

        <!-- MODAL PARA EDITAR USUARIO     -->
         <modal-editar-administracion-usuario></modal-editar-administracion-usuario>

         <!-- MODAL PARA EDITAR USUARIO PASSWORD     -->
         <modal-editar-administracion-usuario-password></modal-editar-administracion-usuario-password>

        <!-- MODAL PARA EDITAR ROLES USUARIO     -->
        <modal-editar-roles-usuario></modal-editar-roles-usuario>
         
    </div>
</template>
<script>
    import axios from 'axios'
    export default {
    data() {
        return{
            usuarios:[],
            buscador:{
                nombres:'',
                documento:'',
                codigo:''
            },
            loading:false,
             currentPage: 1,
             total:0,
             total_pages:0,
             per_page:10,
             tipo_busqueda:1
        }
    },
    methods:{
        getTotal(){
            axios.get(`${this.variableGlobal}/lista-administracion-usuario-total-pages`).then(({data}) => {
                this.total = parseInt(data[0].coddoc);
                this.total_pages = Math.ceil(this.total/10);
                if(this.tipo_busqueda==1){
                    this.getUsuarios(this.currentPage);
                }
                if(this.tipo_busqueda==2){
                    this.searchUsuario();
                }
            }).catch((error) => {
                console.log(error);
            });
        },
        getUsuarios(i){
            this.loading=true;
            axios.get(`${this.variableGlobal}/lista-administracion-usuario-list/`+i).then(({data}) => {
                this.usuarios = data;
                this.loading=false;
            }).catch((error) => {
                console.log(error);
            });

        },
        onPageChange(page) {
            this.currentPage = page;
            if(this.tipo_busqueda==1){
                this.getUsuarios(this.currentPage);
            }else{
                this.searchUsuario();
            }
            
        },
        searchUsuario(){
            if(this.buscador.nombres=='' && this.buscador.documento=='' && this.buscador.codigo==''){
                console.log('INGRESE SUS PARAMETROS');
            }else{
                this.tipo_busqueda=2;
                this.loading=true;
                axios.post(`${this.variableGlobal}/lista-administracion-usuario-search/`,this.buscador).then(({data}) => {
                        this.usuarios = data;
                        this.total=parseInt(this.usuarios.length);
                        this.total_pages = Math.ceil(this.total/10);
                        this.loading=false;
                }).catch((error) => {
                    console.log(error);
                });
            }

        },
        limpiar(){
            this.buscador.nombres='';
            this.buscador.documento='';
            this.buscador.codigo='';
            this.tipo_busqueda=1;
            this.getTotal();
        },
        AbriModalCrearUsuario(){
            $('#modalCrearUsuario').modal({backdrop: 'static', keyboard: false});
            $('#modalCrearUsuario').modal('show');
        },
        deleteDataUsuario(id){
            this.loading=true;
            this.$swal.fire({
                title: '¿Desea desactivar este usuario?',
                text: "Dejará de tener acceso al sistema.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Si, desactivar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    let formData = new FormData()
                    formData.append('persona_id',id)
                    var request ={
                        url:`${this.variableGlobal}/delete-usuario`,
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
                this.getTotal();
            })
            
        },
        ActiveDataUsuario(id){
            this.loading=true;
            this.$swal.fire({
                title: '¿Desea Activar este usuario?',
                text: "Volverá a tener acceso al sistema.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Si, activar!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let formData = new FormData()
                        formData.append('persona_id',id)
                        var request ={
                            url:`${this.variableGlobal}/active-usuario`,
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
                    this.getTotal();  
            })
        },
        editDataUsuario(id){
            $('#modalProcesoEditUsuario').modal({backdrop: 'static', keyboard: false});
            $('#modalProcesoEditUsuario').modal('show');
            Bus.$emit("modalEditarUsuario",id);
        },
        editDataPasswordUsuario(id){
            $('#modalProcesoEditPasswordUsuario').modal({backdrop: 'static', keyboard: false});
            $('#modalProcesoEditPasswordUsuario').modal('show');
            Bus.$emit("modalEditarPasswordUsuario",id);
        },
        editDataRolesUsuario(id){
            $('#modalProcesoEditRolesUsuario').modal({backdrop: 'static', keyboard: false});
            $('#modalProcesoEditRolesUsuario').modal('show');
            Bus.$emit("modalEditarRolesUsuario",id);
        },
    },
    created(){
        this.getTotal();
        Bus.$on("DetalleCreatePersona", (data) => {
            this.getTotal();
        });
        Bus.$on("ProcesoEditUsuario", (data) => {
            this.getTotal();
        });
        Bus.$on("ProcesoEditRolesUsuario", (data) => {
            this.getTotal();
        });
        Bus.$on("ProcesoEditPasswordUsuario", (data) => {
            this.getTotal();
        });

        
    }
}
</script>


<style >
    .pagination {
        display: flex;
        justify-content: center;
    }
</style>
