<template>
    <div>
         <page-loader v-if="loading==true"/>
         <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header text-center">
                            <h2>MANTENEDOR TRIBUTOS</h2>
                        </div>
                        <div class="body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="">Grupo: </label>
                                    <select id="2" class="form-control" v-model="buscador.grupo" >
                                        <option value="" :selected="true">Seleccione Grupo:</option>
                                        <option v-for="(item, index) in todostributosgrupo" :key="index" :value="item.valor">{{ item.descripcion }}</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Descripción: </label>
                                    <input type="text" class="form-control" placeholder="Ingrese la descripción" v-model="buscador.descripcion" @keyup.enter="searchTributos()">
                                </div>
                                <div class="col-md-4">
                                    <label for="">Área: </label>
                                    <select id="2" class="form-control" v-model="buscador.area" >
                                        <option value="" :selected="true">Seleccione Área:</option>
                                        <option v-for="(item, index) in todostributosarea" :key="index" :value="item.valor">{{ item.descripcion }}</option>
                                    </select>
                                </div>
                            </div>
                            <!-- <br>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="">Genérica: </label>
                                    <select id="2" class="form-control" v-model="buscador.generica"   @change="changeGenerica($event)">
                                        <option value="" :selected="true">Seleccione Genérica:</option>
                                        <option v-for="(item, index) in todostributosgenerica" :key="index" :value="item.cod_generica">{{ item.generica }}</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Sub-Genérica: </label>
                                    <select id="2" class="form-control" v-model="buscador.subgenerica" @change="changeSubGenerica($event)">
                                        <option value="" :selected="true">Seleccione Sub-Genérica:</option>
                                        <option v-for="(item, index) in todostributossubgenerica" :key="index" :value="item.cod_sgenerica">{{ item.sgenerica }}</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Específica: </label>
                                    <select id="2" class="form-control" v-model="buscador.especifica" >
                                        <option value="" :selected="true">Seleccione Específica:</option>
                                        <option v-for="(item, index) in todostributosespecifica" :key="index" :value="item.cod_especifica">{{ item.especifica }}</option>
                                    </select>
                                </div>
                            </div> -->
                            <br>
                            <div class="row">
                                <div class="col-md-4">
                                </div>
                                <div class="col-md-4">
                                    <button type="button" @click="searchTributos()" class="btn mb-1 btn-simple btn-sm btn-secondary btn-filter" data-target="all"><i class="fa fa-search">  Buscar</i></button>
                                    <button type="button" @click="limpiar()" class="btn mb-1 btn-simple btn-sm btn-default btn-filter" data-target="approved"><i class="icon-refresh">  Limpiar</i></button>
                                    <button  type="button" v-if="$can('mantenedores.aranceles.store')" @click="AbriModalCrearTributos()" class="btn mb-1 btn-simple btn-sm btn-success btn-filter" data-target="blocked"><i class="fa fa-plus-square-o">  Nuevo</i></button>
                                </div>
                            </div>
                        </div>
                        <div class="body">
                            <div class="table-responsive" v-if="tributos.length==0">
                                <table class="table table-hover m-b-0 c_list">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Código</th>
                                            <th class="text-center">Descripción</th>
                                            <th class="text-center">Abrev</th>
                                            <th class="text-center">Importe</th>
                                            <th class="text-center">Grupo</th>
                                            <th class="text-center">% UIT</th>
                                            <th class="text-center">presupuesto</th>
                                            <th class="text-center">clasificador</th>
                                            <th class="text-center">Cod. Contable</th>
                                            <th class="text-center">Area</th>
                                            <th class="text-center">% Area</th>
                                            <th class="text-center">Fuente</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center">Opciones</th>
                                        </tr>
                                    </thead>
                                        <tbody>
                                            <tr><td colspan="8">No se encontraron registros.</td></tr>
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
                                            <th class="text-center">Abrev</th>
                                            <th class="text-center">Importe</th>
                                            <th class="text-center">Grupo</th>
                                            <th class="text-center">% UIT</th>
                                            <th class="text-center">presupuesto</th>
                                            <th class="text-center">clasificador</th>
                                            <th class="text-center">Cod. Contable</th>
                                            <th class="text-center">Area</th>
                                            <th class="text-center">% Area</th>
                                            <th class="text-center">Fuente</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center">Opciones</th>
                                        </tr>
                                    </thead>
                                        <tbody>
                                            <tr v-for="(item, index) in tributos" :key="index">
                                                <td class="text-center">
                                                    <p class="c_name">{{index+1}}</p>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.tributos_id}}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.descripcion}}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.abrev}}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.importe}}</span>
                                                </td>

                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.grupo}}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.porce_uit}}</span>
                                                </td>

                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.clai_presupuesto}}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.clai_descripcion}}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.cod_contable}}</span>
                                                </td>

                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.are_descripcion}}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.porce_area}}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.fuente}}</span>
                                                </td>

                                                <td class="text-center" >
                                                    <span class="badge badge-success" v-if="item.activo==1">Activo</span>
                                                    <span class="badge badge-danger" v-if="item.activo==0">Anulado</span>
                                                </td>
                                                <td class="text-center">
                                                    <button v-if="$can('mantenedores.aranceles.update')" type="button"  class="btn btn-info" @click="editDataTributos(item.tributos_id)" title="Editar Tributos"><i class="fa fa-edit"></i></button>
                                                    <span  v-if="$can('mantenedores.aranceles.delete')"><button v-if="item.activo==1" type="button" @click="deleteDataTributos(item.tributos_id)" data-type="confirm" class="btn btn-danger js-sweetalert" title="Borrar Tributos"><i class="fa fa-trash-o"></i></button></span>
                                                    <span  v-if="$can('mantenedores.aranceles.active')"><button v-if="item.activo==0" type="button" @click="ActiveDataTributos(item.tributos_id)" data-type="confirm" class="btn btn-success js-sweetalert" title="Activar Tributos"><i class="fa fa-check"></i></button></span>
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
         <modal-crear-mantenedores-tributos></modal-crear-mantenedores-tributos>

        <!-- MODAL PARA EDITAR grupos     -->
         <modal-editar-mantenedores-tributos></modal-editar-mantenedores-tributos>


    </div>
</template>
<script>
    import axios from 'axios'
    import { required, email , minLength } from "vuelidate/lib/validators";

    export default {
    data() {
        return{
            tributos:[],
            buscador:{
                descripcion:'',
                grupo:'',
                // generica:'',
                // subgenerica:'',
                // especifica:'',
                area:''
            },

            //LISTADO PARA SELECT
            todostributosgrupo:'',
            todostributosgenerica:'',
            todostributossubgenerica:'',
            todostributosespecifica:'',
            todostributosarea:'',

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
        // OBTENER EL TOTAL DE REGISTROS
        getTotal(){
            axios.get(`${this.variableGlobal}/lista-mantenedores-tributos-total-pages`).then(({data}) => {
                this.total = parseInt(data[0].total);
                this.total_pages = Math.ceil(this.total/10);
                if(this.tipo_busqueda==1){
                    this.getTributos(this.currentPage);
                }
                if(this.tipo_busqueda==2){
                    this.searchTributos();
                }
            }).catch((error) => {
                console.log(error);
            });
        },
        //OBTENER LISTADO DE TRIBUTOS
        getTributos(i){
            this.loading=true;
            axios.get(`${this.variableGlobal}/lista-mantenedores-tributos-list/`+i).then(({data}) => {
                this.tributos = data;
                this.loading=false;
            }).catch((error) => {
                console.log(error);
            });

        },

        onPageChange(page) {
            this.currentPage = page;
            if(this.tipo_busqueda==1){
                this.getTributos(this.currentPage);
            }else{
                this.searchTributos();
            }
        },


        //BUSQUEDA DE TRIBUTOS
        searchTributos(){
            if(this.buscador.descripcion=='' && this.buscador.grupo==''    && this.buscador.area==''){
                console.log('INGRESE SUS PARAMETROS');
            }else{
                this.tipo_busqueda=2;
                this.loading=true;
                axios.post(`${this.variableGlobal}/lista-mantenedores-tributos-search/`,this.buscador).then(({data}) => {
                        this.tributos = data;
                        this.loading=false;
                }).catch((error) => {
                    console.log(error);
                });
            }
        },



        //LIMPIAR BUSQUEDA DE ARANCELES RUSTICOS
        limpiar(){
            this.buscador.descripcion='';
            this.buscador.grupo='';
            this.buscador.generica='';
            this.buscador.subgenerica='';
            this.buscador.especifica='';
            this.buscador.area='';
            this.tipo_busqueda=1;
            this.getTotal();
        },

        AbriModalCrearTributos(){
            $('#modalCrearTributos').modal({backdrop: 'static', keyboard: false});
            $('#modalCrearTributos').modal('show');
        },

        //ANULAR ARANCELES RUSTICOS
        deleteDataTributos(id){
            this.$swal.fire({
            title: '¿Estás seguro de anular este tributo?',
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
                        url:`${this.variableGlobal}/delete-tributos`,
                        method:'post',
                        data:formData
                    }
                        axios(request).then(({data}) => {
                        if (data) {
                            this.$swal.fire(
                            'Anulado!',
                            'El tributo fue anulado con éxito.',
                            'success'
                            )
                        }
                    });
                    this.loading=false;
                    this.getTotal();
                }
            })

        },

        //ACTIVAR ARANCELES RUSTICOS
        ActiveDataTributos(id){
            this.$swal.fire({
            title: '¿Estás seguro de activar este tributo?',
            text: "¡Activarás este tributo!",
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
                    url:`${this.variableGlobal}/active-tributos`,
                    method:'post',
                    data:formData
                }

                axios(request).then(({data}) => {
                if (data) {
                    this.$swal.fire(
                        'Activado!',
                        'El tributo fue activado con éxito.',
                        'success'
                        )
                    }
                });
                this.loading=false;
                this.getTotal();
                }
            })
        },


        editDataTributos(id){
            $('#modalProcesoEditTributos').modal({backdrop: 'static', keyboard: false});
            $('#modalProcesoEditTributos').modal('show');
            Bus.$emit("modalEditarTributos",id);
        },

        //OBTENER GRUPO DE TRIBUTOS
        getListGrupoTributos(){
            axios.get(`${this.variableGlobal}/lista-tributos-grupos-text`).then(({data}) => {
                this.todostributosgrupo = data;
            }).catch((error) => {
                console.log(error);
            });
        },
        //OBTENER GENERICOS
        // getListGenericoTributos(){
        //     axios.get(`${this.variableGlobal}/lista-tributos-genericos-text`).then(({data}) => {
        //         this.todostributosgenerica = data;
        //     }).catch((error) => {
        //         console.log(error);
        //     });
        // },
        //OBTENER SUBGENERICOS A PARTIR DE GENERICOS
        // changeGenerica(){
        //     let value=this.buscador.generica;
        //     axios.get(`${this.variableGlobal}/lista-tributos-subgenericos-text/`+value).then(({data}) => {
        //         this.todostributossubgenerica = data;
        //     }).catch((error) => {
        //         console.log(error);
        //     });
        // },
        //OBTENER ESPECIFICOS A PARTIR DE SUBGENERICOS
        // changeSubGenerica(){
        //     let value=this.buscador.subgenerica;
        //     axios.get(`${this.variableGlobal}/lista-tributos-especifica-text/`+value).then(({data}) => {
        //         this.todostributosespecifica = data;
        //     }).catch((error) => {
        //         console.log(error);
        //     });
        // },
        //OBTENER AREA DE TRIBUTO
        getListAreaTributos(){
            axios.get(`${this.variableGlobal}/lista-tributos-area-text`).then(({data}) => {
                this.todostributosarea = data;
            }).catch((error) => {
                console.log(error);
            });
        }
    },
    created(){
        this.getTotal();
        this.getListGrupoTributos();
        // this.getListGenericoTributos();
        this.getListAreaTributos();

        Bus.$on("DetalleEditarTributos", (data) => {
            this.getTotal();
            this.getListGrupoTributos();
            // this.getListGenericoTributos();
            this.getListAreaTributos();
        });

        Bus.$on("DetalleCreateTributos", (data) => {
            this.getTotal();
            this.getListGrupoTributos();
            // this.getListGenericoTributos();
            this.getListAreaTributos();
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
