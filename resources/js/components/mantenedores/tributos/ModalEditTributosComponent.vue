<template>
    <div class="modal fade xd2" id="modalProcesoEditTributos"  tabindex="-1" role="dialog"
          data-keyboard="false" data-backdrop="static">
          <page-loader v-if="loading==true"/>
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center">EDITAR TRIBUTO</h5>
                </div>
                <div class="modal-body">
                    <form  @submit.prevent="editarTributos">
                        <div class="row">
                            <!-- <div class="mb-3 col-12 col-md-2">
                                <label class="form-label" for="lname">Código:</label>
                                <input type="text"  class="form-control" v-model="tributo.codigo" >
                                <div v-if="enviado && (!$v.tributo.codigo.required)" class="mensajeError">
                                    Debe rellenar el código.
                                </div>
                            </div> -->
                            <div class="mb-3 col-12 col-md-3">
                                <label class="form-label" for="lname">Abrev:</label>
                                <input type="text"  class="form-control" v-model="tributo.abrev" >
                                <div v-if="enviado && (!$v.tributo.abrev.required)" class="mensajeError">
                                    Debe rellenar la abrev.
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-3">
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
                                    class="btn btn-danger btn-pill"  @click="closeModalEditarTributosOut()"
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
                validado:'',

                selectEditTributos:''
            }
        },
        methods:{
            editarTributos(){
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
                        url:`${this.variableGlobal}/update-data-tributos`,
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
                    this.closeModalEditarTributos();
                }
            },
            //CERRAR MODAL CON ACCION
            closeModalEditarTributos(){
                $('#modalProcesoEditTributos').modal('hide');
                Bus.$emit("DetalleEditarTributos");
            },

            //CERRAR MODAL SIN ACCION
            closeModalEditarTributosOut(){
                $('#modalProcesoEditTributos').modal('hide');
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
                this.todostributossubgenerica=[];
                this.todostributosespecifica=[];
                if(value!=''){
                    axios.get(`${this.variableGlobal}/lista-tributos-subgenericos-text/`+value).then(({data}) => {
                        this.todostributossubgenerica = data;
                    }).catch((error) => {
                        console.log(error);
                    });
                }

            },
            //OBTENER ESPECIFICOS A PARTIR DE SUBGENERICOS
            changeSubGenerica(){
                let value=this.tributo.subgenerica;
                this.todostributosespecifica=[];
                if(value!=''){
                    axios.get(`${this.variableGlobal}/lista-tributos-especifica-text/`+value).then(({data}) => {
                        this.todostributosespecifica = data;
                    }).catch((error) => {
                        console.log(error);
                    });
                }
            },
            //OBTENER DATA TRIBUTO
            getDataTributos(id){
                axios.get(`${this.variableGlobal}/datos-tributos-edit/`+id).then(({data}) => {
                    this.tributo.codigo = data[0].tributos_id;
                    this.tributo.abrev = data[0].abrev;
                    this.tributo.importe = data[0].importe;
                    this.tributo.descripcion = data[0].tb_descripcion;
                    this.tributo.codigocontable = data[0].cod_contable;
                    this.tributo.area = data[0].are_codigo;
                    this.tributo.fuente = data[0].fuente.trim();
                    this.tributo.area_porc = data[0].porce_area;
                    this.tributo.grupo = data[0].valor;
                    this.tributo.generica = data[0].cod_generica;
                    this.tributo.subgenerica = data[0].cod_sgenerica;
                    this.tributo.especifica = data[0].cod_especifica;
                    this.changeGenerica();
                    this.changeSubGenerica();
                    this.loading=false;
                }).catch((error) => {
                    console.log(error);
                });
            }

        },
        created() {
            //OBTENER ID DE LA FILA
            Bus.$on("modalEditarTributos", (data) => {
                this.loading=true;
                this.selectEditTributos=data;
                this.getListAreaTributos();
                this.getListGrupoTributos();
                this.getListFuentesTributos();
                this.getListGrupoTributos();
                this.getDataTributos(this.selectEditTributos);
                this.getListGenericoTributos();
            });

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


