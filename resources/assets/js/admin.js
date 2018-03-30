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

//初始化判断
/*if(Number(sessionStorage.getItem('hide_left_nav'))){ //1
    $('body').addClass('sidebar-collapse'); // 切换为隐藏(添加class) => hide_left_nav = 1
}else {
    $('body').removeClass('sidebar-collapse'); //将状态切换为 1 隐藏
}
$('.sidebar-toggle').click(function() {
    //当前的状态
    var left_nav_status =  Number(sessionStorage.getItem('hide_left_nav'));
    if(!left_nav_status){ //当前hide_left_nav = 0 显示
        //  加上sidebar-collapse这个class就是隐藏
        $('body').addClass('sidebar-collapse'); // 切换为隐藏(添加class) => hide_left_nav = 1
        //把1存储进去
        sessionStorage.setItem('hide_left_nav', 1);
    }else{ //hide_left_nav = 1 隐藏
        $('body').removeClass('sidebar-collapse'); //将状态切换为 1 隐藏
        //把0存储进去
        sessionStorage.setItem('hide_left_nav', 0);
    }
});*/
