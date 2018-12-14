<template>
    <div class="bg-white rounded box-shadow thread h-80 overflow-hidden">
        <message-item
                :list="thread"
                :comments-order="'hot'"
                :full="true"
                :creatorId="creatorId"
                :is_children="true"
                @showProfile="showProfile"
                @removeUser="removeUser"/>
    </div>
</template>
<script>
    import CommentForm from '../../includes/CommentForm'
    import MessageItem from "./Message.vue"
    export default {
      props: ['thread', 'creatorId'],
      components: {
        CommentForm,
        MessageItem
      },

      methods: {
        showProfile(){
          this.$emit("showProfile")
        },
        removeUser(){
          this.$emit("removeUser")
        }
      }
    }
</script>

<style scoped>
    .max-h350{
        max-height: 350px !important;
    }
    </style>