<template>
    <div>
         <page-loader v-if="loading==true"/>
         <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header text-center">
                            <h2>MANTENEDOR UBIGEO</h2>
                        </div>
                        <div class="body">
                            <div class="row">
                                <div class="col-md-2">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" placeholder="Ingrese la ubicación" v-model="buscador.descripcion" @keyup.enter="searchUbigeo()">
                                </div>
                                <div class="col-md-4">
                                    <button type="button" @click="searchUbigeo()" class="btn mb-1 btn-simple btn-sm btn-secondary btn-filter" data-target="all"><i class="fa fa-search">  Buscar</i></button>
                                    <button type="button" @click="limpiar()" class="btn mb-1 btn-simple btn-sm btn-default btn-filter" data-target="approved"><i class="icon-refresh">  Limpiar</i></button>
                                    <button  type="button" v-if="$can('administracion.grupos.store')" @click="AbriModalCrearUbigeo()" class="btn mb-1 btn-simple btn-sm btn-success btn-filter" data-target="blocked"><i class="fa fa-plus-square-o">  Nuevo</i></button>
                                </div>
                            </div>
                        </div>
                        <div class="body">
                            <div class="table-responsive" v-if="ubigeos.length==0">
                                <table class="table table-hover m-b-0 c_list">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Código</th>
                                            <th class="text-center">Descripción</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center">Opciones</th>
                                        </tr>
                                    </thead>
                                        <tbody>
                                            <tr><td colspan="5">No se encontraron registros.</td></tr>
                                        </tbody>
                                </table>
                            </div>
                            <div class="table-responsive" v-else>
                                <table class="table table-hover m-b-0 c_list">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Código</th>
                                            <th class="text-center">Descripción</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center">Opciones</th>
                                        </tr>
                                    </thead>
                                        <tbody>
                                            <tr v-for="(item, index) in ubigeos" :key="index">
                                                <td class="text-center">
                                                    <p class="c_name">{{index+1}}</p>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.ubicacion_id}}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.descripcion}}</span>
                                                </td>
                                                <td class="text-center" >
                                                    <span class="badge badge-success" v-if="item.estado==1">Activo</span>
                                                    <span class="badge badge-danger" v-if="item.estado==0">Anulado</span>
                                                </td>
                                                <td class="text-center">
                                                    <button v-if="$can('administracion.grupos.update')" type="button"  class="btn btn-info" @click="editDataUbigeos(item.ubicacion_id)" title="Editar Ubigeo"><i class="fa fa-edit"></i></button>
                                                    <span  v-if="$can('administracion.grupos.delete')"><button v-if="item.estado==1" type="button" @click="deleteDataUbigeos(item.ubicacion_id)" data-type="confirm" class="btn btn-danger js-sweetalert" title="Borrar Ubigeo"><i class="fa fa-trash-o"></i></button></span>
                                                    <span  v-if="$can('administracion.grupos.active')"><button v-if="item.estado==0" type="button" @click="ActiveDataUbigeos(item.ubicacion_id)" data-type="confirm" class="btn btn-success js-sweetalert" title="ACtivar Ubigeo"><i class="fa fa-check"></i></button></span>

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

        <!-- MODAL PARA CREAR UBIGEOS     -->
         <modal-crear-mantenedores-ubigeo></modal-crear-mantenedores-ubigeo>

        <!-- MODAL PARA EDITAR grupos     -->
         <modal-editar-mantenedores-ubigeo></modal-editar-mantenedores-ubigeo>


    </div>
</template>
<script>
    import axios from 'axios'

    export default {
    data() {
        return{
            ubigeos:[],
            buscador:{
                ubicacion_id:'',
                descripcion:''
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
            axios.get(`${this.variableGlobal}/lista-mantenedores-ubigeos-total-pages`).then(({data}) => {
                this.total = parseInt(data[0].total);
                this.total_pages = Math.ceil(this.total/10);
                if(this.tipo_busqueda==1){
                    this.getUbigeos(this.currentPage);
                }
                if(this.tipo_busqueda==2){
                    this.searchUbigeo();
                }
            }).catch((error) => {
                console.log(error);
            });
        },
        getUbigeos(i){
            this.loading=true;
            axios.get(`${this.variableGlobal}/lista-mantenedores-ubigeos-list/`+i).then(({data}) => {
                this.ubigeos = data;
                this.loading=false;
            }).catch((error) => {
                console.log(error);
            });

        },
        onPageChange(page) {
            this.currentPage = page;
            if(this.tipo_busqueda==1){
                this.getUbigeos(this.currentPage);
            }else{
                this.searchUbigeo();
            }

        },
        searchUbigeo(){
            if(this.buscador.descripcion==''){
                console.log('INGRESE SUS PARAMETROS');
            }else{
                this.tipo_busqueda=2;
                this.loading=true;
                axios.post(`${this.variableGlobal}/lista-mantenedores-ubigeos-search/`,this.buscador).then(({data}) => {
                        this.ubigeos = data;
                        this.loading=false;
                }).catch((error) => {
                    console.log(error);
                });
            }
        },
        limpiar(){
            this.buscador.descripcion='';
            this.tipo_busqueda=1;
            this.getTotal();
        },
        AbriModalCrearUbigeo(){
            $('#modalCrearUbigeo').modal({backdrop: 'static', keyboard: false});
            $('#modalCrearUbigeo').modal('show');
        },
        deleteDataUbigeos(id){
            this.$swal.fire({
            title: '¿Estás seguro de anular este ubigeo?',
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
                formData.append('codigo',id)
                var request ={
                    url:`${this.variableGlobal}/delete-ubigeo`,
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
        ActiveDataUbigeos(id){
            this.$swal.fire({
            title: '¿Estás seguro de activar este ubigeo?',
            text: "¡Activarás este ubigeo!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Activar!'
            }).then((result) => {
            if (result.isConfirmed) {
                this.loading=true;
                let formData = new FormData()
                formData.append('codigo',id)
                var request ={
                    url:`${this.variableGlobal}/active-ubigeo`,
                    method:'post',
                    data:formData
                }

                axios(request).then(({data}) => {
                if (data) {
                    this.$swal.fire(
                    'Activado!',
                    'El ubigeo fue activado con éxito.',
                    'success'
                    )
                }
            });
            this.loading=false;
            this.getTotal();
            }
            })
        },
        editDataUbigeos(id){
            $('#modalProcesoEditUbigeos').modal({backdrop: 'static', keyboard: false});
            $('#modalProcesoEditUbigeos').modal('show');
            Bus.$emit("modalEditarUbigeos",id);
        }
    },
    created(){
        this.getTotal();
        Bus.$on("DetalleCreateUbigeos", (data) => {
            this.getTotal();
        });
        Bus.$on("ProcesoEditUbigeo", (data) => {
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
