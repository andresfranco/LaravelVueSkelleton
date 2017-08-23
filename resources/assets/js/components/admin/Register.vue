<template>
    <div class="login">
     <div class="login-triangle"></div>
      <h2 class="login-header">Register</h2>
       <form class="login-container" autocomplete="off" @submit.prevent="validateBeforeSubmit()" > 
        <p><input type="text" placeholder="Name" name="name" v-model="registerForm.name" v-validate="'required'" :class="{'has-error':errors.has('name')}" ></p>
        <span class='has-error' v-show="errors.has('name')">{{ errors.first('name') }}</span> 
        <p><input type="email" placeholder="Email" name ="email" v-model="registerForm.email" v-validate="'required|email'" :class="{'has-error':errors.has('email')}"></p>
        <span class='has-error' v-show="errors.has('email')">{{ errors.first('email') }}</span>     
        <p><input type="password" name="password" placeholder="Password" v-model="registerForm.password" v-validate="'required|confirmed:vpassword'" :class="{'has-error':errors.has('password')}"></p>
        <span class='has-error' v-show="errors.has('password')">{{ errors.first('password') }}</span> 
        <p><input type="password" name="vpassword" placeholder="Password Confirmation" v-model="registerForm.vpassword"></p>
        <p><input type="submit" value="Sign Up"></p>
        <a href="" @click ="backtoLogin()" style="padding-left:20px"><span class="" aria-hidden="true"></span>Login</a>
        </form>
    </div>
</template>
<script>
import auth from '../../auth.js';
export default {     
     data:function() {
        return {
         registerForm:{name:'',email:'',password:'',vpassword:''},
         errorData:{}
      
        }
    },
    methods:{
        backtoLogin:function(){
          this.$router.push({name:'Login'});
        },
        validateBeforeSubmit() { 
             this.$validator.validateAll().then((result) => {
        if (result) {
          auth.register(this.registerForm,this.$router);
          if(auth.errors){this.errorData =auth.errors}
        }

      });
    }
        
    }
    
}
</script>