<template>
    <div class="col-10 col-md-6 m-auto h-100 text-center">
        <div class="row h-50 justify-content-center align-items-center">
            <div class="w-100">
                <h2 class="text-center mb-5">Direct Message</h2>
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
                        <template slot="tag" slot-scope="{ option, remove }"><span class="custom__tag"><span>{{ option.name }}</span><span class="custom__remove" @click="remove(option)">❌</span></span></template>
                        <template slot="clear" slot-scope="props">
                            <div class="multiselect__clear" v-if="selected.length" @mousedown.prevent.stop="clearAll(props.search)"></div>
                        </template>
                    </div>
                    <div class="col-1 px-0">
                        <button type="button" class="btn btn-success h-100 margin-left-10" @click="goToDirectMess">Go to</button>
                    </div>
                </div>
                <p class="text-muted">
                    entry name or email of user! press enter to add selection or
                    <router-link :to="{name: 'homeIndex'}">Back</router-link>
                </p>
            </div>
        </div>
    </div>
</template>

<script>
  import {get, post} from '../../../helper/request'
  export default {
    components: {
    },
    data() {
      return {
        currentUser: this.$store.state.auth.user,

        options: [

        ],

        selected: [],

        isLoading: false
      }
    },
    methods: {
      asyncFind (query) {
        if(query) {
          this.isLoading = true;
          let url = '/api/user/list?search_name=' + query
          get(url).then((response) => {
            this.options = response.data.data.filter((user) => {
              return user.id !== this.currentUser.id;
            })
            this.isLoading = false
          })
        }
      },

      clearAll () {
        this.selected = []
      },

      goToDirectMess() {
        if(!this.selected.length) {
          this.$message({
            type: 'error',
            message: 'Please select user for direct message'
          })
        } else {
          let type = 2;
          let invited_users = [];
          this.selected.forEach(user => {
            invited_users.push(user.id);
          })
          let name = this.selected.reduce((a, b) => {
            return a + b.name + ', ';
          }, '');
          name = name.substring(0, name.length - 2);
          let payload = {
            type : type,
            purpose: 'Direct Messages between ' + name,
            description: '',
            name: name,
            invited_users: invited_users
          }
          let url = '/api/channel/create'
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
