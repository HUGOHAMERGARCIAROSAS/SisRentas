window.Vue = require('vue');
window.Bus = new Vue();

import Vue from 'vue';

Vue.use(require('vue-moment')); // PARA LAS FECHAS

import VueSweetalert2 from 'vue-sweetalert2'; // PARA LAS ALERTAS
Vue.use(VueSweetalert2);
import 'sweetalert2/dist/sweetalert2.min.css';

import { Vuelidate } from 'vuelidate';
Vue.use(Vuelidate);

window._ = require('lodash');

Vue.prototype.variableGlobal = '';  //TAMBIEN MODIFICAR EN MIXIN
Vue.config.productionTip = false;

//ESTILOS
import './global.css';
//ASIGNAR ROLES Y PERMISOS AL LOGUEARSE
import './mixin/mixin.js';

// PAGE LOADER
Vue.component('page-loader', require('./components/PageLoaderComponent.vue').default);
// PAGE PAGINATION
Vue.component('pagination-view', require('./components/PaginationComponent.vue').default);
//INICIO DE SESIÓN
Vue.component('iniciar-session-component', require('./components/iniciar_session/IniciarSessionComponent.vue').default);

//1) COMPONENTES ADMINISTRACION
import './routes/administracion/index';

//2) MANTENEDORES

//UBIGEO
Vue.component('mantenedores-ubigeo-inicio', require('./components/mantenedores/ubigeo/HomeComponent.vue').default);
Vue.component('modal-crear-mantenedores-ubigeo', require('./components/mantenedores/ubigeo/ModalCreateUbigeosComponent.vue').default);
Vue.component('modal-editar-mantenedores-ubigeo', require('./components/mantenedores/ubigeo/ModalEditUbigeosComponent.vue').default);


//ARANCELES
Vue.component('mantenedores-arancel-inicio', require('./components/mantenedores/aranceles/HomeComponent.vue').default);
Vue.component('modal-crear-mantenedores-arancel', require('./components/mantenedores/aranceles/ModalCreateArancelesComponent.vue').default);
Vue.component('modal-editar-mantenedores-arancel', require('./components/mantenedores/aranceles/ModalEditArancelesComponent.vue').default);


//FECHAS DE VENCIMIENTO
Vue.component('mantenedores-fechas_vencimiento-inicio', require('./components/mantenedores/fecha_vencimiento/HomeComponent.vue').default);
Vue.component('modal-crear-mantenedores-fechas-vencimiento', require('./components/mantenedores/fecha_vencimiento/ModalCreateFechaVencimientosComponent.vue').default);
Vue.component('modal-editar-mantenedores-fechas-vencimiento', require('./components/mantenedores/fecha_vencimiento/ModalEditFechaVencimientosComponent.vue').default);


//CLASIFICADOR DE INGRESOS
Vue.component('mantenedores-clasificador-ingresos-inicio', require('./components/mantenedores/clasificador_ingresos/HomeComponent.vue').default);
Vue.component('modal-crear-mantenedores-clasificador-ingresos', require('./components/mantenedores/clasificador_ingresos/ModalCreateClasificadorIngresosComponent.vue').default);
Vue.component('modal-editar-mantenedores-clasificador-ingresos', require('./components/mantenedores/clasificador_ingresos/ModalEditClasificadorIngresosComponent.vue').default);

//ARANCELES RUSTICOS
Vue.component('mantenedores-arancel-rustico-inicio', require('./components/mantenedores/aranceles_rustico/HomeComponent.vue').default);
Vue.component('modal-crear-mantenedores-arancel-rustico', require('./components/mantenedores/aranceles_rustico/ModalCreateArancelesRusticoComponent.vue').default);
Vue.component('modal-editar-mantenedores-arancel-rustico', require('./components/mantenedores/aranceles_rustico/ModalEditArancelesRusticoComponent.vue').default);

//TRIBUTOS
Vue.component('mantenedores-tributos-inicio', require('./components/mantenedores/tributos/HomeComponent.vue').default);
Vue.component('modal-crear-mantenedores-tributos', require('./components/mantenedores/tributos/ModalCreateTributosComponent.vue').default);
Vue.component('modal-editar-mantenedores-tributos', require('./components/mantenedores/tributos/ModalEditTributosComponent.vue').default);

//IPM REAJUSTE
Vue.component('mantenedores-ipm-reajuste-inicio', require('./components/mantenedores/ipm_reajuste/HomeComponent.vue').default);
Vue.component('modal-crear-mantenedores-ipm-reajuste', require('./components/mantenedores/ipm_reajuste/ModalCreateIpmReajusteComponent.vue').default);
Vue.component('modal-editar-mantenedores-ipm-reajuste', require('./components/mantenedores/ipm_reajuste/ModalEditIpmReajusteComponent.vue').default);

//IPM ALCABALA
Vue.component('mantenedores-ipm-alcabala-inicio', require('./components/mantenedores/ipm_alcabala/HomeComponent.vue').default);
Vue.component('modal-crear-mantenedores-ipm-alcabala', require('./components/mantenedores/ipm_alcabala/ModalCreateIpmAlcabalaComponent.vue').default);
Vue.component('modal-editar-mantenedores-ipm-alcabala', require('./components/mantenedores/ipm_alcabala/ModalEditIpmAlcabalaComponent.vue').default);


//PARAMETROS
Vue.component('mantenedores-parametros-inicio', require('./components/mantenedores/parametros/HomeComponent.vue').default);
Vue.component('modal-crear-mantenedores-parametros', require('./components/mantenedores/parametros/ModalCreateParametrosComponent.vue').default);
Vue.component('modal-editar-mantenedores-parametros', require('./components/mantenedores/parametros/ModalEditParametrosComponent.vue').default);




const app = new Vue({
    el: '#app',
});
