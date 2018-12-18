import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex)
const store = new Vuex.Store({
    state: {
        map: {
            donation: {
                amount: null,
            },
            fname: null,
        }
    },
    getters: {
        donor: state => state.donor,
        donation: state => state.donor.donation
    },
    mutations: {
        setDonor: (state,payload) => state.donor = payload,
        setAmount: (state,payload) => state.donor.donation = payload
    }
});

export default store;