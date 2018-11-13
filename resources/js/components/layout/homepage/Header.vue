<template>
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row" style="overflow:visible;">
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
            <p class="page-name d-none d-lg-block">
                <strong id="Channelname">Channel Name</strong>
                <small><span class="far fa-user mx-2"></span><span id="member-number">5</span></small>
            </p>
            <div class="nav-item dropdown">

                <a class="nav-link" style="cursor: pointer" data-toggle="dropdown">
                    <span class="fas fa-cogs"></span>
                </a>
                <div class="dropdown-menu navbar-dropdown preview-list  dropdownAnimation" aria-labelledby="notificationDropdown">
                    <a class="dropdown-item">
                        <p>
                            <span class="fas fa-info-circle mr-2"></span>
                            Channel About
                        </p>
                    </a>
                    <a class="dropdown-item">
                        <p>
                            <span class="fas fa-bell mr-2"></span>
                            Notification
                        </p>
                    </a>
                    <a class="dropdown-item">
                        <p>
                            <span class="fas fa-hand-holding-heart mr-2"></span>
                            Invite
                        </p>
                    </a>
                    <a class="dropdown-item">
                        <p>
                            <span class="fas fa-sign-out-alt mr-2"></span>
                            Leave Channel
                        </p>
                    </a>
                    <a class="dropdown-item">
                        <p>
                            <span class="fas fa-trash-alt mr-2"></span>
                            Remove Channel
                        </p>
                    </a>

                </div>
            </div>
            <ul class="navbar-nav ml-lg-auto">
                <!--<li class="nav-item">-->
                    <!--<a @click="logout()" class="cursor-pointer">Logout</a>-->
                <!--</li>-->
                <li class="nav-item">
                    <form class="mt-2 mt-md-0 d-none d-lg-block search-input">
                        <div class="input-group">
                            <!--<span class="input-group-addon d-flex align-items-center"><i class="fas fa-search"></i></span>-->
                            <input type="text" class="form-control" placeholder="Search...">
                        </div>
                    </form>
                </li>
                <!--<li class="nav-item d-none d-sm-block profile-img">-->
                    <!--<a class="nav-link profile-image" @click="preferences()" style="cursor: pointer">-->
                        <!--<img src="images/faces/face4.jpg" alt="profile-img">-->
                        <!--<span class="online-status online bg-success"></span>-->
                    <!--</a>-->
                <!--</li>-->
                <li class="nav-item dropdown">

                    <a class="nav-link profile-image" style="cursor: pointer" data-toggle="dropdown">
                        <img src="images/faces/face4.jpg" alt="profile-img">
                        <span class="online-status online bg-success"></span>
                    </a>
                    <div class="dropdown-menu navbar-dropdown preview-list  dropdownAnimation" aria-labelledby="notificationDropdown">
                        <a class="dropdown-item" @click="preferences()">
                            <p>
                                <span class="fas fa-user-circle mr-2"></span>
                                Preferences
                            </p>
                        </a>
                        <a class="dropdown-item" @click="logout()">
                            <p>
                                <span class="fas fa-sign-out-alt mr-2"></span>
                                Logout
                            </p>
                        </a>

                    </div>
                </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center ml-auto" type="button" data-toggle="offcanvas">
                <span class="icon-menu icons"></span>
            </button>
        </div>
    </nav>
</template>
<script>
    import {get} from '../../../helper/request.js'
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
