window.Vue = require('vue');
import Vue from 'vue';
//PERSONAS
Vue.component('administracion-persona-inicio', require('../../components/administracion/persona/HomeComponent.vue').default);
Vue.component('modal-crear-administracion-persona', require('../../components/administracion/persona/ModalCreatePersonComponent.vue').default);
Vue.component('modal-editar-administracion-persona', require('../../components/administracion/persona/ModalEditPersonComponent.vue').default);

//USUARIOS
Vue.component('administracion-usuarios-inicio', require('../../components/administracion/usuario/HomeComponent.vue').default);
Vue.component('modal-crear-administracion-usuario', require('../../components/administracion/usuario/ModalCreateUsuarioComponent.vue').default);
Vue.component('modal-editar-administracion-usuario-password', require('../../components/administracion/usuario/ModalEditUsuarioPaswordComponent.vue').default);
Vue.component('modal-editar-administracion-usuario', require('../../components/administracion/usuario/ModalEditUsuarioComponent.vue').default);
Vue.component('modal-editar-roles-usuario', require('../../components/administracion/usuario/ModalEditRolesUsuarioComponent.vue').default);

//ROLES
Vue.component('administracion-roles-inicio', require('../../components/administracion/roles/HomeComponent.vue').default);
Vue.component('modal-crear-administracion-roles', require('../../components/administracion/roles/ModalCreateRolesComponent.vue').default);
Vue.component('modal-editar-administracion-roles', require('../../components/administracion/roles/ModalEditRolesComponent.vue').default);
Vue.component('administracion-roles-asignar', require('../../components/administracion/roles/AsignarComponent.vue').default);

//Grupos
Vue.component('administracion-grupos-inicio', require('../../components/administracion/grupos/HomeComponent.vue').default);
Vue.component('modal-crear-administracion-grupos', require('../../components/administracion/grupos/ModalCreateGruposComponent.vue').default);
Vue.component('modal-editar-administracion-grupos', require('../../components/administracion/grupos/ModalEditGruposComponent.vue').default);

//Tareas
Vue.component('administracion-tareas-inicio', require('../../components/administracion/tareas/HomeComponent.vue').default);
Vue.component('modal-crear-administracion-tareas', require('../../components/administracion/tareas/ModalCreateTareasComponent.vue').default);
Vue.component('modal-editar-administracion-tareas', require('../../components/administracion/tareas/ModalEditTareasComponent.vue').default);
