<script>
    import MapWindowItem from './MapWindowItem';

    export default {
        props: {
            styles: Object,
            state: Object,
            title: String
        },
        
        components: {
            MapWindowItem
        },

        methods: {
            getTitle: function(){
                if(this.state.properties){
                    return this.state.properties.properties.STATE_NAME;
                }
                return '';
            },
        }
    };
</script>
<template>
    <div>
        <h2 class='state-name'>{{getTitle()}}</h2>
        <div class='data-info row'>
            <MapWindowItem
                v-for="(item,i) in state.data"
                class="col-xs-12 col-sm-6 col-md-6 col-lg-6"
                :key="'data-' + i"
                :state="item" />
        </div>
    </div>
</template>