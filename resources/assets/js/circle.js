window._ = require('lodash');

window.Vue = require('vue');
window.axios = require('axios');

window.axios.defaults.headers.common = {
    'X-CSRF-TOKEN': window.Laravel.csrfToken,
    'X-Requested-With': 'XMLHttpRequest'
};

window.$ = window.jQuery = require('jquery');


//引入weui.js

// require('bootstrap-sass');
Vue.component('CreateCircle', require('./components/circle/CreateCircle.vue'));
Vue.component('Circles', require('./components/circle/Circles.vue'));

const app = new Vue({
 el: '#app',
 });
