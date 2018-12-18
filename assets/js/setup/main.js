import Vue from 'vue';
import axios from 'axios';

Vue.component('mapMain', {
    components: {
        // ProductButton
    },
    data() {
        return {

            // params
            mapData: {},
            mapLoading: false
        }
    },

    methods: {

        getMapData:function(){
            axios.post()
        },
        setDonation:function(){}
    },   
    computed: {}

});