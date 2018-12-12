<template>

    <nav class="navbar navbar-expand-md bg-light navbar-light h-10">
        <!-- Brand -->
        <div class="navbar-brand ml-3">
            <strong id="Channelname" v-if="inChannel">{{channel.name}}</strong>
            <strong v-else>Home</strong>
            <small><span class="far fa-user mx-2"></span><span id="member-number">{{numberMemberInChannel}}</span></small>

            <span class="mx-3 dropdown" data-toggle="collapse" data-target="#settingDropdown">
                <a style="cursor: pointer" data-toggle="dropdown">
                    <span class="fas fa-cogs"></span>
                </a>
                <div id="settingDropdown" class="dropdown-menu navbar-dropdown preview-list  dropdownAnimation" aria-labelledby="notificationDropdown">
                <a class="dropdown-item" @click.prevent="showAboutChannel">
                    <p>
                        <span class="fas fa-info-circle mr-2"></span>
                        Channel About
                    </p>
                </a>
                <a class="dropdown-item">
                    <p>
                        <span class="fas fa-bell mr-2"></span>
                        Notification
                    </p>
                </a>
                <a class="dropdown-item" data-toggle="modal" data-target="#inviteModal">
                    <p>
                        <span class="fas fa-hand-holding-heart mr-2"></span>
                        Invite
                    </p>
                </a>
                <a class="dropdown-item">
                    <p>
                        <span class="fas fa-sign-out-alt mr-2"></span>
                        Leave Channel
                    </p>
                </a>
                <a class="dropdown-item" v-show="currentUser.id === channel.creator" data-toggle="modal" data-target="#deleteChannel">
                    <p>
                        <span class="fas fa-trash-alt mr-2"></span>
                        Delete Channel
                    </p>
                </a>

            </div>
            </span>
            <span class="dropdown d-md-none" data-toggle="collapse" data-target="#preferencesDropdown">
                    <a style="cursor: pointer" data-toggle="dropdown">
                        <img :src="userAvatar" class="rounded-circle" style="width: 50px;height:50px" alt="profile-img">
                        <span class="online-status online bg-success"></span>
                        <strong class="ml-3">{{currentUser.name}}</strong>
                    </a>
                    <div id="preferencesDropdown" class="dropdown-menu navbar-dropdown preview-list  dropdownAnimation">
                        <a class="dropdown-item" @click="preferences()">
                            <p>
                                <span class="fas fa-user-circle mr-2"></span>
                                Preferences
                            </p>
                        </a>
                        <a class="dropdown-item" @click="logout()">
                            <p>
                                <span class="fas fa-sign-out-alt mr-2"></span>
                                Logout
                            </p>
                        </a>

                    </div>
                </span>

        </div>

        <!-- Toggler/collapsibe Button -->
        <button class="navbar-toggler mr-3" type="button" data-toggle="collapse" data-target="#navbarSupportedConten">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="navbarSupportedConten">


            <menu-list :channel_id="channel_id" :isVertical="isVertical"/>

            <form class="form-inline p-3 searchForm" action="/action_page.php">
                <input class="form-control" type="text" placeholder="Search">
            </form>
            <span class="dropdown ml-auto margin-right-35 d-none d-md-block" data-toggle="collapse" data-target="#preferencesDropdown2">
                <a style="cursor: pointer" data-toggle="dropdown">
                    <img :src="userAvatar" class="rounded-circle" style="width: 50px;height:50px" alt="profile-img">
                    <span class="online-status online bg-success"></span>
                    <strong class="ml-3" style="font-size: 18px">{{currentUser.name}}</strong>
                </a>

                <div id="preferencesDropdown2" class="dropdown-menu navbar-dropdown preview-list  dropdownAnimation">
                    <a class="dropdown-item" @click="preferences()">
                        <p>
                            <span class="fas fa-user-circle mr-2"></span>
                            Preferences
                        </p>
                    </a>
                    <a class="dropdown-item" @click="logout()">
                        <p>
                            <span class="fas fa-sign-out-alt mr-2"></span>
                            Logout
                        </p>
                    </a>

                </div>
            </span>
        </div>
        <div class="modal fade" id="deleteChannel" ref="deleteChannel">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Are you want delete this channel?
                        </h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" @click.prevent="deleteChannel">Delete</button>

                    </div>

                </div>
            </div>
        </div>
    </nav>
</template>
<script>
  import {get, del} from '../../../helper/request.js'
  import menuList from "./Menu.vue"


  export default {
    props: ['channel'],

    data() {
      return {
        currentUser: this.$store.state.auth.user,
        isVertical: false,
        channel_id: this.$route.params.id ? this.$route.params.id : 0,
      }
    },



    computed: {
      inChannel: function() {
        return this.channel.channel_id;
      },

      numberMemberInChannel: function() {
        if(this.inChannel) {
          return this.channel.users.data.length;
        }
        return 0;
      },

      userAvatar: function() {
        if(!this.currentUser.avatar) {
          this.currentUser.avatar = '/images/default-avatar.png'
        }
        return this.currentUser.avatar;
      }
    },

      components:{
          menuList
      },

    methods: {
      logout: function () {
        this.$store.dispatch('auth/logout')
          .then(() => {
            this.$router.push({ name: 'login' });
          });
      },

      preferences: function () {
        this.$router.push({ name: 'preferences' });
      },

      newchannel: function () {
        this.$router.push({ name: 'channel' });
      },

      showAboutChannel: function () {
          this.$emit('showAboutChannel');
      },

      deleteChannel() {
        if(this.channel.name !== 'General') {
          let url = '/api/channel/destroy?id=' + this.channel.channel_id;
          del(url).then(res => {
            console.log('res: ', res);
            this.$message({
              type: 'success',
              message: 'Delete Channel ' + this.channel.name + ' success!!'
            })
            this.$router.push({
              name: 'homeIndex'
            })
          })
        } else {
          this.$message({
            type: 'error',
            message: 'You cant delete this channel!!'
          })
        }
        $('#deleteChannel').modal('toggle');
      }

    },
  }
</script>
