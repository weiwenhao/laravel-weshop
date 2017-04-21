window._ = require('lodash');

window.Vue = require('vue');
window.axios = require('axios');

window.axios.defaults.headers.common = {
    'X-CSRF-TOKEN': window.Laravel.csrfToken,
    'X-Requested-With': 'XMLHttpRequest'
};

window.$ = window.jQuery = require('jquery');


require('bootstrap-sass');
//弹出层组件
require('sweetalert');
require('select2')
//日期选择控件
// require('laydate')

//adminlet后台
require('./admin/fastclick')
require('./admin/jquery.slimscroll')
require('./admin/app')
require('./admin/demo')


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
