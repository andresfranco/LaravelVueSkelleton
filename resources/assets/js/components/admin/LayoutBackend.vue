<template>
<html>
<body>
<top-navbar @openmenu="onClickTopNavbar" :topNavbarOptions="topNavbarOptions"></top-navbar>
<div id="wrapper" v-bind:class="{ toggled: menuclicked }">
    <div class="container-fluid">
    <sidebar-menu :menuOptions="menuOptions"></sidebar-menu>
    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
            <div class="col-lg-12">
                <router-view></router-view>
            </div>
            </div>
        </div>
    </div>
    </div>
</div>
</body>
</html>
</template>

<script>
import Topnavbar from './Topnavbar.vue';
import Sidebarmenu from './Sidebarmenu.vue';
import auth from '../../auth.js';
export default {
    data: function () {
        return {
            menuclicked: false,
            menuOptions:[{route:'BackendIndex',icon:'glyphicon glyphicon-home',name:'Home'},
                {route:'TopicIndex',icon:'glyphicon glyphicon-align-justify',name:'Topics'}],
            topNavbarOptions:[{code:'username',route:'',icon:'glyphicon glyphicon-user'
            ,name:localStorage.getItem('userName'),clickEvent:''},
            {route:'',icon:'glyphicon glyphicon-off',name:'Logout',clickEvent:this.signOut}
            ]
            
        }
    },
    components:{
        'top-navbar':Topnavbar,
        'sidebar-menu':Sidebarmenu
    },
    methods:{
        onClickTopNavbar:function(value){
           this.menuclicked =value;
        },
        signOut:function(){
         auth.signOut(this.$router);
        }
        
    }

}
</script>
<style>
    body{
        font-size: 12px;
    }
    .btn{
        font-size: 12px;
    }
    h3{
        font-size: 20px;
    }
    .search-control {
        height: 25px;
        font-size: 12px;
    }
    
    .errorMessage{
        padding-top:10px;
        color:red;
        font-weight:bold;
        }
    #wrapper {
        padding-left: 0;
        -webkit-transition: all 0.5s ease;
        -moz-transition: all 0.5s ease;
        -o-transition: all 0.5s ease;
        transition: all 0.5s ease;
    }

    #wrapper.toggled {
        padding-left: 250px;
    }

    #sidebar-wrapper {
        position: fixed;
        left: 100px;
        z-index: 1000;
        overflow-y: auto;
        margin-left: -100px;
        width: 0;
        height: 100%;
        background: #000;
        -webkit-transition: all 0.5s ease;
        -moz-transition: all 0.5s ease;
        -o-transition: all 0.5s ease;
        transition: all 0.5s ease;
    }

    #wrapper.toggled #sidebar-wrapper {
        width: 250px;
    }

    #page-content-wrapper {
        padding: 15px;
        width: 100%;
    }

    #wrapper.toggled #page-content-wrapper {
        position: absolute;
        margin-right: -250px;
    }

    /* Sidebar Styles */

    .sidebar-nav {
        position: absolute;
        top: 0;
        margin: 0;
        padding: 0;
        width: 250px;
        list-style: none;
    }

    .sidebar-nav li {
        text-indent: 20px;
        line-height: 40px;
    }

    .sidebar-nav li a {
        display: block;
        color: #999999;
        text-decoration: none;
    }

    .sidebar-nav li a:hover {
        background: rgba(255, 255, 255, 0.2);
        color: #fff;
        text-decoration: none;
    }

    .sidebar-nav li a:active,
    .sidebar-nav li a:focus {
        text-decoration: none;
    }

    .sidebar-nav > .sidebar-brand {
        height: 65px;
        font-size: 18px;
        line-height: 60px;
    }

    .sidebar-nav > .sidebar-brand a {
        color: #999999;
    }

    .sidebar-nav > .sidebar-brand a:hover {
        background: none;
        color: #fff;
    }

    @media (min-width: 768px) {
        #wrapper {
            padding-left: 250px;
        }

        #wrapper.toggled {
            padding-left: 0;
        }

        #sidebar-wrapper {
            width: 250px;
        }

        #wrapper.toggled #sidebar-wrapper {
            width: 0;
        }

        #page-content-wrapper {
            padding: 20px;
        }

        #wrapper.toggled #page-content-wrapper {
            position: relative;
            margin-right: 0;
        }
    }
</style>