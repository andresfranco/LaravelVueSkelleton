import {HTTP} from './components/common/http-common.js';
export default {
    user: {
        authenticated: false,
        profile: null
    },
    errors:{},
    check() {
        let token = localStorage.getItem('id_token')
        if (token !== null) {
            HTTP.get('user?token=' + token,
            ).then(response => {
                this.user.authenticated = true
                this.user.profile = response.data.data
            })
        }
    },   
    register(registerForm,router){
        HTTP.post('register',registerForm )
        .then(response =>{
            router.push({name:'Login',params:{ message:"Registration success"}});
        })
        .catch(error=>{
        this.errors = error.error;
        });
   },
   signin(LoginForm) {
    HTTP.post('signin',LoginForm)
    .then(response => {
        localStorage.setItem('id_token', response.data.meta.token);
        Vue.http.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('id_token');

        this.user.authenticated = true;
        this.user.profile = response.data.data;

        router.push({name: 'BackendIndex',params:{user:this.user}});
    }).catch(error=>{
        this.errors = error.response.data.error;
        });
    },
    signout() {
        localStorage.removeItem('id_token');
        this.user.authenticated = false;
        this.user.profile = null;

        router.push({name: 'Login'});
    }     
  
}