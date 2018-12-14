<template>
    <div>
        <div class="col-10 col-md-6 mx-auto mt-5 border-bottom pb-3 overflow-hidden" v-show="!isSent">
            <h2 class="text-center">Invite member to <strong class="appName">App</strong></h2>
            <div class="inviteForm my-2">
                <div class="row formTitle mb-3">
                    <div class="col-6"><strong>Email Address</strong></div>
                    <div class="col-5"><strong>Fullname (option)</strong></div>
                </div>
                <div class="formElement row" v-for="(user, index) in invite_users" :key="index">
                    <div class="col-6 p-0">
                        <input type="email" v-model="user.email" class="form-control" placeholder="email@example.com">
                    </div>
                    <div class="col-5 p-0">
                        <input type="text" v-model="user.name" class="form-control" placeholder="Optional">
                    </div>
                    <div class="col-1 p-0">
                        <span class="fas fa-times btn-lg" @click.prevent="destroyElement(index)"></span>
                    </div>
                </div>

            </div>
            <a href="" @click.prevent="addMore"> <i class="fas fa-plus-circle mr-2"></i>Add another</a>
            <p></p>
            <div class="col-11 overflow-hidden p-0 ">
                <span slot="footer" class="dialog-footer float-right">
                    <el-button type="text" size="medium" class="margin-right-1" @click.prevent="close">
                        Cancel
                    </el-button>
                    <el-button round type="success" size="medium" @click="sendInvite">
                        Submit
                    </el-button>
                </span>
            </div>
        </div>
        <div class="col-10 col-md-6 mx-auto mt-5 border-bottom pb-3 overflow-hidden" v-if="isSent">
            <h2 class="text-center">List of sendted invite member to <strong class="appName">App</strong></h2>
            <div class="inviteForm my-2">
                <div class="row formTitle mb-3">
                    <div class="col-6"><strong>Email Address</strong></div>
                    <div class="col-6"><strong>Fullname (option)</strong></div>
                </div>
                <div class="listElement row" v-for="(user, index) in invite_users" :key="index">
                    <div class="col-6">
                        {{user.email}}
                    </div>
                    <div class="col-6">
                        {{user.name}}
                    </div>
                </div>
            </div>
            <div class="overflow-hidden p-0 d-flex justify-content-between">
                <!-- submit -->
                <span slot="footer" class="dialog-footer">
                    <el-button type="text" size="medium" class="margin-right-1" @click.prevent="reSend">
                        Cancel
                    </el-button>

                    <el-button round type="success" size="medium" @click.prevent="inviteToApp">
                        Submit
                    </el-button>
                </span>
            </div>
        </div>
    </div>
</template>
<script>
  import {post} from '../../../helper/request'
  export default {
    data() {
      return {
        invite_users: [
          {
            email: "",
            name: ""
          },
          {
            email: "",
            name: ""
          },
          {
            email: "",
            name: ""
          }
        ],

        isSent: false,
      }
    },

    components: {},

    methods: {
      addMore() {
        console.log("add more function");
        this.invite_users.push({
          email: "",
          name: ""
        })
      },

      sendInvite() {
        this.isSent = true;
        console.log("send invite function");
      },

      destroyElement(index) {
        console.log("destroy element function");
        this.invite_users.splice(index, 1);
      },

      backToInvite() {
        this.isSent = false;
      },

      done() {
        this.$router.push({name: 'homeIndex'});
      },

      reSend() {
        this.isSent = false;
      },

      close() {
        window.history.go(-1);
      },

      inviteToApp() {
        let invites = this.invite_users.filter((i) => {
          return i.email !== "";
        })

        let url = '/api/invite-to-app';
        let payload = {
          invited_users: invites
        }

        post(url, payload).then((res) => {

        }).catch((err)=> {
          this.$message({
            type: 'error',
            message: 'Something error!!'
          })
        }).finally(() => {
          this.close();
        })
      }

    }
  }
</script>

<style>
    .fas:hover {
        cursor: pointer;
    }
</style>
