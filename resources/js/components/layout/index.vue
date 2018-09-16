<template>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <header/>
        <container/>
        <!-- page-body-wrapper ends -->
    </div>
</template>
<script>
    import header from "header.vue"
    import container from "container.vue"
    export default {
        comments:{
            header,
            container
        }
    }
</script>