<template>
    <div class="container d-flex h-100">
        <div class="row align-self-center w-100">
            <div class="col-9 mx-auto my-3">
                <div class="jumbotron">
                    <h2>Create a channel</h2>
                    <div class="text-muted mb-2">Channels are where your members communicate.
                        They're best when organized around a topic - #leads, for example</div>
                    <form>
                        <div class="form-group can-toggle demo-rebrand-2">
                            <input
                                id="ispublic"
                                type="checkbox"
                                v-model="type"
                                true-value="public"
                                false-value="private"
                            >
                            <label for="ispublic">
                                <div class="can-toggle__switch" data-checked="public" data-unchecked="private"></div>
                            </label>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input id="name" class="form-control" v-model="name" type="text" name="name" placeholder="# e.g leads">
                            <small class="form-text text-muted">Names must be lowercase, without spaces or periods, and shoter than 22 characters</small>
                        </div>
                        <div class="form-group">
                            <label>Purpose <span class="text-muted">(optional)</span></label>
                            <input id="purpose" class="form-control" v-model="purpose" type="text" name="purpose">
                            <small id="purposeHelp" class="form-text text-muted">What's channle about?</small>
                        </div>
                        <div class="form-group">
                            <label>Send invites to: <span class="text-muted">(optional)</span></label>
                            <multiselect v-model="invite_users"
                                         placeholder="Search username"
                                         label="name"
                                         track-by="id"
                                         :options="users"
                                         :hide-selected="true"
                                         open-direction="bottom"
                                         :internal-search="false"
                                         :searchable="true"
                                         :multiple="true"
                                         @search-change="findUsers"
                            />
                            <template slot="tag" slot-scope="{ option, remove }"><span class="custom__tag"><span>{{ option.name }}</span><span class="custom__remove" @click="remove(option)">❌</span></span></template>
                            <template slot="clear" slot-scope="props">
                                <div class="multiselect__clear" v-if="invite_users.length" @mousedown.prevent.stop="clearAll(props.search)"></div>
                            </template>

                            <small class="form-text text-muted">Select up to 1000 people to add this channel</small>
                        </div>
                        <button type="submit" @click.prevent="submit" class="btn btn-primary">Submit</button>
                    </form>
                    <div class="card-body cs-pointer text-info" @click="toHome">
                        <i class="fa fa-backward "></i> Back
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import {get, post} from '../../../helper/request'
    export default {
      name: 'CreateChannel',

      data() {
        return {
          type: 0,
          purpose: "",
          invites: [],
          name: "",
          submmit: false,
          users: [],
          invite_users: [],
        }
      },

      created() {
      },

      methods: {
        toHome() {
          this.$router.push({
            name: "homeIndex"
          })
        },

        submit() {
          let url = '/api/channel/create';
          let invited_users = [];
          this.invite_users.forEach((data) => {
            invited_users.push(data.id);
          });
          console.log("invited_users: ", invited_users);
          let payload = {
            type : this.type === "public" ? 0 : 1,
            purpose : this.purpose,
            name: this.name,
            invited_users: invited_users,
          }
          post(url, payload).then(({data}) => {
            this.$router.push({
              name: "ChannelDetail",
              params: {
                id: data.data.channel_id,
              }
            })
          })
        },

        findUsers(query) {
          if(query) {
            let url = '/api/user/list' + '?search_name=' + query;
            get(url).then(({data}) => {
              console.log(data)
              this.users = data.data;
            }).catch((err) => {

            })
          } else {
            this.users = [];
          }
        },

        clearAll () {
          this.invite_users = [];
        }
      }
    }
</script>
