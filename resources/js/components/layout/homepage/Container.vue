<template>
    <div class="container-fluid page-body-wrapper">
        <div class="row row-offcanvas row-offcanvas-right">
            <left-bar/>

            <div class="content-wrapper">
                <div class="row h-100">
                    <div class="col-8 border-right  h-100">
                        <messagelist/>
                        <newmessage/>
                    </div>
                    <div class="col-4 h-100" id="right-content">
                        <aboutchannel/>
                    </div>
                </div>
            </div>
        </div>
        <!-- row-offcanvas ends -->

    </div>
</template>
<script>
    import leftBar from "./LeftBar.vue"
    import newmessage from "./NewMessage.vue"
    import messagelist from "./MessageList.vue"
    import aboutchannel from "./AboutChannel.vue"
    export default {
        components:{
            leftBar,
            newmessage,
            messagelist,
            aboutchannel
        }
    }
</script>
