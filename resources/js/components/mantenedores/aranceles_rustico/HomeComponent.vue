<template>
    <div>
         <page-loader v-if="loading==true"/>
         <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header text-center">
                            <h2>MANTENEDOR ARANCELES RUSTICOS</h2>
                        </div>
                        <div class="body">
                            <div class="row">
                                <div class="col-md-2">
                                </div>
                                <div class="col-md-2">
                                    <select id="2" class="form-control" v-model="buscador.anio" >
                                        <option value="" :selected="true">Año:</option>
                                        <option v-for="(item, index) in todosaniosarancelesr" :key="index" :value="item.anio">{{ item.anio }}</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" placeholder="Ingrese la descripción" v-model="buscador.descripcion" @keyup.enter="searchArancelRusticos()">
                                </div>
                                <div class="col-md-4">
                                    <button type="button" @click="searchArancelRusticos()" class="btn mb-1 btn-simple btn-sm btn-secondary btn-filter" data-target="all"><i class="fa fa-search">  Buscar</i></button>
                                    <button type="button" @click="limpiar()" class="btn mb-1 btn-simple btn-sm btn-default btn-filter" data-target="approved"><i class="icon-refresh">  Limpiar</i></button>
                                    <button  type="button" v-if="$can('mantenedores.aranceles.store')" @click="AbriModalCrearArancelRusticos()" class="btn mb-1 btn-simple btn-sm btn-success btn-filter" data-target="blocked"><i class="fa fa-plus-square-o">  Nuevo</i></button>
                                </div>
                            </div>
                        </div>
                        <div class="body">
                            <div class="table-responsive" v-if="arancelesr.length==0">
                                <table class="table table-hover m-b-0 c_list">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Código</th>
                                            <th class="text-center">Año</th>
                                            <th class="text-center">Clasificación</th>
                                            <th class="text-center">Categoría</th>
                                            <th class="text-center">Monto</th>
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
                                            <th class="text-center">Año</th>
                                            <th class="text-center">Clasificación</th>
                                            <th class="text-center">Categoría</th>
                                            <th class="text-center">Monto</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center">Opciones</th>
                                        </tr>
                                    </thead>
                                        <tbody>
                                            <tr v-for="(item, index) in arancelesr" :key="index">
                                                <td class="text-center">
                                                    <p class="c_name">{{index+1}}</p>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.ararustico_ID}}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.anio}}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.clasific}}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.categor}}</span>
                                                </td>

                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.valor}}</span>
                                                </td>

                                                <td class="text-center" >
                                                    <span class="badge badge-success" v-if="item.activo==1">Activo</span>
                                                    <span class="badge badge-danger" v-if="item.activo==0">Anulado</span>
                                                </td>
                                                <td class="text-center">
                                                    <button v-if="$can('mantenedores.aranceles.update')" type="button"  class="btn btn-info" @click="editDataArancelesRusticos(item.ararustico_ID)" title="Editar Ubigeo"><i class="fa fa-edit"></i></button>
                                                    <span  v-if="$can('mantenedores.aranceles.delete')"><button v-if="item.activo==1" type="button" @click="deleteDataArancelesRusticos(item.ararustico_ID)" data-type="confirm" class="btn btn-danger js-sweetalert" title="Borrar Arancel Rustico"><i class="fa fa-trash-o"></i></button></span>
                                                    <span  v-if="$can('mantenedores.aranceles.active')"><button v-if="item.activo==0" type="button" @click="ActiveDataArancelesRusticos(item.ararustico_ID)" data-type="confirm" class="btn btn-success js-sweetalert" title="Activar Arancel Rustico"><i class="fa fa-check"></i></button></span>
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
         <modal-crear-mantenedores-arancel-rustico></modal-crear-mantenedores-arancel-rustico>

        <!-- MODAL PARA EDITAR grupos     -->
         <modal-editar-mantenedores-arancel-rustico></modal-editar-mantenedores-arancel-rustico>


    </div>
</template>
<script>
    import axios from 'axios'
    import { required, email , minLength } from "vuelidate/lib/validators";

    export default {
    data() {
        return{
            arancelesr:[],
            buscador:{
                anio:'',
                descripcion:'',
                junta:'',
            },

            todosaniosarancelesr:'',
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
        // OBTENER EL TOTAL DE REGISTROS
        getTotal(){
            axios.get(`${this.variableGlobal}/lista-mantenedores-aranceles-rusticos-total-pages`).then(({data}) => {
                this.total = parseInt(data[0].total);
                this.total_pages = Math.ceil(this.total/10);
                if(this.tipo_busqueda==1){
                    this.getArancelesRusticos(this.currentPage);
                }
                if(this.tipo_busqueda==2){
                    this.searchArancelRusticos();
                }
            }).catch((error) => {
                console.log(error);
            });
        },
        //OBTENER LISTADO DE ARANCELES RUSTICOS
        getArancelesRusticos(i){
            this.loading=true;
            axios.get(`${this.variableGlobal}/lista-mantenedores-aranceles-rusticos-list/`+i).then(({data}) => {
                this.arancelesr = data;
                this.loading=false;
            }).catch((error) => {
                console.log(error);
            });

        },

        onPageChange(page) {
            this.currentPage = page;
            if(this.tipo_busqueda==1){
                this.getArancelesRusticos(this.currentPage);
            }else{
                this.searchArancelRusticos();
            }
        },
        //BUSQUEDA DE ARANCELES RUSTICOS
        searchArancelRusticos(){
            if(this.buscador.descripcion=='' && this.buscador.anio==''){
                console.log('INGRESE SUS PARAMETROS');
            }else{
                this.tipo_busqueda=2;
                this.loading=true;
                axios.post(`${this.variableGlobal}/lista-mantenedores-aranceles-rusticos-search/`,this.buscador).then(({data}) => {
                        this.arancelesr = data;
                        this.loading=false;
                }).catch((error) => {
                    console.log(error);
                });
            }
        },
        //LIMPIAR BUSQUEDA DE ARANCELES RUSTICOS
        limpiar(){
            this.buscador.descripcion='';
            this.buscador.anio='';
            this.tipo_busqueda=1;
            this.getTotal();
        },

        AbriModalCrearArancelRusticos(){
            $('#modalCrearArancelRustico').modal({backdrop: 'static', keyboard: false});
            $('#modalCrearArancelRustico').modal('show');
        },

        //ANULAR ARANCELES RUSTICOS
        deleteDataArancelesRusticos(id){
            this.$swal.fire({
            title: '¿Estás seguro de anular este arancel rustico?',
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
                        url:`${this.variableGlobal}/delete-arancel-rustico`,
                        method:'post',
                        data:formData
                    }
                        axios(request).then(({data}) => {
                        if (data) {
                            this.$swal.fire(
                            'Anulado!',
                            'El arancelrustico fue anulado con éxito.',
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
        ActiveDataArancelesRusticos(id){
            this.$swal.fire({
            title: '¿Estás seguro de activar este arancel rustico?',
            text: "¡Activarás este arancel rustico!",
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
                    url:`${this.variableGlobal}/active-arancel-rustico`,
                    method:'post',
                    data:formData
                }

                axios(request).then(({data}) => {
                if (data) {
                    this.$swal.fire(
                        'Activado!',
                        'El arancel rustico fue activado con éxito.',
                        'success'
                        )
                    }
                });
                this.loading=false;
                this.getTotal();
                }
            })
        },

        editDataArancelesRusticos(id){
            $('#modalProcesoEditArancelesRusticos').modal({backdrop: 'static', keyboard: false});
            $('#modalProcesoEditArancelesRusticos').modal('show');
            Bus.$emit("modalEditarClasificadorIngresos",id);
        },

        //OBTENER ANIOS DE REGISTROS DE ARANCELES RUSTICOS
        getAniosArancelRusticos(){
            axios.get(`${this.variableGlobal}/lista-aniosaranceles-rusticos-text`).then(({data}) => {
                this.todosaniosarancelesr = data;
            }).catch((error) => {
                console.log(error);
            });
        }
    },
    created(){
        this.getTotal();
        this.getAniosArancelRusticos();
        Bus.$on("DetalleEditarArancelesRusticos", (data) => {
            this.getTotal();
            this.getAniosArancelRusticos();
        });
        Bus.$on("DetalleCreateArancelesRusticos", (data) => {
            this.getTotal();
            this.getAniosArancelRusticos();
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
