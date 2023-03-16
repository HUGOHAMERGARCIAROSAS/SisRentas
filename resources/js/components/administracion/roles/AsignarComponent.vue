<template>
    <div>
        <page-loader v-if="loading==true"/> 
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header text-center letter-title">
                       <span>ROL: {{titulo}}</span> 
                    </div>
                    <div class="card-body">
                        <div class="accordion" id="accordionExample">
                            <div class="form-check text-center" >
                                <button type="button" class="btn btn-info"  @click="seleccionadoRoles(rol_id)"><i class="fa fa fa-refresh"></i> Por Defecto</button>
                            </div>
                            <div class="form-check" style="float:right">
                                <input type="checkbox" v-model="selectAll" id="allnone">
                                <label for="allnone"> Seleccionar Todo/ Deseleccionar Todo</label>
                            </div>
                            <div class="card" v-for="(item, index) in gruposByGrupo" :key="index">
                                <div class="card-header" :id="'heading'+item.grupo_id">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left"  type="button" data-toggle="collapse" 
                                                :data-target="'#collapse'+item.grupo_id" aria-expanded="true" :aria-controls="'collapseOne'+item.grupo_id">
                                        {{item.gru_nombre}}
                                        </button>
                                    </h2>
                                </div>
                                <div :id="'collapse'+item.grupo_id" class="collapse show" :aria-labelledby="'heading'+item.grupo_id" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="row" >
                                            <div class="col-md-3" v-for="(itemx,indexx) in item.order_tareas" :key="indexx">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" :id="itemx.tarea_id" :value="itemx.tarea_id" v-model="seleccionados" number>
                                                    <label :for="itemx.tarea_id" >
                                                        {{itemx.tar_nombre}}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5"></div>
                        <div class="col-md-7">
                            <button type="button" class="btn btn-danger" @click="backRoles()"><i class="icon-close"></i> Regresar</button>
                            <button type="button" class="btn btn-primary" @click="guardarRolesPermisos()"><i class="fa fa-save nav-icon" aria-hidden="true" ></i> Guardar</button>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
         </div>
    </div>
</template>

<script >
    import axios from 'axios'
    const url = window.location.href;
    const lastParam = url.split("/").slice(-1)[0];
    export default {

        data() {
            return{
                loading:false,
                grupos:[],
                gruposByGrupo:[],
                seleccionados:[],
                rol_id:lastParam,
                titulo:'',
                detalle:{
                    rol_id:lastParam,
                    seleccionados:[]
                }
            }
        },
        methods:{
            getRolPermisos(){
                this.loading=true;
                axios.get(`${this.variableGlobal}/lista-administracion-grupos-permisos-byGrupo`).then(({data}) => {
                    this.gruposByGrupo = data;
                    this.loading=false;
                }).catch((error) => {
                    console.log(error);
                });
            },
            seleccionadoRoles(id){
                this.loading=true;
                this.seleccionados=[];
                axios.get(`${this.variableGlobal}/lista-administracion-permisos-roles-list/`+id).then(({data}) => {
                    data.forEach(element => this.seleccionados.push(element.tar_id) );
                    this.loading=false;
                }).catch((error) => {
                    console.log(error);
                });
            },
            getTituloRoles(id){
                this.loading=true;
                axios.get(`${this.variableGlobal}/lista-administracion-permisos-roles-titulo/`+id).then(({data}) => {
                    this.titulo=data[0].rol_nombre;
                    this.loading=false;
                }).catch((error) => {
                    console.log(error);
                });
            },
             guardarRolesPermisos(){
                this.loading=true;
                this.detalle.seleccionados = this.seleccionados;
                if(this.detalle.seleccionados.length > 0 ){
                        this.$swal.fire({
                        title: '¿Estás seguro de actualizar?',
                        text: "Actualizarás los permisos!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, Actualizar!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                axios.post(`${this.variableGlobal}/update-roles-permisos-actual`,this.detalle).then(({data}) => {
                                if (data) {
                                        this.$swal.fire({
                                            icon: 'success',
                                            title: 'GUARDADO!',
                                            text: "Se registro exitosamente",
                                            showConfirmButton: false,
                                            timer: 2500
                                        })
                                    }
                                    this.getTituloRoles(this.rol_id);
                                    this.loading=false;
                                });
                            }
                        })
                }else{
                    this.$swal.fire({
                        title: 'No ha seleccionado ningún permiso para este rol',
                        text: "¡Debe seleccionar alguno!",
                        icon: 'warning',
                        })
                }
                this.loading=false;
            },
            backRoles(){
                window.location.href = `${this.variableGlobal}/administracion-roles`;
            }
        },
        created(){
            this.getRolPermisos();
            this.seleccionadoRoles(lastParam);
            this.getTituloRoles(lastParam);
        },
        computed: {
            selectAll: {
                get: function () {
                    return this.gruposByGrupo.forEach(element => element.order_tareas ? this.seleccionados.length == element.order_tareas.length : false);
                },
                set: function (value) {
                    var seleccionados = [];
                    if (value) {
                        this.gruposByGrupo.forEach(element => 
                            element.order_tareas.forEach(function (element) {
                            seleccionados.push(element.tarea_id)
                            })
                        );
                    }
                    this.seleccionados = seleccionados;
                }
            }
        }
    }
</script>
<style>
.letter-title{
    color:#007bff;
    font-size: 18px
}
.card-header{
    background: #49c5b6;
    color: white;
}
.btn-link{
    color:white;
}
</style>