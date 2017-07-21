
module.exports = {
    routes: [
        { path: '/', component: require('./components/landing/Index.vue') },
        { path: '/test', component: require('./components/Test.vue') },
        { path: '/prueba', component: require('./components/Prueba.vue')},
        { path: '/topics', component: require('./components/topics/Index.vue')},
        { path: '/topics/new', component: require('./components/topics/AddEdit.vue')},
        { path: '/admin', component: require('./components/admin/Index.vue')}
    ]
};