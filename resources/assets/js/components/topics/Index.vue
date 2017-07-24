<template>
    <div class ="grid-container">
                <div>
                    <div><h3>{{title}}</h3></div>

                    <div>
                 <div>
                    <form v-on:submit.prevent="Search(currentPage,'searchForm')">
                        <div class="form-group">
                        <label for="name">Name</label>
                        <input  name ="name" type="text" v-model="name" class="form-control search-control">
                        </div>
                        <div class="form-group">
                        <label for="name">Description</label>
                        <input name ="description" type="text" v-model="description" class="form-control search-control">
                        </div>
                        <div class="form-group">
                     <button type="submit" class="btn btn-primary">Buscar</button>  
                    </div>
                    </form>
                    
                 </div>  
                 <hr>      
              <button type="button" class="btn btn-primary"><router-link to="/topics/new">New</router-link></button> 
            
            <table class="table">
                <thead>
                    <tr>
                    <th v-for="column in columns" >
                     <a v-if="column.name" @click ="Order(column.name)">{{column.title}}
                     <icon v-bind:name="iconName" v-if="(clickedColumn==column.name) && iconName && column.name "></icon>
                     </a>
                     
                    </th>
                    </tr>
                    <tr>
                    <td> </td>
                    <td><input  type ="text" class ="search-control" v-model ="fname"></td>
                    <td><input type ="text" class ="search-control" v-model = "fdescription" ></td>
                    </tr>
                </thead>
                
                <tbody>

                    <tr v-for="(topic, index) in  topicList" v-bind:data-index="index">
                        
                        <td>{{ topic.id }}</td>
                        <td>{{ topic.name }}</td>
                        <td>{{ topic.description}}</td>
                        <td><button type="button" class="btn btn-primary">Edit</button></td>
                        <td><button type="button" class="btn btn-danger">Delete</button></td>
                    </tr>
                   
                </tbody>
                
            </table>
                    </div>
 
                <nav >
                    <div>Showing {{from}} to {{to}} of {{total}}</p>         
                    <ul class="pagination">
                    <li class="page-item"><a class="page-link" @click="Paginate('prev',currentPage)">Previous</a></li>
                    <li> <span>Page {{currentPage}} of {{lastPage}} </span>  </li>
                    <li class="page-item"><a class="page-link" @click="Paginate('next',currentPage)">Next</a></li>
                    </ul>
                    </div>
                </nav>
           
            </div>
    </div>
</template>

<script>
import {HTTP} from '../common/http-common';
import  'vue-awesome/icons/arrow-down';
import 'vue-awesome/icons/arrow-up';
import Icon from 'vue-awesome/components/Icon';
import R from 'ramda';
import VuePaginate from 'vue-paginate'; 

    export default {
    components:{Icon,VuePaginate},
    data:function() {
        return {
        title: '',
        test:'Testasas',
        topics:[],
        columns:[{code:"",name:"id",title:"Id"},{code:"",name:"name",title:"Name",filterName:"fname"}
        ,{code:"",name:"description",title:"Description",filterName:"fdescription"}
        ,{code:"edit",name:""}
        ,{code:"delete",name:""}],
        name:'',
        description:'',
        iconName:'',
        clickedColumn:'',
        order:'',
        paginate: ['topicsList'],
        fname:'',
        fdescription:'',
        currentPage:1,
        from:'',
        lastPage:'',
        nextPageUrl:'',
        perPage:'',
        pervPageUrl:'',
        to:'',
        total:'',
        urlType:'list'

        }
    },
    computed:{
        topicList:function(){
           var vm = this;
         return this.topics.filter(function (item) { 
             
             if(vm.fname && !vm.fdescription){
                 return (item.name.toLowerCase().indexOf(vm.fname.toLowerCase()) !== -1);
             }
             if(!vm.fname && vm.fdescription){
               return (item.description.toLowerCase().indexOf(vm.fdescription.toLowerCase()) !== -1);
             }
             if(vm.fname && vm.fdescription){
            return ((item.name.toLowerCase().indexOf(vm.fname.toLowerCase()) !== -1)
             || (item.description.toLowerCase().indexOf(vm.fdescription.toLowerCase()) !== -1));
             }
             return item;
       
      }); 
        
        
        }
        
    },
    methods: {
        
        Search:function(currentPage,callType){
           this.urlType ='search';  
           callType=='searchForm'?currentPage=1:currentPage;
           HTTP.post('topics/search?page='+currentPage.toString(),{name:this.name,description:this.description})
            .then(response => {
                //Grid data    
                this.topics = response.data.data, 
                //Pagination Values
                this.setPaginatedData({
                currentPage:response.data.current_page,
                from:response.data.from,
                lastPage:response.data.last_page,
                nextPageUrl:response.data.next_page_url,
                perPage:response.data.per_page,
                prevPageUrl:response.data.prev_page_url,
                to:response.data.to,
                total:response.data.total 
                });
                })
                .catch(e => {
                this.errors.push(e)
                }); 
                this.iconName = '';
        },
        Order:function(column_name){
           this.clickedColumn =column_name;
           this.order ='desc';
           this.topics = R.sortBy(R.prop(column_name), this.topics);
            if (this.iconName ==''){
                this.iconName='arrow-down';       
            }else if(this.iconName=='arrow-down'){
             this.iconName = 'arrow-up';
             this.order ='asc';
             this.topics = R.reverse(this.topics);
            }
            else if(this.iconName=='arrow-up'){
                this.iconName = 'arrow-down';
            }    
        },
        Paginate:function(type,currentPage){

          currentPage = (type =='prev' ? currentPage -1 : currentPage =currentPage +1);
          this.urlType =='search'?this.Search(currentPage.toString(),'paginate'):this.getAllTopics(currentPage.toString());
          
        },
        setPaginatedData:function(paginationObj){
            this.currentPage = paginationObj.currentPage,
            this.from=paginationObj.from,
            this.lastPage=paginationObj.lastPage,
            this.nextPageUrl=paginationObj.nextPageUrl,
            this.perPage=paginationObj.perPage,
            this.pervPageUrl=paginationObj.prevPageUrl,
            this.to=paginationObj.to,
            this.total=paginationObj.total
        } ,
        getAllTopics:function(currentPage){
          HTTP.get('topics/all?page='+currentPage)
                .then(response => {
            //Grid data    
                this.topics = response.data.topics.data 
            //Grid Title    
                ,this.title =response.data.title.toUpperCase()
            //Pagination Values
                this.setPaginatedData({
                    currentPage:response.data.topics.current_page,
                    from:response.data.topics.from,
                    lastPage:response.data.topics.last_page,
                    nextPageUrl:response.data.topics.next_page_url,
                    perPage:response.data.topics.per_page,
                    prevPageUrl:response.data.topics.prev_page_url,
                    to:response.data.topics.to,
                    total:response.data.topics.total
                });

                })
                .catch(e => {
                this.errors.push(e)
                });

        }
    },
    created() 
    {
        this.getAllTopics(this.currentPage.toString());
    },
    
    } 
</script>
<style>
    .grid-container{
        padding-top: 40px;
    }

</style>
