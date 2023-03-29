<template>
    <div>
         <page-loader v-if="loading==true"/>
         <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header text-center">
                            <h2>MANTENEDOR CLASIFICADOR DE INGRESOS</h2>
                        </div>
                        <div class="body">
                            <div class="row">
                                <div class="col-md-2">
                                    <select id="2" class="form-control" v-model="buscador.estado" >
                                        <option value="" :selected="true">Estado:</option>
                                        <option value="1" :selected="true">ACTIVO</option>
                                        <option value="0" :selected="true">INACTIVO</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select id="2" class="form-control" v-model="buscador.anio" >
                                        <option value="" :selected="true">Año:</option>
                                        <option v-for="(item, index) in todosaniosclasificadores" :key="index" :value="item.valor">{{ item.valor }}</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" placeholder="Ingrese la descripción" v-model="buscador.descripcion" @keyup.enter="searchClasificadorIngresos()">
                                </div>
                                <div class="col-md-4">
                                    <button type="button" @click="searchClasificadorIngresos()" class="btn mb-1 btn-simple btn-sm btn-secondary btn-filter" data-target="all"><i class="fa fa-search">  Buscar</i></button>
                                    <button type="button" @click="limpiar()" class="btn mb-1 btn-simple btn-sm btn-default btn-filter" data-target="approved"><i class="icon-refresh">  Limpiar</i></button>
                                    <button  type="button" v-if="$can('mantenedores.aranceles.store')" @click="AbriModalCrearClasificadorIngresos()" class="btn mb-1 btn-simple btn-sm btn-success btn-filter" data-target="blocked"><i class="fa fa-plus-square-o">  Nuevo</i></button>
                                </div>
                            </div>
                        </div>
                        <div class="body">
                            <div class="table-responsive" v-if="clasificadores.length==0">
                                <table class="table table-hover m-b-0 c_list">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Código</th>
                                            <th class="text-center">Código Presupuestal</th>
                                            <th class="text-center">Descripción</th>
                                            <th class="text-center">Año</th>
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
                                            <th class="text-center">Código</th>
                                            <th class="text-center">Código Presupuestal</th>
                                            <th class="text-center">Descripción</th>
                                            <th class="text-center">Año</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center">Opciones</th>
                                        </tr>
                                    </thead>
                                        <tbody>
                                            <tr v-for="(item, index) in clasificadores" :key="index">
                                                <td class="text-center">
                                                    <p class="c_name">{{index+1}}</p>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.clai_codigo}}</span>
                                                </td>

                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.clai_presupuesto}}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.clai_descripcion}}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.clai_anio}}</span>
                                                </td>
                                                <td class="text-center" >
                                                    <span class="badge badge-success" v-if="item.clai_estado==1">Activo</span>
                                                    <span class="badge badge-danger" v-if="item.clai_estado==0">Anulado</span>
                                                </td>
                                                <td class="text-center">
                                                    <button v-if="$can('mantenedores.aranceles.update')" type="button"  class="btn btn-info" @click="editDataClasificadorIngresos(item.clai_codigo)" title="Editar Ubigeo"><i class="fa fa-edit"></i></button>
                                                    <span  v-if="$can('mantenedores.aranceles.delete')"><button v-if="item.clai_estado==1" type="button" @click="deleteDataClasificadorIngresos(item.clai_codigo)" data-type="confirm" class="btn btn-danger js-sweetalert" title="Borrar Clasificador"><i class="fa fa-trash-o"></i></button></span>
                                                    <span  v-if="$can('mantenedores.aranceles.active')"><button v-if="item.clai_estado==0" type="button" @click="ActiveDataClasificadorIngresos(item.clai_codigo)" data-type="confirm" class="btn btn-success js-sweetalert" title="Activar Clasificador"><i class="fa fa-check"></i></button></span>
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
         <modal-crear-mantenedores-clasificador-ingresos></modal-crear-mantenedores-clasificador-ingresos>

        <!-- MODAL PARA EDITAR grupos     -->
         <modal-editar-mantenedores-clasificador-ingresos></modal-editar-mantenedores-clasificador-ingresos>


    </div>
</template>
<script>
    import axios from 'axios'
    import { required, email , minLength } from "vuelidate/lib/validators";

    export default {
    data() {
        return{
            clasificadores:[],
            buscador:{
                anio:'',
                descripcion:'',
                estado:''
            },

            todosaniosclasificadores:'',
            todosjuntas:'',

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
        //CANTIDAD TOTAL DE REGISTROS
        getTotal(){
            axios.get(`${this.variableGlobal}/lista-mantenedores-clasificador-ingresos-total-pages`).then(({data}) => {
                this.total = parseInt(data[0].coddoc);
                this.total_pages = Math.ceil(this.total/10);
                if(this.tipo_busqueda==1){
                    this.getClasificadorIngresos(this.currentPage);
                }
                if(this.tipo_busqueda==2){
                    this.searchClasificadorIngresos();
                }
            }).catch((error) => {
                console.log(error);
            });
        },

        //LISTADO SEGUN PAGINACION
        getClasificadorIngresos(i){
            this.loading=true;
            axios.get(`${this.variableGlobal}/lista-mantenedores-clasificador-ingresos-list/`+i).then(({data}) => {
                this.clasificadores = data;
                this.loading=false;
            }).catch((error) => {
                console.log(error);
            });

        },
        onPageChange(page) {
            this.currentPage = page;
            if(this.tipo_busqueda==1){
                this.getClasificadorIngresos(this.currentPage);
            }else{
                this.searchClasificadorIngresos();
            }
        },

        //BUSCADOR DE CLASIFICADORES
        searchClasificadorIngresos(){
            if(this.buscador.descripcion=='' && this.buscador.anio==''  && this.buscador.estado==''){
                console.log('INGRESE SUS PARAMETROS');
            }else{
                this.tipo_busqueda=2;
                this.loading=true;
                axios.post(`${this.variableGlobal}/lista-mantenedores-clasificador-ingresos-search/`,this.buscador).then(({data}) => {
                        this.clasificadores = data;
                        this.loading=false;
                }).catch((error) => {
                    console.log(error);
                });
            }
        },

        //LIMPIAR INPUT DE BUSQUEDA
        limpiar(){
            this.buscador.descripcion='';
            this.buscador.anio='';
            this.buscador.estado='';
            this.tipo_busqueda=1;
            this.getTotal();
        },

        //ABRIR CREAR CLASIFICADOR
        AbriModalCrearClasificadorIngresos(){
            $('#modalCrearClasificadorIngresos').modal({backdrop: 'static', keyboard: false});
            $('#modalCrearClasificadorIngresos').modal('show');
        },

        //ANULAR CLASIFICADOR
        deleteDataClasificadorIngresos(id){
            this.$swal.fire({
            title: '¿Estás seguro de anular este clasificador?',
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
                        url:`${this.variableGlobal}/delete-clasificador-ingresos`,
                        method:'post',
                        data:formData
                    }
                        axios(request).then(({data}) => {
                        if (data) {
                            this.$swal.fire(
                            'Anulado!',
                            'El clasificador fue anulado con éxito.',
                            'success'
                            )
                        }
                    });
                    this.loading=false;
                    this.getTotal();
                }
            })

        },

        //ACTIVAR CLASIFICADOR
        ActiveDataClasificadorIngresos(id){
            this.$swal.fire({
            title: '¿Estás seguro de activar este clasificador?',
            text: "¡Activarás este clasificador!",
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
                    url:`${this.variableGlobal}/active-clasificador-ingresos`,
                    method:'post',
                    data:formData
                }

                axios(request).then(({data}) => {
                if (data) {
                    this.$swal.fire(
                    'Activado!',
                    'El clasificador fue activado con éxito.',
                    'success'
                    )
                }
            });
            this.loading=false;
            this.getTotal();
            }
            })
        },

        editDataClasificadorIngresos(id){
            $('#modalProcesoEditClasificadorIngresos').modal({backdrop: 'static', keyboard: false});
            $('#modalProcesoEditClasificadorIngresos').modal('show');
            Bus.$emit("modalEditarClasificadorIngresos",id);
        },

        //GET AÑOS DE REGISTROS
        getAniosClasificadorIngresos(){
            axios.get(`${this.variableGlobal}/lista-aniosclasificadoringresos-text`).then(({data}) => {
                this.todosaniosclasificadores = data;
            }).catch((error) => {
                console.log(error);
            });
        }
    },
    created(){
        this.getTotal();
        this.getAniosClasificadorIngresos();
        Bus.$on("DetalleEditarClasificadorIngresos", (data) => {
            this.getTotal();
            this.getAniosClasificadorIngresos();
        });
        Bus.$on("DetalleCreateClasificadorIngresos", (data) => {
            this.getTotal();
            this.getAniosClasificadorIngresos();
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
