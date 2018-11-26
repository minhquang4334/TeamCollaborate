<template>
    <div class="container-fluid h-100">
        <div class="row h-100">
            <leftBar/>
            <div class="col-md-10 p-0">
                <headBar/>
                <container/>
            </div>
        </div>

        <invite/>

    </div>

</template>
<script>
    import headBar from "./Header.vue"
    import container from "./Container.vue"
    import leftBar from "./LeftBar.vue"
    import invite from "./InVite.vue"
    export default {
        components:{
            leftBar,
            headBar,
            container,
            invite
        }
    }
</script>
