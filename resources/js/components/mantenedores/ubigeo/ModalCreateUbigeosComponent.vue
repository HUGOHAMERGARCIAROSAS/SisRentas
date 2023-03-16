<template>
    <div class="modal fade xd2" id="modalCrearUbigeo"  tabindex="-1" role="dialog"
          data-keyboard="false" data-backdrop="static">
          <page-loader v-if="loading==true"/>
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center">CREAR UBIGEO</h5>
                </div>
                <div class="modal-body">
                    <form  @submit.prevent="guardarUbigeos">
                        <div class="row">
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Código:</label>
                                <input type="text"  class="form-control" v-model="ubigeo.codigo" >
                                <div v-if="enviado && (!$v.ubigeo.codigo.required)" class="mensajeError">
                                    Debe rellenar el ubigeo
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-9">
                                <label class="form-label" for="lname">Descripción:</label>
                                <input type="text"  class="form-control" v-model="ubigeo.descripcion" >
                                <div v-if="enviado && (!$v.ubigeo.descripcion.required)" class="mensajeError">
                                    Debe rellenar la descripción
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
                                    class="btn btn-danger btn-pill"  @click="closeModalAgregarUbigeos()"
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
                ubigeo:{
                    codigo:'',
                    descripcion:'',
                },

                loading:false,
                enviado:false,
                validado:''
            }
        },
        methods:{
            guardarUbigeos(){
                this.loading=true;
                this.enviado=true;
                this.$v.$touch();
                if (this.$v.$invalid) {
                    this.loading=false;
                    return;
                }else{
                    let formData = new FormData()
                    formData.append('codigo',this.ubigeo.codigo)
                    formData.append('descripcion',this.ubigeo.descripcion.toUpperCase())
                    var request ={
                        url:`${this.variableGlobal}/store-data-ubicacion`,
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
                            text: `Ya existe registro con este código.`,
                            showConfirmButton: false,
                            timer: 2500
                        })
                    }
                    });
                    this.loading=false;
                    this.closeModalAgregarUbigeos();
                }
            },
            closeModalAgregarUbigeos(){
                this.limpiarUbigeo();
                $('#modalCrearUbigeo').modal('hide');
                Bus.$emit("DetalleCreateUbigeos");
            },
            limpiarUbigeo(){
                    this.ubigeo.codigo='',
                    this.ubigeo.descripcion=''
            } 
        },
        created() {
        },
        validations () {
            return {
                ubigeo:{
                    codigo:{ required },
                    descripcion:{required},
                }
            }
        }
    }
</script>


