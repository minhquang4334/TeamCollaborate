<template>
    <section>
        <h3 class="dotted-title">
			<span>
				Avatar
			</span>
        </h3>

        <div class="form-group">
            <div class="flex-space">
                <div>
                    <div round class="el-button v-button--upload el-button--default is-plain is-round" plain>
                        <i class="margin-right-half" :class="avatar.uploading ? 'el-icon-loading' : 'el-icon-upload'"></i>

                        {{ avatar.uploading ? 'Uploading...' : 'Click To Browse'}}

                        <input class="v-button" type="file" @change="uploadAvatar" />
                    </div>

                    <p class="go-gray go-small">
                        The Uploaded photo must have a minimum of
                        <strong>250*250 pixels</strong> with a
                        <strong>ratio of 1/1</strong> (such as a square or circle)
                    </p>

                    <el-alert v-for="e in avatar.errors.photo"
                              :title="e"
                              type="error"
                              :key="e"></el-alert>
                </div>

                <div class="edit-avatar-preview">
                    <img :alt="currentUser.username"
                         :src="currentUser.avatar ? currentUser.avatar :'/images/default-avatar.png'"
                         class="circle" />
                </div>
            </div>
        </div>

        <h3 class="dotted-title">
			<span>
				Public Profile
			</span>
        </h3>

        <el-form label-position="top"
                 label-width="10px"
                 :model="form">

            <el-form-item label="Full Name">
                <el-input placeholder="Your full name..."
                          v-model="form.name"></el-input>
                <el-alert v-for="e in errors.name"
                          :title="e"
                          type="error"
                          :key="e"></el-alert>
            </el-form-item>

            <el-form-item label="About me">
                <el-input placeholder="How would you describe you?"
                          v-model="form.about_me"
                          type="textarea"
                          :autosize="{ minRows: 4, maxRows: 10}"></el-input>
                <el-alert v-for="e in errors.about_me"
                          :title="e"
                          type="error"
                          :key="e"></el-alert>
            </el-form-item>

            <el-form-item label="Phone Number">
                <el-input placeholder="Phone Number..."
                          v-model="form.phone_number"
                          type="url"></el-input>
                <el-alert v-for="e in errors.phone_number"
                          :title="e"
                          type="error"
                          :key="e"></el-alert>
            </el-form-item>

            <el-form-item label="Address">
                <el-input placeholder="Address..."
                          v-model="form.address"></el-input>
                <el-alert v-for="e in errors.address"
                          :title="e"
                          type="error"
                          :key="e"></el-alert>
            </el-form-item>

            <el-form-item label="University">
                <el-input placeholder="University..."
                          v-model="form.university"></el-input>
                <el-alert v-for="e in errors.university"
                          :title="e"
                          type="error"
                          :key="e"></el-alert>
            </el-form-item>

            <el-form-item label="Facebook Username">
                <el-input placeholder="Facebook Username..."
                          v-model="form.facebook_url">
                    <template slot="prepend">Https://facebook.com/</template>
                </el-input>

                <el-alert v-for="e in errors.facebook_url"
                          :title="e"
                          type="error"
                          :key="e"></el-alert>
            </el-form-item>

            <!-- submit -->
            <el-form-item v-if="changed">
                <el-button round type="success"
                           @click="save"
                           :loading="sending"
                           size="medium">Save</el-button>
            </el-form-item>
        </el-form>
    </section>
</template>

<script>
  import Helpers from '../../mixins/Helpers';
  import {post, put, get} from "../../helper/request"

  export default {
    mixins: [Helpers],

    data() {
      return {
        sending: false,
        errors: [],
        currentUser: this.$store.state.auth.user,
        form: {
          name: this.$store.state.auth.user.name,
          about_me: this.$store.state.auth.user.about_me,
          address: this.$store.state.auth.user.address,
          facebook_url: this.$store.state.auth.user.facebook_url,
          university: this.$store.state.auth.user.university,
          phone_number: this.$store.state.auth.user.phone_number
        },

        avatar: {
          fileUploadFormData: new FormData(),
          uploading: false,
          errors: []
        }
      };
    },

    computed: {
      changed() {
        if (
          this.currentUser.name !== this.form.name ||
          this.currentUser.about_me !== this.form.about_me ||
          this.currentUser.phone_number !== this.form.phone_number ||
          this.currentUser.address !== this.form.address ||
          this.currentUser.university !== this.form.university ||
          this.currentUser.facebook_url !== this.form.facebook_url
        ) {
          return true;
        }

        return false;
      }
    },

    methods: {
      uploadAvatar(e) {
        this.avatar.uploading = true;
        this.avatar.errors = [];
        this.avatar.fileUploadFormData = new FormData();
        this.avatar.fileUploadFormData.append('photo', e.target.files[0]);

        post('/api/user/avatar', this.avatar.fileUploadFormData)
          .then((response) => {
            //location.reload();
            this.currentUser.avatar = response.data.image_address
            this.avatar.uploading = false;
              this.$message({
                  type: 'success',
                  message: 'User Avatar Update Successfully'
              });
          })
          .catch((error) => {
            this.avatar.errors = error.response.data.errors;
            this.avatar.uploading = false;
              this.$message({
                  type: 'error',
                  message: 'Some thing error'
              });
          });
      },

      save() {
        this.sending = true;
        let payload = {
            name: this.form.name,
            about_me: this.form.about_me,
            phone_number: this.form.phone_number,
            address: this.form.address,
            facebook_url: 'https://facebook.com/' + this.form.facebook_url,
            university: this.form.university
        }

        put('/api/user/update', payload)
          .then(() => {
            this.errors = [];

            this.currentUser.name = this.form.name;
            this.currentUser.about_me = this.form.about_me;
            this.currentUser.address = this.form.address;
            this.currentUser.university = this.form.university;
            this.currentUser.phone_number = this.form.phone_number;
            this.currentUser.facebook_url = this.form.facebook_url;

            this.sending = false;
              this.$message({
                  type: 'success',
                  message: 'User Profile Update Successfully'
              });
          })
          .catch((error) => {
            this.sending = false;
            this.errors = error.response.data.errors;
              this.$message({
                  type: 'error',
                  message: 'Some thing error'
              });
          });
      }
    }
  };
</script>
