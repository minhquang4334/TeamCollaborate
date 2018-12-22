<template>
    <div class="row px-3 h-90 position-relative">
        <div id="leftElement" class="col-md-7 h-100 border-right px-0">
            <message-list
                    :listMessages="listMessages"
                    @showComment="showComment"
                    @showProfile="showProfile"
                    :creator-id="channel.creator"
                    @removeUser="removeUser"/>
            <comment-form
                    @postComment="addNewPost"
                    :parent_id="0"
                    :commentors="commentors"
                    :channel_id="channel_id"
                    :comment_form_textarea="`post-form-textarea`"
            />
        </div>
        <div id="rightElement" class="col-md-5 h-100 ">
            <about-channel v-if="rightBox === 1"
                           :channelDetail="channelDetail"
                           @showProfile="showProfile"
                           @removeUser="removeUser"/>
            <div v-else-if="rightBox === 2" class="border-right">
                <thread class="h-80 max-h550 overflow-auto"
                        :thread="threadDetail"
                        :creator-id="channel.creator"/>
                <comment-form
                        class="margin-top-10"
                        @postComment="addNewPost"
                        :commentors="commentors"
                        :channel_id="channel_id"
                        :parent_id="threadDetail.id"
                        :comment_form_textarea="`comment-form-textarea`"/>
            </div>
            <profile
                    :profileUser="profileUser"
                    v-else/>

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
                        <button type="button" class="btn btn-success">OK</button>
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
    props: ['channel', 'rightBox', 'profileUser'],

    data() {
      return {
        channel_id: this.$route.params.id ? this.$route.params.id : 0,
        commentors: [],
        number_items: 0,
        EchoChannelAddress: 'channel.' + (this.$route.params.id ? this.$route.params.id : 'ASTEAMK60'),
        channelDetail: {
          listUsers: [],
          listFile: [],
          listPinItems: [],
          channelPurpose: '',
          channelName: '',
        },
        listMessages: [],
        threadDetail: {},
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
      },

      '$route.params.id': function() {
        this.channel_id = this.$route.params.id ? this.$route.params.id : 0
        this.getListPosts();
        this.EchoChannelAddress = 'channel.' + (this.$route.params.id ? this.$route.params.id : 'ASTEAMK60');
        this.subscribeToEcho();
      }
    },

    created() {
      this.$eventHub.$on('newPost', this.newPost);
      this.$eventHub.$on('remove-pin-thread', this.removePin);
      this.subscribeToEcho();



    },

    beforeDestroy() {
      this.$eventHub.$off('newPost', this.newPost);
      this.$eventHub.$off('remove-pin-thread', this.removePin);

    },

    mounted() {
      let self = this;
      self.getListPosts();
    },

    methods: {

      subscribeToEcho() {
        Echo.private(this.EchoChannelAddress)
          .listen('.CommentWasDeleted', (e) => {
            let deletedCommentId = e.data;
            this.echoDelete(deletedCommentId);
          })
          .listen('.CommentWasBookmarked', (e) => {
            console.log('data: ',e.data.data);
            let comment = this.listMessages.filter((m) => (m.id == e.data.data.id))[0]
            if(comment) {
              comment.type = e.data.data.type;
            }
            this.removePin(e.data.data, !e.data.data.type)
          })
          .listen('.CommentWasLiked', (e) => {
            let likedComment = e.data.data;
            let filter = this.listMessages.filter((m) => m.id == likedComment.id)[0];
            if(filter) {

            }
          })
          .listen('.FileUploaded', (e) => {
            console.log('adasdsd');
            let file = e.data.data;
            if(file) {
              this.$eventHub.$emit('uploadFile', file)
            }
          })
      },

      echoDelete(id) {
        console.log(id);
        let deletedComment = this.listMessages.filter((m) => (m.id == id))[0];
        if(deletedComment) {
          if(deletedComment.is_parent === 0) {
            this.$eventHub.$emit('remove-parent-comment');
          };
          this.$eventHub.$emit('deletedComment', deletedComment);
        }
      },

      initData() {
        this.channelDetail.channelPurpose = this.channel.purpose;
        this.channelDetail.listUsers = this.channel.users.data;
        this.channelDetail.listPinItems = this.channel.pin_posts.data;
        this.channelDetail.listFile = this.channel.files.data;
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
        }).finally(() => {
          setTimeout(() => {
            if(this.listMessages.length) {
              this.$nextTick(() => {
                let lastMessage;
                if(this.listMessages.length > 3) {
                  lastMessage = this.listMessages[this.listMessages.length - 2];
                }
                else {
                  lastMessage = this.listMessages[this.listMessages.length - 1];
                }
                if(document.getElementById('comment' + lastMessage.id)) {
                  document.getElementById('comment' + lastMessage.id).scrollIntoView();
                }
              })
            }
          }, 400)
        })

      },

      guidGenerator() {
        let S4 = function () {
          return (((1 + Math.random()) * 0x10000) | 0).toString(16).substring(1);
        };
        return (S4() + S4() + "-" + S4() + "-" + S4() + "-" + S4() + "-" + S4() + S4() + S4());
      },

      showComment(list) {
        this.$emit('showComment');
        $("#rightElement").css("z-index","1");
        this.threadDetail = list;
      },

      showProfile(user) {
        this.$emit('showProfile', user);
        $("#rightElement").css("z-index","1");
      },
      removeUser() {
        $("#removeUser").modal("show");
      },

      newPost(newPost) {
        if(this.channel.id === newPost.channel_id) {
          this.listMessages.push(newPost);
          this.$nextTick(() => {
            if(document.getElementById('comment' + newPost.id)) {
              document.getElementById('comment' + newPost.id).scrollIntoView();
            }
          })
        }
      },

      removePin(post, type) {
        if(!type) {
          if(this.channelDetail.listPinItems.length) {
            let removePin = this.channelDetail.listPinItems.filter((i) => i.id == post.id)[0];
            let index = this.channelDetail.listPinItems.indexOf(removePin);
            if(index > -1) {
              this.channelDetail.listPinItems.splice(index, 1);
            }
          }
        } else {
          let check = this.channelDetail.listPinItems.filter((i) => i.id == post.id).length;
          if(check === 0) {
            this.channelDetail.listPinItems.push(post);
          }
        }

        this.channelDetail.listPinItems.sort(this.compare)

      },

      compare(a, b) {
        if (a.created_at.date < b.created_at.date)
          return -1;
        if (a.created_at.date > b.created_at.date)
          return 1;
        return 0;
      }
    }
  }
</script>
<style>
    .max-h550 {
        max-height: 550px !important;
        overflow-y: auto;
        overflow-x: hidden;
    }

    .w-65p {
        width: 65%;
    }

    .w-35p {
        width: 35%;
    }
</style>
