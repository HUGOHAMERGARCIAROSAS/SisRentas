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
Vue.component('mantenedores-ubigeo-inicio', require('./components/mantenedores/ubigeo/HomeComponent.vue').default);
Vue.component('modal-crear-mantenedores-ubigeo', require('./components/mantenedores/ubigeo/ModalCreateUbigeosComponent.vue').default);
Vue.component('modal-editar-mantenedores-ubigeo', require('./components/mantenedores/ubigeo/ModalEditUbigeosComponent.vue').default);
Vue.component('mantenedores-arancel-inicio', require('./components/mantenedores/aranceles/HomeComponent.vue').default);
Vue.component('modal-crear-mantenedores-arancel', require('./components/mantenedores/aranceles/ModalCreateArancelesComponent.vue').default);
Vue.component('modal-editar-mantenedores-arancel', require('./components/mantenedores/aranceles/ModalEditArancelesComponent.vue').default);




// TRAMITE DOCUMENTARIO
// Vue.component('tramite-documentario-expedientes-inicio', require('./components/tramite_documentario/expedientes/HomeComponent.vue').default);
// Vue.component('modal-editar-tramite-documentario-expediente', require('./components/tramite_documentario/expedientes/ModalEditExpedienteComponent.vue').default);
// Vue.component('modal-adjuntar-archivo-tramite-documentario-expediente', require('./components/tramite_documentario/expedientes/ModalAdjuntarArchivoExpedienteComponent.vue').default);
// Vue.component('mantenedores-caja-inicio', require('./components/mantenedores/caja/IndexCAjaComponent.vue').default);


const app = new Vue({
    el: '#app',
});
