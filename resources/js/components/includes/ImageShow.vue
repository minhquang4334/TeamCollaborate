<template>
    <el-dialog
            :title="`Created by ${image.creator_name} ` + image.file_name"
            :visible="visible"
            :width="isMobile ? '99%' : '600px'"
            @close="close"
            append-to-body
            class="user-select"
    >
        <img :src="image.file_path" class="img-fluid">
    </el-dialog>
</template>

<script>
  import Helpers from '../../mixins/Helpers';

  export default {
    mixins: [Helpers],

    props: ['visible', 'image'],

    beforeDestroy() {
      if (window.location.hash == '#showImage') {
        history.go(-1);
      }
    },

    created() {

    },

    methods: {
      close() {
        this.$emit('close');
      }
    }
  };
</script>
