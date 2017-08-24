<template>
<div class="login" >
  <div class="login-triangle"></div>
  <h2 class="login-header">Log in</h2>
  <form class="login-container" @submit.prevent="signin()">
  <alert  v-model="alertFields.showAlert" :duration="alertFields.alertDuration" :type="alertFields.type" :width="alertFields.width" dismissable>
    <icon :name="alertFields.iconName"></icon>
    <strong>{{alertFields.alertMessage}}</strong>
  </alert>
    <p><input type="email" name="email" placeholder="Email" v-model="loginForm.email" v-validate="'required|email'" :class="{'has-error':errors.has('email')}"></p>
    <span class='has-error' v-show="errors.has('email')">{{ errors.first('email') }}</span>
    <p><input name="password" type="password" placeholder="Password" v-model="loginForm.password" v-validate="'required'" :class="{'has-error':errors.has('password')}"></p>
    <span class='has-error' v-show="errors.has('password')">{{ errors.first('password') }}</span> 
    <p><input type="submit" value="Log in"></p>
    <div>
    <a href="" @click ="signUp()" style="padding-left:20px"><span class="" aria-hidden="true"></span>Register</a>      
    </div>
  </form>
</div>

</template>
<script>
import auth from '../../auth.js';
import {alert} from 'vue-strap';
import Icon from 'vue-awesome/components/Icon';
import {HTTP} from '../common/http-common.js';
  export default {         
    data:function() {
        return {
         loginForm:{email:'',password:''},
         alertFields:{alertMessage:'',showAlert:false,alertDuration:5000,
            type:'success',width:'350px',iconName:'check-square'
        },
        dataErrors:'None',
        user: {
        authenticated: false,
        profile: null
          }
        }
    },
    components:{alert,Icon},
    methods:{
      signUp:function(){
         this.$router.push({name:'SignUp'});
       
      },
      signin:function() {
          this.$validator.validateAll().then((result) => {
        if (result) {
              HTTP.post('signin',this.loginForm)
              .then(response => {
                if(response.data.error){
                //this.dataErrors = 
                this.alertFields.type='danger';
                this.alertFields.alertMessage=response.data.error;
                this.alertFields.showAlert=true;
                this.alertFields.iconName='exclamation-circle';
                this.alertFields.alertDuration=9999999
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
              });
        }
      }); 
      }
    },
    created()
        {
           
            //Check if the component was called from an edit or new action.
            if ( this.$route.params.message) {
                //Set the timeout for the alert that shows action success
                this.alertFields.alertMessage =this.$route.params.message;
                this.alertFields.showAlert = true;
                setTimeout(()=>{
                    this.alertFields.showAlert = false;
                },this.alertFields.alertDuration);
            }
           
          
            
        }
  }
</script>