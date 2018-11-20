<template>
    <div class="p-3 bg-white rounded box-shadow message-list overflow-auto">
        <message-item :list="c" :comments-order="'hot'" :full="true" v-for="c in listMessages" :key="c.id"/>
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

      }
    }

</script>
