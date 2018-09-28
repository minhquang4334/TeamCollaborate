<template>
    <div class="container-fluid page-body-wrapper">
        <div class="row row-offcanvas row-offcanvas-right">
            <left-bar/>

            <div class="content-wrapper">
            </div>
        </div>
        <!-- row-offcanvas ends -->

    </div>
</template>
<script>
    import leftBar from "./leftBar.vue"
    import footer from "./footer.vue"
    export default {
        components:{
            leftBar,
            footer
        }
    }
</script>
