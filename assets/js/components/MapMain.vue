<script>
    import axios from 'axios';
    import usmap from './MapData/StateData';
    import MapWindowMain from './MapWindow/MapWindowMain';
    import MobileViewer from './MobileViewer/MobileViewer';

    export default {
        
        beforeMount() {
            // set up the data
            this.getMapData();
        },

        components: {
            MapWindowMain,
            MobileViewer
        },

        data() {
            return {
                mapLoading: true,
                dataLoading: true,
                mapData: {},
                mapID: document.getElementById('us-map').getAttribute('data-map'),
                stateData: [],
                isCSV: false,
                csvURL: null,
                showDC: false,
                showSmallStateIcons: false,
                smallStates: ['CT','MA','RI','NJ','DE','MD','HI'],
                selectedState: null,
                mapStyle: {},
                windowStyle: {},
            }
        },

        methods: {

            // init
            getMapData: function(){
                axios.get('/wp-json/wp/v2/map/' + this.mapID)
                    .then(res => {
                        console.log('INIT:',res.data);
                        // setup using the post meta
                        this.showDC = res.data.map_meta.show_dc;
                        this.showSmallStateIcons = res.data.map_meta.show_small_state_icons;
                        this.isCSV = res.data.map_meta.has_csv;
                        this.csvURL = res.data.map_meta.map_csv;
                        this.mapStyle = res.data.map_meta.style.map;
                        this.windowStyle = res.data.map_meta.style.dataViewer;
                        this.mapData = res.data.map_meta;

                        console.log('style',this.mapStyle,this.windowStyle)

                        // get state data from the right source based on the rest reponse
                        if(this.isCSV){
                            // set up csv data for use
                            this.setupCSV()
                                .then(
                                    (res) => {
                                        this.stateData = res;
                                    }
                                );
                        } else {
                            // or just grab the array from here
                            this.stateData = res.data.map_meta.states_array;
                        }

                        // build the map
                        this.setupMap()

                    })
                    .catch(error => {
                        // get error handling code
                    }) 
            },

            // get state data from a csv file
            setupCSV: function(){
                let response = $.Deferred();
                d3.csv(this.csvURL)
                    .row(function(d) {
                        let items = [];
                        items['state'] = d.State.toUpperCase();
                        items['state_meta'] = []
                        
                        for (const [key, value] of Object.entries(d)) {
                            if(key !== 'State'){
                                items['state_meta'].push({
                                    array_item_data: value,
                                    array_item_label: key,
                                    is_download: false
                                });
                            }
                        }

                        return items;
                    })
                    .get(function(error, rows) { 
                        return response.resolve(rows);
                    });
                return response.promise();

            },

            // get the map ready and attach events
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

                // have to use stuff from the vue instance but 'this' means something else in the d3 function
                const showDC = this.showDC;
                const showSmallStateIcons = this.showSmallStateIcons;
                const smallStates = this.smallStates;
                const stateClicked = this.stateClicked;
                const svgStyles = this.mapStyle;

                /* Load the map data (after the CSV file has been retrieved and parsed, if there is one) */
                const states_json = usmap;
                const g = svg.append('g');

                /* Add the states and associated event handlers */
                g.append('g')
                    .attr('id', 'states')
                    .selectAll('path')
                    .data(topojson.feature(states_json, states_json.objects['usStates']).features)
                    .enter().append('path')
                    .attr('d', path)
                    .attr('class', 'svg-state')
                    .style('fill', svgStyles.initial)
                    .each(function(d) {

                        // set up state so we can manipulate it
                        const header = d3.select(this);
                        const abbr = d['properties'].STATE_ABBR

                        // add an ID attr
                        header.attr('id',abbr)
                            .attr('data-state',abbr);
                        
                        // handle small state icons and/or DC if necessary
                        if( showDC && abbr === 'DC'){
                            const icon = d['properties'].ICON;
                            g.append('rect')
                                .attr('id', 'rect-' + abbr)
                                .attr('x', icon.rect.x)
                                .attr('y', icon.rect.y)
                                .attr('width', icon.rect.w)
                                .attr('height', icon.rect.h)
                                .attr('class', 'svg-state small-state-icon ' + abbr)
                                .attr('data-state',abbr)
                                .style('fill', svgStyles.initial)
                                .on('click', () => {
                                    stateClicked(d)
                                });
                                
                            g.append('text')
                                .attr('id', 'text-' + abbr)
                                .attr('x', icon.text.x)
                                .attr('y', icon.text.y)
                                .attr('class', 'svg-state small-state-icon ' + abbr)
                                .text(abbr)
                                .attr('data-state',abbr)
                                .style('fill', svgStyles.borders)
                                .on('click', () => 
                                    stateClicked(d)
                                );
                                
                        }
                        if(showSmallStateIcons && smallStates.indexOf(abbr) !== -1){
                            const icon = d['properties'].ICON;
                            g.append('rect')
                                .attr('id', 'rect-' + abbr)
                                .attr('x', icon.rect.x)
                                .attr('y', icon.rect.y)
                                .attr('width', icon.rect.w)
                                .attr('height', icon.rect.h)
                                .attr('class', 'svg-state small-state-icon ' + abbr)
                                .attr('data-state',abbr)
                                .style('fill', svgStyles.initial)
                                .on('click', () => {
                                    stateClicked(d)
                                })
                                
                            g.append('text')
                                .attr('id', 'text-' + abbr)
                                .attr('x', icon.text.x)
                                .attr('y', icon.text.y)
                                .attr('class', 'svg-state small-state-icon ' + abbr)
                                .attr('data-state',abbr)
                                .text(abbr)
                                .style('fill', svgStyles.borders)
                                .on('click', () => {
                                    stateClicked(d)
                                })
                                
                        }
                        
                    })
                    .on('click', this.stateClicked)
                    .on("mouseover", function(d){
                        const stateSVG = document.getElementById(d.properties.STATE_ABBR);
                        if(stateSVG.classList.contains('active')){
                            return;
                        }
                        d3.select(this).style('fill', svgStyles.hover);
                    })
                    .on("mouseout", function(d){
                        const stateSVG = document.getElementById(d.properties.STATE_ABBR);
                        if(stateSVG.classList.contains('active')){
                            return;
                        }
                        d3.select(this).style('fill', svgStyles.initial);
                    });

                /* Add state outlines */
                g.append('path')
                    .datum(topojson.mesh(states_json, states_json.objects['usStates'], function(a, b) { return a !== b; }))
                    .attr('id', 'state-borders')
                    .attr('d', path)
                    .attr('stroke',svgStyles.borders);

                this.mapLoading = false;

            },

            // process the styles for use in the components
            setStyles: function(d){
                // console.log('set style',data);
            },

            // When a state is clicked, display relevant information in the lower boxes
            stateClicked: function(d) {
                if(typeof(d) !== 'undefined'){
                    // console.log('d',d);
                }
                        
                const abbr = d['properties'].STATE_ABBR;
                const name = d['properties'].STATE_NAME;
                const elem = document.getElementById(d['properties'].STATE_ABBR);
                const state = {
                    id: abbr,
                    properties: d,
                    data: [],
                    is_csv: this.isCSV
                };

                // set the active state
                this.setActiveState(elem);

                // add the stats to the state object
                for(let i = 0; i < this.stateData.length; i++){
                    if(this.stateData[i].state === name || this.stateData[i].state === abbr){
                        state.data = this.stateData[i].state_meta;
                        break;
                    }
                }
                this.selectedState = state;

            },

            // remove the 'active' class from svg elements
            deactivateStates: function(){
                const abbr = this.selectedState.id;
                const stateSVG = document.getElementById(abbr);
                const stateRect = document.getElementById('rect-' + abbr);
                const stateText = document.getElementById('text-' + abbr);

                // deactivate state path
                stateSVG.classList.remove('active');
                stateSVG.style.fill = this.mapStyle.initial;

                // check the icons
                if((this.showDC && abbr === 'DC')){
                    stateRect.classList.remove('active');
                    stateText.classList.remove('active');
                    stateRect.style.fill = this.mapStyle.initial;
                }
                if((this.showSmallStateIcons && this.smallStates.indexOf(abbr) !== -1 )){
                    stateRect.classList.remove('active');
                    stateText.classList.remove('active');
                    stateRect.style.fill = this.mapStyle.initial;
                }


            },

            // add the 'active' class to the right svg element
            setActiveState: function(elem){

                const abbr = elem.getAttribute('data-state');
                const stateSVG = document.getElementById(abbr);
                const stateRect = document.getElementById('rect-' + abbr);
                const stateText = document.getElementById('text-' + abbr);

                if(this.selectedState){
                    this.deactivateStates();
                }
        
                // add the active class
                stateSVG.classList.add('active');
                stateSVG.style.fill = this.mapStyle.clicked;

                // add the active class to the icons too (DC)
                if((this.showDC && abbr === 'DC')){
                    stateRect.classList.add('active')
                    stateRect.style.fill = this.mapStyle.clicked;
                    stateText.classList.add('active');
                }
                // add the active class to the icons too (other small states)
                if((this.showSmallStateIcons && this.smallStates.indexOf(abbr) !== -1 )){
                    stateRect.classList.add('active');
                    stateRect.style.fill = this.mapStyle.clicked;
                    stateText.classList.add('active');
                }
            }

        }
    };
</script>
<template>
    <div :id="'rr-us-map-' + mapID" class="rr-us-map">
        <div v-if="mapLoading" class="loader">
            <div class="map-init">
                <span>Loading map data... <i class="fa fa-sync"></i></span>
            </div>
        </div>
        <div class="map-wrapper">
            <div id="data-box" class="col-md-5">
                <MapWindowMain
                    v-if="selectedState"
                    :styles="windowStyle"
                    :state="selectedState"
                />
                <div v-else class="data-preview map-init">
                    <span>{{windowStyle.placeholderHeading}}</span>
                </div>
            </div>
            <div class='col-md-7 hidden-xs visible-sm visible-md visible-lg'>
                <div class='map-container'>
                    <div id='map'></div>
                </div>
            </div>
            <div v-if="stateData.length > 0">
                <MobileViewer
                    :states="stateData"
                />
            </div>
        </div>
    </div>
</template>
<style>
</style>