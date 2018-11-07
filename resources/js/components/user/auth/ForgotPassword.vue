<template>
    <div class="register-box">
        <div class="register-logo">
            <a>Team Collaborate</a>
        </div>

        <div class="register-box-body">
            <p class="login-box-msg">Đăng ký tài khoản</p>

            <form @submit.prevent="sendEmail" @keydown="clearErrors($event)">

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
    data() {
      return {
        form: new Form({
          email: '',
        }),
        loading: false,
        success: null,
        message: null
      }
    },
    computed: {
      hasAlert() {
        return this.success !== null;
      }
    },
    methods: {
      sendEmail() {
        let self = this;
        self.loading = true;

        this.form.post('api/user/auth/password/email')
          .then(({data}) => {
            self.loading = false;

            this.success = true;
            this.message = data.message;
          })
          .catch(({response}) => {
            self.loading = false;
            this.success = false;
            if (response.data.errors) {
              this.message = 'Giá trị không hợp lệ'
            } else {
              this.message = response.data.message;
            }
          })
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