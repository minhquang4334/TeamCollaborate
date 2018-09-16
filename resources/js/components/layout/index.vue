<template>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <header/>
        <container/>
        <!-- page-body-wrapper ends -->
    </div>
</template>
<script>
    import header from "./Header.vue"
    import container from "./Container.vue"
    export default {
        comments:{
            header,
            container
        }
    }
</script>