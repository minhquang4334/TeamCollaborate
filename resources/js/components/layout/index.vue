<template>
    <div class="container-scroller">
        <headBar/>
        <container/>
    </div>
</template>
<script>
    import headBar from "./header.vue"
    import container from "./container.vue"
    export default {
        components:{
            headBar,
            container
        }
    }
</script>
