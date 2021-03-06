import App from './components/vultr/App';
import Vue from 'vue';
import router from './router/vultr';
import ElementUi from 'element-ui';
import "element-ui/lib/theme-chalk/index.css";

Vue.use(ElementUi);

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

let app = null;

function formatErrorInfo(code) {
    switch (code) {
        case 422:
            return "参数不合法";
        case 403:
            return "禁止访问";
        default:

    }
}

//http 请求结果拦截器
window.axios.interceptors.response.use(response => response, error => {
    if (error.response.status === 401) { //未登录跳转
        window.location.href = '/login?r=' + window.location.href;
        return;
    }

    app.share.dialogVisible = true;
    let info = formatErrorInfo(error.response.status);
    app.share.dialogVal.info = '请求错误（http status）：' + error.response.status + ` (${info})`;

    return Promise.reject(error);
});

app = new Vue({
    el: '#app',
    router,
    //箭头函数绑定的this作用域为上下文中的this，此处要使用vue的作用域，故没有使用箭头函数
    //普通函数的this是调用函数的那个对象
    render: function (h) {
        return h(App, {
            props: {
                share: this.share,
            }
        });
    },
    data: {
        share: {
            dialogVisible: false,
            dialogVal: {info: ''},
        }
    }
});