<template>
    <div class="row px-3 h-90">
        <div class="col-md-8 h-100 border-right px-0">
            <message-list :listMessages="listMessages" @showComment="showComment" @showProfile="showProfile" @removeUser="removeUser"/>
            <comment-form @postComment="addNewPost" :commentors="commentors" :channel_id="channel_id"/>
        </div>
        <div class="col-md-4 h-100 d-none d-md-block">
            <about-channel v-if="rightBox===1" :channelDetail="channelDetail" @showProfile="showProfile" @removeUser="removeUser"/>
            <thread v-else-if="rightBox===2"/>
            <profile v-else/>

        </div>
        <div id="removeUser" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">

                        <h4 class="modal-title">Remove User</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>If you remove user from this channel, they will no longer be able to see any of its messages.
                            To rejoin the private channel, they will have to be re-invited.
                        </p>
                        <p>Are you sure you wish to do this?`</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" >OK</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>
<script>
    import CommentForm from "../../includes/CommentForm.vue"
    import MessageList from "./MessageList.vue"
    import AboutChannel from "./AboutChannel.vue"
    import Thread from "./Thread.vue"
    import Profile from "./Profile.vue"
    import {get} from "../../../helper/request"

    export default {
        props: ['channel', 'rightBox'],

        data() {
            return {
                channel_id: this.$route.params.id ? this.$route.params.id : 0,
                commentors: [],
                number_items: 0,
                channelDetail: {
                    listUsers: [],
                    listFile: [],
                    listPinItems: [],
                    channelPurpose: '',
                    channelName: '',
                },
                listMessages: [

                ]
            }
        },

        components: {
            MessageList,
            AboutChannel,
            Thread,
            CommentForm,
            Profile
        },

        watch: {
            channel: function () {
                this.initData();
            }
        },

        mounted() {
            let self = this;
            self.getListPosts();
        },

        methods: {
            initData() {
                this.channelDetail.channelPurpose = this.channel.purpose;
                this.channelDetail.listUsers = this.channel.users.data;
                this.channelDetail.channelName = this.channel.name;
                this.commentors = this.channel.users.data;

            },

            addNewPost(cmt) {
                let newComment = {
                    id: this.guidGenerator(),
                    author: {
                        avatar: '/images/default-avatar.png',
                        username: this.$store.state.auth.user.name
                    },
                    content: {
                        text: cmt
                    },
                    children: [],
                    parent_id: null,
                    created_at: Date.now()
                }

                let channel_id = this.channel_id;
                let content = cmt;
                let url = '/api/post/add';
                this.listMessages.unshift(newComment);
            },

            getListPosts() {
                let query = 'channel_id=' + this.channel_id + '&number_items=' + this.number_items;
                let url = '/api/post/list?' + query;
                get(url).then((res) => {
                    console.log(res);
                    this.listMessages = res.data.data;
                }).catch((err) => {
                    this.$message({
                        type: 'failed',
                        message: 'Something error when update list threads!!'
                    });
                })

            },

            guidGenerator() {
                let S4 = function () {
                    return (((1 + Math.random()) * 0x10000) | 0).toString(16).substring(1);
                };
                return (S4() + S4() + "-" + S4() + "-" + S4() + "-" + S4() + "-" + S4() + S4() + S4());
            },

            showComment() {
                this.$emit('showComment');
            },
            showProfile() {
                this.$emit('showProfile');
            },
            removeUser() {
                $("#removeUser").modal("show");
            },

        }

    }
</script>
