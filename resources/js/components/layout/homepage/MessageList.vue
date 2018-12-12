<template>
    <div class="px-0 py-3 bg-white rounded box-shadow message-list overflow-auto">
        <message-item :list="c" :comments-order="'hot'" :full="true" v-for="c in listMessages" :key="c.id"
                      @comment="showComment" @showProfile="showProfile"/>
    </div>
</template>
<script>
    import MessageItem from "./Message.vue"
    export default {
      props: ['listMessages'],
      data() {
        return {

        }
      },

      components: {
        MessageItem
      },

      methods: {
          showComment(){
              this.$emit("showComment")
          },
          showProfile(){
              this.$emit("showProfile")
          }
      }
    }

</script>
