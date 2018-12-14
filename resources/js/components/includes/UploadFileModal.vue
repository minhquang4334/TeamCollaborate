<template>
    <div class="modal" id="fileModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Upload a file</h4>
                    <button type="button" @click="clearFile" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <comment-form :commentors="commentors" :channel_id="channel_id" />

                    <p>Filename</p>
                    <span class="list-group-item">file.txt</span>
                    <img src="#" id="previewImage" alt="preview-image">
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" @click="clearFile" data-dismiss="modal">Close
                    </button>
                    <button type="button" class="btn btn-success">Send</button>
                </div>

            </div>
        </div>
    </div>
</template>
<script>
  import CommentForm from './CommentForm.vue'

  export default {
      components: {
        CommentForm
      }
    }
</script>