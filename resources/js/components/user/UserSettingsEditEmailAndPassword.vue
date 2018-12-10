<template>
    <section>
        <h3 class="dotted-title">
			<span>
				Change Password
			</span>
        </h3>

        <el-form label-position="top"
                 label-width="10px">
            <el-form-item label="Old Password">
                <el-input placeholder="Enter current password to confirm..."
                          v-model="passwordForm.old_password"
                          type="password"></el-input>

                <el-alert v-for="e in passwordForm.errors.old_password"
                          :title="e"
                          type="error"
                          :key="e"></el-alert>
            </el-form-item>

            <el-form-item label="New Password">
                <el-input placeholder="New Password..."
                          v-model="passwordForm.new_password"
                          type="password"></el-input>

                <el-alert v-for="e in passwordForm.errors.new_password"
                          :title="e"
                          type="error"
                          :key="e"></el-alert>
            </el-form-item>

            <el-form-item label="Confirm Password">
                <el-input placeholder="Confirm Password..."
                          v-model="passwordForm.new_password_confirmation"
                          type="password"></el-input>

                <el-alert v-for="e in passwordForm.errors.new_password_confirmation"
                          :title="e"
                          type="error"
                          :key="e"></el-alert>
            </el-form-item>

            <el-form-item v-if="changedPassword">
                <el-button round type="success"
                           @click="updatePassword"
                           :loading="passwordForm.loading"
                           size="medium">
                    Save
                </el-button>
            </el-form-item>
        </el-form>
    </section>
</template>

<script>
  import Helpers from '../../mixins/Helpers';
  import {put, post} from '../../helper/request';
  export default {
    mixins: [Helpers],

    data() {
      return {
        emailForm: {
          errors: [],
          email: auth.email,
          loading: false,
          showConfirmPassword: false,
          verificationEmailResent: false
        },

        passwordForm: {
          errors: [],
          loading: false,
          old_password: '',
          new_password: '',
          new_password_confirmation: ''
        }
      };
    },

    computed: {
      showVerificationWarning() {
        return (
          !auth.verified_email &&
          auth.email &&
          !this.emailForm.showConfirmPassword
        );
      },

      changedEmail() {
        return auth.email != this.emailForm.email;
      },

      changedPassword() {
        return (
          this.passwordForm.new_password ==
          this.passwordForm.new_password_confirmation &&
          this.passwordForm.new_password &&
          this.passwordForm.old_password
        );
      }
    },

    methods: {
      /**
       * updates users' password. old-password is required
       *
       * @return void
       */
      updatePassword() {
        this.passwordForm.loading = true;
        let payload = {
          old_password: this.passwordForm.old_password,
          new_password: this.passwordForm.new_password,
          new_password_confirmation: this.passwordForm.new_password_confirmation
        }
        put('/api/user/change-password', payload)
          .then(() => {
            this.passwordForm.old_password = '';
            this.passwordForm.new_password = '';
            this.passwordForm.new_password_confirmation = '';
            this.passwordForm.loading = false;

            this.passwordForm.errors = [];

            this.$message({
              type: 'success',
              message: 'Password updated successfully.'
            });
          })
          .catch((error) => {
            this.passwordForm.errors = error.response.data.errors;
            this.passwordForm.loading = false;
          });
      }
    }
  };
</script>
