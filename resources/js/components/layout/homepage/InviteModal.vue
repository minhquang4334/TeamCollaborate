<template>
    <div class="modal fade" id="inviteModal" ref="inviteModals">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">
                        Anyone you invite will be able to see all of the channel's contents
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="d-flex flex-row">
                        <div class="p-2 bd-highlight">
                            <input type="radio" value="toChannel" v-model="inviteSelect">
                        </div>
                        <div class="p-2 bd-highlight">
                            <strong>Invite to this channel</strong>
                            <p>Add new members to the existing channel</p>
                        </div>
                    </div>
                    <div class="d-flex flex-row">
                        <div class="p-2 bd-highlight">
                            <input type="radio" value="toApp" v-model="inviteSelect">
                        </div>
                        <div class="p-2 bd-highlight">
                            <strong>Invite to this app</strong>
                            <p>Add new members to this application</p>
                        </div>
                    </div>

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click.prevent="nextStep">Next <i
                            class="fas fa-arrow-right"></i></button>

                </div>

            </div>
        </div>
    </div>
</template>

<script>
  export default {
    data() {
      return {
        inviteSelect: 'toChannel',
        channel_id: this.$route.params.id ? this.$route.params.id : 0
      }
    },

    components: {},

    methods: {
      nextStep() {
        if (this.inviteSelect === "toChannel") {
          this.$router.push({name: 'inviteToChannel', params: {
            channel_id: this.channel_id
            }});
        }
        else {
          this.$router.push({name: 'inviteToApp'});
        }
        $("#inviteModal").modal('hide');
      }
    }
  }

</script>
