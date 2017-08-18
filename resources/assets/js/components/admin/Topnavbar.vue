<template>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand"  id="menu-toggle" @click ="OpenMenu(menuclicked)"><span class="glyphicon glyphicon-list" aria-hidden="true"></span></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li v-for ="item in topNavbarOptions"><router-link :to="{name:item.route}"><span :class="item.icon"></span> {{ item.name}}</router-link></li>
            </ul>
        </div>
    </div>
</nav>
</template>

<script>  
import  'vue-awesome/icons';
export default {
    props:['topNavbarOptions'],
    data: function () {
        return {
            menuclicked: false,
        }
    },
    methods: {
        OpenMenu: function (menuclicked) {
            this.menuclicked = !menuclicked;
            this.$emit('openmenu', this.menuclicked );
        }
    }
}
</script>