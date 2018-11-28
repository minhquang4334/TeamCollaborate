<template>
    <div class="container-fluid h-100">
        <div class="row h-100">
            <leftBar/>
            <div class="col-md-10 p-0">
                <headBar/>
                <container/>
            </div>
        </div>

        <inviteModal/>

    </div>

</template>
<script>
    import headBar from "./Header.vue"
    import container from "./Container.vue"
    import leftBar from "./LeftBar.vue"
    import inviteModal from "./InviteModal.vue"
    export default {
        components:{
            leftBar,
            headBar,
            container,
            inviteModal
        }
    }
</script>
