<template>
    <div class="d-md-block d-none col-md-2 bg-dark px-3 text-white">
        <a class="navbar-brand px-3" href="#">
            <h3>Team Collaborate</h3>
        </a>
        <ul class="nav flex-column">
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
