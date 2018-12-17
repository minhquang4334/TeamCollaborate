<template>
    <ul v-bind:class="isVertical?'flex-column nav':'d-md-none navbar-nav'">
        <li class="nav-item nav-category">
            <a class="nav-link" style="cursor:pointer" @click="newchannel">CHANNELS<span
                    class="fas fa-plus-circle float-right"></span></a>
        </li>
        <li class="nav-item cursor-pointer"
            :class="activeChannel(channel) ? 'active' : ''"
            v-for="(channel, index) in listChannels"
            :key="channel.channel_id + index"
            @click="toChannelDetail(channel)">
            <span class="nav-link">
                <span v-bind:class="channelIconClass(channel.type)"></span>
                <span class="menu-title">{{ channel.name}}</span>
            </span>
        </li>
        <li class="nav-item nav-category">
            <a class="nav-link" style="cursor:pointer" @click="directMessage">DIRECT MESSAGE<span
                    class="fas fa-plus-circle float-right"></span></a>
        </li>
        <li class="nav-item cursor-pointer"
            :class="activeChannel(channel) ? 'active' : ''"
            v-for="(channel, index) in listDirectMessages"
            :key="channel.channel_id + index"
            @click="toChannelDetail(channel)"
        >
            <span class="nav-link">
                <span class="menu-title">
                    <span class="fas fa-user mr-2"></span>
                    {{channel.name}}
                </span>
            </span>
        </li>
        <li class="nav-item nav-category">
            <a class="nav-link" style="cursor:pointer" @click="inviteToApp">Invite To App<span
                    class="fas fa-plus-circle float-right"></span></a>
        </li>
    </ul>
</template>
<script>
  import {get} from "../../../helper/request"

  export default {
    props: [
      'channel_id',
      'isVertical'
    ],
    data() {
      return {
        listChannels: [],
        listDirectMessages: [],
        listDirectUsers: [],
        EchoChannelAddress: 'channel.' + (this.$route.params.id ? this.$route.params.id : 'ASTEAMK60'),

      }
    },

    watch: {
      '$route.params.id': function() {
        this.EchoChannelAddress = 'channel.' + (this.$route.params.id ? this.$route.params.id : 'ASTEAMK60');
        this.subscribeToEcho();
      }
    },


    created() {
      this.$eventHub.$on('leaveChannel', this.leaveChannel);
      this.$eventHub.$on('deleteChannel', this.leaveChannel);
      this.$eventHub.$on('newDirectMessage', this.newChannel);
      this.getListChannel();
      this.subscribeToEcho();
    },

    beforeDestroy() {
      this.$eventHub.$off('leaveChannel', this.leaveChannel);
      this.$eventHub.$off('newDirectMessage', this.newChannel);
      this.$eventHub.$off('deleteChannel', this.leaveChannel);
    },

    computed: {},

    methods: {
      inviteToApp() {
        this.$router.push({name: 'inviteToApp'});
      },

      subscribeToEcho() {
        Echo.private('channel.ASTEAMK60')
          .listen('.InvitedToChannel', (e) => {
            let channel = e.data.data;
            this.pushChannel(channel);
          })
          .listen('.ChannelWasDeleted', (e) => {
          console.log('adsadss: ', e.data)
          let channelId = e.data
          this.leaveChannel(channelId);
        })

      },

      channelIconClass: function (type) {
        return type === 0 ? "fab fa-slack-hash text-light" : "fas fa-lock text-light";
      },

      newchannel: function () {
        this.$router.push({name: 'channel'});
      },

      directMessage: function () {
        this.$router.push({name: 'derectMessage'});
      },

      getListChannel() {
        let url = '/api/channel/my'
        get(url).then(({data}) => {
          console.log(data);
          this.listChannels = data.data.filter((channel) => {
            return channel.type !== 2;
          });
          this.listDirectMessages = data.data.filter((channel) => {
            return channel.type === 2;
          });
        }).catch(err => {
          console.log(err);
        })
      },

      getListDirectMessage() {

      },

      newChannel(channel) {
        if(channel.type === 2) {
          if(this.listDirectMessages.filter((c) => c.id === channel.id).length === 0) {
            this.listDirectMessages.unshift(channel);
          }
        } else {
          if(this.listChannels.filter((c) => c.id === channel.id).length === 0) {
            this.listChannels.unshift(channel);
          }
        }
      },

      toChannelDetail(channel) {
          $("#rightElement").css("z-index","-1");
        if(channel.name === 'General') {
          this.$router.push({
            name: 'homeIndex',
          })
        }
        else {
          this.$router.push({
            name: 'ChannelDetail',
            params: {
              id: channel.channel_id
            }
          })
        }
      },

      activeChannel(channel) {
        if ((channel.name === 'General') && !this.channel_id)
          return true;
        return this.channel_id === channel.channel_id;
      },

      leaveChannel(channel_id) {
        let leave;
        this.listChannels.forEach((c) => {
          if (c.channel_id === channel_id) {
            leave = c;
          }
        })
        let index = this.listChannels.indexOf(leave);
        if (index > -1) {
          this.listChannels.splice(index, 1);
        } else {
          this.listDirectMessages.forEach((c) => {
            if (c.channel_id === channel_id) {
              leave = c;
            }
          })
          let index = this.listDirectMessages.indexOf(leave);
          if (index > -1) {
            this.listDirectMessages.splice(index, 1);
          }
        }
      },

      pushChannel(channel) {
        let currentUserId = this.$store.state.auth.user.id;
        if(channel.users.data.filter((u) => u.id == currentUserId).length) {
          if (channel.type === 2) {
            if (!this.listDirectMessages.filter((m) => m.id == channel.id).length) {
              this.listDirectMessages.push(channel);
              this.message({
                type: 'success',
                message: 'You were invited to ' + channel.name
              })
            }
          } else {
            if (!this.listChannels.filter((m) => m.id == channel.id).length) {
              this.listChannels.push(channel);
            }
          }
        }
      },


    },
  }
</script>
<style scoped>
    .title {
        font-weight: bold;
        color: #fff;
    }

    .nav-menu {
        max-height: 400px;
        overflow: auto;
    }

    .fa-plus-circle {
        padding: 3px;
    }
</style>
