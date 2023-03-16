import Vue from 'vue';
import axios from 'axios'
import { VueQuickAcl } from '../VueQuickAcl'
Vue.use(VueQuickAcl)

Vue.prototype.variableGlobal = '';

if(window.user){
    if (window.user.persona_id){
        Vue.mixin({
            data() {
                return {
                    permissions: [],
                    activeUser: 0,
                    users: [{ permissions: [] }]
                }
            },
            watch: {
                users: {
                    deep: true,
                    handler() {
                        this.$setUserPermissions(this.users[this.activeUser].permissions, false)
                    }
                }
            },
            methods: {
                permissionsUserUnique() {
                    axios.get(`${this.variableGlobal}/lista-administracion-todos-permisos-usuario`).then(({ data }) => {
                        const permissionsUserUniq = data.map(function(data) {
                            return data.tar_url;
                        });
                        this.users[0].permissions = permissionsUserUniq;
                        axios.get(`${this.variableGlobal}/lista-administracion-todos-permisos`).then(({ data }) => {
                            const permissionsUser = data.map(function(data) {
                                return data.tar_url;
                            });
                            this.permissions = permissionsUser;
                        }).catch((error) => {
                            console.log(error);
                        });
                    }).catch((error) => {
                        console.log(error);
                    });
                },

            },
            created() {
                this.permissionsUserUnique();
            }
        });
    }
}
