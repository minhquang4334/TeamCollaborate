<template>
    <el-dialog
            title="Report Comment"
            :visible="visible"
            :width="isMobile ? '99%' : '600px'"
            @close="close"
            append-to-body
            class="user-select"
    >
        <el-form label-position="top" label-width="10px">
            <p>
                Please help us understand the problem. What is wrong with this comment?
            </p>

            <el-form-item label="Subject">
                <el-select v-model="subject" placeholder="Subject">
                    <el-option
                            v-for="item in subjects"
                            :key="item"
                            :label="item"
                            :value="item">
                    </el-option>
                </el-select>
            </el-form-item>

            <el-form-item label="Additional Description">
                <el-input
                        type="textarea"
                        v-model="description"
                        placeholder="(optional) Additional desciption..."
                        name="description"
                        :maxlength="1000"
                        :rows="4"
                        ref="description"
                ></el-input>
            </el-form-item>
        </el-form>

        <!-- submit -->
        <span slot="footer" class="dialog-footer">
            <el-button type="text" @click.prevent="closeReport" size="medium" class="margin-right-1">
                Cancel
            </el-button>

            <el-button round type="success" @click="send" :loading="sending" size="medium">
                Submit
            </el-button>
        </span>
    </el-dialog>
</template>

<script>
  import Helpers from '../../mixins/Helpers';
  import {post, get} from '../../helper/request'

  export default {
    mixins: [Helpers],

    props: ['visible', 'comment'],

    data() {
      return {
        subject: "It's spam",
        description: '',
        sending: false,
        subjects: [
          "It's spam",
          "It doesn't follow channel's exclusive rules",
          "It doesn't follow Voten's general rules",
          "It's harassing me or someone that I know",
          'Other'
        ]
      };
    },

    mounted() {

    },

    beforeDestroy() {

    },

    created() {
    },

    computed: {

    },

    methods: {
      send() {
        this.sending = true;

        post(`/api/post/report`, {
            subject: this.subject,
            post_id: this.comment.id,
            description: this.description
          })
          .then(() => {
            this.$message({
              message: 'Report submitted. Thanks for caring!',
              type: 'success'
            });

            this.close();
            this.sending = false;
          })
          .catch(() => {
            this.sending = false;
          });
      },

      close() {
        this.$emit('close');
      },

      closeReport() {
        this.$emit('close');
      }
    }
  };
</script>
