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
import Vue from 'vue';

Vue.use(ElementUI);

var app = null;

//http 请求结果拦截器
axios.interceptors.response.use(response => response, error => {
    if (error.response.status === 401) { //未登录跳转
        window.location.href = '/login?r=' + window.location.href;
        return;
    }
    if (error.response.status === 403) { //forbid 错误
        app.share.dialogVisible = true;
        app.share.dialogVal.info = '接口请求错误，http code : 403';
        return;
    }
    return Promise.reject(error);
});

app = new Vue({
    el: '#app',
    //箭头函数绑定的this作用域为上下文中的this，此处要使用vue的作用域，故没有使用箭头函数
    render : function (h){
        return h(App, {
            props: {
                share: this.share
            }
        });
    },
    data: {
        share : {
            dialogVisible: false,
            dialogVal: {info: ""},
        }
    }
});