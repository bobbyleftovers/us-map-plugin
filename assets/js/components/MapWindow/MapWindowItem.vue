<script>
    export default {
        props: {
            state: Object
        },

        data() {
            return {}
        }
    }
</script>
<template>
    <span class='data-single'>
        <div class='data-field'>{{state.array_item_label}}</div>
        <a :href="state.state_download" v-if="state.is_download" class="data-value" target="_blank">{{state.array_item_data}} <i class="fa fa-download"></i></a>
        <div class='data-value' v-if="!state.is_download">{{state.array_item_data}}</div>
    </span>
</template>