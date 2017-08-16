<template>
     <div>
    <div :class ="cssClasses.gridContainer">
        <div>
           <div><h3>{{gridFields.gridTitle}}</h3></div>
         <div>
         <a @click="showSearchForm(searchForm.searchShow,searchForm.showIcon)" :class="cssClasses.showIcon">
         <icon v-bind:name="searchForm.showIcon"></icon> {{searchForm.searchIconLabel}}</a>            
         <div id="search-form" v-show ="searchForm.searchShow">
            <form v-on:submit.prevent="Search(gridFields.currentPage,'searchForm')">
                <div :class="cssClasses.formGroup" v-for ="searchitem in searchForm.formFields">
                <label for="name">{{searchitem.name}}</label>
                <input  :name ="searchitem.name" type="text" v-model="searchFields[searchitem.modelname]" :class="searchitem.class">
                </div>
                <div :class="cssClasses.formGroup">
                <button type="submit" :class="cssClasses.searchButton">{{searchForm.searchButtonTitle}}</button>
                </div>
            </form>
            <hr>
         </div>
         
            <router-link :to="getComponentLink(null,gridFields.newComponentData)" :class="cssClasses.newButton">{{gridFields.newButtonLabel}}</router-link>
            <br><br>
            <alert  v-model="alertFields.showAlert" :duration="alertFields.alertDuration" :type="alertFields.type" :width="alertFields.width" dismissable>
                <icon :name="alertFields.iconName"></icon>
                <strong>{{alertFields.alertMessage}}</strong>
            </alert>
            <a @click="showFilters(searchForm.filtersShow,searchForm.showFilterIcon)" :class="cssClasses.showIcon">
            <icon v-bind:name="searchForm.showFilterIcon"></icon> {{searchForm.searchIconFiltersLabel}}</a>
            <table :class="cssClasses.gridTable">
                <thead>
                    <tr>
                        <th v-for="column in gridColumns" >
                        <a v-if="column.name" @click ="Order(column.name)">{{column.title}}
                        <icon v-bind:name="gridFields.iconName" v-if="(gridFields.clickedColumn==column.name) && gridFields.iconName && column.name "></icon>
                        </a>
                        </th>
                    </tr>
                    <tr v-show="searchForm.filtersShow">   
                        <td v-for="column in gridColumns">
                        <input v-if="column.enabledFilter"  type ="text" :class ="column.filterData.class" v-model ="gridFields.gridfilters[column.filterData.modelname]">
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(griditem,index) in dataList" v-bind:data-index="index">
                        <td v-for="item in griditem">{{item}}</td>
                        <td><router-link :to="getComponentLink(griditem.id,gridFields.editComponentData)" :class="cssClasses.editButton">{{gridFields.editButtonLabel}}</router-link></td>
                        <td><button type="button" :class="cssClasses.deleteButton" @click ="showModalData(griditem)">{{gridFields.deleteButtonLabel}}</button></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <nav >
            <div>{{paginateFields.labels.showing+' '+ gridFields.from+' '+ paginateFields.labels.to+' '+gridFields.to+' '+paginateFields.labels.of+' '+gridFields.total}}</p>
            <ul :class="paginateFields.cssClasses.paginateList">
            <li :class="paginateFields.cssClasses.pageItem" v-if="gridFields.currentPage > 1"><a :class="paginateFields.cssClasses.pageLink" @click="Paginate('prev',gridFields.currentPage)">{{paginateFields.labels.previous}}</a></li>
            <li> <span>{{paginateFields.labels.page +' '+gridFields.currentPage+' '+paginateFields.labels.of+' '+gridFields.lastPage}}</span>  </li>
            <li :class="paginateFields.cssClasses.pageItem" v-if="gridFields.nextPageUrl"><a :class="paginateFields.cssClasses.pageLink" @click="Paginate('next',gridFields.currentPage)">{{paginateFields.labels.next}}</a></li>
            </ul>
            </div>
        </nav>

    </div>
    </div>
  <div>
    <modal v-model="modalFields.showDeleteModal" :effect="modalFields.effect" :width="modalFields.width">
        <div slot="modal-header" :class="modalFields.cssClasses.modalHeader">
            <h4 :class="modalFields.cssClasses.modalTitle">
            {{modalFields.modalTitle}}
            </h4>
        </div>
        <div slot="modal-body" :class="modalFields.cssClasses.modalBody">
            <div v-for="modalitem in  modalFields.availableFields">
             {{modalitem.title}} : {{modalFields.modalData[modalitem.name]}}
            </div>
        </div>
        <div slot="modal-footer" :class="modalFields.cssClasses.modalFooter">
            <button type="button" :class="modalFields.cssClasses.cancelButton" @click="modalFields.showDeleteModal = false">{{gridFields.cancelButtonLabel}}</button>
            <button type="button" :class="modalFields.cssClasses.deleteButton" @click="deleteData(modalFields.modalData.id)">{{gridFields.deleteButtonLabel}}</button>
        </div>
    </modal>
   </div>
   <div>

   </div>

 </div>
</template>

<script>
import {HTTP} from './common/http-common';
import  'vue-awesome/icons/arrow-down';
import 'vue-awesome/icons/arrow-up';
import Icon from 'vue-awesome/components/Icon';
import R from 'ramda';
import { modal,alert} from 'vue-strap';

    export default {
    name:'grid',           
    components:{Icon,modal,alert},
    props:['gridColumns', 'searchFields','searchForm','gridFields','modalFields'
    ,'alertFields','paginateFields','cssClasses','filterConditions'],
    computed:{
        dataList:function(){
         var vm = this;
         return this.gridApiData.filter(function (item) {

            if(vm.gridFields.gridfilters.fname && !vm.gridFields.gridfilters.fdescription){
                 return (item.name.toLowerCase().indexOf(vm.gridFields.gridfilters.fname.toLowerCase()) !== -1);
             }
             if(!vm.gridFields.gridfilters.fname && vm.gridFields.gridfilters.fdescription){
               return (item.description.toLowerCase().indexOf(vm.gridFields.gridfilters.fdescription.toLowerCase()) !== -1);
             }
             if(vm.gridFields.gridfilters.fname && vm.gridFields.gridfilters.fdescription){
            return ((item.name.toLowerCase().indexOf(vm.gridFields.gridfilters.fname.toLowerCase()) !== -1)
             && (item.description.toLowerCase().indexOf(vm.gridFields.gridfilters.fdescription.toLowerCase()) !== -1));
             }
             return item;});
    }

    },
    data:function() {
        return {
        gridApiData:[]
    }
    },
    methods:{
        //Search data , filter with the search form inputs
        Search:function(currentPage,callType){
           this.gridFields.urlType ='search';
           callType=='searchForm'?currentPage=1:currentPage;
           HTTP.post(this.gridFields.routeData.moduleName+this.gridFields.routeData.searchRoute+'?page='+currentPage.toString(),this.searchFields)
            .then(response => {
                //Grid data
                this.gridApiData = response.data.data,
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
        //Order data if click column
        Order:function(column_name){
           this.gridFields.clickedColumn =column_name;
           this.gridFields.order ='desc';
           this.gridApiData = R.sortBy(R.prop(column_name), this.gridApiData);
            if (this.gridFields.iconName ==''){
                this.gridFields.iconName= this.gridFields.iconNames.orderDown;
            }else if(this.gridFields.iconName== this.gridFields.iconNames.orderDown){
             this.gridFields.iconName = this.gridFields.iconNames.orderUp;
             this.gridFields.order ='asc';
             this.gridApiData = R.reverse(this.gridApiData);
            }
            else if(this.gridFields.iconName== this.gridFields.iconNames.orderUp){
                this.gridFields.iconName =  this.gridFields.iconNames.orderDown;
            }
        },
        //Set Paginate values from api , all the paginate data is comming from the api rest.
        Paginate:function(type,currentPage){

          currentPage = (type =='prev' ? currentPage -1 : currentPage =currentPage +1);
          this.gridFields.urlType =='search'?this.Search(currentPage.toString(),'paginate'):this.getAll(currentPage.toString());

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
        //Get all the data ,paginated
        getAll:function(currentPage){
          HTTP.get(this.gridFields.routeData.moduleName+this.gridFields.routeData.allRoute+'?page='+currentPage)
                .then(response => {
            //Grid data
                this.gridApiData = response.data.gridData.data
            //Grid Title
                ,this.gridFields.gridTitle =response.data.title.toUpperCase()
            //Pagination Values
                this.setPaginatedData({
                    currentPage:response.data.gridData.current_page,
                    from:response.data.gridData.from,
                    lastPage:response.data.gridData.last_page,
                    nextPageUrl:response.data.gridData.next_page_url,
                    perPage:response.data.gridData.per_page,
                    prevPageUrl:response.data.gridData.prev_page_url,
                    to:response.data.gridData.to,
                    total:response.data.gridData.total
                });

                })
                .catch(e => {
                this.errors.push(e)
                });

        },
        //Show modal if click delete button
        showModalData:function(modaldata){
           this.modalFields.showDeleteModal=true;
           this.modalFields.modalData =modaldata;

        },
        //Call the api rest and delete the row in the database.
        deleteData:function(id){

          HTTP.delete(this.gridFields.routeData.moduleName+this.gridFields.routeData.deleteRoute+'/'+id)
                    .then(response =>{
                        this.modalFields.showDeleteModal=false;
                        this.alertFields.showAlert =true;
                        this.alertFields.alertMessage = this.modalFields.deleteMessage;
                        this.$router.push({name:this.gridFields.routeData.indexRoute});
                        this.getAll(this.gridFields.currentPage.toString());

                    })
                    .catch(error=>{
                         this.errors = error.response.data.error;
                    });

        },
        //Hide or show search form
        showSearchForm:function(searchShow,showIcon){

        showIcon ==this.gridFields.iconNames.showPlus?this.searchForm.showIcon =this.gridFields.iconNames.showMinus:this.searchForm.showIcon =this.gridFields.iconNames.showPlus;
        this.searchForm.searchShow =!searchShow;
            
        },
        //Hide or show grid filters
        showFilters:function(filtersShow,showFilterIcon){

        showFilterIcon ==this.gridFields.iconNames.showPlus?this.searchForm.showFilterIcon =this.gridFields.iconNames.showMinus:this.searchForm.showFilterIcon =this.gridFields.iconNames.showPlus;
        this.searchForm.filtersShow =!filtersShow;
            
        },
        //Get the component link if id is null get the component for new if not get the component for Edit.
        getComponentLink:function(id,addEditParams){
           let returnObject ={name:'',params:{}};
           id==null? returnObject= {name:addEditParams.name, params:{title:addEditParams.title,mode:addEditParams.mode}}:
           returnObject={name:addEditParams.name, params:{title:addEditParams.title,mode:addEditParams.mode,id:id}};
           return returnObject;
        }

    },
        created()
        {
            //Populate the grid with all the data paginated.
            this.getAll(this.gridFields.currentPage.toString());
            //Check if the component was called from an edit or new action.
            if ( this.$route.params.action) {
                //Set the timeout for the alert that shows action success
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
    .show-icon{
        float:right;
    }
</style>
