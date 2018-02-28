
import VueRouter from 'vue-router';
import fireInfo from '../components/vultr/FireInfo';
import index from '../components/vultr/Index';
import Vue from "vue";

Vue.use(VueRouter);

export default new VueRouter({
    routes:[
        {
            path: '/fire_info/:fireid',
            component: fireInfo
        },
        {
            path: '/',
            component: index
        },
    ]
});