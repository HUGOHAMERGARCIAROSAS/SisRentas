<template>
    <div>
         <page-loader v-if="loading==true"/> 
         <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header text-center">
                            <h2>ADMINISTRACIÓN DE PERSONAS</h2>
                        </div>
                        <div class="body">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" class="form-control" placeholder="Ingrese apellidos y nombres" v-model="buscador.nombres" @keyup.enter="searchPersona()">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" placeholder="Ingrese Código" v-model="buscador.codigo" @keyup.enter="searchPersona()">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" placeholder="Ingrese documento" v-model="buscador.documento" @keyup.enter="searchPersona()">
                                </div>
                                <div class="col-md-4">
                                     <button type="button" @click="searchPersona()" class="btn mb-1 btn-simple btn-sm btn-secondary btn-filter" data-target="all"><i class="fa fa-search">  Buscar</i></button>
                                    <button type="button" @click="limpiar()" class="btn mb-1 btn-simple btn-sm btn-default btn-filter" data-target="approved"><i class="icon-refresh">  Limpiar</i></button>
                                    <button v-if="$can('administracion.persona.store')" type="button" @click="AbriModalCrearPersona()" class="btn mb-1 btn-simple btn-sm btn-success btn-filter" data-target="blocked"><i class="fa fa-plus-square-o">  Nuevo</i></button>
                                </div>
                            </div>
                        </div>
                        <div class="body">
                            <div class="table-responsive" v-if="personas.length==0">
                                <table class="table table-hover m-b-0 c_list">
                                    <thead>
                                        <tr>        
                                            <th class="text-center">#</th>                           
                                            <th class="text-center">Código</th>
                                            <th class="text-center">Persona</th>
                                            <th class="text-center">Dirección</th>
                                            <th class="text-center">Sexo</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center">Opciones</th>
                                        </tr>
                                    </thead>
                                        <tbody >
                                            <tr><td colspan="7">No se encontraron registros.</td></tr>
                                        </tbody>
                                </table>
                            </div>
                            <div class="table-responsive" v-else>
                                <table class="table table-hover m-b-0 c_list">
                                    <thead>
                                        <tr>                                 
                                            <th class="text-center">Código</th>
                                            <th class="text-center">Persona</th>
                                            <th class="text-center">Documento</th>
                                            <th class="text-center">Dirección</th>
                                            <th class="text-center">Sexo</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center">Opciones</th>
                                        </tr>
                                    </thead>
                                        <tbody>
                                            <tr v-for="(item, index) in personas" :key="index">
                                                <td class="text-center">
                                                    <p class="c_name">{{item.persona_ID}}</p>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.texto}}</span>
                                                </td>  
                                                <td class="text-center">
                                                    <p class="c_name">{{item.documento}}</p>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.direccion}}</span>
                                                </td> 
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.sexo}}</span>
                                                </td> 
                                                <td class="text-center" >
                                                    <span class="badge badge-success" v-if="item.estado==1">{{item.estadod}}</span>
                                                    <span class="badge badge-danger" v-if="item.estado==0">{{item.estadod}}</span>
                                                </td>
                                                <td class="text-center">                                            
                                                    <button v-if="$can('administracion.persona.update')" type="button" class="btn btn-info" @click="editDataPersona(item.persona_ID)" title="Edit"><i class="fa fa-edit"></i></button>
                                                    <span v-if="$can('administracion.persona.delete')"><button v-if="item.estado==1" type="button" @click="deleteDataPersona(item.persona_ID)" data-type="confirm" class="btn btn-danger js-sweetalert" title="Delete"><i class="fa fa-trash-o"></i></button></span>
                                                    <span v-if="$can('administracion.persona.active')"><button v-if="item.estado==0" type="button" @click="ActiveDataPersona(item.persona_ID)" data-type="confirm" class="btn btn-success js-sweetalert" title="Active"><i class="fa fa-check"></i></button></span>
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

        <!-- MODAL PARA CREAR PERSONAS     -->
         <modal-crear-administracion-persona></modal-crear-administracion-persona>

        <!-- MODAL PARA EDITAR PERSONAS     -->
         <modal-editar-administracion-persona></modal-editar-administracion-persona>
         
    </div>
</template>
<script>
import axios from 'axios'
export default {
    data() {
        return{
            personas:[],
            buscador:{
                nombres:'',
                documento:'',
                codigo:''
            },
             loading:false,
             currentPage: 1,
             total:0,
             total_pages:0,
             per_page:10,
             tipo_busqueda:1
        }
    },
    methods:{
        getTotal(){
            axios.get(`${this.variableGlobal}/lista-administracion-persona-total-pages`).then(({data}) => {
                this.total = parseInt(data[0].coddoc);
                this.total_pages = Math.ceil(this.total/10);
                if(this.tipo_busqueda==1){
                    this.getPersonas(this.currentPage);
                }
                if(this.tipo_busqueda==2){
                    this.searchPersona();
                }
            }).catch((error) => {
                console.log(error);
            });
        },
        onPageChange(page) {
            this.currentPage = page;
            if(this.tipo_busqueda==1){
                this.getPersonas(this.currentPage);
            }else{
                this.searchPersona();
            }
            
        },
        getPersonas(i){
            this.loading=true;
            axios.get(`${this.variableGlobal}/lista-administracion-persona-list/`+i).then(({data}) => {
                this.personas = data;
                this.loading=false;
            }).catch((error) => {
                console.log(error);
            });
        },
        searchPersona(){
            if(this.buscador.nombres=='' && this.buscador.documento=='' && this.buscador.codigo==''){
                console.log('INGRESE SUS PARAMETROS');
            }else{
                this.tipo_busqueda=2;
                this.loading=true;
                axios.post(`${this.variableGlobal}/lista-administracion-persona-search/`,this.buscador).then(({data}) => {
                        this.personas = data;
                        this.total=parseInt(this.personas.length);
                        this.total_pages = Math.ceil(this.total/10);
                        this.loading=false;
                }).catch((error) => {
                    console.log(error);
                });
            }
        },
        limpiar(){
            this.buscador.nombres='';
            this.buscador.documento='';
            this.buscador.codigo='';
            this.tipo_busqueda=1;
            this.getTotal();
        },
        AbriModalCrearPersona(){
            $('#modalCrearPersona').modal({backdrop: 'static', keyboard: false});
            $('#modalCrearPersona').modal('show');
        },
        deleteDataPersona(id){
            this.loading=true;
            this.$swal.fire({
                title: '¿Desea anular esta persona?',
                text: "Anulará esta persona en el sistema.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Si, anular!'
                }).then((result) => {
                if (result.isConfirmed) {
                    let formData = new FormData()
                    formData.append('persona_id',id)
                    var request ={
                        url:`${this.variableGlobal}/delete-persona`,
                        method:'post',
                        data:formData
                    }
                    axios(request).then(({data}) => {
                        if (data) {
                            this.$swal.fire({
                                icon: 'success',
                                title: 'GUARDADO!',
                                text: "Se eliminó exitosamente",
                                showConfirmButton: false,
                                timer: 2500
                            })
                        }
                    });
                } 
                this.loading=false;
                this.getTotal();
            })
        },
        ActiveDataPersona(id){
            this.loading=true;
            this.$swal.fire({
                title: '¿Desea Activar esta persona?',
                text: "Volverá a estar activo en el sistema.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Si, activar!'
                }).then((result) => {
                if (result.isConfirmed) {
                    let formData = new FormData()
                    formData.append('persona_id',id)
                    var request ={
                        url:`${this.variableGlobal}/active-persona`,
                        method:'post',
                        data:formData
                    }
                    axios(request).then(({data}) => {
                        if (data) {
                            this.$swal.fire({
                                icon: 'success',
                                title: 'GUARDADO!',
                                text: "Se activó exitosamente",
                                showConfirmButton: false,
                                timer: 2500
                            })
                        }
                    });
                } 
                this.loading=false;
                this.getTotal();
            })

        },
        editDataPersona(id){
            $('#modalProcesoEditPersona').modal({backdrop: 'static', keyboard: false});
            $('#modalProcesoEditPersona').modal('show');
            Bus.$emit("modalEditarPersona",id);
        }
    },
    created(){
        this.getTotal();
        Bus.$on("DetalleCreatePersona", (data) => {
            this.getTotal();
        });
        Bus.$on("DetalleEditPersona", (data) => {
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
