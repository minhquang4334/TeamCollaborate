<template>
    <div class="card">
        <img class="card-img-top fixed-image-size" :src="profileUser.avatar" alt="Card image cap">
        <div class="card-body">
            <h5 class="card-title">{{ profileUser.name }}</h5>
            <el-button
                    round
                    type="success"
                    v-show="profileUser.id !== currentUser.id"
                    size="medium"
                    @click="directMessage(profileUser)">
                Message
            </el-button>
            <div class="text-muted">
                <table class="table table-condensed">
                    <tbody>
                    <tr>
                        <td>Display name</td>
                        <td>{{ profileUser.name }}</td>
                    </tr>
                    <tr>
                        <td>About me</td>
                        <td>{{ profileUser.about_me }}</td>
                    </tr>
                    <tr>
                        <td>University</td>
                        <td>{{ profileUser.university }}</td>
                    </tr>
                    <tr>
                        <td>Join At</td>
                        <td>{{ profileUser.created_at.date }}</td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    import {post} from '../../../helper/request'
    export default {
      props: ['profileUser'],

      data() {
        return {
          currentUser: this.$store.state.auth.user,
        }
      },


      methods: {
        directMessage(user) {
          if(this.profileUser.id !== this.currentUser.id) {
            let type = 2;
            let invited_users = [];
            invited_users.push(user.id);
            let name = this.currentUser.name + ', ' + user.name;
            let payload = {
              type : type,
              purpose: 'Direct Messages between ' + name,
              description: '',
              name: name,
              invited_users: invited_users
            }
            let url = '/api/channel/create'
            post(url, payload).then((res) => {
              if(res.data.data) {
                this.$router.push({
                  name: 'ChannelDetail',
                  params: {
                    id: res.data.data.channel_id
                  }
                })
                this.$eventHub.$emit('newDirectMessage', res.data.data);
              }
            }).catch((err) => {
              console.log('err: ', err);
              this.$message({
                type: 'error',
                message: 'Something error: ', err
              })
            })
          }
        },
      }
    }
</script>

<style scoped>
    .fixed-image-size {
        max-height: 300px;
    }
</style>
