<template>
    <div>
         <page-loader v-if="loading==true"/> 
         <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header text-center">
                            <h2>MANTENEDOR DE EXPEDIENTES</h2>
                        </div>
                        <div class="body">
                            <div class="row">
                                <div class="col-md-2">
                                    <input type="text" class="form-control" placeholder="Número Expediente" v-model="buscador.numero" @keyup.enter="searchExpediente()">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" placeholder="Año" v-model="buscador.anio" @keyup.enter="searchExpediente()">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" placeholder="Interesado" v-model="buscador.interesado" @keyup.enter="searchExpediente()">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" placeholder="Asunto" v-model="buscador.asunto" @keyup.enter="searchExpediente()">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-5">
                                </div>
                                <div class="col-md-4">
                                     <button type="button" @click="searchExpediente()" class="btn mb-1 btn-simple btn-sm btn-secondary btn-filter" data-target="all"><i class="fa fa-search">  Buscar</i></button>
                                    <button type="button" @click="limpiar()" class="btn mb-1 btn-simple btn-sm btn-default btn-filter" data-target="approved"><i class="icon-refresh">  Limpiar</i></button>
                                </div>
                            </div>
                        </div>
                        <div class="body">
                            <div class="table-responsive" v-if="expedientes.length==0">
                                <table class="table table-hover m-b-0 c_list">
                                    <thead>
                                        <tr>                                  
                                            <th class="text-center">opciones</th>
                                            <th class="text-center">Código</th>
                                            <th class="text-center">Expediente</th>
                                            <th class="text-center">Tipo Trámite</th>
                                            <th class="text-center">Remitente</th>
                                            <th class="text-center">Asunto</th>
                                            <th class="text-center">Fecha</th>
                                            <th class="text-center">Hora</th>
                                            <th class="text-center">Referencia</th>
                                            <th class="text-center">Folios</th>
                                            <th class="text-center">Descripción</th>
                                            <th class="text-center">Estado</th>
                                        </tr>
                                    </thead>
                                        <tbody v-if="expedientes.length==0">
                                            <tr><td colspan="12">No se encontraron registros.</td></tr>
                                        </tbody>
                                </table>
                            </div>
                            <div class="table-responsive" v-else>
                                <table class="table table-hover m-b-0 c_list">
                                    <thead>
                                        <tr>                                
                                            <th class="text-center">Opciones</th>
                                            <th class="text-center">Expediente</th>
                                            <th class="text-center">Tipo Trámite</th>
                                            <th class="text-center">Remitente</th>
                                            <th class="text-center">Asunto</th>
                                            <th class="text-center">Fecha</th>
                                            <th class="text-center">Hora</th>
                                            <th class="text-center">Referencia</th>
                                            <th class="text-center">Folios</th>
                                            <th class="text-center">Descripción</th>
                                            <th class="text-center">Estado</th>
                                        </tr>
                                    </thead>
                                        <paginate name="expedientes" :list="expedientes" :per="10" tag="tbody">
                                            <tr v-for="(item, index) in paginated('expedientes')" :key="index">
                                                <td class="text-center">                          
                                                    <button type="button" class="btn btn-warning" @click="editDataExpediente(item.coddocumento,item.anio)" title="Editar"><i class="fa fa-edit"></i></button>
                                                    <button v-if="item.estado==1" type="button" @click="deleteDataExpediente(item.coddocumento,item.anio)" data-type="Anular" class="btn btn-danger js-sweetalert" title="Anular"><i class="fa fa-trash-o"></i></button>
                                                    <button type="button" class="btn btn-info" @click="viewDataExpediente(item.coddocumento,item.anio)" title="Imprimir"><i class="fa fa-picture-o "></i></button>
                                                    <button type="button" class="btn btn-success" @click="adjuntarArchivo(item.coddocumento,item.anio)" title="Adjuntar Archivo"><i class="fa fa-plus "></i></button>   
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.expediente}}</span>
                                                </td>  
                                                <td class="text-center">
                                                    <p class="c_name">{{item.descripcion}}</p>
                                                </td>
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.remitente}}</span>
                                                </td> 
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.asunto}}</span>
                                                </td> 
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.fecha}}</span>
                                                </td> 
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.hora_insert}}</span>
                                                </td> 
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.referencia}}</span>
                                                </td> 
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.folios}}</span>
                                                </td> 
                                                <td class="text-center">
                                                    <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i>{{item.descripcion}}</span>
                                                </td> 
                                                <td class="text-center" >
                                                    <span class="badge badge-success" v-if="item.estado==1">{{item.estadod}}</span>
                                                    <span class="badge badge-danger" v-if="item.estado==0">{{item.estadod}}</span>
                                                </td>
                                                
                                            </tr>
                                        </paginate>
                                </table>
                                <br>
                                <div class="pagination">
                                    <div class="row align-items-center">
                                        <div class="col text-center">
                                            <paginate-links for="expedientes" :classes="{'ul': 'pagination', 'li': 'page-item', 'a': 'page-link'}"></paginate-links>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
         </div>

        <!-- MODAL PARA EDITAR EXPEDIENTE     -->
         <modal-editar-tramite-documentario-expediente></modal-editar-tramite-documentario-expediente>

         <!-- MODAL PARA EDITAR EXPEDIENTE     -->
         <modal-adjuntar-archivo-tramite-documentario-expediente></modal-adjuntar-archivo-tramite-documentario-expediente>
         
    </div>
</template>
<script>
import axios from 'axios'
export default {
    data() {
        return{
            expedientes:[],
            paginate: ['expedientes'],
            buscador:{
                numero:'',
                anio:'2021',
                interesado:'',
                asunto:''
            },
            loading:false,
            editExpediente:{
                numero:'',
                anio:''
            }
        }
    },
    methods:{
        getExpedientes(){
            axios.get(`${this.variableGlobal}/lista-tramite_documentario-expedientes-list`).then(({data}) => {
                this.expedientes = data;
            }).catch((error) => {
                console.log(error);
            });
        },
        searchExpediente(){
            if(this.buscador.numero=='' && this.buscador.anio=='' && this.buscador.interesado=='' && this.buscador.asunto=='' ){
                console.log('INGRESE SUS PARAMETROS');
            }else{
                this.loading=true;
                axios.post(`${this.variableGlobal}/lista-tramite_documentario-expedientes-search/`,this.buscador).then(({data}) => {
                        this.expedientes = data;
                        this.loading=false;
                }).catch((error) => {
                    console.log(error);
                });
            }
        },
        limpiar(){
            this.buscador.numero='';
            this.buscador.interesado='';
            this.buscador.asunto='';
            this.getExpedientes();
        },
        async deleteDataExpediente(id){
            this.loading=true;
            let formData = new FormData()
            formData.append('persona_id',id)
            var request ={
                url:`${this.variableGlobal}/delete-persona`,
                method:'post',
                data:formData
            }
            await axios(request).then(({data}) => {
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
            this.loading=false;
            this.searchExpediente();
        },
        async ActiveDataPersona(id){
            this.loading=true;
            let formData = new FormData()
            formData.append('persona_id',id)
            var request ={
                url:`${this.variableGlobal}/active-persona`,
                method:'post',
                data:formData
            }
            await axios(request).then(({data}) => {
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
            this.loading=false;
            this.searchExpediente();
        },
        editDataExpediente(id,anio){
            this.editExpediente.numero=id;
            this.editExpediente.anio=anio;
            $('#modalProcesoEditExpediente').modal({backdrop: 'static', keyboard: false});
            $('#modalProcesoEditExpediente').modal('show');
            Bus.$emit("modalEditarExpediente",this.editExpediente);
        },
        async deleteDataExpediente(id,anio){
            this.loading=true;
            this.buscador.numero=id;
            this.buscador.anio=anio;
            let formData = new FormData()
            formData.append('numero',id)
            formData.append('anio',anio)
            var request ={
                url:`${this.variableGlobal}/delete-expediente-tramite-documentario`,
                method:'post',
                data:formData
            }
            await axios(request).then(({data}) => {
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
            this.loading=false;
            this.searchExpediente();
        },
        viewDataExpediente(id,anio){
            console.log("Hola");
        },
        adjuntarArchivo(id,anio){
            this.editExpediente.numero=id;
            this.editExpediente.anio=anio;
            $('#modalProcesoAdjuntarArchivoExpediente').modal({backdrop: 'static', keyboard: false});
            $('#modalProcesoAdjuntarArchivoExpediente').modal('show');
            Bus.$emit("modalAdjuntarArchivoExpediente",this.editExpediente);
        }

    },
    created(){
        this.getExpedientes();
    }
}
</script>


<style >
    .pagination {
        display: flex;
        justify-content: center;
    }
</style>
