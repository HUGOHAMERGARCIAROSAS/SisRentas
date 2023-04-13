<template>
    <div>
         <page-loader v-if="loading==true"/>
         <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header text-center">
                            <h2>MANTENEDOR PARAMETROS</h2>
                        </div>
                        <div class="body">
                            <div class="row">
                                <div class="col-md-2">
                                    <select id="2" class="form-control" v-model="buscador.anio" >
                                        <option value="" :selected="true">Año:</option>
                                        <option v-for="(item, index) in todosaniosparametros" :key="index" :value="item.anio">{{ item.anio }}</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select id="2" class="form-control" v-model="buscador.estado" >
                                        <option value="" :selected="true">Estado:</option>
                                        <option value="1">Activo</option>
                                        <option value="0">Anulado</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" placeholder="Ingrese la descripción" v-model="buscador.descripcion" @keyup.enter="searchTotal()">
                                </div>
                                <div class="col-md-5">
                                    <button type="button" @click="searchTotal()" class="btn mb-1 btn-simple btn-sm btn-secondary btn-filter" data-target="all"><i class="fa fa-search">  Buscar</i></button>
                                    <button type="button" @click="limpiar()" class="btn mb-1 btn-simple btn-sm btn-default btn-filter" data-target="approved"><i class="icon-refresh">  Limpiar</i></button>
                                    <button  type="button" v-if="$can('mantenedores.aranceles.store')" @click="AbriModalCrearParametros()" class="btn mb-1 btn-simple btn-sm btn-success btn-filter" data-target="blocked"><i class="fa fa-plus-square-o">  Nuevo</i></button>
                                </div>
                            </div>
                        </div>
                        <div class="body">
                            <div class="table-responsive" v-if="parametros.length==0">
                                <table class="table table-hover m-b-0 c_list">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">código</th>
                                            <th class="text-center">Año</th>
                                            <th class="text-center">Descripción</th>
                                            <th class="text-center">Valor</th>
                                            <th class="text-center">Fecha Registro</th>
                                            <th class="text-center">Usuarios</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center">Opciones</th>
                                        </tr>
                                    </thead>
                                        <tbody>
                                            <tr><td colspan="11">No se encontraron registros.</td></tr>
                                        </tbody>
                                </table>
                            </div>
                            <div class="table-responsive" v-else>
                                <table class="table table-hover m-b-0 c_list">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">código</th>
                                            <th class="text-center">Año</th>
                                            <th class="text-center">Descripción</th>
                                            <th class="text-center">Valor</th>
                                            <th class="text-center">Fecha Registro</th>
                                            <th class="text-center">Usuarios</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center">Opciones</th>
                                        </tr>
                                    </thead>
                                        <tbody>
                                            <tr><td colspan="8">Se encontraron <b>{{total}}</b> registros.</td></tr>
                                            <tr v-for="(item, index) in parametros" :key="index">
                                                <td class="text-center">
                                                    <p class="c_name">{{index+1}}</p>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.codigo}}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.anio}}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.descripcion}}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.valor%1==0 && item.valor!=0 ?  parseInt(item.valor)  : parseFloat(item.valor).toFixed(2)}}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.registro_fecha}}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.registro_user}}</span>
                                                </td>
                                                 <td class="text-center" >
                                                    <span class="badge badge-success" v-if="item.estado==1">Activo</span>
                                                    <span class="badge badge-danger" v-if="item.estado==0">Anulado</span>
                                                </td>
                                                <td class="text-center">
                                                    <button v-if="$can('mantenedores.aranceles.update')" type="button"  class="btn btn-info" @click="editDataParametros(item.parametros_id)" title="Editar Parametros"><i class="fa fa-edit"></i></button>
                                                     <span  v-if="$can('mantenedores.aranceles.delete')"><button v-if="item.estado==1" type="button" @click="deleteDataParametros(item.parametros_id)" data-type="confirm" class="btn btn-danger js-sweetalert" title="Borrar parametros"><i class="fa fa-trash-o"></i></button></span>
                                                    <span  v-if="$can('mantenedores.aranceles.active')"><button v-if="item.estado==0" type="button" @click="ActiveDataParametros(item.parametros_id)" data-type="confirm" class="btn btn-success js-sweetalert" title="Activar parametros"><i class="fa fa-check"></i></button></span>
                                                </td>
                                            </tr>
                                        </tbody>
                                </table>
                                <br>
                                <pagination-view :total-pages="total_pages"
                                    :total="total"
                                    :per-page="per_page"
                                    :current-page="currentPage"
                                    @pagechanged="onPageChange" v-if="tipo_busqueda==1">
                                </pagination-view>
                                <pagination-view :total-pages="total_pages"
                                    :total="total"
                                    :per-page="per_page"
                                    :current-page="currentPage"
                                    @pagechanged="onPageChangeSearch" v-if="tipo_busqueda==2">
                                </pagination-view>
                            </div>
                        </div>
                    </div>
                </div>
         </div>

        <!-- MODAL PARA CREAR PARAMETROS    -->
         <modal-crear-mantenedores-parametros></modal-crear-mantenedores-parametros>

        <!-- MODAL PARA EDITAR PARAMETROS    -->
         <modal-editar-mantenedores-parametros></modal-editar-mantenedores-parametros>


    </div>
</template>
<script>
    import axios from 'axios'
    import { required, email , minLength } from "vuelidate/lib/validators";

    export default {
    data() {
        return{
            parametros:[],
            buscador:{
                anio:'',
                descripcion:'',
                estado:'',
                page:''
            },

            todosaniosparametros:'',

            //VARIABLE DE LOADING
            loading:false,

            //VARIABLES DE PAGINACION
            currentPage: 1,
            total:0,
            total_pages:0,
            per_page:10,
            tipo_busqueda:1,
            tipo_accion:1
        }
    },
    methods:{
        getTotal(){
            axios.get(`${this.variableGlobal}/lista-mantenedores-parametros-total-pages`).then(({data}) => {
                this.total = parseInt(data[0].total);
                this.total_pages = Math.ceil(this.total/10);
                this.getParametros(this.currentPage);
            }).catch((error) => {
                console.log(error);
            });
        },
        getParametros(i){
            this.loading=true;
            axios.get(`${this.variableGlobal}/lista-mantenedores-parametros-list/`+i).then(({data}) => {
                this.parametros = data;
                this.loading=false;
            }).catch((error) => {
                console.log(error);
            });

        },
        onPageChange(page) {
            this.currentPage = page;
            this.getParametros(this.currentPage);
        },
        searchTotal(){
            if(this.buscador.anio=='' && this.buscador.descripcion=='' && this.buscador.estado=='' ){
                console.log('INGRESE SUS PARAMETROS');
            }else{
                this.tipo_busqueda=2;
                this.loading=true;
                this.tipo_accion==1 ?  this.currentPage=1 : '';
                axios.post(`${this.variableGlobal}/lista-mantenedores-parametros-search-total/`,this.buscador).then(({data}) => {
                        this.total = parseInt(data.length);
                        this.total_pages = Math.ceil(this.total/10);
                        this.searchParametros(this.currentPage);
                        this.tipo_accion=1;
                        this.loading=false;
                }).catch((error) => {
                    console.log(error);
                });
            }
        },
        searchParametros(i){
            if(this.buscador.anio=='' && this.buscador.descripcion=='' && this.buscador.estado=='' ){
                console.log('INGRESE SUS PARAMETROS');
            }else{
                this.tipo_busqueda=2;
                this.loading=true;
                this.buscador.page=i;
                axios.post(`${this.variableGlobal}/lista-mantenedores-parametros-search/`,this.buscador).then(({data}) => {
                        this.parametros = data;
                        this.loading=false;
                }).catch((error) => {
                    console.log(error);
                });
            }
        },
        onPageChangeSearch(page){
            this.currentPage = page;
            this.searchParametros(page);
        },
        limpiar(){
            this.buscador.anio='';
            this.buscador.estado='';
            this.buscador.descripcion='';
            this.currentPage=1;
            this.tipo_busqueda=1;
            this.getTotal();
        },
        AbriModalCrearParametros(){
            $('#modalCrearParametros').modal({backdrop: 'static', keyboard: false});
            $('#modalCrearParametros').modal('show');
        },
        editDataParametros(id){
            $('#modalProcesoEditParametros').modal({backdrop: 'static', keyboard: false});
            $('#modalProcesoEditParametros').modal('show');
            Bus.$emit("modalEditarParametros",id);
        },
        getAniosParametros(){
            axios.get(`${this.variableGlobal}/lista-anios-parametros-text`).then(({data}) => {
                this.todosaniosparametros = data;
            }).catch((error) => {
                console.log(error);
            });
        },
        deleteDataParametros(id){
            this.$swal.fire({
            title: '¿Estás seguro de anular este parametro?',
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
                        url:`${this.variableGlobal}/delete-parametros`,
                        method:'post',
                        data:formData
                    }
                    axios(request).then(({data}) => {
                        if (data) {
                            this.$swal.fire(
                            'Anulado!',
                            'El parametro fue anulado con éxito.',
                            'success'
                            )
                        }
                    });
                    this.loading=false;
                    this.tipo_accion=2;
                    this.tipo_busqueda==1 ?  this.getTotal() : this.searchTotal();


                }
            })

        },
        ActiveDataParametros(id){
            this.$swal.fire({
            title: '¿Estás seguro de activar este parametro?',
            text: "¡Activarás este parametro!",
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
                            url:`${this.variableGlobal}/active-parametros`,
                            method:'post',
                            data:formData
                        }
                        axios(request).then(({data}) => {
                        if (data) {
                            this.$swal.fire(
                            'Activado!',
                            'El parametro fue activado con éxito.',
                            'success'
                            )
                        }
                    });
                    this.loading=false;
                    this.tipo_accion=2;
                    this.tipo_busqueda==1 ?  this.getTotal() : this.searchTotal();

                }
            })
        },
    },
    created(){
        this.getTotal();
        this.getAniosParametros();
        Bus.$on("DetalleCreateParametro", (data) => {
            this.getTotal();
            this.getAniosParametros();
        });
        Bus.$on("ProcesoEditParametros", (data) => {
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
