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
            HTTP.get('user?token='+token,
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
   signin(vm,loginForm,router) {
    HTTP.post('signin',loginForm)
    .then(response => {
      if(response.data.error){
        vm.alertFields.type='danger';
        vm.alertFields.alertMessage=response.data.error;
        vm.alertFields.showAlert=true;
        vm.alertFields.iconName='exclamation-circle';
        vm.alertFields.alertDuration=9000;
        }
        else if(response.data.data.name){
            localStorage.setItem('id_token', response.data.meta.token);
            vm.user.authenticated = true;
            vm.user.profile = response.data;
            localStorage.setItem('userName', response.data.data.name);
            window.location.replace('/admin');
        }
      
    }).catch(error=>{
    console.log(error);
    });
    },
    signOut(router) {
        localStorage.removeItem('id_token');
        localStorage.removeItem('userName');
        this.user.authenticated = false;
        this.user.profile = null;
        window.location.replace('/login');
    }     
  
}