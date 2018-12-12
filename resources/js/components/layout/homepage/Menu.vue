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
      }
    },


    created() {
      this.getListChannel();
    },

    computed: {},

    methods: {
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

      toChannelDetail(channel) {
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
      }


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
</style>
