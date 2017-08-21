
module.exports = {
    routes: [
        { path: '/', component: require('./components/landing/Index.vue') },
        { path: '/signup', component: require('./components/admin/Register.vue'),name:'SignUp' },
        { path: '/prueba', component: require('./components/Prueba.vue')},
        { path: '/admin', component: require('./components/admin/Index.vue'),name:'BackendIndex'},
        { path: '/login', component: require('./components/admin/Login.vue'),name:'Login'},
        { path: '/admin/topics', component: require('./components/topics/Index.vue'),name:'TopicIndex'},
        { path: '/admin/topics/addedit', component: require('./components/topics/AddEdit.vue'),name:'AddEditTopic'},

    ]
};