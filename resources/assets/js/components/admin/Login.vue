<template>
<div class="login" >
  <div class="login-triangle"></div>
  <h2 class="login-header">Log in</h2>
  <form class="login-container">
    <div>Errors</div>
    
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
  export default {         
    data:function() {
        return {
         loginForm:{email:'',password:''}
        }
    },
    methods:{
      signUp:function(){
         this.$router.push({name:'SignUp'});
       
      },
      register:function(){

      }
    }
  }
</script>
