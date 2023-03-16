<template>
    <div class="modal fade xd2" id="modalCrearTareas"  tabindex="-1" role="dialog"
          data-keyboard="false" data-backdrop="static">
          <page-loader v-if="loading==true"/>
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center">CREAR TAREA</h5>
                </div>
                <div class="modal-body">
                    <form  @submit.prevent="guardarTarea">
                        <div class="row">
                            <div class="mb-3 col-12 col-md-3">
                            <label>Grupo:</label>
                                <select id="2" class="form-control" v-model="tarea.grupo_id" >
                                    <option value="" :selected="true">Seleccionar</option>
                                    <option v-for="(item, index) in todostipogrupo" :key="index" v-bind:value="item.valor">{{item.descripcion}}</option>
                                </select>
                                <div v-if="enviado && !$v.tarea.grupo_id.required" class="mensajeError">
                                    Debe seleccionar el grupo.
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Tarea:</label>
                                <input type="text"  class="form-control" v-model="tarea.tar_nombre" >
                                <div v-if="enviado && (!$v.tarea.tar_nombre.required)" class="mensajeError">
                                    Debe rellenar el tarea
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-6">
                                <label class="form-label" for="lname">Descripción:</label>
                                <input type="text"  class="form-control" v-model="tarea.tar_descripcion" >
                                <div v-if="enviado && (!$v.tarea.tar_descripcion.required)" class="mensajeError">
                                    Debe rellenar la descripción
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-12 col-md-5">
                                <label class="form-label" for="lname">URL:</label>
                                <input type="text"  class="form-control" v-model="tarea.tar_url" >
                                <div v-if="enviado && (!$v.tarea.tar_url.required)" class="mensajeError">
                                    Debe rellenar la url
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-2">
                                <label class="form-label" for="lname">Orden:</label>
                                <input type="text"  class="form-control" v-model="tarea.tar_orden" >
                                <div v-if="enviado && (!$v.tarea.tar_orden.required)" class="mensajeError">
                                    Debe rellenar el Orden
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-5">
                                <label class="form-label" for="lname">&nbsp;</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" v-model="tarea.tar_menu" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        ¿Es tarea de menu?
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                            </div>
                            <div class="mb-3 col-12 col-md-4" style="margin-top:2%">
                                <button type="submit" 
                                    class="btn btn-primary btn-pill"><i class="fa fa-save nav-icon" aria-hidden="true" ></i>
                                    Grabar
                                </button>
                                <button type="button"
                                    class="btn btn-danger btn-pill"  @click="closeModalAgregarTareas()"
                                    ><i class="icon-close"></i>
                                    Cerrar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</template>


<script lang="js">
    import axios from 'axios'
    import { required, email , minLength } from "vuelidate/lib/validators";

    export default {
        data(){
            return{
                tarea:{
                    tar_nombre:'',
                    tar_descripcion:'',
                    tar_url:'',
                    tar_icono:'icon-grid',
                    tar_orden:'',
                    grupo_id:'',
                    tar_menu:''
                },

                loading:false,
                enviado:false,
                validado:'',
                todostipogrupo:''
            }
        },
        methods:{
            guardarTarea(){
                this.loading=true;
                this.enviado=true;
                this.$v.$touch();
                if (this.$v.$invalid) {
                    this.loading=false;
                    return;
                }else{
                    let formData = new FormData()
                    formData.append('tar_nombre',this.tarea.tar_nombre)
                    formData.append('tar_descripcion',this.tarea.tar_descripcion)
                    formData.append('tar_url',this.tarea.tar_url)
                    formData.append('tar_icono',this.tarea.tar_icono)
                    formData.append('tar_orden',this.tarea.tar_orden)
                    formData.append('grupo_id',this.tarea.grupo_id)
                    formData.append('tar_menu',this.tarea.tar_menu)
                    var request ={
                        url:`${this.variableGlobal}/store-data-tareas`,
                        method:'post',
                        data:formData
                    }
                    axios(request).then(({data}) => {
                    if (data) {
                            this.$swal.fire({
                                icon: 'success',
                                title: 'GUARDADO!',
                                text: "Se registro exitosamente",
                                showConfirmButton: false,
                                timer: 2500
                            })
                    }else{
                        this.$swal.fire({
                            icon: 'warning',
                            title: '¡Error!',
                            text: `Ya existe esta tarea.`,
                            showConfirmButton: false,
                            timer: 2500
                        })
                    }
                    });
                    this.loading=false;
                    this.closeModalAgregarTareas();
                }
            },
            closeModalAgregarTareas(){
                this.limpiarTareas();
                $('#modalCrearTareas').modal('hide');
                Bus.$emit("DetalleCreateTareas");
            },
            limpiarTareas(){
                    this.tarea.tar_nombre='',
                    this.tarea.tar_descripcion='',
                    this.tarea.tar_url='',
                    this.tarea.tar_orden='',
                    this.tarea.grupo_id='',
                    this.tarea.tar_menu=''
            },
            getTipoGrupo(){
                axios.get(`${this.variableGlobal}/lista-tipogrupo-text`).then(({data}) => {
                    this.todostipogrupo = data;
                }).catch((error) => {
                    console.log(error);
                });
            },
        },
        created() {
            this.getTipoGrupo();
        },
        validations () {
            return {
                tarea:{
                    tar_nombre:{ required },
                    tar_descripcion:{required},
                    tar_icono:{required},
                    tar_url:{required},
                    tar_orden:{required},
                    grupo_id:{required}
                }
            }
        }
    }
</script>





