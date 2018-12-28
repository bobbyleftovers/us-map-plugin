import Vue from 'vue';
import axios from 'axios';
import usmap from './MapData/StateData';
console.log(usmap);
Vue.component('mapMain', {
    
    beforeMount() {
        this.getMapData()
    },

    components: {
        // MapWindow
    },

    data() {
        return {
            mapData: {},
            mapID: document.getElementById('us-map').getAttribute('data-map'),
            mapLoading: true
        }
    },

    methods: {

        getMapData: function(){
            axios.get('/wp-json/wp/v2/map/' + this.mapID)
                .then(res => {
                    this.mapLoading = false;
                    this.mapData = res.data;

                    /* Declare global variables */
                    const width = 960,
                    height = 500;

                    /* Declare D3 variables for map rendering */
                    const projection = d3.geo.albersUsa()
                        .scale(1000)
                        .translate([width / 2, height / 2]);
                    const path = d3.geo.path()
                        .projection(projection);
                    const svg = d3.select('#map').append('svg')
                        .attr('class', 'scaling-svg')
                        .attr('viewBox','50 0 850 800');

                    /* Load the map data after the CSV file has been retrieved and parsed */
                    const states_json = usmap;
                    const g = svg.append('g');

                    g.append('g')
                        .attr('id', 'states')
                        .selectAll('path')
                        .data(topojson.feature(states_json, states_json.objects['usStates']).features)
                        .enter().append('path')
                        .attr('d', path);

                    /* Add state outlines */
                    g.append('path')
                        .datum(topojson.mesh(states_json, states_json.objects['usStates'], function(a, b) { return a !== b; }))
                        .attr('id', 'state-borders')
                        .attr('d', path);

                }) // get error code
        },

        // When a state is clicked, display relevant information in the lower boxes
        state_clicked: function(d) {
            console.log(d)
        }

    }, 

    computed: {},
    
    render(){
        console.log(this.mapData);
        return (
            <div>
                <div class='col-md-5'>
                    <div id='data-box'>
                        <div id='data-preview'>
                            <h1>Click a state to view data</h1>
                        </div>
                        <h1 class='state-name'></h1>
                        <div class='data-info'>
                            <div class='col-md-6'>
                                <div class='data-single'>
                                    <div class='data-field'>Overall DOE Funding (FY17)</div>
                                    <div class='data-value doe-funding'></div>
                                </div>
                                <div class='data-single'>
                                    <div class='data-field'>Total EERE Funding (FY17)</div>
                                    <div class='data-value total_eere_funding'></div>
                                </div>
                                <div class='data-single'>
                                    <div class='data-field'>Number of EERE Grants (FY17)</div>
                                    <div class='data-value total-eere'></div>
                                </div>
                                <div class='data-single'>
                                    <div class='data-field'>Total EERE Grant Funding (FY17)</div>
                                    <div class='data-value total_eere_grant_funding'></div>
                                </div>
                                <div class='data-single'>
                                    <div class='data-field'>Total SC Funding (FY17)</div>
                                    <div class='data-value total-sc'></div>
                                </div>
                                    <div class='data-single'>
                                    <div class='data-field'>Number of SC Grants (FY17)</div>
                                    <div class='data-value num_sc_grants'></div>
                                </div>
                            </div>
                            <div class='col-md-6'>
                                <div class='data-single'>
                                    <div class='data-field'>Total SC Grant Funding (FY17)</div>
                                    <div class='data-value total_sc_grant_funding'></div>
                                </div>
                                <div class='data-single'>
                                    <div class='data-field'>Total FE Funding (FY17)</div>
                                    <div class='data-value total_fe'></div>
                                </div>
                                <div class='data-single'>
                                    <div class='data-field'>Total NE Funding (FY17)</div>
                                    <div class='data-value total_ne'></div>
                                </div>
                                <div class='data-single'>
                                    <div class='data-field'>Number of ARPA-E Grants</div>
                                    <div class='data-value num_arpa_grants'></div>
                                </div>
                                <div class='data-single'>
                                    <div class='data-field'>Total ARPA-E Grant Funding</div>
                                    <div class='data-value total_arpa_grant_funding'></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='col-md-7'>
                    <div class='map-container'>
                        <div id='map'></div>
                    </div>
                </div>
            </div>
        );

    }

});