<template>
<div>
    <div class="card">
        <div class="header">
            <p class="lead">INICIAR SESIÓN</p>
        </div>
        <div class="body">
            <form class="form-auth-small"  @submit.prevent="iniciarSession" enctype="multipart/form-data">
                <div class="form-group">
                    <input class="form-control" style="height:40px;" placeholder="Usuario" id="per_login" v-model="inicio.per_login" type="text" autocomplete="off" autofocus required>
                </div>
                <div class="form-group">
                    <input class="form-control" placeholder="Contraseña" id="password" v-model="inicio.password" type="password"  autocomplete="off" required>
                </div>
                <button type="submit" class="btn btn-primary btn-lg btn-block">LOGIN</button>
                <div class="bottom">
                    <span class="helper-text m-b-10"><i class="fa fa-lock"></i> <a href="#">¿Olvidaste tu contraseña?</a><br> Contáctate con el administrador del sistema.</span>
                </div>
            </form>
        </div>
    </div> 
</div>
</template>
<script>
import Vue from 'vue';
import axios from 'axios'
import VueSweetalert2 from 'vue-sweetalert2';
Vue.use(VueSweetalert2);
import 'sweetalert2/dist/sweetalert2.min.css';
export default {
    data() {
        return{
            inicio:{
                per_login:'',
                password:''
            }
        }
    },
    methods:{
        async iniciarSession(){
            let formData = new FormData()
            formData.append('per_login',this.inicio.per_login)
            formData.append('password',this.inicio.password)
            var request ={
                url:`${this.variableGlobal}/login`,
                method:'post',
                data:formData
            }
            await axios(request).then(({data}) => {
                if (data===true) {
                    window.location.href = `${this.variableGlobal}/home`;
                }
                if (data===false) {
                    this.$swal.fire({
                        icon: 'error',
                        title: 'ERROR!',
                        text: "Las claves son incorrectas",
                        showConfirmButton: false,
                        timer: 2500
                    })
                }
            });
        }
    }
}
</script>
