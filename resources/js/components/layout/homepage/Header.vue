<template>
    <!--<nav class="navbar navbar-expand-lg navbar-light bg-light">-->
        <!--<a class="navbar-brand mx-5" href="#">-->
            <!--<strong id="Channelname">Channel Name</strong>-->
            <!--<small><span class="far fa-user mx-2"></span><span id="member-number">5</span></small>-->
        <!--</a>-->
        <!--<div class="nav-item dropdown">-->
            <!--<a class="nav-link" style="cursor: pointer" data-toggle="dropdown">-->
                <!--<span class="fas fa-cogs"></span>-->
            <!--</a>-->
            <!--<div class="dropdown-menu navbar-dropdown preview-list  dropdownAnimation" aria-labelledby="notificationDropdown">-->
                <!--<a class="dropdown-item">-->
                    <!--<p>-->
                        <!--<span class="fas fa-info-circle mr-2"></span>-->
                        <!--Channel About-->
                    <!--</p>-->
                <!--</a>-->
                <!--<a class="dropdown-item">-->
                    <!--<p>-->
                        <!--<span class="fas fa-bell mr-2"></span>-->
                        <!--Notification-->
                    <!--</p>-->
                <!--</a>-->
                <!--<a class="dropdown-item">-->
                    <!--<p>-->
                        <!--<span class="fas fa-hand-holding-heart mr-2"></span>-->
                        <!--Invite-->
                    <!--</p>-->
                <!--</a>-->
                <!--<a class="dropdown-item">-->
                    <!--<p>-->
                        <!--<span class="fas fa-sign-out-alt mr-2"></span>-->
                        <!--Leave Channel-->
                    <!--</p>-->
                <!--</a>-->
                <!--<a class="dropdown-item">-->
                    <!--<p>-->
                        <!--<span class="fas fa-trash-alt mr-2"></span>-->
                        <!--Remove Channel-->
                    <!--</p>-->
                <!--</a>-->

            <!--</div>-->
        <!--</div>-->

        <!--<div class="nav-item dropdown">-->
            <!--<a class="nav-link profile-image" style="cursor: pointer" data-toggle="dropdown">-->
                <!--<img src="/images/faces/face4.jpg" class="rounded-circle" style="width: 50px;height:50px" alt="profile-img">-->
                <!--<span class="online-status online bg-success"></span>-->
            <!--</a>-->
            <!--<div class="dropdown-menu navbar-dropdown preview-list  dropdownAnimation" aria-labelledby="notificationDropdown">-->
                <!--<a class="dropdown-item" @click="preferences()">-->
                    <!--<p>-->
                        <!--<span class="fas fa-user-circle mr-2"></span>-->
                        <!--Preferences-->
                    <!--</p>-->
                <!--</a>-->
                <!--<a class="dropdown-item" @click="logout()">-->
                    <!--<p>-->
                        <!--<span class="fas fa-sign-out-alt mr-2"></span>-->
                        <!--Logout-->
                    <!--</p>-->
                <!--</a>-->

            <!--</div>-->
        <!--</div>-->
        <!--<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">-->
            <!--<span class="navbar-toggler-icon"></span>-->
        <!--</button>-->

        <!--<div class="collapse navbar-collapse" id="navbarSupportedContent">-->

            <!--<ul class="navbar-nav mr-auto d-md-none">-->
                <!--<li class="nav-item nav-category">-->
                    <!--<a class="nav-link" style="cursor:pointer" @click="newchannel()">CHANNELS<span class="fas fa-plus-circle float-right"></span></a>-->
                <!--</li>-->
                <!--<li class="nav-item active">-->
                    <!--<a class="nav-link" href="index.html">-->
                        <!--<span class="fab fa-slack-hash text-light"></span>-->
                        <!--<span class="menu-title">Genarate</span>-->
                    <!--</a>-->
                <!--</li>-->
                <!--<li class="nav-item">-->
                    <!--<a class="nav-link" href="index.html">-->
                        <!--<span class="fas fa-lock text-light"></span>-->
                        <!--<span class="menu-title">Channel 1</span>-->
                    <!--</a>-->
                <!--</li>-->
                <!--<li class="nav-item">-->
                    <!--<a class="nav-link" href="index.html">-->
                        <!--<span class="fas fa-lock text-light"></span>-->
                        <!--<span class="menu-title">Channel 2</span>-->
                    <!--</a>-->
                <!--</li>-->
                <!--<li class="nav-item nav-category">-->
                    <!--<span class="nav-link">DIRECT MESSAGE</span>-->
                <!--</li>-->
                <!--<li class="nav-item">-->
                    <!--<a class="nav-link" href="pages/tables/basic-table.html">-->
                        <!--<span class="fas fa-user text-light"></span>-->
                        <!--<span class="menu-title">User 1</span>-->
                    <!--</a>-->
                <!--</li>-->
                <!--<li class="nav-item">-->
                    <!--<a class="nav-link" href="pages/tables/basic-table.html">-->
                        <!--<span class="fas fa-user text-light"></span>-->
                        <!--<span class="menu-title">User 2</span>-->
                    <!--</a>-->
                <!--</li>-->
                <!--<li class="nav-item">-->
                    <!--<a class="nav-link" href="pages/tables/basic-table.html">-->
                        <!--<span class="fas fa-user text-light"></span>-->
                        <!--<span class="menu-title">User 3</span>-->
                    <!--</a>-->
                <!--</li>-->
            <!--</ul>-->

            <!--<form class="form-inline" action="/action_page.php">-->
                <!--<input class="form-control mr-sm-2" type="text" placeholder="Search">-->
                <!--<button class="btn btn-success" type="submit">Search</button>-->
            <!--</form>-->
        <!--</div>-->
    <!--</nav>-->
    <nav class="navbar navbar-expand-md bg-light navbar-light">
        <!-- Brand -->
        <a class="navbar-brand ml-3" href="#">
            <strong id="Channelname">Channel Name</strong>
            <small><span class="far fa-user mx-2"></span><span id="member-number">5</span></small>

            <span class="mx-3 dropdown" data-toggle="collapse" data-target="#settingDropdown">
                <span class="fas fa-cogs"></span>
                <div id="settingDropdown" class="dropdown-menu navbar-dropdown preview-list  dropdownAnimation" aria-labelledby="notificationDropdown">
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
            </span>
            <span class="dropdown d-md-none" data-toggle="collapse" data-target="#preferencesDropdown">
                    <img src="/images/faces/face4.jpg" class="rounded-circle" style="width: 50px;height:50px" alt="profile-img">
                    <span class="online-status online bg-success"></span>
                    <div id="preferencesDropdown" class="dropdown-menu navbar-dropdown preview-list  dropdownAnimation">
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
                </span>

        </a>

        <!-- Toggler/collapsibe Button -->
        <button class="navbar-toggler mr-3" type="button" data-toggle="collapse" data-target="#navbarSupportedConten">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="navbarSupportedConten">
            <ul class="navbar-nav d-md-none">
                <li class="nav-item nav-category">
                    <a class="nav-link" style="cursor:pointer" @click="newchannel()">CHANNELS<span class="fas fa-plus-circle float-right"></span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="index.html">
                        <span class="fab fa-slack-hash text-light"></span>
                        <span class="menu-title">Genarate</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.html">
                        <span class="fas fa-lock text-light"></span>
                        <span class="menu-title">Channel 1</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.html">
                        <span class="fas fa-lock text-light"></span>
                        <span class="menu-title">Channel 2</span>
                    </a>
                </li>
                <li class="nav-item nav-category">
                    <span class="nav-link">DIRECT MESSAGE</span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pages/tables/basic-table.html">
                        <span class="fas fa-user text-light"></span>
                        <span class="menu-title">User 1</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pages/tables/basic-table.html">
                        <span class="fas fa-user text-light"></span>
                        <span class="menu-title">User 2</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pages/tables/basic-table.html">
                        <span class="fas fa-user text-light"></span>
                        <span class="menu-title">User 3</span>
                    </a>
                </li>
            </ul>

            <span class="dropdown ml-auto d-sm-none d-md-block" data-toggle="collapse" data-target="#preferencesDropdown">
                    <img src="/images/faces/face4.jpg" class="rounded-circle" style="width: 50px;height:50px" alt="profile-img">
                    <span class="online-status online bg-success"></span>
                    <div id="preferencesDropdown" class="dropdown-menu navbar-dropdown preview-list  dropdownAnimation">
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
                </span>
            <form class="form-inline p-3 searchForm" action="/action_page.php">
                <input class="form-control" type="text" placeholder="Search">
                <button class="btn btn-success" type="submit">Search</button>
            </form>
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
