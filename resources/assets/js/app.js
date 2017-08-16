
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');




window.Vue = require('vue');

import VueRouter from 'vue-router';
Vue.use(VueRouter);
 
import {routes} from './routes';
 
const router = new VueRouter({routes, mode: 'history'});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('grid-table', require('./components/GridTable.vue'));
Vue.component('grid', require('./components/Grid.vue'));
Vue.component('layoutbackend', require('./components/admin/LayoutBackend.vue'));
Vue.component('landinglayout', require('./components/landing/LandingLayout.vue'));
Vue.component('index', require('./components/landing/Index.vue'));
Vue.component('topics-index', require('./components/topics/Index.vue'));
Vue.component('topics-add-edit', require('./components/topics/AddEdit.vue'));
Vue.component('test', require('./components/Test.vue'));

const app = new Vue({
  router
}).$mount('#app')
