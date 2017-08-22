
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');




window.Vue = require('vue');

import VueRouter from 'vue-router';
import VeeValidate from 'vee-validate';

const config = {
  errorBagName: 'errors', // change if property conflicts.
  fieldsBagName: 'fields', 
  delay: 0, 
  locale: 'en', 
  dictionary: null, 
  strict: true, 
  classes: false, 
  classNames: {
    touched: 'touched', // the control has been blurred
    untouched: 'untouched', // the control hasn't been blurred
    valid: 'valid', // model is valid
    invalid: 'invalid', // model is invalid
    pristine: 'pristine', // control has not been interacted with
    dirty: 'dirty' // control has been interacted with
  },
  events: 'input|blur',
  inject: true
};
Vue.use(VueRouter);
Vue.use(VeeValidate,config);
 
import {routes} from './routes';
 
const router = new VueRouter({routes, mode: 'history'});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('layoutlogin', require('./components/admin/LayoutLogin.vue'));
Vue.component('login', require('./components/admin/Login.vue'));
Vue.component('signup', require('./components/admin/Register.vue'));
Vue.component('grid-table', require('./components/GridTable.vue'));
Vue.component('grid', require('./components/Grid.vue'));
Vue.component('layoutbackend', require('./components/admin/LayoutBackend.vue'));
Vue.component('backend-index', require('./components/admin/Index.vue'));
Vue.component('landinglayout', require('./components/landing/LandingLayout.vue'));
Vue.component('index', require('./components/landing/Index.vue'));
Vue.component('topics-index', require('./components/topics/Index.vue'));
Vue.component('topics-add-edit', require('./components/topics/AddEdit.vue'));
Vue.component('test', require('./components/Test.vue'));

const app = new Vue({
  router
}).$mount('#app')
