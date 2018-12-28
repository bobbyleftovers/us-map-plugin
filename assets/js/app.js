import axios from 'axios';
import Vue from 'vue';
import store from './setup/store';
// import router from './setup/router';
// import MapMain from './components/MapMain.vue';

//LoDash cuse it awesome
window._ = require('lodash');

/**
 * AXIOS
 */

window.axios = require('axios');

//import vue
window.Vue = require('vue');

//Bus for emits and ons
window.Bus = new Vue();

Vue.prototype.$_window = window;

/**
 * Startup Vue
 */

require('./components/mapMain.js');
const app = new Vue({
    el: '#us-map',
});