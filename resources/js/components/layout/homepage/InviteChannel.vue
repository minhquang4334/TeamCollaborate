<template>
    <div class="col-10 col-md-6 m-auto h-100 text-center">
        <div class="row h-50 justify-content-center align-items-center">
            <div class="w-100">
                <h2 class="text-center mb-5">Invite to <strong class="">{{channel.name}}</strong></h2>
                <div class="w-100 row">
                    <div class="col-11 p-0">
                        <multiselect
                                v-model="selected"
                                tag-placeholder="Add this as new user"
                                placeholder="Search or add a user"
                                label="name"
                                :options="options"
                                :multiple="true"
                                open-direction="bottom"
                                :searchable="true"
                                :loading="isLoading"
                                :internal-search="false"
                                :clear-on-select="true"
                                :close-on-select="true"
                                track-by="id"
                                :show-no-results="false"
                                :hide-selected="true"
                                title="name"
                                :max-height="600"
                                @search-change="asyncFind"
                                :options-limit="10"
                        />
                        <template slot="tag" slot-scope="{ option, remove }"><span class="custom__tag"><span>{{ option.name }}</span><span
                                class="custom__remove" @click="remove(option)">❌</span></span></template>
                        <template slot="clear" slot-scope="props">
                            <div class="multiselect__clear" v-if="selected.length"
                                 @mousedown.prevent.stop="clearAll(props.search)"></div>
                        </template>
                    </div>
                    <div class="col-1 px-0">
                        <button type="button"
                                @click.prevent="invite"
                                class="btn h-100"
                                :class="selected.length ? `btn-success` : `btn-secondary`"
                        >
                            Send Invite
                        </button>
                    </div>
                </div>
                <p class="text-muted">
                    Recent conversations or
                    <router-link :to="{name: 'ChannelDetail', params: {id: channel_id}}">Back</router-link>
                </p>
            </div>
        </div>
    </div>
</template>

<script>
  import Multiselect from 'vue-multiselect'
  import {get, post} from '../../../helper/request'
  export default {
    components: {
      Multiselect
    },
    data() {
      return {
        selected: [],
        options: [],
        isLoading: false,
        channel: {},
        userInChannel: [],
        currentUser: this.$store.state.auth.user,
        channel_id: this.$route.params.channel_id ? this.$route.params.channel_id : 0
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
          this.userInChannel = this.channel.users.data;
        }).catch((err) => {
          this.$message({
            type: 'error',
            message: 'Something error: ', err
          })
          console.log(err);
        })
      },

      checkUserInChannel(user) {
        return this.userInChannel.filter((u) => u.id === user.id).length === 0;
      },

      asyncFind (query) {
        if(query) {
          this.isLoading = true;
          let url = '/api/user/list?search_name=' + query
          get(url).then((response) => {
            this.options = response.data.data.filter((user) => this.checkUserInChannel(user))
            this.isLoading = false
          })
        }
      },

      clearAll () {
        this.selected = []
      },

      invite() {
        if(!this.selected.length) {
          this.$message({
            type: 'error',
            message: 'Please select user for invite'
          })
        } else {
          let invited_users = [];
          this.selected.forEach(user => {
            invited_users.push(user.id);
          })
          let payload = {
            channel_id: this.channel_id,
            invited_users: invited_users
          }
          let url = '/api/channel/invite'
          post(url, payload).then((res) => {
            console.log('res: ', res);
            if(res.data.data) {
              this.$router.push({
                name: 'ChannelDetail',
                params: {
                  id: res.data.data.channel_id
                }
              })
            }
          }).catch((err) => {
            console.log('err: ', err);
            this.$message({
              type: 'error',
              message: 'Something error: ', err
            })
          })
        }
      }
    }
  }
</script>
