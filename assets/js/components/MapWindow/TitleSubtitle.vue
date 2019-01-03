<template>
    <div>
        <h2 class='state-name'>{{this.title}}</h2>
    </div>
</template>

<script>
    export default {
        props: {
            title: String,
            subtitle: String
        },
        data(){
            return{
                isOpen:false
            }
        }
    }
</script>