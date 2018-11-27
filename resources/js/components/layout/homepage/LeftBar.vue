<template>
    <div class="d-md-block d-none col-md-2 bg-side-bar pl-3 pr-0 text-white">
        <a class="navbar-brand px-3" href="#">
            <h3 class="title">ASK60</h3>
        </a>
        <ul class="menu nav flex-column">
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
    </div>

</template>
<script>
    export default {
        methods: {
            newchannel: function () {
                this.$router.push({ name: 'channel' });
            },

        },
    }
</script>
<style scoped>
    .title {
        font-weight: bold;
        color: #fff;
    }
    </style>
