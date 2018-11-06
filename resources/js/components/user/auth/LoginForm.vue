<template>
    <form @submit.prevent="login" @keydown="clearErrors($event)" class="form-login">
        <div :class="{ 'form-group': true, 'has-error': form.errors.has('login-failed') }">
            <has-error :form="form" field="login-failed" class="d-block"></has-error>
        </div>

        <div :class="{ 'form-group': true, 'has-error': form.errors.has('email') }">
            <input v-model="form.email" type="text" name="email" title="Email" class="form-control"
                   placeholder="Email">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            <has-error :form="form" field="email" class="d-block"></has-error>
        </div>

        <div :class="{ 'form-group': true, 'has-feedback': true, 'has-error': form.errors.has('password') }">
            <input v-model="form.password" type="password" name="password" title="Password" class="form-control"
                   placeholder="Mật khẩu">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            <has-error :form="form" field="password" class="d-block"></has-error>
        </div>
        <div class="row margin-top-25">
            <div class="col-md-6 col-xs-7 remember-me d-inline-block">
                <label class="float-left full-with">
                    <input v-model="form.remember" type="checkbox"> <span class="margin-left-10">Ghi nhớ </span>
                </label>
            </div>
            <div class="col-md-6 col-xs-5">
                <button :disabled="loggingIn" type="submit" :class="loggingIn ? 'registration-disabled': 'cursor-pointer registration'">
                    Đăng nhập
                </button>
            </div>
        </div>
    </form>
</template>

<script>
  import Form from 'vform'

  export default {
    data() {
      return {
        form: new Form({
          email: '',
          password: '',
          remember: false,
        }),

      }
    },
    props: ['logging-in'],
    methods: {
      login() {
        let self = this;
        this.$emit('setLogin');
        console.log(this.form);
        this.$emit('disableLoginBtns');
        this.form.post(`api/user/auth/login`)
          .then(({data}) => {
              self.$store.dispatch('auth/saveToken', {
                token: data.access_token,
              });

              self.$store.dispatch('auth/fetchUser')
                .then(() => {
                  self.$router.push({name: 'homeIndex'});
                })
                .catch(() => {
                  self.$emit('enableLoginBtns');
                });
            }
          ).finally(() => {
            this.$emit('setLogin');
          })
          .catch(() => {
            self.$emit('enableLoginBtns');
          });
      },
      clearErrors(event) {
        this.form.errors.clear('login-failed');
        this.form.errors.clear(event.target.name);
      }
    }
  }
</script>