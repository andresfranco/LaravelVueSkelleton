
module.exports = {
    routes: [
        { path: '/', component: require('./components/landing/Index.vue') },
        { path: '/prueba', component: require('./components/Prueba.vue')},
        { path: '/admin', component: require('./components/admin/Index.vue')},
        { path: '/admin/topics', component: require('./components/topics/Index.vue'),name:'TopicIndex'},
        { path: '/admin/topics/addedit', component: require('./components/topics/AddEdit.vue'),name:'AddEditTopic'},

    ]
};