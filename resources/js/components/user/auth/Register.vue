
<template>
    <div class="login-homepage-form">
        <div class="container">
            <div class="content-login col-md-5 m-auto col-sm-8">
                <div class="logo-left">
                    <img src="/images/logo.jpg" class="size-img">
                </div>
                <div class="login-box-body">
                    <p class="green-strong">Team Collaborate</p>
                    <p>Đăng ký tài khoản</p>

                    <register-form/>
                    <div class="margin-top-50 text-center">
                        <router-link :to="{ name: 'login' }">Tôi đã có tài khoản đăng nhập</router-link>
                    </div>


                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import RegisterForm from './RegisterForm'
    export default {
        components: {
            'register-form' : RegisterForm,
        }
    }
</script>
<style scoped>
    .size-img {
        max-height: 100px;
        max-width: 100px;
    }

    .height-auto{
        height: 120px;
    }
</style>
