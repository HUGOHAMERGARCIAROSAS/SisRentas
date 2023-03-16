<template>
    <div>
         <page-loader v-if="loading==true"/> 
         <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header text-center">
                            <h2>ADMINISTRACIÓN DE TAREAS</h2>
                        </div>
                        <div class="body">
                            <div class="row">
                                <div class="col-md-2">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" placeholder="Ingrese la tarea" v-model="buscador.tar_nombre" @keyup.enter="searchTareas()">
                                </div>
                                <div class="col-md-4">
                                    <button type="button" @click="searchTareas()" class="btn mb-1 btn-simple btn-sm btn-secondary btn-filter" data-target="all"><i class="fa fa-search">  Buscar</i></button>
                                    <button type="button" @click="limpiar()" class="btn mb-1 btn-simple btn-sm btn-default btn-filter" data-target="approved"><i class="icon-refresh">  Limpiar</i></button>
                                    <button v-if="$can('administracion.tareas.store')" type="button" @click="AbriModalCrearTarea()" class="btn mb-1 btn-simple btn-sm btn-success btn-filter" data-target="blocked"><i class="fa fa-plus-square-o">  Nuevo</i></button>
                                </div>
                            </div>
                        </div>
                        <div class="body">
                            <div class="table-responsive" v-if="tareas.length==0">
                                <table class="table table-hover m-b-0 c_list">
                                    <thead>
                                        <tr>        
                                            <th class="text-center">#</th>
                                            <th class="text-center">Tarea</th>
                                            <th class="text-center">Descripción</th>
                                            <th class="text-center">Ruta</th>
                                            <th class="text-center">Orden</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center">Opciones</th>
                                        </tr>
                                    </thead>
                                        <tbody v-if="tareas.length==0">
                                            <tr><td colspan="8">No se encontraron registros.</td></tr>
                                        </tbody>
                                </table>
                            </div>
                            <div class="table-responsive" v-else>
                                <table class="table table-hover m-b-0 c_list">
                                    <thead>
                                        <tr>                                 
                                            <th class="text-center">#</th>
                                            <th class="text-center">Tarea</th>
                                            <th class="text-center">Descripción</th>
                                            <th class="text-center">Ruta</th>
                                            <th class="text-center">Orden</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center">Opciones</th>
                                        </tr>
                                    </thead>
                                        <tbody>
                                            <tr v-for="(item, index) in tareas" :key="index">
                                                <td class="text-center">
                                                    <p class="c_name">{{index+1}}</p>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.tar_nombre}}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.tar_descripcion}}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.tar_url}}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.tar_orden}}</span>
                                                </td>
                                                <td class="text-center" >
                                                    <span class="badge badge-success" v-if="item.tar_activo==1">Activo</span>
                                                    <span class="badge badge-danger" v-if="item.tar_activo==0">Anulado</span>
                                                </td>  
                                                <td class="text-center">  
                                                    <button v-if="$can('administracion.tareas.update')" type="button"  class="btn btn-info" @click="editDataTareas(item.tarea_id)" title="Editar Rol"><i class="fa fa-edit"></i></button>
                                                    <span v-if="$can('administracion.tareas.delete')" ><button v-if="item.tar_activo==1" type="button" @click="deleteDataTareas(item.tarea_id)" data-type="confirm" class="btn btn-danger js-sweetalert" title="Borrar Rol"><i class="fa fa-trash-o"></i></button></span>
                                                    <span v-if="$can('administracion.tareas.active')"><button v-if="item.tar_activo==0" type="button" @click="ActiveDataTareas(item.tarea_id)" data-type="confirm" class="btn btn-success js-sweetalert" title="ACtivar Rol"><i class="fa fa-check"></i></button></span>
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

        <!-- MODAL PARA CREAR tareas     -->
         <modal-crear-administracion-tareas></modal-crear-administracion-tareas>

        <!-- MODAL PARA EDITAR tareas     -->
         <modal-editar-administracion-tareas></modal-editar-administracion-tareas>

         
    </div>
</template>
<script>
    import axios from 'axios'

    export default {
    data() {
        return{
            tareas:[],
            buscador:{
                tar_nombre:''
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
            axios.get(`${this.variableGlobal}/lista-administracion-tareas-total-pages`).then(({data}) => {
                this.total = parseInt(data[0].total);
                this.total_pages = Math.ceil(this.total/10);
                this.getTareas(this.currentPage);
            }).catch((error) => {
                console.log(error);
            });
        },
        getTareas(i){
            this.loading=true;
            axios.get(`${this.variableGlobal}/lista-administracion-tareas-list/`+i).then(({data}) => {
                this.tareas = data;
                this.loading=false;
            }).catch((error) => {
                console.log(error);
            });

        },
        onPageChange(page) {
            this.currentPage = page;
            if(this.tipo_busqueda==1){
                this.getTareas(this.currentPage);
            }else{
                this.searchTareas();
            }
            
        },
        searchTareas(){
            if(this.buscador.tar_nombre==''){
                console.log('INGRESE SUS PARAMETROS');
            }else{
                this.tipo_busqueda=2;
                this.loading=true;
                axios.post(`${this.variableGlobal}/lista-administracion-tareas-search/`,this.buscador).then(({data}) => {
                        this.tareas = data;
                        this.total=parseInt(this.tareas.length);
                        this.total_pages = Math.ceil(this.total/10);
                        this.loading=false;
                }).catch((error) => {
                    console.log(error);
                });
            }
        },
        limpiar(){
            this.buscador.tar_nombre='';
            this.tipo_busqueda=1;
            this.getTotal();
        },
        AbriModalCrearTarea(){
            $('#modalCrearTareas').modal({backdrop: 'static', keyboard: false});
            $('#modalCrearTareas').modal('show');
        },
        deleteDataTareas(id){
            this.$swal.fire({
            title: '¿Estás seguro de anular esta tarea?',
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
                formData.append('tarea_id',id)
                var request ={
                    url:`${this.variableGlobal}/delete-tarea`,
                    method:'post',
                    data:formData
                }
                
                axios(request).then(({data}) => {
                if (data) {
                    this.$swal.fire(
                    'Anulado!',
                    'La tarea  fue anulada con éxito.',
                    'success'
                    )
                }
            });
            this.loading=false;
            this.getTotal();
            }
            })
            
        },
        ActiveDataTareas(id){
            this.$swal.fire({
            title: '¿Estás seguro de activar esta tarea?',
            text: "¡Activarás esta tarea!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Activar!'
            }).then((result) => {
            if (result.isConfirmed) {
                this.loading=true;
                let formData = new FormData()
                formData.append('tarea_id',id)
                var request ={
                    url:`${this.variableGlobal}/active-tarea`,
                    method:'post',
                    data:formData
                }
                
                axios(request).then(({data}) => {
                if (data) {
                    this.$swal.fire(
                    'Activado!',
                    'La tarea fue activada con éxito.',
                    'success'
                    )
                }
            });
            this.loading=false;
            this.getTotal();
            }
            })
        },
        editDataTareas(id){
            $('#modalProcesoEditTareas').modal({backdrop: 'static', keyboard: false});
            $('#modalProcesoEditTareas').modal('show');
            Bus.$emit("modalEditarTareas",id);
        }
    },
    created(){
        this.getTotal();
        Bus.$on("DetalleCreateTareas", (data) => {
            this.getTotal();
        });
        Bus.$on("ProcesoEditTarea", (data) => {
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
