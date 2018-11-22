<template>
    <div class="row p-3 h-100">
        <div class="col-md-8 h-100 border-right">
            <message-list :listMessages="listMessages"/>
            <comment-form @postComment="addNewComment"/>
        </div>
        <div class="col-md-4 h-100 d-none d-md-block">
            <about-channel/>
        </div>
    </div>
</template>
<script>
    import NewMessage from "./NewMessage.vue"
    import CommentForm from "../../includes/CommentForm.vue"
    import MessageList from "./MessageList.vue"
    import AboutChannel from "./AboutChannel.vue"
    import Thread from "./Thread.vue"
    export default {
      data() {
        return {
          listMessages: [
            {
              id: 1,
              author: {
                avatar: '/images/default-avatar.png',
                username: 'admin'
              },
              content: {
                text: ':kissing: hahahha cai do ngu nhat the gioi'
              },
              children: [],
              parent_id: null,
              created_at: '2018-11-09 05:54:55'
            },
            {
              id: 2,
              author: {
                avatar: '/images/default-avatar.png',
                username: 'admin'
              },
              content: {
                text: ':kissing: hahahha cai do ngu nhat the gioi'
              },
              children: [],
              parent_id: null,
              created_at: '2018-11-09 05:54:55'
            },
            {
              id: 3,
              author: {
                avatar: '/images/default-avatar.png',
                username: 'admin'
              },
              content: {
                text: ':kissing: hahahha cai do ngu nhat the gioi'
              },
              children: [],
              parent_id: null,
              created_at: '2018-11-09 05:54:55'
            },
            {
              id: 4,
              author: {
                avatar: '/images/default-avatar.png',
                username: 'admin'
              },
              content: {
                text: ':kissing: hahahha cai do ngu nhat the gioi'
              },
              children: [],
              parent_id: null,
              created_at: '2018-11-09 05:54:55'
            }
          ]
        }
      },
        components:{

            NewMessage,
            MessageList,
            AboutChannel,
            Thread,
            CommentForm
        },
      methods: {
          addNewComment(cmt) {
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
            this.listMessages.unshift(newComment);
          },
        guidGenerator() {
          let S4 = function() {
            return (((1+Math.random())*0x10000)|0).toString(16).substring(1);
          };
          return (S4()+S4()+"-"+S4()+"-"+S4()+"-"+S4()+"-"+S4()+S4()+S4());
        }
      }

    }
</script>
