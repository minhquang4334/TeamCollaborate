<template>
    <form @submit.prevent="register" @keydown="clearErrors($event)">

        <div :class="{ 'form-group': true, 'has-feedback': true, 'has-error': form.errors.has('name') }">
            <input v-model="form.name"
                   type="text" name="name" title="Name" id="inputName"
                   class="form-control" placeholder="Họ và tên">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
            <has-error :form="form" field="name"></has-error>
        </div>

        <div :class="{ 'form-group': true, 'has-feedback': true, 'has-error': form.errors.has('email') }">
            <input v-model="form.email"
                   type="text" name="email" title="Email" id="inputEmail"
                   class="form-control" placeholder="Email">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            <has-error :form="form" field="email"></has-error>
        </div>

        <div :class="{ 'form-group': true, 'has-feedback': true, 'has-error': form.errors.has('password') }">
            <input v-model="form.password"
                   type="password" name="password" title="Password"
                   class="form-control" placeholder="Mật khẩu">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            <has-error :form="form" field="password"></has-error>
        </div>

        <div :class="{ 'form-group': true, 'has-feedback': true, 'has-error': form.errors.has('password_confirmation') }">
            <input v-model="form.password_confirmation"
                   type="password" name="password_confirmation" title="Confirm Password"
                   class="form-control" placeholder="Nhập lại mật khẩu">
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
            <has-error :form="form" field="password_confirmation"></has-error>
        </div>

        <div :class="{ 'form-group': true, 'has-feedback': true, 'has-error': form.errors.has('gender') }">
            <select v-model="form.gender" class="form-control">
                <option value="-1" selected>Giới tính</option>
                <option value="0">Nam</option>
                <option value="1">Nữ</option>
            </select>
            <span class="glyphicon glyphicon-envelop form-control-feedback"></span>
            <has-error :form="form" field="gender"></has-error>
        </div>
        <button :disabled="loading" type="submit" class="btn btn-primary btn-block btn-flat">Đăng ký
        </button>
    </form>
</template>
<script>
  import Form from 'vform'

  export default {
    data() {
      return {
        form: new Form({
          name: '',
          email: '',
          password: '',
          password_confirmation: '',
          gender: -1,
        }),
        loading: false,
      }
    },

    mounted() {

      let url = window.location.href;
      let x = url.split('?');
      if(x.length < 2){
        clearInterval(checkExist);
        return;
      }
      let data = x[x.length-1].split('---');
      this.form.email = atob(data[0]);
      this.form.name = atob(data[1]);
    },

    methods: {
      register() {
        let self = this;
        self.loading = true;
        console.log(document.getElementById('inputName').value);
        this.form.name = document.getElementById('inputName').value;
        this.form.email = document.getElementById('inputEmail').value;
        this.form.post(`api/user/auth/register`)
          .then(({data}) => {
              self.loading = false;
              this.$store.dispatch('auth/saveToken', {token: data.data.token});
              self.$store.dispatch('auth/fetchUser');

              self.$router.push({name: 'homeIndex'});
            }
          )
          .catch(({response}) => {
            self.loading = false;
          });
      },
      clearErrors(event) {
        this.form.errors.clear('register-failed');
        this.form.errors.clear(event.target.name);
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

  setNameAndEmail();
</script>

<style scoped>
    .invalid-feedback {
        display: block !important;
    }
</style>
