<template>
    <div>
         <page-loader v-if="loading==true"/>
         <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header text-center">
                            <h2>ADMINISTRACIÓN DE ROLES</h2>
                        </div>
                        <div class="body">
                            <div class="row">
                                <div class="col-md-2">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" placeholder="Ingrese el rol" v-model="buscador.rol_nombre" @keyup.enter="searchRoles()">
                                </div>
                                <div class="col-md-4">
                                    <button type="button" @click="searchRoles()" class="btn mb-1 btn-simple btn-sm btn-secondary btn-filter" data-target="all"><i class="fa fa-search">  Buscar</i></button>
                                    <button type="button" @click="limpiar()" class="btn mb-1 btn-simple btn-sm btn-default btn-filter" data-target="approved"><i class="icon-refresh">  Limpiar</i></button>
                                    <button v-if="$can('administracion.roles.store')" type="button" @click="AbriModalCrearRol()" class="btn mb-1 btn-simple btn-sm btn-success btn-filter" data-target="blocked"><i class="fa fa-plus-square-o">  Nuevo</i></button>
                                </div>
                            </div>
                        </div>
                        <div class="body">
                            <div class="table-responsive" v-if="roles.length==0">
                                <table class="table table-hover m-b-0 c_list">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Rol</th>
                                            <th class="text-center">Descripción</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center">Opciones</th>
                                        </tr>
                                    </thead>
                                        <tbody v-if="roles.length==0">
                                            <tr><td colspan="7">No se encontraron registros.</td></tr>
                                        </tbody>
                                </table>
                            </div>
                            <div class="table-responsive" v-else>
                                <table class="table table-hover m-b-0 c_list">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Rol</th>
                                            <th class="text-center">Descripción</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center">Opciones</th>
                                        </tr>
                                    </thead>
                                        <tbody>
                                            <tr v-for="(item, index) in roles" :key="index">
                                                <td class="text-center">
                                                    <p class="c_name">{{index+1}}</p>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.rol_nombre}}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.rol_descripcion}}</span>
                                                </td>
                                                <td class="text-center" >
                                                    <span class="badge badge-success" v-if="item.rol_activo==1">Activo</span>
                                                    <span class="badge badge-danger" v-if="item.rol_activo==0">Anulado</span>
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" v-if="$can('administracion.permisosrol.roles')"  class="btn btn-warning" @click="asignarPermisosRol(item.rol_id)" title="Asignar Tareas"><i class="fa fa-bars" aria-hidden="true"></i></button>
                                                    <button type="button" v-if="$can('administracion.roles.update')"  class="btn btn-info" @click="editDataRoles(item.rol_id)" title="Editar Rol"><i class="fa fa-edit"></i></button>
                                                    <span v-if="$can('administracion.roles.delete')"><button v-if="item.rol_activo==1" type="button" @click="deleteDataRoles(item.rol_id)" data-type="confirm" class="btn btn-danger js-sweetalert" title="Borrar Rol"><i class="fa fa-trash-o"></i></button></span>
                                                    <span v-if="$can('administracion.roles.active')"><button v-if="item.rol_activo==0" type="button" @click="ActiveDataRoles(item.rol_id)" data-type="confirm" class="btn btn-success js-sweetalert" title="ACtivar Rol"><i class="fa fa-check"></i></button></span>

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
         <modal-crear-administracion-roles></modal-crear-administracion-roles>

        <!-- MODAL PARA EDITAR ROLES     -->
         <modal-editar-administracion-roles></modal-editar-administracion-roles>


    </div>
</template>
<script>
    import axios from 'axios'

    export default {
    data() {
        return{
            roles:[],
            buscador:{
                rol_nombre:''
            },

            //VARIABLE DE LOADING
            loading:false,

            //VARIABLES DE PAGINACION
            currentPage: 1,
            total:0,
            total_pages:0,
            per_page:10,
            tipo_busqueda:1
        }
    },
    methods:{
        getTotal(){
            axios.get(`${this.variableGlobal}/lista-administracion-roles-total-pages`).then(({data}) => {
                this.total = parseInt(data[0].total);
                this.total_pages = Math.ceil(this.total/10);
                if(this.tipo_busqueda==1){
                    this.getRoles(this.currentPage);
                }
                if(this.tipo_busqueda==2){
                    this.searchRoles();
                }
            }).catch((error) => {
                console.log(error);
            });
        },
        getRoles(i){
            this.loading=true;
            axios.get(`${this.variableGlobal}/lista-administracion-roles-list/`+i).then(({data}) => {
                this.roles = data;
                this.loading=false;
            }).catch((error) => {
                console.log(error);
            });

        },
        onPageChange(page) {
            this.currentPage = page;
            if(this.tipo_busqueda==1){
                this.getRoles(this.currentPage);
            }else{
                this.searchRoles();
            }

        },
        searchRoles(){
            if(this.buscador.rol_nombre==''){
                console.log('INGRESE SUS PARAMETROS');
            }else{
                this.tipo_busqueda=2;
                this.loading=true;
                axios.post(`${this.variableGlobal}/lista-administracion-roles-search/`,this.buscador).then(({data}) => {
                        this.roles = data;
                        this.total=parseInt(this.roles.length);
                        this.total_pages = Math.ceil(this.total/10);
                        this.loading=false;
                }).catch((error) => {
                    console.log(error);
                });
            }
        },
        limpiar(){
            this.buscador.rol_nombre='';
            this.tipo_busqueda=1;
            this.getTotal();
        },
        AbriModalCrearRol(){
            $('#modalCrearRoles').modal({backdrop: 'static', keyboard: false});
            $('#modalCrearRoles').modal('show');
        },
        deleteDataRoles(id){
            this.$swal.fire({
            title: '¿Estás seguro de anular este rol?',
            text: "¡Puedes volver a activarlo luego!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Borrar!'
            }).then((result) => {
            if (result.isConfirmed) {
                this.loading=true;
                let formData = new FormData()
                formData.append('rol_id',id)
                var request ={
                    url:`${this.variableGlobal}/delete-rol`,
                    method:'post',
                    data:formData
                }

                axios(request).then(({data}) => {
                if (data) {
                    this.$swal.fire(
                    'Anulado!',
                    'El Rol fue anulado con éxito.',
                    'success'
                    )
                }
            });
            this.loading=false;
            this.getTotal();
            }
            })

        },
        ActiveDataRoles(id){
            this.$swal.fire({
            title: '¿Estás seguro de activar este rol?',
            text: "¡Activarás este rol!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Activar!'
            }).then((result) => {
            if (result.isConfirmed) {
                this.loading=true;
                let formData = new FormData()
                formData.append('rol_id',id)
                var request ={
                    url:`${this.variableGlobal}/active-rol`,
                    method:'post',
                    data:formData
                }

                axios(request).then(({data}) => {
                if (data) {
                    this.$swal.fire(
                    'Activado!',
                    'El Rol fue activado con éxito.',
                    'success'
                    )
                }
            });
            this.loading=false;
            this.getTotal();
            }
            })
        },
        editDataRoles(id){
            $('#modalProcesoEditRoles').modal({backdrop: 'static', keyboard: false});
            $('#modalProcesoEditRoles').modal('show');
            Bus.$emit("modalEditarRoles",id);
        },
        asignarPermisosRol(id){
            window.location.href = `${this.variableGlobal}/administracion/PermisosRol/${id}`;
        }

    },
    created(){
        this.getTotal();
        Bus.$on("DetalleCreateRoles", (data) => {
            this.getTotal();
        });
        Bus.$on("ProcesoEditRol", (data) => {
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
