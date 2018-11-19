<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light px-4">
        <a class="navbar-brand" href="#">
            <strong id="Channelname">Channel Name</strong>
            <small><span class="far fa-user mx-2"></span><span id="member-number">5</span></small>
        </a>
        <div class="dropdown">
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
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="dropdown">

                <a class="nav-link profile-image" style="cursor: pointer" data-toggle="dropdown">
                    <img src="images/faces/face4.jpg" class="rounded-circle" style="width: 50px;height:50px" alt="profile-img">
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
            </div>
            <ul class="navbar-nav mr-auto d-md-none">
                <li class="nav-item nav-category">
                    <a class="nav-link" style="cursor:pointer" @click="newchannel()">CHANNELS<span class="fas fa-plus-circle float-right"></span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.html">
                        <span class="menu-title">channel 1</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.html">
                        <span class="menu-title">Channel 2</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.html">
                        <span class="menu-title">Channel 3</span>
                    </a>
                </li>
                <li class="nav-item nav-category">
                    <span class="nav-link">DIRECT MESSAGE</span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pages/tables/basic-table.html">
                        <span class="menu-title">User 1</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pages/tables/basic-table.html">
                        <span class="menu-title">User 2</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pages/tables/basic-table.html">
                        <span class="menu-title">User 3</span>
                    </a>
                </li>
            </ul>

            <form class="form-inline" action="/action_page.php">
                <input class="form-control mr-sm-2" type="text" placeholder="Search">
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
