<template>
<div class="login" >
  <div class="login-triangle"></div>
  <h2 class="login-header">Log in</h2>
  <form class="login-container" v-on:submit="signin()">
  <alert  v-model="alertFields.showAlert" :duration="alertFields.alertDuration" :type="alertFields.type" :width="alertFields.width" dismissable>
    <icon :name="alertFields.iconName"></icon>
    <strong>{{alertFields.alertMessage}}</strong>
  </alert>
    
    <p><input type="email" placeholder="Email" v-model="loginForm.email"></p>
    <p><input type="password" placeholder="Password" v-model="loginForm.password"></p>
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
  export default {         
    data:function() {
        return {
         loginForm:{email:'',password:''},
         alertFields:{alertMessage:'',showAlert:false,alertDuration:5000,
            type:'success',width:'350px',iconName:'check-square'
        }
        }
    },
    components:{alert,Icon},
    methods:{
      signUp:function(){
         this.$router.push({name:'SignUp'});
       
      },
      signin(event) {
        auth.signin(this.loginForm);
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