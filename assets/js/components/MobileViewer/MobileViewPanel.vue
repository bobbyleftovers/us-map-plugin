<template>
    <div>
        <b-btn @click="showCollapse = !showCollapse"
            :class="showCollapse ? 'collapsed test' : 'test'"
            :aria-controls="state.id"
            :aria-expanded="showCollapse ? 'true' : 'false'">
        {{state.state}}
        </b-btn>
        <b-collapse class="mt-2" v-model="showCollapse" :id="state.id">
            <b-card>
                <MapWindowItem v-for="(state,i) in state.state_meta" v-bind:key="'state-panel-' + i" :state="state" />
            </b-card>
        </b-collapse>
    </div>
</template>
<script>
    import MapWindowItem from '../MapWindow/MapWindowItem';

    export default {
        props:{
            state: {
                type:Array,
                required:true
            }
        },
        
        components: {
            MapWindowItem
        },

        data(){
            return{
                showCollapse: false
            }
        }
    }
</script>