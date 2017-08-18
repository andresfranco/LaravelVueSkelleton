<template>
    <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <br>
                </li>

                <li v-for="menuItem in menuOptions">
                    <router-link :to="{name:menuItem.route}"><span :class="menuItem.icon" aria-hidden="true"></span> {{ menuItem.name}}</router-link>
                </li>
               
            </ul>
        </div>
</template>
<script>
export default {
    props:['menuOptions'],
    data: function () {
        return {
           
        }
    }
}
</script>
