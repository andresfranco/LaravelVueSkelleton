<template>
    <div class="login">
     <div class="login-triangle"></div>
      <h2 class="login-header">Register</h2>
       <form class="login-container" autocomplete="off" @submit.prevent="validateForm()" >
        <div><p v-for="error in errors">{{error}}</p></div>  
        <p><input type="text" placeholder="Name" v-model="registerForm.name"></p>
        <p><input type="email" placeholder="Email" v-model="registerForm.email" ></p>
        <p><input type="password" placeholder="Password" v-model="registerForm.password"></p>
        <p><input type="password" placeholder="Password Confirmation" v-model="registerForm.vpassword"></p>
        <p><input type="submit" value="Sign Up"></p>
        <div>
        <a href="" @click ="backtoLogin()" style="padding-left:20px"><span class="" aria-hidden="true"></span>Login</a>      
        </div>
        </form>
    </div>
</template>
<script>
export default {     
     data:function() {
        return {
         registerForm:{name:'',email:'',password:'',vpassword:''},
         errors:[],
         success:false
      
        }
    },
    methods:{
        backtoLogin:function(){
          this.$router.push({name:'Login'});
        },
        validateForm:function(){
          this.errors=[];   
          let valid =true;  
          if(this.registerForm.password !== this.registerForm.vpassword ){
            valid = false;
            this.errors.push('Password and password confirmation have to be equal');
          }

          return valid; 
        }
    }
}
</script>