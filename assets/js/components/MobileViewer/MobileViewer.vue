<template>
    <div class="visible-xs hidden-sm hidden-md hidden-lg col-xs-12">
        <div v-for="(state) in states" v-bind:key="state.state">
            <MobileViewPanel :state="state" />
        </div>
    </div>
</template>
<script>
    import Vue from 'vue';
    import MobileViewPanel from './MobileViewPanel';
    export default {
        beforeMount(){
            for(let i = 0; i < this.states.length; i++){
                this.states[i]['id'] = this.states[i]['state'].toLowerCase().replace(/\s/g, '-');
            }
        },
        components:{
            MobileViewPanel
        },
        props:{
            states: {
                type:Array,
                required:true
            }
        }
    }
</script>