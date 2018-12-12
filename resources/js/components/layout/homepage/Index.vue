<template>
    <div class="container-fluid h-100">
        <div class="row h-100 ">
            <leftBar :channel_id="channel_id"/>
            <div class="col-md-10 p-0">
                <headBar :channel="channel"  @showAboutChannel="showAboutChannel"/>
                <container :channel="channel" :isAboutChannel="isAboutChannel" @showComment="showComment"/>
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
  import {get} from "../../../helper/request"

  export default {
    data() {
      return {
        channel_id: (this.$route.params.id) ? this.$route.params.id : 0,
        channel: {},
        isAboutChannel: true,
      }
    },

    components: {
      leftBar,
      headBar,
      container,
      inviteModal
    },

    watch: {
     '$route.params.id' : function() {
       this.channel_id = this.$route.params.id ? this.$route.params.id : 0;
       this.getChannelDetail();
     }
    },

    created() {
      this.getChannelDetail();
    },

    methods: {
      getChannelDetail() {
          let url = '/api/channel/info?id=' + this.channel_id;
          get(url).then(res => {
            this.channel = res.data.data;
          }).catch((err) => {
            console.log(err);
          })
      },

      showAboutChannel(){
          this.isAboutChannel = true;
      },

      showComment(){
          this.isAboutChannel = false;
      }
    }


  }
</script>
