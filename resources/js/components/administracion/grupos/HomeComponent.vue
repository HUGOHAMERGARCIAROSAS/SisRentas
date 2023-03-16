<template>
    <div>
         <page-loader v-if="loading==true"/>
         <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header text-center">
                            <h2>ADMINISTRACIÓN DE GRUPOS</h2>
                        </div>
                        <div class="body">
                            <div class="row">
                                <div class="col-md-2">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" placeholder="Ingrese el grupo" v-model="buscador.gru_nombre" @keyup.enter="searchGrupos()">
                                </div>
                                <div class="col-md-4">
                                    <button type="button" @click="searchGrupos()" class="btn mb-1 btn-simple btn-sm btn-secondary btn-filter" data-target="all"><i class="fa fa-search">  Buscar</i></button>
                                    <button type="button" @click="limpiar()" class="btn mb-1 btn-simple btn-sm btn-default btn-filter" data-target="approved"><i class="icon-refresh">  Limpiar</i></button>
                                    <button  type="button" v-if="$can('administracion.grupos.store')" @click="AbriModalCrearGrupo()" class="btn mb-1 btn-simple btn-sm btn-success btn-filter" data-target="blocked"><i class="fa fa-plus-square-o">  Nuevo</i></button>
                                </div>
                            </div>
                        </div>
                        <div class="body">
                            <div class="table-responsive" v-if="grupos.length==0">
                                <table class="table table-hover m-b-0 c_list">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Grupo</th>
                                            <th class="text-center">Descripción</th>
                                            <th class="text-center">Icono</th>
                                            <th class="text-center">Orden</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center">Opciones</th>
                                        </tr>
                                    </thead>
                                        <tbody v-if="grupos.length==0">
                                            <tr><td colspan="7">No se encontraron registros.</td></tr>
                                        </tbody>
                                </table>
                            </div>
                            <div class="table-responsive" v-else>
                                <table class="table table-hover m-b-0 c_list">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Grupo</th>
                                            <th class="text-center">Descripción</th>
                                            <th class="text-center">Icono</th>
                                            <th class="text-center">Orden</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center">Opciones</th>
                                        </tr>
                                    </thead>
                                        <tbody>
                                            <tr v-for="(item, index) in grupos" :key="index">
                                                <td class="text-center">
                                                    <p class="c_name">{{index+1}}</p>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.gru_nombre}}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.gru_descripcion}}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.gru_icono}}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.gru_orden}}</span>
                                                </td>
                                                <td class="text-center" >
                                                    <span class="badge badge-success" v-if="item.gru_activo==1">Activo</span>
                                                    <span class="badge badge-danger" v-if="item.gru_activo==0">Anulado</span>
                                                </td>
                                                <td class="text-center">
                                                    <button v-if="$can('administracion.grupos.update')" type="button"  class="btn btn-info" @click="editDataGrupos(item.grupo_id)" title="Editar Rol"><i class="fa fa-edit"></i></button>
                                                    <span  v-if="$can('administracion.grupos.delete')"><button v-if="item.gru_activo==1" type="button" @click="deleteDataGrupos(item.grupo_id)" data-type="confirm" class="btn btn-danger js-sweetalert" title="Borrar Grupo"><i class="fa fa-trash-o"></i></button></span>
                                                    <span  v-if="$can('administracion.grupos.active')"><button v-if="item.gru_activo==0" type="button" @click="ActiveDataGrupos(item.grupo_id)" data-type="confirm" class="btn btn-success js-sweetalert" title="ACtivar Grupo"><i class="fa fa-check"></i></button></span>

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

        <!-- MODAL PARA CREAR grupos     -->
         <modal-crear-administracion-grupos></modal-crear-administracion-grupos>

        <!-- MODAL PARA EDITAR grupos     -->
         <modal-editar-administracion-grupos></modal-editar-administracion-grupos>


    </div>
</template>
<script>
    import axios from 'axios'

    export default {
    data() {
        return{
            grupos:[],
            buscador:{
                gru_nombre:''
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
            axios.get(`${this.variableGlobal}/lista-administracion-grupos-total-pages`).then(({data}) => {
                this.total = parseInt(data[0].total);
                this.total_pages = Math.ceil(this.total/10);
                if(this.tipo_busqueda==1){
                    this.getGrupos(this.currentPage);
                }
                if(this.tipo_busqueda==2){
                    this.searchGrupos();
                }

            }).catch((error) => {
                console.log(error);
            });
        },
        getGrupos(i){
            this.loading=true;
            axios.get(`${this.variableGlobal}/lista-administracion-grupos-list/`+i).then(({data}) => {
                this.grupos = data;
                this.loading=false;
            }).catch((error) => {
                console.log(error);
            });

        },
        onPageChange(page) {
            this.currentPage = page;
            if(this.tipo_busqueda==1){
                this.getGrupos(this.currentPage);
            }else{
                this.searchGrupos();
            }

        },
        searchGrupos(){
            if(this.buscador.gru_nombre==''){
                console.log('INGRESE SUS PARAMETROS');
            }else{
                this.tipo_busqueda=2;
                this.loading=true;
                axios.post(`${this.variableGlobal}/lista-administracion-grupos-search/`,this.buscador).then(({data}) => {
                        this.grupos = data;
                        this.loading=false;
                }).catch((error) => {
                    console.log(error);
                });
            }
        },
        limpiar(){
            this.buscador.gru_nombre='';
            this.tipo_busqueda=1;
            this.getTotal();
        },
        AbriModalCrearGrupo(){
            $('#modalCrearGrupos').modal({backdrop: 'static', keyboard: false});
            $('#modalCrearGrupos').modal('show');
        },
        deleteDataGrupos(id){
            this.$swal.fire({
            title: '¿Estás seguro de anular este grupo?',
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
                formData.append('gru_id',id)
                var request ={
                    url:`${this.variableGlobal}/delete-grupo`,
                    method:'post',
                    data:formData
                }

                axios(request).then(({data}) => {
                if (data) {
                    this.$swal.fire(
                    'Anulado!',
                    'El grupo fue anulado con éxito.',
                    'success'
                    )
                }
            });
            this.loading=false;
            this.getTotal();
            }
            })

        },
        ActiveDataGrupos(id){
            this.$swal.fire({
            title: '¿Estás seguro de activar este grupo?',
            text: "¡Activarás este grupo!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Activar!'
            }).then((result) => {
            if (result.isConfirmed) {
                this.loading=true;
                let formData = new FormData()
                formData.append('gru_id',id)
                var request ={
                    url:`${this.variableGlobal}/active-grupo`,
                    method:'post',
                    data:formData
                }

                axios(request).then(({data}) => {
                if (data) {
                    this.$swal.fire(
                    'Activado!',
                    'El Grupo fue activado con éxito.',
                    'success'
                    )
                }
            });
            this.loading=false;
            this.getTotal();
            }
            })
        },
        editDataGrupos(id){
            $('#modalProcesoEditGrupos').modal({backdrop: 'static', keyboard: false});
            $('#modalProcesoEditGrupos').modal('show');
            Bus.$emit("modalEditarGrupos",id);
        }
    },
    created(){
        this.getTotal();
        Bus.$on("DetalleCreateGrupos", (data) => {
            this.getTotal();
        });
        Bus.$on("ProcesoEditGrupo", (data) => {
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
