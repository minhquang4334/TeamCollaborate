<template>
    <div class="px-0 py-3 bg-white rounded box-shadow message-list overflow-auto" id="list-message-0">
        <el-button type="text"
                   v-if="hasMoreCommentsToLoad"
                   @click="loadMoreComments">
            Load More Threads ({{ listMessages.length - listLimit }} more threads)
        </el-button>
        <message-item
                :list="c"
                :comments-order="'hot'"
                :creatorId="creatorId"
                :full="true"
                v-for="(c, index) in listShowThreads"
                :key="c.id + '---' + index"
                :is_children="false"
                @comment="showComment"
                @showProfile="showProfile"
                @removeUser="removeUser"/>
    </div>
</template>
<script>
  import MessageItem from "./Message.vue"

  export default {
    props: ['listMessages', 'creatorId'],
    data() {
      return {
        listLimit: 6,
      }
    },

    components: {
      MessageItem
    },

    computed: {
      hasMoreCommentsToLoad() {
        return this.listMessages.length > this.listLimit;
      },

      listShowThreads() {
        let start = this.listMessages.length - this.listLimit;
        if(start < 0) {
          start = 0;
        }
        return this.listMessages.slice(start, this.listMessages.length);
      }

    },

    created() {
      this.$eventHub.$on('showPinItem', this.showPinnedItem);
      this.$eventHub.$on('uploadFile', this.uploadFile);
    },

    beforeDestroy() {
      this.$eventHub.$off('uploadFile', this.uploadFile);
    },

    methods: {
      showPinnedItem(postId) {
        let pinItem = this.listMessages.filter(m => m.id == postId)[0];
        let start = this.listMessages.length - this.listLimit;
        if(pinItem) {
          let index = this.listMessages.indexOf(pinItem);
          if(index > -1) {
            if(start > index) {
              this.listLimit = this.listMessages.length - index;
            }
            setTimeout(() => {
              if(document.getElementById('comment' + postId)) {
                document.getElementById('comment' + postId).scrollIntoView();
                let element = document.getElementById('comment' + postId);
                element.className += ' background-pinned'
                console.log(element.className);
                console.log(element.style.backgroundColor);
                setTimeout(() => {
                  element.classList.remove('background-pinned')
                }, 3000)
              }
            }, 500)

          }
        }
      },

      uploadFile(file) {
        console.log('file: ', file);
        let upLoadFile = this.listMessages.filter(m => (m.id == file.post_id))[0];
        console.log('fileUploaded: ', upLoadFile);
        if(upLoadFile) {
          upLoadFile.files.data.push(file);
        }
      },

      loadMoreComments() {
        this.listLimit += 6;
      },

      showComment(list) {
        this.$emit("showComment", list)
      },

      showProfile(user) {
        this.$emit("showProfile", user)
      },

      removeUser() {
        this.$emit("removeUser")
      },

    }
  }

</script>
