<template>
    <div>
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">
                <li class="nav-item nav-category">
                    <span class="nav-link">Channels <a class="fas fa-plus-circle" style="cursor:pointer" @click="newchannel()"></a></span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.html">
                        <span class="menu-title">channel 1</span>
                        <i class="icon-speedometer menu-icon"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.html">
                        <span class="menu-title">Channel 2</span>
                        <i class="icon-speedometer menu-icon"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.html">
                        <span class="menu-title">Channel 3</span>
                        <i class="icon-speedometer menu-icon"></i>
                    </a>
                </li>
                <li class="nav-item nav-category">
                    <span class="nav-link">Direct Message</span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pages/tables/basic-table.html">
                        <span class="menu-title">User 1</span>
                        <i class="icon-grid menu-icon"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pages/tables/basic-table.html">
                        <span class="menu-title">User 2</span>
                        <i class="icon-grid menu-icon"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pages/tables/basic-table.html">
                        <span class="menu-title">User 3</span>
                        <i class="icon-grid menu-icon"></i>
                    </a>
                </li>

            </ul>
        </nav>
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
