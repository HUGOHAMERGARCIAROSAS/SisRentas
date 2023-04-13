<template>
    <div>
         <page-loader v-if="loading==true"/>
         <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header text-center">
                            <h2>MANTENEDOR IPM ALCABALA</h2>
                        </div>
                        <div class="body">
                            <div class="row">
                                <div class="col-md-2">
                                </div>
                                <div class="col-md-3">
                                    <select id="2" class="form-control" v-model="buscador.anio" >
                                        <option value="" :selected="true">Año:</option>
                                        <option v-for="(item, index) in todosaniosipmalcabala" :key="index" :value="item.anio">{{ item.anio }}</option>
                                    </select>
                                </div>
                                <div class="col-md-7">
                                    <button type="button" @click="searchIpmAlcabala()" class="btn mb-1 btn-simple btn-sm btn-secondary btn-filter" data-target="all"><i class="fa fa-search">  Buscar</i></button>
                                    <button type="button" @click="limpiar()" class="btn mb-1 btn-simple btn-sm btn-default btn-filter" data-target="approved"><i class="icon-refresh">  Limpiar</i></button>
                                    <button  type="button" v-if="$can('mantenedores.aranceles.store')" @click="AbriModalCrearIpmAlcabala()" class="btn mb-1 btn-simple btn-sm btn-success btn-filter" data-target="blocked"><i class="fa fa-plus-square-o">  Nuevo</i></button>
                                </div>
                            </div>
                        </div>
                        <div class="body">
                            <div class="table-responsive" v-if="ipm_alcabala.length==0">
                                <table class="table table-hover m-b-0 c_list">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Código</th>
                                            <th class="text-center">Año</th>
                                            <th class="text-center">Mes</th>
                                            <th class="text-center">V. Mensual</th>
                                            <th class="text-center">V. Acumulada</th>
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
                                            <th class="text-center">Año</th>
                                            <th class="text-center">Mes</th>
                                            <th class="text-center">V. Mensual</th>
                                            <th class="text-center">V. Acumulada</th>
                                            <th class="text-center">Opciones</th>
                                        </tr>
                                    </thead>
                                        <tbody>
                                            <tr v-for="(item, index) in ipm_alcabala" :key="index">
                                                <td class="text-center">
                                                    <p class="c_name">{{index+1}}</p>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.idipm}}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.anio}}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.descripcion}}</span>
                                                </td>

                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.vmensual}}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.vacumulada}}</span>
                                                </td>
                                                <td class="text-center">
                                                    <button v-if="$can('mantenedores.aranceles.update')" type="button"  class="btn btn-info" @click="editDataIpmAlcabala(item.idipm)" title="Editar IPM"><i class="fa fa-edit"></i></button>
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

        <!-- MODAL PARA CREAR IPM ALCABALA     -->
         <modal-crear-mantenedores-ipm-alcabala></modal-crear-mantenedores-ipm-alcabala>

        <!-- MODAL PARA EDITAR IPM ALCABALA     -->
         <modal-editar-mantenedores-ipm-alcabala></modal-editar-mantenedores-ipm-alcabala>


    </div>
</template>
<script>
    import axios from 'axios'
    import { required, email , minLength } from "vuelidate/lib/validators";

    export default {
    data() {
        return{
            ipm_alcabala:[],
            buscador:{
                anio:'',
                descripcion:'',
                junta:'',
            },

            todosaniosipmalcabala:'',
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
        getTotal(){
            axios.get(`${this.variableGlobal}/lista-mantenedores-ipm-alcabala-total-pages`).then(({data}) => {
                this.total = parseInt(data[0].total);
                this.total_pages = Math.ceil(this.total/10);
                if(this.tipo_busqueda==1){
                    this.getIpmAlcabala(this.currentPage);
                }
                if(this.tipo_busqueda==2){
                    this.searchIpmAlcabala();
                }
            }).catch((error) => {
                console.log(error);
            });
        },
        getIpmAlcabala(i){
            this.loading=true;
            axios.get(`${this.variableGlobal}/lista-mantenedores-ipm-alcabala-list/`+i).then(({data}) => {
                this.ipm_alcabala = data;
                this.loading=false;
            }).catch((error) => {
                console.log(error);
            });

        },
        onPageChange(page) {
            this.currentPage = page;
            if(this.tipo_busqueda==1){
                this.getIpmAlcabala(this.currentPage);
            }else{
                this.searchIpmAlcabala();
            }
        },
        searchIpmAlcabala(){
            if(this.buscador.anio=='' ){
                console.log('INGRESE SUS PARAMETROS');
            }else{
                this.tipo_busqueda=2;
                this.loading=true;
                axios.post(`${this.variableGlobal}/lista-mantenedores-ipm-alcabala-search/`,this.buscador).then(({data}) => {
                        this.ipm_alcabala = data;
                        this.loading=false;
                }).catch((error) => {
                    console.log(error);
                });
            }
        },
        limpiar(){
            this.buscador.anio='';
            this.tipo_busqueda=1;
            this.getTotal();
        },
        AbriModalCrearIpmAlcabala(){
            $('#modalCrearIpmAlcabala').modal({backdrop: 'static', keyboard: false});
            $('#modalCrearIpmAlcabala').modal('show');
        },

        editDataIpmAlcabala(id){
            $('#modalProcesoEditIpmAlcabala').modal({backdrop: 'static', keyboard: false});
            $('#modalProcesoEditIpmAlcabala').modal('show');
            Bus.$emit("modalEditarIpmAlcabala",id);
        },
        getAniosIpmAlcabala(){
            axios.get(`${this.variableGlobal}/lista-anios-ipm-alcabala-text`).then(({data}) => {
                this.todosaniosipmalcabala = data;
            }).catch((error) => {
                console.log(error);
            });
        }
    },
    created(){
        this.getTotal();
        this.getAniosIpmAlcabala();
        Bus.$on("DetalleCreateIpmAlcabala", (data) => {
            this.getTotal();
            this.getAniosIpmAlcabala();
        });
        Bus.$on("ProcesoEditIpmAlcabala", (data) => {
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
