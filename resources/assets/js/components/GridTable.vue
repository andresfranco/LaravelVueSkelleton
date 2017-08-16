<template>
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
</template>

<script>
    import {HTTP} from './common/http-common';
    export default {         
    data:function() {
        return {
         gridApiData:[],    
        //Columns shown in the grid and columns with filter, Filterdata has the information of the v-model name and class for the grid filters.
        gridColumns:[
        {name:'id',title:'Id',enabledFilter:false,filterData:{class:'search-control',modelname:'id'}},
        {name:'name',title:'Name',enabledFilter:true,filterData:{class:'search-control',modelname:'fname'}}
        ,{name:'description',title:'Description',enabledFilter:true, filterData:{class:'search-control',modelname:'fdescription'}},
        //Buttons for actions , do not have names.
        {code:'edit',name:''},
        {code:"delete",name:''}
        ],
        //Object send to the api, it fill with the values of inputs in search form.
        searchFields:{name:'',description:''},
        //Search form parameters
        searchForm:{
        searchButtonTitle:'Search',searchIconLabel:'Search Fields',searchIconFiltersLabel:'Show Filters',searchShow:true,showIcon:'search-plus',filtersShow:true,showFilterIcon:'search-plus',formFields:[
        {name:'Name',modelname:'name',class:'form-control search-control'},
        {name:'Description',modelname:'description',class:'form-control search-control'}
        ]},
        //Grid parameters
        gridFields:
        {
        gridTitle:'',iconName:'',clickedColumn:'',order:'',iconName:'',currentPage:1,
        from:'',lastPage:'',nextPageUrl:'', perPage:'', pervPageUrl:'', to:'',
        total:'', urlType:'list',
        gridfilters:{fname:'',fdescription:''},
        //Edit component parameters in the edit button
        editComponentData:{name:'AddEditTopic',title:'Edit Topic',mode:'upd'},
        //New component parameters in the new button
        newComponentData:{name:'AddEditTopic', title:'New Topic',mode:'ins'},
        editButtonLabel:'Edit',newButtonLabel:'New',deleteButtonLabel:'Delete',cancelButtonLabel:'Cancel',
        //Routes for all actions search form , delete, new and edit button
        routeData:{moduleName:'topics',searchRoute:'/search',allRoute:'/all',deleteRoute:'/delete',indexRoute:'TopicIndex'},
        //Icons for order and show and hide search form and filters.
        iconNames:{orderUp:'arrow-up',orderDown:'arrow-down',showPlus:'search-plus',showMinus:'search-minus'}
        },
        //Delete modal.
        modalFields:{
            effect:'fade',width:'400px',showDeleteModal:false,modalData:{},
            modalTitle:'Are you sure you want to delete this topic?',deleteMessage:'Delete Success'
            ,availableFields:[{name:'name',title:'Name'},{name:'description',title:'Description'}],
            cssClasses:{
            modalTitle:'modal-title',modalHeader:'modal-header',modalBody:'modal-body',modalFooter:'modal-footer',
            cancelButton:'btn btn-default',deleteButton:'btn btn-danger'}
        },
        //Alerts that show the success actions: new ,update and delete
        alertFields:{alertMessage:this.$route.params.message,showAlert:false,alertDuration:5000,
            type:'success',width:'400px',iconName:'check-square'
        },
        //Grid paginator
        paginateFields:{
            labels:{showing:'Showing',to:'to',of:'of',page:'Page',next:'Next',previous:'Previous'},
            paginateListName:'gridApiDataList',cssClasses:{paginateList:'pagination',pageItem:'page-item',pageLink:'page-link'}
        },
        //Grid css classes 
        cssClasses:{
            gridContainer:'grid-container',showIcon:'show-icon',formGroup:'form-group',searchButton:'btn btn-primary',
            newButton:'btn btn-primary',gridTable:'table',editButton:'btn btn-primary',deleteButton:'btn btn-danger',
            cancelButton:'btn btn-default'} ,
         errors:[]    
         
        
        }
       
        
        
    },
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
    methods:{
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

