import axios from 'axios';
import Vue from 'vue';
import store from './setup/store';

//LoDash cuse it awesome
window._ = require('lodash');

/**
 * AXIOS
 */

window.axios = require('axios');

// window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

//import vue
window.Vue = require('vue');

//Bus for emits and ons
window.Bus = new Vue();

Vue.prototype.$_window = window;

/**
 * Startup Vue
 */

require('./setup/main.js');

// WP REST Test:
axios.get('/wp-json/wp/v2/map/50668')
    .then(res => {console.log(res.data)}) // works

const app = new Vue({
    el: '#us-map',
    store
});

// window.axios.interceptors.response.use(function (response) {
//     return response;
// }, function (error) {
//     switch (error.response.status) {
//         case 401:
//             // window.location = '/login/expired'
//             break;

//         case 419:
//             // window.location = '/login/expired';
//             break;

//     }

//     return Promise.reject(error);
// });