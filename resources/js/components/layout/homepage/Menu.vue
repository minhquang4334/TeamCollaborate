<template>
    <ul v-bind:class="isVertical?'flex-column nav':'d-md-none navbar-nav'">
        <li class="nav-item nav-category">
            <a class="nav-link" style="cursor:pointer" @click="newchannel">CHANNELS<span class="fas fa-plus-circle float-right"></span></a>
        </li>
        <li class="nav-item cursor-pointer"
            :class="(channel_id === channel.channel_id) ? 'active' : ''"
            v-for="(channel, index) in listChannels"
            :key="index"
            @click="toChannelDetail(channel.channel_id)">
            <a class="nav-link" href="pages/tables/basic-table.html">
                <span v-bind:class="channelIconClass(channel.type)"></span>
                <span class="menu-title">{{ channel.name}}</span>
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
</template>
<script>
    import {get} from "../../../helper/request"
    export default {
        props: [
            'channel_id',
            'isVertical'
        ],
        data() {
            return {
                listChannels: [],
                listDirectUsers: [],
            }
        },



        created() {
            this.getListChannel();
        },

        computed: {

        },

        methods: {
            channelIconClass: function(type) {
                return type === 0 ? "fab fa-slack-hash text-light" : "fas fa-lock text-light";
            },

            newchannel: function () {
                this.$router.push({ name: 'channel' });
            },

            getListChannel() {
                let url = '/api/channel/my'
                get(url).then(({data}) => {
                    console.log(data);
                    this.listChannels = data.data;
                }).catch(err => {
                    console.log(err);
                })
            },

            getListDirectMessage() {

            },

            toChannelDetail(channel_id) {
                this.$router.push({
                    name: 'ChannelDetail',
                    params: {
                        id: channel_id
                    }
                })
            }



        },
    }
</script>
<style scoped>
    .title {
        font-weight: bold;
        color: #fff;
    }
    .nav-menu {
        max-height: 400px;
        overflow: auto;
    }
</style>
