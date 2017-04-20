window._ = require('lodash');

window.Vue = require('vue');
window.axios = require('axios');

window.axios.defaults.headers.common = {
    'X-CSRF-TOKEN': window.Laravel.csrfToken,
    'X-Requested-With': 'XMLHttpRequest'
};



// 引入element组件库
/*import ElementUI from 'element-ui'
import 'element-ui/lib/theme-default/index.css'
Vue.use(ElementUI) //注册为vue的全局组件了*/

Vue.component('example', require('./components/Example.vue'));




/*
const app = new Vue({
    el: '#app',
});
*/
