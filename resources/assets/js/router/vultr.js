
import VueRouter from 'vue-router';
import Vue from "vue";
import fireInfo from '../components/vultr/FireInfo';
import index from '../components/vultr/Index';
import ipList from  '../components/vultr/IpList';

Vue.use(VueRouter);

export default new VueRouter({
    routes:[
        {
            path: '/fire_info/:fireid',
            component: fireInfo
        },
        {
            path: '/ip/list',
            component: ipList
        },
        {
            path: '/',
            component: index
        },
    ]
});