<template lang="html">
    <div class='col-md-5'>
    </div>
</template>

<script>

export default {
    props: {
        name: null,
    },
    data() {
        return {
            site_url: null,
        }
    },
    components: {
        // ChannelSettings
    },

    methods: {
        getMapData: function(){
            axios.get('/wp-json/wp/v2/map/' + this.mapID)
                .then(res => {
                    this.mapLoading = false;
                    this.mapData = res.data;
                    this.setupMap();
                }) // get error code
        },

        setupMap: function(){

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
        },

        // When a state is clicked, display relevant information in the lower boxes
        state_clicked: function(d) {
            console.log(d)
        }
    },
    watch: {
        site_url(val) {
        }
    }
}
</script>

<style lang="css">
</style>
