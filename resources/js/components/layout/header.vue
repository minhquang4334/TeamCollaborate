<template>
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper">
            <a class="navbar-brand brand-logo" href="index.html"><img src="/images/logo.svg" alt="logo"></a>
            <a class="navbar-brand brand-logo-mini" href="index.html"><img src="/images/logo_mini.svg"
                                                                           alt="logo"></a>
        </div>
        <!--<el-tooltip content="Preferences"-->
                    <!--placement="right"-->
                    <!--transition="false"-->
                    <!--:open-delay="500"-->
                    <!--&gt;-->
            <!--<a class="item cursor-pointer"-->
               <!--@click.prevent="preferences"-->
               <!--&gt;-->
                <!--<i class="el-icon-setting"-->
                   <!--aria-hidden="true"></i>-->
            <!--</a>-->
        <!--</el-tooltip>-->
        <div class="navbar-menu-wrapper d-flex align-items-center">
            <p class="page-name d-none d-lg-block">Hi, Dave Mattew</p>
            <ul class="navbar-nav ml-lg-auto">
                <li class="nav-item">
                    <a @click="logout()" class="cursor-pointer">Logout</a>
                </li>
                <li class="nav-item">
                    <form class="mt-2 mt-md-0 d-none d-lg-block search-input">
                        <div class="input-group">
                            <span class="input-group-addon d-flex align-items-center"><i class="icon-magnifier icons"></i></span>
                            <input type="text" class="form-control" placeholder="Search...">
                        </div>
                    </form>
                </li>
                <li class="nav-item d-none d-sm-block profile-img">
                    <a class="nav-link profile-image" @click="preferences()" style="cursor: pointer">
                        <img src="images/faces/face4.jpg" alt="profile-img">
                        <span class="online-status online bg-success"></span>
                    </a>
                </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center ml-auto" type="button" data-toggle="offcanvas">
                <span class="icon-menu icons"></span>
            </button>
        </div>
    </nav>
</template>
<script>
    import {get} from '../../helper/request.js'
    export default {
      methods: {
        logout: function () {
          this.$store.dispatch('auth/logout')
            .then(() => {
              this.$router.push({ name: 'login' });
            });
        },

        preferences: function () {
          this.$router.push({ name: 'preferences' });
        },

      },
    }
</script>
