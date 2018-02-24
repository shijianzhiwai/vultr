
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */
import App from './App.vue';
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';

//http 请求结果拦截器
axios.interceptors.response.use(response => response,  error => {
    if(error.response.status == 401){ //未登录跳转
        window.location.href = '/login?r='+window.location.href;
        return;
    }
    return Promise.reject(error);
  });

Vue.use(ElementUI);

const app = new Vue({
    el: '#app',
    render: h => h(App)
});
