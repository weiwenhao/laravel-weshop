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
Vue.component('CreatePost', require('./components/circle/CreatePost.vue'));
Vue.component('Posts', require('./components/circle/Posts.vue'));
Vue.component('Post', require('./components/circle/Post.vue'));
Vue.component('PostNews', require('./components/circle/PostNews.vue'));

const app = new Vue({
 el: '#app',
 });
