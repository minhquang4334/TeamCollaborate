<template>
    <div class="register-box">
        <div class="register-logo">
            <a>App</a>
        </div>

        <div class="register-box-body">
            <p class="login-box-msg">Khôi phục mật khẩu</p>

            <form @submit.prevent="reset" @keydown="clearErrors($event)">
                <transition name="fade">
                    <div v-if="hasAlert" :class="{ 'alert': true, 'alert-danger': !success, 'alert-success': success }">
                        {{ message }}
                    </div>
                </transition>

                <div :class="{ 'form-group': true, 'has-feedback': true, 'has-error': form.errors.has('email') }">
                    <input v-model="form.email"
                           type="text" name="email" title="Email"
                           class="form-control" placeholder="Email">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    <has-error :form="form" field="email"></has-error>
                </div>

                <div :class="{ 'form-group': true, 'has-feedback': true, 'has-error': form.errors.has('password') }">
                    <input v-model="form.password"
                           type="password" name="password" title="Password"
                           class="form-control" placeholder="Mật khẩu mới">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    <has-error :form="form" field="password"></has-error>
                </div>

                <div :class="{ 'form-group': true, 'has-feedback': true, 'has-error': form.errors.has('password_confirmation') }">
                    <input v-model="form.password_confirmation"
                           type="password" name="password_confirmation" title="Confirm Password"
                           class="form-control" placeholder="Nhập lại mật khẩu" autocomplete="off">
                    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                    <has-error :form="form" field="password_confirmation"></has-error>
                </div>

                <div class="row">
                    <div class="col-xs-8 col-xs-offset-2">
                        <button :disabled="loading" type="submit" class="btn btn-primary btn-block btn-flat">
                            <i v-if="loading" class="fa fa-spin fa-refresh"></i>
                            Khôi phục mật khẩu
                        </button>
                    </div>
                </div>
            </form>
            <div class="margin-top-50 text-center">
                <router-link :to="{ name: 'login' }">Quay lại trang đăng nhập</router-link>
            </div>
        </div>
    </div>
</template>


<script>
  import Form from 'vform'

  export default {
    data: () => ({
      form: new Form({
        token: '',
        email: '',
        password: '',
        password_confirmation: '',
      }),
      success: null,
      message: '',
      loading: false
    }),
    computed: {
      hasAlert() {
        return this.success !== null;
      }
    },
    methods: {
      reset() {
        let self = this;
        this.loading = true;
        this.form.token = this.$route.params.token;

        this.form.post('/api/user/auth/password/reset/')
          .then(({data}) => {
            self.loading = false;
            self.success = true;
            self.message = data.message;

            self.$store.dispatch('auth/saveToken', {token: data.data.token});
            self.$store.dispatch('auth/fetchUser');

            self.$router.push({name: 'homeIndex'});
          })
          .catch(({response}) => {
            console.log(response);
            self.loading = false;
            self.success = false;
            self.message = response.data.message ? response.data.message : 'Khôi phục mật khẩu thất bại!';
          });
      },
      clearErrors(event) {
        this.success = null;
      }
    },
    beforeCreate: function () {
      let classList = document.body.classList;
      while (classList.length > 0) {
        classList.remove(classList.item(0));
      }
      document.body.classList.add("hold-transition", "register-page")
    }
  }
</script>