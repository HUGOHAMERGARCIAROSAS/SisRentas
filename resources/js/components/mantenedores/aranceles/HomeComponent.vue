<template>
    <div>
         <page-loader v-if="loading==true"/>
         <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header text-center">
                            <h2>MANTENEDOR ARANCELES</h2>
                        </div>
                        <div class="body">
                            <div class="row">
                                <div class="col-md-1">
                                    <select id="2" class="form-control" v-model="buscador.anio" >
                                        <option value="" :selected="true">Año:</option>
                                        <option v-for="(item, index) in todosaniosaranceles" :key="index" :value="item.anio">{{ item.anio }}</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select id="2" class="form-control" v-model="buscador.junta" >
                                        <option value="" :selected="true">Junta:</option>
                                        <option v-for="(item, index) in todosjuntas" :key="index" :value="item.valor">{{ item.texto }}</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" placeholder="Ingrese la descripción (Junta - Vía)" v-model="buscador.descripcion" @keyup.enter="searchArancel()">
                                </div>
                                <div class="col-md-4">
                                    <button type="button" @click="searchArancel()" class="btn mb-1 btn-simple btn-sm btn-secondary btn-filter" data-target="all"><i class="fa fa-search">  Buscar</i></button>
                                    <button type="button" @click="limpiar()" class="btn mb-1 btn-simple btn-sm btn-default btn-filter" data-target="approved"><i class="icon-refresh">  Limpiar</i></button>
                                    <button  type="button" v-if="$can('mantenedores.aranceles.store')" @click="AbriModalCrearArancel()" class="btn mb-1 btn-simple btn-sm btn-success btn-filter" data-target="blocked"><i class="fa fa-plus-square-o">  Nuevo</i></button>
                                </div>
                            </div>
                        </div>
                        <div class="body">
                            <div class="table-responsive" v-if="aranceles.length==0">
                                <table class="table table-hover m-b-0 c_list">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Código</th>
                                            <th class="text-center">Año</th>
                                            <th class="text-center">Número</th>
                                            <th class="text-center">Tipo Vía</th>
                                            <th class="text-center">Vía Junta</th>
                                            <th class="text-center">Cuadra</th>
                                            <th class="text-center">Lado</th>
                                            <th class="text-center">Monto</th>
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
                                            <th class="text-center">Año</th>
                                            <th class="text-center">Número</th>
                                            <th class="text-center">Tipo Vía</th>
                                            <th class="text-center">Vía Junta</th>
                                            <th class="text-center">Cuadra</th>
                                            <th class="text-center">Lado</th>
                                            <th class="text-center">Monto</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center">Opciones</th>
                                        </tr>
                                    </thead>
                                        <tbody>
                                            <tr v-for="(item, index) in aranceles" :key="index">
                                                <td class="text-center">
                                                    <p class="c_name">{{index+1}}</p>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.arancel_ID}}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.anio}}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.numero}}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.tipo_via}}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.descripcion}}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.cuadra}}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.lado}}</span>
                                                </td>

                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.arancel_monto}}</span>
                                                </td>

                                                <td class="text-center" >
                                                    <span class="badge badge-success" v-if="item.activo==1">Activo</span>
                                                    <span class="badge badge-danger" v-if="item.activo==0">Anulado</span>
                                                </td>
                                                <td class="text-center">
                                                    <button v-if="$can('mantenedores.aranceles.update')" type="button"  class="btn btn-info" @click="editDataAranceles(item.arancel_ID)" title="Editar Ubigeo"><i class="fa fa-edit"></i></button>
                                                    <span  v-if="$can('mantenedores.aranceles.delete')"><button v-if="item.activo==1" type="button" @click="deleteDataAranceles(item.arancel_ID)" data-type="confirm" class="btn btn-danger js-sweetalert" title="Borrar Arancel"><i class="fa fa-trash-o"></i></button></span>
                                                    <span  v-if="$can('mantenedores.aranceles.active')"><button v-if="item.activo==0" type="button" @click="ActiveDataAranceles(item.arancel_ID)" data-type="confirm" class="btn btn-success js-sweetalert" title="Activar Arancel"><i class="fa fa-check"></i></button></span>
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
         <modal-crear-mantenedores-arancel></modal-crear-mantenedores-arancel>

        <!-- MODAL PARA EDITAR grupos     -->
         <modal-editar-mantenedores-arancel></modal-editar-mantenedores-arancel>


    </div>
</template>
<script>
    import axios from 'axios'
    import { required, email , minLength } from "vuelidate/lib/validators";

    export default {
    data() {
        return{
            aranceles:[],
            buscador:{
                anio:'',
                descripcion:'',
                junta:'',
            },

            todosaniosaranceles:'',
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
        getTodasJuntas(){
            axios.get(`${this.variableGlobal}/lista-mantenedores-aranceles-total-juntas`).then(({data}) => {
                this.todosjuntas = data;
            }).catch((error) => {
                console.log(error);
            });
        },
        getTotal(){
            axios.get(`${this.variableGlobal}/lista-mantenedores-aranceles-total-pages`).then(({data}) => {
                this.total = parseInt(data[0].total);
                this.total_pages = Math.ceil(this.total/10);
                if(this.tipo_busqueda==1){
                    this.getAranceles(this.currentPage);
                }
                if(this.tipo_busqueda==2){
                    this.searchArancel();
                }
            }).catch((error) => {
                console.log(error);
            });
        },
        getAranceles(i){
            this.loading=true;
            axios.get(`${this.variableGlobal}/lista-mantenedores-aranceles-list/`+i).then(({data}) => {
                this.aranceles = data;
                this.loading=false;
            }).catch((error) => {
                console.log(error);
            });

        },
        onPageChange(page) {
            this.currentPage = page;
            if(this.tipo_busqueda==1){
                this.getAranceles(this.currentPage);
            }else{
                this.searchArancel();
            }
        },
        searchArancel(){
            if(this.buscador.descripcion=='' && this.buscador.anio==''  && this.buscador.junta==''){
                console.log('INGRESE SUS PARAMETROS');
            }else{
                this.tipo_busqueda=2;
                this.loading=true;
                axios.post(`${this.variableGlobal}/lista-mantenedores-aranceles-search/`,this.buscador).then(({data}) => {
                        this.aranceles = data;
                        this.loading=false;
                }).catch((error) => {
                    console.log(error);
                });
            }
        },
        limpiar(){
            this.buscador.descripcion='';
            this.buscador.anio='';
            this.buscador.junta='';
            this.tipo_busqueda=1;
            this.getTotal();
        },
        AbriModalCrearArancel(){
            $('#modalCrearArancel').modal({backdrop: 'static', keyboard: false});
            $('#modalCrearArancel').modal('show');
        },
        deleteDataAranceles(id){
            this.$swal.fire({
            title: '¿Estás seguro de anular este arancel?',
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
                        url:`${this.variableGlobal}/delete-arancel`,
                        method:'post',
                        data:formData
                    }
                        axios(request).then(({data}) => {
                        if (data) {
                            this.$swal.fire(
                            'Anulado!',
                            'El arancel fue anulado con éxito.',
                            'success'
                            )
                        }
                    });
                    this.loading=false;
                    this.getTotal();
                }
            })

        },
        ActiveDataAranceles(id){
            this.$swal.fire({
            title: '¿Estás seguro de activar este arancel?',
            text: "¡Activarás este arancel!",
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
                    url:`${this.variableGlobal}/active-arancel`,
                    method:'post',
                    data:formData
                }

                axios(request).then(({data}) => {
                if (data) {
                    this.$swal.fire(
                    'Activado!',
                    'El arancel fue activado con éxito.',
                    'success'
                    )
                }
            });
            this.loading=false;
            this.getTotal();
            }
            })
        },

        editDataAranceles(id){
            $('#modalProcesoEditAranceles').modal({backdrop: 'static', keyboard: false});
            $('#modalProcesoEditAranceles').modal('show');
            Bus.$emit("modalEditarAranceles",id);
        },
        getAniosArancel(){
            axios.get(`${this.variableGlobal}/lista-aniosaranceles-text`).then(({data}) => {
                this.todosaniosaranceles = data;
            }).catch((error) => {
                console.log(error);
            });
        }
    },
    created(){
        this.getTodasJuntas();
        this.getTotal();
        this.getAniosArancel();
        Bus.$on("DetalleUpdateAranceles", (data) => {
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
