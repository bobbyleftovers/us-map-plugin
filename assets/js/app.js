import Vue from 'vue';
import MapMain from './components/MapMain';
import BootstrapVue from 'bootstrap-vue';
// import 'bootstrap/dist/css/bootstrap.css'; // comment this in if you need it
import 'bootstrap-vue/dist/bootstrap-vue.css';

Vue.use(BootstrapVue);

//LoDash cuse it awesome
window._ = require('lodash');

//import vue
window.Vue = require('vue');

Vue.prototype.$_window = window;

/**
 * Startup Vue
 */

new Vue({
    components:{
        MapMain
    }
}).$mount('#us-map');