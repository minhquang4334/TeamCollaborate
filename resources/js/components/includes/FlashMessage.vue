<template>
    <div class="flash-message">
        <div class="cover warning active">
            {{ contentPopup }}
        </div>
    </div>
</template>

<script>
  export default {
    props: ['content', 'status'],

    watch: {
      content: function (value) {
        this.contentPopup = value;
      }
    },

    methods: {},

    data() {
      return {
        contentPopup: this.content,
      }
    },
  }
</script>