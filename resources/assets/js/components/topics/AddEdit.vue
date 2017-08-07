<template>
<div class="form-container">
    <div><h3>{{title}}</h3></div>
    <form>
        <div class="form-group">
        <label for="name">Name</label>
        <input  name ="name" type="text" v-model="name" class="form-control">
        </div>
        <div class="form-group">
        <label for="name">Description</label>
        <input name ="description" type="text" v-model="description" class="form-control">
        </div>
        <div class="form-group">
        <button type="submit" class="btn btn-primary">Guardar</button>  <button class="btn btn-primary" @click="Cancel()" >Cancelar</button> 
        </div>
    </form>
</div>  
</template>

<script>
export default {
     data: function () {
        return {
            menuclicked: false,
            name:'',
            description:'' ,
            title:this.$route.query.title,
            mode:this.$route.query.mode
           
        }
    },
    methods:{
        Cancel:function(){
          this.$router.push({ path: '/admin/topics' });
        }
    }
}
</script>
<style> 
.form-container{
padding-top:50px;
}
</style>    