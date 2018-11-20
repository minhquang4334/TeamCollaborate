<template>
    <div class="row p-3 h-90">
        <div class="col-md-8 h-100 border-right">
            <messagelist/>
            <newmessage/>
        </div>
        <div class="col-md-4 h-100 d-none d-md-block">
            <aboutchannel/>
            <newmessage/>
        </div>
    </div>
</template>
<script>
    import newmessage from "./NewMessage.vue"
    import messagelist from "./MessageList.vue"
    import aboutchannel from "./AboutChannel.vue"
    import thread from "./Thread.vue"
    export default {
        components:{
            newmessage,
            messagelist,
            aboutchannel,
            thread
        }
    }
</script>
