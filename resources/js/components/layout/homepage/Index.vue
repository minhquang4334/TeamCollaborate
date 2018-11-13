<template>
    <div class="container-scroller">
        <headBar/>
        <container/>
    </div>
</template>
<script>
    import headBar from "./Header.vue"
    import container from "./Container.vue"
    export default {
        components:{
            headBar,
            container
        }
    }
</script>
