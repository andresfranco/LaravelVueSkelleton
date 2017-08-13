<template>
     <div>
    <div class ="grid-container">
        <div>
            <div><h3>{{gridFields.gridTitle}}</h3></div>
         <div>
         <div>
            <form v-on:submit.prevent="Search(gridFields.currentPage,'searchForm')">
                <div class="form-group" v-for ="searchitem in searchForm.formFields">
                <label for="name">{{searchitem.name}}</label>
                <input  :name ="searchitem.name" type="text" v-model="searchFields[searchitem.modelname]" :class="searchitem.class">
                </div>
                <div class="form-group">
                <button type="submit" class="btn btn-primary">{{searchForm.searchButtonTitle}}</button>
                </div>
            </form>
         </div>
         <hr>
            <router-link :to="{name:'AddEditTopic', params:{title:'New Topic',mode:'ins'}}" class="btn btn-primary">New</router-link>
            <br><br>
            <alert  v-model="alertFields.showAlert" :duration="alertFields.alertDuration" type="success" width="400px" dismissable>
                <icon v-bind:name="'check-square'"></icon>
                <strong>{{alertFields.alertMessage}}</strong>
            </alert>

            <table class="table">
                <thead>
                    <tr>
                        <th v-for="column in columns" >
                        <a v-if="column.name" @click ="Order(column.name)">{{column.title}}
                        <icon v-bind:name="gridFields.iconName" v-if="(gridFields.clickedColumn==column.name) && gridFields.iconName && column.name "></icon>
                        </a>
                        </th>
                    </tr>
                    <tr>
                        <td v-for="column in columns">
                        <input v-if="column.enabledFilter"  type ="text" :class ="column.filterData.class" v-model ="gridFields.gridfilters[column.filterData.modelname]">
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(griditem,index) in  topicList" v-bind:data-index="index">
                        <td v-for="item in griditem">{{item}}</td>
                        <td><router-link :to="{name:'AddEditTopic', params:{title:'Edit Topic',mode:'upd',id: griditem.id }}"  class="btn btn-primary">Edit</router-link></td>
                        <td><button type="button" class="btn btn-danger" @click ="showModalData(griditem)">Delete</button></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <nav >
            <div>Showing {{gridFields.from}} to {{gridFields.to}} of {{gridFields.total}}</p>
            <ul class="pagination">
            <li class="page-item" v-if="gridFields.currentPage > 1"><a class="page-link" @click="Paginate('prev',gridFields.currentPage)">Previous</a></li>
            <li> <span>Page {{gridFields.currentPage}} of {{gridFields.lastPage}} </span>  </li>
            <li class="page-item" v-if="gridFields.nextPageUrl"><a class="page-link" @click="Paginate('next',gridFields.currentPage)">Next</a></li>
            </ul>
            </div>
        </nav>

    </div>
    </div>
  <div>
    <modal v-model="modalFields.showDeleteModal" effect="fade" width="400">
        <div slot="modal-header" class="modal-header">
            <h4 class="modal-title">
            Are you sure you want to delete this topic?
            </h4>
        </div>
        <div slot="modal-body" class="modal-body">
            <p>Name: {{modalFields.modalData.name}}</p>
            <p>Description: {{modalFields.modalData.description}}</p>
        </div>
        <div slot="modal-footer" class="modal-footer">
            <button type="button" class="btn btn-default" @click="modalFields.showDeleteModal = false">Cancel</button>
            <button type="button" class="btn btn-danger" @click="deleteData(modalFields.modalData.id)">Delete</button>
        </div>
    </modal>
   </div>
   <div>

   </div>

 </div>
</template>

<script type="text/ecmascript-6">
import {HTTP} from '../common/http-common';
import  'vue-awesome/icons/arrow-down';
import 'vue-awesome/icons/arrow-up';
import Icon from 'vue-awesome/components/Icon';
import R from 'ramda';
import VuePaginate from 'vue-paginate';
import { modal,alert} from 'vue-strap';

    export default {
    components:{Icon,VuePaginate,modal,alert},
    data:function() {
        return {
        title: '',
        topics:[],
        columns:[
        {code:"",name:"id",title:"Id",enabledFilter:false,filterData:{class:'search-control',modelname:'id'}},
        {code:"",name:"name",title:"Name",enabledFilter:true,filterData:{class:'search-control',modelname:'fname'}}
        ,{code:"",name:"description",title:"Description",enabledFilter:true,filterData:{class:'search-control',modelname:'fdescription'}}
        ,{code:"edit",name:""}
        ,{code:"delete",name:""}
        ],
        searchFields:{name:'',description:''},
        searchForm:{searchButtonTitle:"Search",formFields:[
        {name:'Name',modelname:'name',class:'form-control search-control'},

        {name:'Description',modelname:'description',class:'form-control search-control'}
        ]},
        gridFields:
        {
        gridTitle:'',iconName:'',clickedColumn:'',order:'',iconName:'',currentPage:1,
        from:'',lastPage:'',nextPageUrl:'', perPage:'', pervPageUrl:'', to:'',
        total:'', urlType:'list',
        gridfilters:{fname:'',fdescription:''}
        },
        modalFields:{showDeleteModal:false,modalData:{}},
        alertFields:{alertMessage:this.$route.params.message,showAlert:false,alertDuration:5000},
        paginate: ['topicsList'],
        urlType:'list'

        }
    },
    computed:{
        topicList:function(){
           var vm = this;
         return this.topics.filter(function (item) {

             if(vm.gridFields.gridfilters.fname && !vm.gridFields.gridfilters.fdescription){
                 return (item.name.toLowerCase().indexOf(vm.gridFields.gridfilters.fname.toLowerCase()) !== -1);
             }
             if(!vm.gridFields.gridfilters.fname && vm.gridFields.gridfilters.fdescription){
               return (item.description.toLowerCase().indexOf(vm.gridFields.gridfilters.fdescription.toLowerCase()) !== -1);
             }
             if(vm.gridFields.gridfilters.fname && vm.gridFields.gridfilters.fdescription){
            return ((item.name.toLowerCase().indexOf(vm.gridFields.gridfilters.fname.toLowerCase()) !== -1)
             || (item.description.toLowerCase().indexOf(vm.gridFields.gridfilters.fdescription.toLowerCase()) !== -1));
             }
             return item;

      });


        }


    },
    methods: {

        Search:function(currentPage,callType){
           this.urlType ='search';
           callType=='searchForm'?currentPage=1:currentPage;
           HTTP.post('topics/search?page='+currentPage.toString(),this.searchFields)
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
                this.gridFields.iconName = '';
        },
        Order:function(column_name){
           this.gridFields.clickedColumn =column_name;
           this.gridFields.order ='desc';
           this.topics = R.sortBy(R.prop(column_name), this.topics);
            if (this.gridFields.iconName ==''){
                this.gridFields.iconName='arrow-down';
            }else if(this.gridFields.iconName=='arrow-down'){
             this.gridFields.iconName = 'arrow-up';
             this.gridFields.order ='asc';
             this.topics = R.reverse(this.topics);
            }
            else if(this.gridFields.iconName=='arrow-up'){
                this.gridFields.iconName = 'arrow-down';
            }
        },
        Paginate:function(type,currentPage){

          currentPage = (type =='prev' ? currentPage -1 : currentPage =currentPage +1);
          this.urlType =='search'?this.Search(currentPage.toString(),'paginate'):this.getAllTopics(currentPage.toString());

        },
        setPaginatedData:function(paginationObj){
            this.gridFields.currentPage = paginationObj.currentPage,
            this.gridFields.from=paginationObj.from,
            this.gridFields.lastPage=paginationObj.lastPage,
            this.gridFields.nextPageUrl=paginationObj.nextPageUrl,
            this.gridFields.perPage=paginationObj.perPage,
            this.gridFields.pervPageUrl=paginationObj.prevPageUrl,
            this.gridFields.to=paginationObj.to,
            this.gridFields.total=paginationObj.total
        } ,
        getAllTopics:function(currentPage){
          HTTP.get('topics/all?page='+currentPage)
                .then(response => {
            //Grid data
                this.topics = response.data.topics.data
            //Grid Title
                ,this.gridFields.gridTitle =response.data.title.toUpperCase()
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

        },
        showModalData:function(topic){
           this.modalFields.showDeleteModal=true;
           this.modalFields.modalData =topic;

        },
        deleteData:function(id){

          HTTP.delete('topics/delete/'+id)
                    .then(response =>{
                        this.modalFields.showDeleteModal=false;
                        this.alertFields.showAlert =true;
                        this.alertFields.alertMessage = "Delete Success";
                        this.$router.push({name:'TopicIndex'});
                        this.getAllTopics(this.gridFields.currentPage.toString());

                    })
                    .catch(error=>{
                         this.errors = error.response.data.error;
                    });

        }

    },
    created()
    {
        this.getAllTopics(this.gridFields.currentPage.toString());
        if ( this.$route.params.action) {
            this.alertFields.showAlert = true;
            setTimeout(()=>{
                this.alertFields.showAlert = false;
            },this.alertFields.alertDuration);

        }

    }
    
    } 
</script>
<style>
    .grid-container{
        padding-top: 40px;
    }

</style>
