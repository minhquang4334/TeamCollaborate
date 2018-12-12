<template>
    <section>
        <h3 class="dotted-title go-red">
			<span>
				Delete Account
			</span>
        </h3>

        <p>
            Deleting an account is a permanent action and
            <b>cannot be undone</b>. It is also going to make us miss you.
        </p>

        <p>
            Click below button to begin. You'll be asked for your password to confirm the action.
        </p>

        <el-form label-position="top"
                 label-width="10px">
            <el-form-item>
                <el-button round type="danger"
                           plain
                           size="medium"
                           @click="showConfirmPassword = true"
                           v-if="!showConfirmPassword">
                    Delete my account
                </el-button>
            </el-form-item>

            <div v-if="showConfirmPassword"
                 class="margin-bottom-1">
                <el-form-item label="To confirm this action please enter your password">
                    <el-input placeholder="Password..."
                              v-model="password"
                              type="password"></el-input>

                    <el-alert v-for="e in errors.password"
                              :title="e"
                              type="error"
                              :key="e"></el-alert>
                </el-form-item>

                <el-form-item>
                    <el-button round type="success"
                               size="small"
                               @click="destroyAccount"
                               :disabled="!password"
                               :loading="loading">
                        Confirm
                    </el-button>
                    <el-button type="text"
                               size="small"
                               @click="showConfirmPassword = false">
                        Cancel
                    </el-button>
                </el-form-item>
            </div>
        </el-form>
    </section>
</template>

<script>
  import Helpers from '../../mixins/Helpers';
  import {del} from '../../helper/request';

  export default {
    mixins: [Helpers],

    data() {
      return {
        loading: false,
        showConfirmPassword: false,
        password: '',
        errors: [],
        username: auth.username
      };
    },

    methods: {
      destroyAccount() {
        this.loading = true;
        let url = '/api/user/delete?password=' + this.password;
        del(url)
          .then((res) => {
            this.loading = false;
            if(res.data.status === false) {
                this.$message({
                    type: 'failed',
                    message: "Your Input Password was incorrect!!"
                });
            } else {
                this.$message({
                    type: 'success',
                    message: "Account deleted. We'll miss you! See you again!!"
                });

                this.$store.dispatch('auth/logout')
                    .then(() => {
                        this.$router.push({ name: 'login' });
                    });
            }

          })
          .catch((error) => {
            this.loading = false;
            this.errors = error.response.data.errors;
          });
      }
    }
  };
</script>
