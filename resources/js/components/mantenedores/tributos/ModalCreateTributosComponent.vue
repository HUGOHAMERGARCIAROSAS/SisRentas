<template>
    <div class="modal fade xd2" id="modalCrearTributos"  tabindex="-1" role="dialog"
          data-keyboard="false" data-backdrop="static">
          <page-loader v-if="loading==true"/>
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center">CREAR TRIBUTOS</h5>
                </div>
                <div class="modal-body">
                    <form  @submit.prevent="guardarTributos">
                        <div class="row">
                            <div class="mb-3 col-12 col-md-2">
                                <label class="form-label" for="lname">Código:</label>
                                <input type="text"  class="form-control" v-model="tributo.codigo" >
                                <div v-if="enviado && (!$v.tributo.codigo.required)" class="mensajeError">
                                    Debe rellenar el código.
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-2">
                                <label class="form-label" for="lname">Abrev:</label>
                                <input type="text"  class="form-control" v-model="tributo.abrev" >
                                <div v-if="enviado && (!$v.tributo.abrev.required)" class="mensajeError">
                                    Debe rellenar la abrev.
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-2">
                                <label class="form-label" for="lname">Importe:</label>
                                <input type="text"  class="form-control" v-model="tributo.importe" >
                                <div v-if="enviado && (!$v.tributo.importe.required)" class="mensajeError">
                                    Debe rellenar el importe.
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-6">
                                <label class="form-label" for="lname">Descripción:</label>
                                <input type="text"  class="form-control" v-model="tributo.descripcion" >
                                <div v-if="enviado && (!$v.tributo.descripcion.required)" class="mensajeError">
                                    Debe rellenar la descripción.
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-12 col-md-2">
                                <label class="form-label" for="lname">Cód. Contable:</label>
                                <input type="text"  class="form-control" v-model="tributo.codigocontable" >
                            </div>
                            <div class="mb-3 col-12 col-md-4">
                                <label class="form-label" for="lname">Área:</label>
                                <select id="2" class="form-control" v-model="tributo.area" >
                                    <option value="" :selected="true">Seleccionar:</option>
                                    <option v-for="(item, index) in todostributosarea" :key="index" :value="item.valor">{{ item.descripcion }}</option>
                                </select>
                                <div v-if="enviado && (!$v.tributo.area.required)" class="mensajeError">
                                    Debe seleccionar el área.
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-2">
                                <label class="form-label" for="lname">% Área:</label>
                                <input type="text"  class="form-control" v-model="tributo.area_porc" >
                                <div v-if="enviado && (!$v.tributo.area_porc.required)" class="mensajeError">
                                    Debe rellenar el % área.
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-4">
                                <label class="form-label" for="lname">Fuente:</label>
                                <select id="2" class="form-control" v-model="tributo.fuente" >
                                    <option value="" :selected="true">Seleccionar:</option>
                                    <option v-for="(item, index) in todostributosfuentes" :key="index" :value="item.valor">{{ item.descripcion }}</option>
                                </select>
                                <div v-if="enviado && (!$v.tributo.fuente.required)" class="mensajeError">
                                    Debe seleccionar la fuente.
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Grupo:</label>
                                <select id="2" class="form-control" v-model="tributo.grupo" >
                                    <option value="" :selected="true">Seleccionar:</option>
                                    <option v-for="(item, index) in todostributosgrupo" :key="index" :value="item.valor">{{ item.descripcion }}</option>
                                </select>
                                <div v-if="enviado && (!$v.tributo.grupo.required)" class="mensajeError">
                                    Debe seleccionar la fuente.
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Genérica:</label>
                                <select id="2" class="form-control" v-model="tributo.generica" @change="changeGenerica($event)">
                                    <option value="" :selected="true">Seleccionar:</option>
                                    <option v-for="(item, index) in todostributosgenerica" :key="index" :value="item.cod_generica">{{ item.generica }}</option>
                                </select>
                                <div v-if="enviado && (!$v.tributo.generica.required)" class="mensajeError">
                                    Debe seleccionar la fuente.
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-3">
                                <label for="">Sub-Genérica: </label>
                                <select id="2" class="form-control" v-model="tributo.subgenerica" @change="changeSubGenerica($event)">
                                    <option value="" :selected="true">Seleccione Sub-Genérica:</option>
                                    <option v-for="(item, index) in todostributossubgenerica" :key="index" :value="item.cod_sgenerica">{{ item.sgenerica }}</option>
                                </select>
                            </div>
                            <div class="mb-3 col-12 col-md-3">
                                <label for="">Específica: </label>
                                <select id="2" class="form-control" v-model="tributo.especifica" >
                                    <option value="" :selected="true">Seleccione Específica:</option>
                                    <option v-for="(item, index) in todostributosespecifica" :key="index" :value="item.cod_especifica">{{ item.especifica }}</option>
                                </select>
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
                                    class="btn btn-danger btn-pill"  @click="closeModalAgregarTributosOut()"
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

                todostributosgrupo:'',
                todostributosgenerica:'',
                todostributossubgenerica:'',
                todostributosespecifica:'',
                todostributosarea:'',
                todostributosfuentes:'',

                tributo:{
                    codigo:'',
                    abrev:'',
                    importe:'0.00',
                    descripcion:'',
                    codigocontable:'',
                    area:'',
                    fuente:'',
                    area_porc:'0',
                    grupo:'',
                    generica:'',
                    subgenerica:'',
                    especifica:''
                },

                loading:false,
                enviado:false,
                validado:''
            }
        },
        methods:{
            guardarTributos(){
                this.loading=true;
                this.enviado=true;
                this.$v.$touch();
                if (this.$v.$invalid) {
                    this.loading=false;
                    return;
                }else{
                    let formData = new FormData()
                    formData.append('codigo',this.tributo.codigo)
                    formData.append('abrev',this.tributo.abrev)
                    formData.append('importe',this.tributo.importe)
                    formData.append('descripcion',this.tributo.descripcion)
                    formData.append('codigocontable',this.tributo.codigocontable)
                    formData.append('area',this.tributo.area)
                    formData.append('fuente',this.tributo.fuente)
                    formData.append('area_porc',this.tributo.area_porc)
                    formData.append('grupo',this.tributo.grupo)
                    formData.append('generica',this.tributo.generica)
                    formData.append('subgenerica',this.tributo.subgenerica)
                    formData.append('especifica',this.tributo.especifica)
                    var request ={
                        url:`${this.variableGlobal}/store-data-tributos`,
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
                        }
                    });
                    this.loading=false;
                    this.closeModalAgregarTributos();
                }
            },
            //CERRAR MODAL CON ACCION
            closeModalAgregarTributos(){
                this.limpiarTributos();
                $('#modalCrearTributos').modal('hide');
                Bus.$emit("DetalleCreateTributos");
            },

            //CERRAR MODAL SIN ACCION
            closeModalAgregarTributosOut(){
                this.limpiarTributos();
                $('#modalCrearTributos').modal('hide');
            },

            //LIMPIAR DESPUES DE GUARDAR
            limpiarTributos(){
                    this.tributo.codigo='',
                    this.tributo.abrev=''
                    this.tributo.importe='0',
                    this.tributo.descripcion='',
                    this.tributo.codigocontable='',
                    this.tributo.area=''
                    this.tributo.area_porc='0',
                    this.tributo.grupo='',
                    this.tributo.fuente='',
                    this.tributo.generica=''
                    this.tributo.subgenerica='',
                    this.tributo.especifica=''
            },

            // OBTENER AREA TRIBUTOS
            getListAreaTributos(){
                axios.get(`${this.variableGlobal}/lista-tributos-area-text`).then(({data}) => {
                    this.todostributosarea = data;
                }).catch((error) => {
                    console.log(error);
                });
            },

            // OBTENER GRUPO TRIBUTOS
            getListGrupoTributos(){
                axios.get(`${this.variableGlobal}/lista-tributos-grupos-text`).then(({data}) => {
                    this.todostributosgrupo = data;
                }).catch((error) => {
                    console.log(error);
                });
            },

            //OBTENER FUENTES
            getListFuentesTributos(){
                axios.get(`${this.variableGlobal}/lista-tributos-fuentes-text`).then(({data}) => {
                    this.todostributosfuentes = data;
                }).catch((error) => {
                    console.log(error);
                });
            },
            //OBTENER GRUPO DE TRIBUTOS
            getListGrupoTributos(){
                axios.get(`${this.variableGlobal}/lista-tributos-grupos-text`).then(({data}) => {
                    this.todostributosgrupo = data;
                }).catch((error) => {
                    console.log(error);
                });
            },
            //OBTENER GENERICOS TRIBUTOS
            getListGenericoTributos(){
                axios.get(`${this.variableGlobal}/lista-tributos-genericos-text`).then(({data}) => {
                    this.todostributosgenerica = data;
                }).catch((error) => {
                    console.log(error);
                });
            },
            //OBTENER SUBGENERICOS A PARTIR DE GENERICOS
            changeGenerica(){
                let value=this.tributo.generica;
                axios.get(`${this.variableGlobal}/lista-tributos-subgenericos-text/`+value).then(({data}) => {
                    this.todostributossubgenerica = data;
                }).catch((error) => {
                    console.log(error);
                });
            },
            //OBTENER ESPECIFICOS A PARTIR DE SUBGENERICOS
            changeSubGenerica(){
                let value=this.tributo.subgenerica;
                axios.get(`${this.variableGlobal}/lista-tributos-especifica-text/`+value).then(({data}) => {
                    this.todostributosespecifica = data;
                }).catch((error) => {
                    console.log(error);
                });
            }

        },
        created() {
            this.getListAreaTributos();
            this.getListGrupoTributos();
            this.getListFuentesTributos();
            this.getListGrupoTributos();
             this.getListGenericoTributos();
        },
        validations () {
            return {
                tributo:{
                    codigo:{ required },
                    abrev:{required},
                    importe:{ required },
                    descripcion:{required},
                    area:{required},
                    grupo:{required},
                    fuente:{ required },
                    generica:{required},
                    subgenerica:{ required },
                    especifica:{required},
                    area_porc :{required}
                }

            }
        }
    }
</script>


