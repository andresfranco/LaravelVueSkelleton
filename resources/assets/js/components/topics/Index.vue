<template>
   <div>
   <grid :gridColumns="gridColumns" :searchFields="searchFields"
    :searchForm="searchForm" :gridFields="gridFields" :modalFields ="modalFields"
    :alertFields="alertFields" :paginateFields="paginateFields" :cssClasses ="cssClasses" >
    </grid>
   </div>
</template>

<script>
    export default {         
    data:function() {
        return {
        //Columns shown in the grid and columns with filter, Filterdata has the information of the v-model name and class for the grid filters.
        gridColumns:[
        {name:'id',title:'Id'},
        {name:'name',title:'Name'}
        ,{name:'description',title:'Description'},
        //Buttons for actions , do not have names.
        {code:'edit',name:''},
        {code:"delete",name:''}
        ],
        //Object send to the api, it fill with the values of inputs in search form.
        searchFields:{name:'',description:''},
        //Search form parameters
        searchForm:{
        searchButtonTitle:'Search',searchIconLabel:'Search Fields',searchShow:true,showIcon:'search-plus',formFields:[
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
            cancelButton:'btn btn-default'} 
         
        
        }
        
        
    }
    
    }   
</script>

