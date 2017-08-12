<template>
<div class="form-container">
    <div><h3>{{title}}</h3></div>
    <form  @submit.prevent="addEditTopic(id)">
        <div class="form-group">
        <label for="name">Name</label>
        <input  name ="name" type="text" v-model="topicData.name" class="form-control">
        <div v-if="!topicData.name" v-for="error in errors.name" >
        <p class="errorMessage">{{error}}</p>
        </div>
        </div>
        <div class="form-group">
        <label for="name">Description</label>
        <input name ="description" type="text" v-model="topicData.description" class="form-control">
        <div v-if="!topicData.description" v-for="error in errors.description" >
        <p class="errorMessage">{{error}}</p>
        </div>
        </div>
        <div class="form-group">
        <button type="submit" class="btn btn-primary">Guardar</button> <button type="button" class="btn btn-primary" @click="Cancel()" >Cancelar</button> 
        </div>
    </form>
</div>  
</template>

<script type="text/ecmascript-6">
import {HTTP} from '../common/http-common';
export default {
     data: function () {
        return {
            menuclicked: false,
            name:'',
            description:'' ,
            title:this.$route.params.title,
            mode:this.$route.params.mode,
            id:this.$route.params.id,
            topicData:this.getTopics(this.$route.params.mode,this.$route.params.id),
             errors:{name:[],description:[]}    
           
        }
    },
    methods:{
        Cancel:function(){
          this.$router.push({name:'TopicIndex'});
        },
        addEditTopic:function(id)
        {
        this.mode =='ins'? this.addTopic():this.updateTopic(id);
        },
        addTopic:function(){
            HTTP.post('topics/create',this.topicData)
                    .then(response =>{
                        this.topicData='';
                        this.$router.push({name:'TopicIndex',params:{ action:true,message:"Succes created" }});
                    })
                    .catch(error=>{
                        this.errors = error.response.data.error;
                    });
        },
        updateTopic:function(id){
          HTTP.put('topics/update/'+id,this.topicData)
                    .then(response =>{
                        this.topicData = '';
                        this.$router.push({name:'TopicIndex',params:{ action:true,message:"Succes update" }});
                    })
                    .catch(error=>{
                        this.errors = error.response.data.error;
                    });
        },
        getTopics:function(mode,id){
            this.topicData ={ name:'',description:''};
            if (mode =='upd'){
             HTTP.get('topics/edit/'+id)
                    .then(response =>{
                        this.topicData = response.data;
                    })
                    .catch(error=>{
                        console.log(response.error);
                    });
            }
            return this.topicData;
        }
    }
}
</script>
<style> 
.form-container{
padding-top:50px;
}
</style>    