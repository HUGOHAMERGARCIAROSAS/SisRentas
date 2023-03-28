<template>
    <div>
         <page-loader v-if="loading==true"/>
         <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header text-center">
                            <h2>MANTENEDOR FECHA DE VENCIMIENTO ARB + PREDIAL</h2>
                        </div>
                        <div class="body">
                            <div class="row">
                                <div class="col-md-2">
                                </div>
                                <div class="col-md-2">
                                    <select id="2" class="form-control" v-model="buscador.anio" >
                                        <option value="" :selected="true">Año:</option>
                                        <option v-for="(item, index) in fecha_vencimientos" :key="index" :value="item.anio">{{ item.anio }}</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select id="2" class="form-control" v-model="buscador.mes">
                                        <option value="" :selected="true">Mes:</option>
                                        <option v-for="(item, index) in todosmeses" :key="index" :value="item.valor">{{ item.descripcion }}</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" @click="searchFechaVencimiento()" class="btn mb-1 btn-simple btn-sm btn-secondary btn-filter" data-target="all"><i class="fa fa-search">  Buscar</i></button>
                                    <button type="button" @click="limpiar()" class="btn mb-1 btn-simple btn-sm btn-default btn-filter" data-target="approved"><i class="icon-refresh">  Limpiar</i></button>
                                    <button  type="button" v-if="$can('mantenedores.aranceles.store')" @click="AbriModalCrearFechaVencimientos()" class="btn mb-1 btn-simple btn-sm btn-success btn-filter" data-target="blocked"><i class="fa fa-plus-square-o">  Nuevo</i></button>
                                </div>
                            </div>
                        </div>
                        <div class="body">
                            <div class="table-responsive" v-if="list_fecha_vencimientos.length==0">
                                <table class="table table-hover m-b-0 c_list">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Editar</th>
                                            <th class="text-center">Año</th>
                                            <th class="text-center">Mes</th>
                                            <th class="text-center">Vence Arbitrios</th>
                                            <th class="text-center">Vence Predial</th>
                                        </tr>
                                    </thead>
                                        <tbody>
                                            <tr><td colspan="6">No se encontraron registros.</td></tr>
                                        </tbody>
                                </table>
                            </div>
                            <div class="table-responsive" v-else>
                                <table class="table table-hover m-b-0 c_list">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Editar</th>
                                            <th class="text-center">Año</th>
                                            <th class="text-center">Mes</th>
                                            <th class="text-center">Vence Arbitrios</th>
                                            <th class="text-center">Vence Predial</th>
                                        </tr>
                                    </thead>
                                        <tbody>
                                            <tr v-for="(item, index) in list_fecha_vencimientos" :key="index">
                                                <td class="text-center">
                                                    <p class="c_name">{{index+1}}</p>
                                                </td>
                                                <td class="text-center">
                                                    <button v-if="$can('mantenedores.aranceles.update')" type="button"  class="btn btn-info" @click="editDataFechaVencimientos(item.parametro_mes_ID)" title="Editar Ubigeo"><i class="fa fa-edit"></i></button>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.anio}}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.mes}}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.fecha_vence}}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.fecha_predial}}</span>
                                                </td>

                                            </tr>
                                        </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
         </div>

        <!-- MODAL PARA CREAR UBIGEOS     -->

         <modal-crear-mantenedores-fechas-vencimiento></modal-crear-mantenedores-fechas-vencimiento>

        <!-- MODAL PARA EDITAR grupos     -->
         <modal-editar-mantenedores-fechas-vencimiento></modal-editar-mantenedores-fechas-vencimiento>
    </div>
</template>
<script>
    import axios from 'axios'
    export default {
    data() {
        return{

            buscador:{
                anio:'',
                mes:''
            },

            todosmeses:[],
            fecha_vencimientos:[],
            list_fecha_vencimientos:[],

            //VARIABLE DE LOADING
            loading:false

        }
    },
    methods:{
        // OBTENER LISTAS
        getFechaVencimientos(i){
            this.loading=true;
            axios.get(`${this.variableGlobal}/lista-fecha-vencimientos-text/`).then(({data}) => {
                this.list_fecha_vencimientos = data;
                this.loading=false;
            }).catch((error) => {
                console.log(error);
            });

        },

        // LIMPIAR BUSCADOR
        limpiar(){
            this.buscador.mes='';
            this.buscador.anio='';
            this.getFechaVencimientos();
        },

        // BUSCAR FECHA DE VENCIMIENTO
        searchFechaVencimiento(){
            if( this.buscador.anio==''  && this.buscador.mes==''){
                console.log('INGRESE SUS PARAMETROS');
            }else{
                this.loading=true;
                axios.post(`${this.variableGlobal}/lista-mantenedores-fecha-vencimientos-search/`,this.buscador).then(({data}) => {
                        this.list_fecha_vencimientos = data;
                        this.loading=false;
                }).catch((error) => {
                    console.log(error);
                });
            }
        },

        // MODAL PARA CREAR FECHAS DE VENCIMIENTOS
        AbriModalCrearFechaVencimientos(){
            this.estado_accion=1;
            $('#modalCrearFechaVencimientos').modal({backdrop: 'static', keyboard: false});
            $('#modalCrearFechaVencimientos').modal('show');
        },

        // MODAL PARA EDITAR FECHAS DE VENCIMIENTOS
        editDataFechaVencimientos(id){
            $('#modalProcesoEditFechaVencimientos').modal({backdrop: 'static', keyboard: false});
            $('#modalProcesoFechaVencimientos').modal('show');
            Bus.$emit("modalEditarFechaVencimientos",id);
        },

        // AÑOS FECHA VENCIMIENTOS
        getFechaVencimientoAnios(){
            axios.get(`${this.variableGlobal}/get-lista-fecha-vencimiento-anios-text`).then(({data}) => {
                this.fecha_vencimientos = data;
            }).catch((error) => {
                console.log(error);
            });
        },
        //OBTENER MESES
        getMeses(){
                axios.get(`${this.variableGlobal}/lista-general-combos-meses-todo`).then(({data}) => {
                this.todosmeses = data;
            }).catch((error) => {
                console.log(error);
            });
        }
    },
    created(){
        this.getFechaVencimientos();
         this.getMeses();
        //ACTUALIZAR DATA DESPUES DE EDITAR
        this.getFechaVencimientoAnios();
        Bus.$on("DetalleUpdateFechaVencimiento", (data) => {
            this.getFechaVencimientos();
        });
        //ACTUALIZAR DATA DESPUES DE GUARDAR
        Bus.$on("DetalleCreateFechaVencimiento", (data) => {
            this.getFechaVencimientos();
            this.getFechaVencimientoAnios();
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
