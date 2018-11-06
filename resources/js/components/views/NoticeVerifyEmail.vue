<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Verify Your Email Address</div>

                    <div class="card-body">

                        <div class="alert alert-success" role="alert" v-if="resent === true">
                            A fresh verification link has been sent to your email address.
                        </div>

                        Before proceeding, please check your email for a verification link.
                        If you did not receive the email, <a @click="resend" class="link-color cursor-pointer">click here to request another</a>.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import {get} from '../../helper/request.js'
    export default {

      name: 'NoticeVerifyEmail',

      data() {
        return {
          resent: false
        }
      },

      methods: {
        resend() {
          get('/api/user/verification/resend').then(() => {
            this.resent = true
          }).catch(() => {

          })
        }
      }
    }
</script>