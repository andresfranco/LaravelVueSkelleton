
module.exports = {
    routes: [
        { path: '/', component: require('./components/landing/Index.vue') },
        { path: '/test', component: require('./components/Test.vue') },
        { path: '/prueba', component: require('./components/Prueba.vue')},
        { path: '/admin', component: require('./components/admin/Index.vue')},
        { path: '/admin/topics', component: require('./components/topics/Index.vue')},
        { path: '/admin/topics/addedit', component: require('./components/topics/AddEdit.vue')},

    ]
};