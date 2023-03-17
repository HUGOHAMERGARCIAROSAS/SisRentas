<template>
    <div class="modal fade xd2" id="modalProcesoEditUbigeos"  tabindex="-1" role="dialog"
          data-keyboard="false" data-backdrop="static">
          <page-loader v-if="loading==true"/>
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center">EDITAR UBIGEOS</h5>
                </div>
                <div class="modal-body">
                    <form  @submit.prevent="editarUbigeos">
                        <div class="row">
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Código:</label>
                                <input type="text"  class="form-control" v-model="ubigeo.codigo" readonly>
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
                                    class="btn btn-danger btn-pill"  @click="closeModalEditarUbigeos()"
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
                    descripcion:''
                },
                loading:false,
                enviado:false,
                validado:'',
                selectEditUbigeo:''
            }
        },
        methods:{
            editarUbigeos(){
                this.loading=true;
                this.enviado=true;
                this.$v.$touch();
                if (this.$v.$invalid) {
                    this.loading=false;
                    return;
                }else{
                    let formData = new FormData()
                    formData.append('codigo',this.ubigeo.codigo)
                    formData.append('descripcion',this.ubigeo.descripcion)
                    var request ={
                        url:`${this.variableGlobal}/update-data-ubigeos`,
                        method:'post',
                        data:formData
                    }
                    axios(request).then(({data}) => {
                    if (data) {
                            this.$swal.fire({
                                icon: 'success',
                                title: 'GUARDADO!',
                                text: "Se actualizó exitosamente",
                                showConfirmButton: false,
                                timer: 2500
                        })
                    }else{
                    this.$swal.fire({
                        icon: 'warning',
                        title: '¡Error!',
                        text: `Ya existe este ubigeo.`,
                        showConfirmButton: false,
                        timer: 2500
                    })
                    }
                    });
                    this.loading=false;
                    this.closeModalEditarUbigeos();
                }
            },
            closeModalEditarUbigeos(){
                $('#modalProcesoEditUbigeos').modal('hide');
                Bus.$emit("ProcesoEditUbigeo");
            },
            getDataUbigeos(id){
                axios.get(`${this.variableGlobal}/datos-ubigeos-edit/`+id).then(({data}) => {
                    this.ubigeo = data[0];
                    this.loading=false;
                }).catch((error) => {
                    console.log(error);
                });
            }
        },
        created() {
            Bus.$on("modalEditarUbigeos", (data) => {
                this.loading=true;
                this.selectEditUbigeo=data;
                this.getDataUbigeos(this.selectEditUbigeo);
            });
        },
        validations () {
            return {
                ubigeo:{
                    codigo:{ required },
                    descripcion:{required}
                }
            }
        }
    }
</script>




