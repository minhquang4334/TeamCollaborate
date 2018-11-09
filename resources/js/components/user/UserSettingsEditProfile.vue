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
            <el-form-item label="Cover Color">
                <el-select v-model="form.cover_color"
                           placeholder="Cover Color..."
                           filterable>
                    <el-option v-for="item in coverColors"
                               :key="item"
                               :label="item"
                               :value="item">
                    </el-option>
                </el-select>
            </el-form-item>

            <el-form-item label="Full Name">
                <el-input placeholder="Your full name..."
                          v-model="form.name"></el-input>
                <el-alert v-for="e in errors.name"
                          :title="e"
                          type="error"
                          :key="e"></el-alert>
            </el-form-item>

            <el-form-item label="Bio">
                <el-input placeholder="How would you describe you?"
                          v-model="form.bio"
                          type="textarea"
                          :autosize="{ minRows: 4, maxRows: 10}"></el-input>
                <el-alert v-for="e in errors.bio"
                          :title="e"
                          type="error"
                          :key="e"></el-alert>
            </el-form-item>

            <el-form-item label="Website">
                <el-input placeholder="Website..."
                          v-model="form.website"
                          type="url"></el-input>
                <el-alert v-for="e in errors.website"
                          :title="e"
                          type="error"
                          :key="e"></el-alert>
            </el-form-item>

            <el-form-item label="Location">
                <el-input placeholder="Location..."
                          v-model="form.location"></el-input>
                <el-alert v-for="e in errors.location"
                          :title="e"
                          type="error"
                          :key="e"></el-alert>
            </el-form-item>

            <el-form-item label="Twitter Username">
                <el-input placeholder="Twitter Username..."
                          v-model="form.twitter">
                    <template slot="prepend">Https://twitter.com/</template>
                </el-input>

                <el-alert v-for="e in errors.twitter"
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

  export default {
    mixins: [Helpers],

    data() {
      return {
        sending: false,
        errors: [],
        currentUser: this.$store.state.auth.user,
        form: {
          name: this.$store.state.auth.user.name,
          bio: this.$store.state.auth.user.bio,
          website: this.$store.state.auth.user.website,
          cover_color: this.$store.state.auth.user.cover_color,
          location: this.$store.state.auth.user.location,
          twitter: this.$store.state.auth.user.twitter
        },

        coverColors: [
          'Blue',
          'Dark Blue',
          'Red',
          'Dark',
          'Dark Green',
          'Bright Green',
          'Purple',
          'Pink',
          'Orange'
        ],

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
          this.currentUser.bio !== this.form.bio ||
          this.currentUser.website !== this.form.website ||
          this.currentUser.location !== this.form.location ||
          this.currentUser.cover_color !== this.form.cover_color ||
          this.currentUser.twitter !== this.form.twitter
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

        axios
          .post('/this.currentUser/avatar', this.avatar.fileUploadFormData)
          .then((response) => {
            location.reload();

            this.avatar.uploading = false;
          })
          .catch((error) => {
            this.avatar.errors = error.response.data.errors;
            this.avatar.uploading = false;
          });
      },

      save() {
        this.sending = true;

        axios
          .patch('/users/profile', {
            name: this.form.name,
            bio: this.form.bio,
            website: this.form.website,
            location: this.form.location,
            cover_color: this.form.cover_color,
            twitter: this.form.twitter
          })
          .then(() => {
            this.errors = [];

            this.currentUser.name = this.form.name;
            this.currentUser.bio = this.form.bio;
            this.currentUser.location = this.form.location;
            this.currentUser.cover_color = this.form.cover_color;
            this.currentUser.website = this.form.website;
            this.currentUser.twitter = this.form.twitter;

            if (
              typeof Store.page.user.temp.username != 'undefined' &&
              Store.page.user.temp.id == this.currentUser.id
            ) {
              Store.page.user.temp.name = this.currentUser.name;
              Store.page.user.temp.bio = this.currentUser.bio;
              Store.page.user.temp.cover_color = this.currentUser.cover_color;
              Store.page.user.temp.location = this.currentUser.location;
              Store.page.user.temp.website = this.currentUser.website;
              Store.page.user.temp.twitter = this.currentUser.twitter;
            }

            this.sending = false;
          })
          .catch((error) => {
            this.sending = false;
            this.errors = error.response.data.errors;
          });
      }
    }
  };
</script>
