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
                this.user.authenticated = true;
                this.user.profile = response;
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
   signin(LoginForm,router) {
    HTTP.post('signin',this.loginForm)
    .then(response => {
         if(response.data.error){
          // this.dataErrors = response.data.error;
        }else{
            if(response.data.data.name){
            localStorage.setItem('id_token', response.data.meta.token);
            //Vue.http.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('id_token');
            this.user.authenticated = true;
            this.user.profile = response.data;
            window.location.replace('/admin?id='+btoa(JSON.stringify(this.user)));
            }
        }
       
      
        }).catch(error=>{
          console.log(error);
          //this.dataErrors = error.error;
        });
    },
    signout() {
        localStorage.removeItem('id_token');
        this.user.authenticated = false;
        this.user.profile = null;

        router.push({name: 'Login'});
    }     
  
}