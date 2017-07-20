
module.exports = {
    routes: [
        { path: '/', component: require('./components/landing/Index.vue') },
        { path: '/test', component: require('./components/Test.vue') },
        { path: '/prueba', component: require('./components/Prueba.vue')},
         { path: '/topics', component: require('./components/topics/Index.vue'),
         children: [
        {
          // UserProfile will be rendered inside User's <router-view>
          // when /user/:id/profile is matched
          path: 'new',
          component:  require('./components/topics/AddEdit.vue')
        }] }
    ]
};