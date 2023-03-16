<template>
    <div class="modal fade xd2" id="modalCrearGrupos"  tabindex="-1" role="dialog"
          data-keyboard="false" data-backdrop="static">
          <page-loader v-if="loading==true"/>
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center">CREAR GRUPO</h5>
                </div>
                <div class="modal-body">
                    <form  @submit.prevent="guardarGrupos">
                        <div class="row">
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Nombre:</label>
                                <input type="text"  class="form-control mayus" v-model="grupo.gru_nombre" >
                                <div v-if="enviado && (!$v.grupo.gru_nombre.required)" class="mensajeError">
                                    Debe rellenar el Grupo
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-4">
                                <label class="form-label" for="lname">Descripción:</label>
                                <input type="text"  class="form-control" v-model="grupo.gru_descripcion" >
                                <div v-if="enviado && (!$v.grupo.gru_descripcion.required)" class="mensajeError">
                                    Debe rellenar la descripción
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Icono:</label>
                                <input type="text"  class="form-control" v-model="grupo.gru_icono" >
                                <div v-if="enviado && (!$v.grupo.gru_icono.required)" class="mensajeError">
                                    Debe rellenar el icono
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-2">
                                <label class="form-label" for="lname">Orden:</label>
                                <input type="text"  class="form-control" v-model="grupo.gru_orden" >
                                <div v-if="enviado && (!$v.grupo.gru_orden.required)" class="mensajeError">
                                    Debe rellenar el Orden
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
                                    class="btn btn-danger btn-pill"  @click="closeModalAgregarGrupos()"
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
                grupo:{
                    gru_nombre:'',
                    gru_descripcion:'',
                    gru_icono:'',
                    gru_orden:'',
                },

                loading:false,
                enviado:false,
                validado:''
            }
        },
        methods:{
            guardarGrupos(){
                this.loading=true;
                this.enviado=true;
                this.$v.$touch();
                if (this.$v.$invalid) {
                    this.loading=false;
                    return;
                }else{
                    let formData = new FormData()
                    formData.append('gru_nombre',this.grupo.gru_nombre.toUpperCase())
                    formData.append('gru_descripcion',this.grupo.gru_descripcion)
                    formData.append('gru_icono',this.grupo.gru_icono)
                    formData.append('gru_orden',this.grupo.gru_orden)
                    var request ={
                        url:`${this.variableGlobal}/store-data-grupos`,
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
                            text: `Ya existe este grupo.`,
                            showConfirmButton: false,
                            timer: 2500
                        })
                    }
                    });
                    this.loading=false;
                    this.closeModalAgregarGrupos();
                }
            },
            closeModalAgregarGrupos(){
                this.limpiarGrupos();
                $('#modalCrearGrupos').modal('hide');
                Bus.$emit("DetalleCreateGrupos");
            },
            limpiarGrupos(){
                    this.grupo.gru_nombre='',
                    this.grupo.gru_descripcion='',
                    this.grupo.gru_icono='',
                    this.grupo.gru_orden=''
            }
        },
        created() {
        },
        validations () {
            return {
                grupo:{
                    gru_nombre:{ required },
                    gru_descripcion:{required},
                    gru_icono:{required},
                    gru_orden:{required}
                }
            }
        }
    }
</script>


