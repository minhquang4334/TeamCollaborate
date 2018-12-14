<template>
    <div class="px-0 py-3 bg-white rounded box-shadow message-list overflow-auto" id="list-message-0">
        <message-item
                :list="c"
                :comments-order="'hot'"
                :full="true"
                v-for="c in listMessages"
                :key="c.id"
                :is_children="false"
                @comment="showComment"
                @showProfile="showProfile"
                @removeUser="removeUser"/>
    </div>
</template>
<script>
  import MessageItem from "./Message.vue"

  export default {
    props: ['listMessages'],
    data() {
      return {}
    },

    components: {
      MessageItem
    },

    created() {

    },

    methods: {
      showComment(list) {
        this.$emit("showComment", list)
      },

      showProfile() {
        this.$emit("showProfile")
      },

      removeUser() {
        this.$emit("removeUser")
      },

    }
  }

</script>
