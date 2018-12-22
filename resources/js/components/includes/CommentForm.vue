<template>
    <div class="fixed-comment-form-wrapper new-message position-relative px-3"
         @keydown.down="handleKey($event, 'down')"
         @keydown.up="handleKey($event, 'up')"
         @keydown.enter="handleKey($event, 'enter')"
         id="comment-form">
        <div class="editing-comment-wrapper user-select"
             v-if="(editing || replying) && !loading">
            <el-tooltip content="Cancel (esc)"
                        placement="right"
                        transition="false"
                        :open-delay="500"
            >
                <div class="close"
                     @click="clear">
                    <i class="v-icon v-cancel-small"></i>
                </div>
            </el-tooltip>


            <div class="editing-comment-previous">
                <h4 class="title">
                    {{ editing ? 'Edit Comment' : replyingComment.author.username }}
                </h4>

                <div class="text"
                     v-text="editing ? str_limit(editingComment.content, 60) : str_limit(replyingComment.content, 60)">
                </div>
            </div>
        </div>

        <div v-if="preview && message"
             class="form-wrapper margin-bottom-1 preview position-absolute w-100 overflow-auto"
             style="top:-200px;left:0;z-index:1000;height: 200px">
            <button type="button" class="close align-right" @click.prevent="preview =! preview" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <markdown :text="message.trim()"></markdown>

        </div>

        <form class="chat-input-form relative" style="max-height: 75%">

            <div class="border-right" style="width:50px">
                <a class="position-absolute btn h-100">
                    <i class="fas fa-plus"></i>
                </a>
                <input type="file" id="addFile" @change="fileSelected" class="h-100 w-100 cursor-pointer"
                       style="opacity:0" multiple>
            </div>

            <transition name="el-zoom-in-bottom">
                <quick-emoji-picker v-if="quickEmojiPicker.show"
                                    @close="quickEmojiPicker.show = false"
                                    :message="message"
                                    :textareaid="comment_form_textarea"
                                    :starter="quickEmojiPicker.starter"
                                    @pick="pick"/>
            </transition>

            <transition name="el-zoom-in-bottom">
                <quick-mentioner v-if="quickMentioner.show"
                                 @close="quickMentioner.show = false"
                                 :message="message"
                                 :textareaid="comment_form_textarea"
                                 @pick="pick"
                                 :suggestions="commentors"
                                 :starter="quickMentioner.starter"/>
            </transition>

            <transition name="el-zoom-in-bottom">
                <quick-channel-picker v-if="quickChannelPicker.show"
                                      @close="quickChannelPicker.show = false"
                                      :message="message"
                                      :textareaid="comment_form_textarea"
                                      @pick="pick"
                                      :starter="quickChannelPicker.starter"/>
            </transition>

            <el-input type="textarea"
                      autosize
                      :placeholder="loading ? 'Submitting...' : 'Type your comment...'"
                      v-model="message"
                      @keydown.native="whisperTyping"
                      @keyup.native="whisperFinishedTyping"
                      :id="comment_form_textarea"
                      @keydown.meta.enter.exact.native="submit($event)"
                      @keydown.ctrl.enter.exact.native="submit($event)"
                      :disabled="loading"
                      name="comment"
                      :maxlength="5000"
                      ref="input"
                      @input="typed">
            </el-input>

            <span class="send-button comment-emoji-button"
                  v-if="isDesktop && !loading">
				<div @mouseout="closeEmojiPicker"
                     @mouseover="openEmojiPicker"
                     class="flex-center">
					<emoji-icon width="38"
                                height="38"/>

					<transition name="el-zoom-in-bottom">
						<emoji-picker v-if="emojiPicker"
                                      :textareaid="comment_form_textarea"
                                      @pick="pick"/>
					</transition>
				</div>
			</span>

            <button type="submit"
                    :class="{ 'go-green': message.trim() }"
                    @click="submit($event)">
                <el-tooltip placement="bottom-end"
                            transition="false"
                            v-show="!loading">
                    <div slot="content">
                        Press Command/Ctrl + Enter to send
                    </div>
                    <i class="v-icon v-send"
                       aria-hidden="true"></i>
                </el-tooltip>

                <moon-loader :loading="loading"
                             :size="'25px'"
                             :color="'#555'"/>
            </button>
        </form>

        <div class="flex-space user-select comment-form-guide-wrapper">
            <typing/>

            <div>
                <button class="comment-form-guide"
                        @click="preview =! preview"
                        type="button"
                        v-show="message.trim()">
                    Preview
                </button>

                <button class="comment-form-guide"
                        @click="showMarkdownGuide = true"
                        type="button">
                    Formatting Guide
                </button>
            </div>
        </div>
        <markdown-guide v-show="showMarkdownGuide" @close="showMarkdownGuide = false" :visible="showMarkdownGuide"/>
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
                        <textarea name="" id="" class="w-100" cols="30" rows="5" style="max-height:300px" v-model="message"></textarea>
                        <span class="list-group-item">{{fileName}}</span>
                        <img src="#" id="previewImage" alt="preview-image">
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" @click="clearFile" data-dismiss="modal">Close
                        </button>
                        <button type="button" class="btn btn-success" @click="submitFile">Send</button>
                    </div>

                </div>
            </div>
        </div>
    </div>

</template>

<script>
  import Markdown from './Markdown.vue';
  import MoonLoader from './MoonLoader.vue';
  import EmojiPicker from './EmojiPicker';
  import QuickEmojiPicker from './QuickEmojiPicker.vue';
  import QuickChannelPicker from './QuickChannelPicker';
  import QuickMentioner from './QuickMentioner.vue';
  import Typing from './Typing.vue';
  import Helpers from '../../mixins/Helpers';
  import InputHelpers from '../../mixins/InputHelpers.js';
  import {get, post, put} from '../../helper/request'
  import EmojiIcon from "./Icons/EmojiIcon";
  import MarkdownGuide from './MarkdownGuide'

  export default {
    components: {
      QuickChannelPicker,
      QuickEmojiPicker,
      QuickMentioner,
      MoonLoader,
      EmojiPicker,
      EmojiIcon,
      Markdown,
      Typing,
      MarkdownGuide
    },

    props: ['submission', 'before', 'commentors', 'comment_form_textarea', 'parent_id'],

    mixins: [Helpers, InputHelpers],

    data() {
      return {
        emojiPicker: false,
        loading: false,
        message: '',
        temp: '',
        mentioning: false,
        EchoChannelAddress: 'channel.' + (this.$route.params.id ? this.$route.params.id : 'ASTEAMK60'),
        isTyping: false,
        preview: false,
        showMarkdownGuide: false,
        fileName: '',

        quickMentioner: {
          show: false,
          starter: null
        },

        quickEmojiPicker: {
          show: false,
          starter: null
        },

        quickChannelPicker: {
          show: false,
          starter: null
        },

        editingComment: [],
        replyingComment: [],
        parent: 0,
        list_tag_users: [],
        channel_id: this.$route.params.id ? this.$route.params.id : 0,
        files : null,
        number_file_send: 0,
        currentUser: this.$store.state.auth.user,
        isSubmitFile: false,
      };
    },

    created() {
      console.log(Echo);
      this.subscribeToEcho()

      this.$eventHub.$on('edit-comment', this.setEditing);
      this.$eventHub.$on('reply-comment', this.setReplying);
      this.$eventHub.$on('pressed-esc', this.handleEscapteKeyup);
    },

    beforeDestroy() {
      this.$eventHub.$off('edit-comment', this.setEditing);
      this.$eventHub.$off('reply-comment', this.setReplying);
      this.$eventHub.$off('pressed-esc', this.handleEscapteKeyup);
    },

    mounted() {
      this.$nextTick(function () {

      })

    },

    watch: {
      $route() {
        this.clear();
      },

      '$route.params.id': function() {
        this.channel_id = this.$route.params.id ? this.$route.params.id : 0;
        this.EchoChannelAddress = 'channel.' + (this.$route.params.id ? this.$route.params.id : 'ASTEAMK60');
        this.subscribeToEcho();

      }

    },

    computed: {
      replying() {
        return !_.isEmpty(this.replyingComment);
      },

      editing() {
        return !_.isEmpty(this.editingComment);
      },

      showSubmit() {
        return this.loading == false && this.message.trim();
      }
    },

    methods: {
      readURL(file) {
        let reader = new FileReader();
        reader.onload = function (event) {
          $('#previewImage').attr('src', event.target.result);
        }
        reader.readAsDataURL(file);
      },

      fileSelected(e) {
        this.files = e.target.files;
        $("#fileModal").modal("show");

        console.log('file: ', this.files);
        if (this.files.length) {
          this.readURL(this.files[0]);
          this.fileName = this.files[0].name
        }
      },

      clearFile() {
        $("#addFile").val('');
      },

      submitFile() {
        this.isSubmitFile = true;
        this.submit();
      },

      typed(string) {
        // close on empty input
        if (!string.trim()) {
          this.quickMentioner.show = false;
          this.quickEmojiPicker.show = false;
          this.quickChannelPicker.show = false;
          return;
        }

        // get the last typed character (but not the last character of the string)
        let lastStrIndex = this.lastTypedCharacter(this.comment_form_textarea);
        let lastStr = string[lastStrIndex];
        // let previousStr = string[lastStrIndex - 1];

        // close on space
        if (lastStr == ' ') {
          this.quickMentioner.show = false;
          this.quickEmojiPicker.show = false;
          this.quickChannelPicker.show = false;
          return;
        }

        // previous must be empty space to continue
        // if (previousStr != ' ' && string.length > 1) return;

        if (lastStr == '@') {
          this.quickMentioner.show = true;
          this.quickMentioner.starter = lastStrIndex;

          this.quickEmojiPicker.show = false;
          this.quickChannelPicker.show = false;
        } else if (lastStr == ':') {
          this.quickEmojiPicker.show = true;
          this.quickEmojiPicker.starter = lastStrIndex;

          this.quickMentioner.show = false;
          this.quickChannelPicker.show = false;
        } else if (lastStr == '#') {
          this.quickChannelPicker.show = true;
          this.quickChannelPicker.starter = lastStrIndex;

          this.quickEmojiPicker.show = false;
          this.quickMentioner.show = false;
        }
      },

      /**
       * Subscribes to the Echo channel. Prepares comment form for whispering "typing".
       *
       * @return void
       */
      subscribeToEcho() {
        Echo.private(this.EchoChannelAddress)
          .listen('.CommentWasCreated', (e) => {
            let newComment = e.data.data;
            if(newComment.is_parent === 0) {
              this.$eventHub.$emit('newPost', newComment);
            } else {
              this.$eventHub.$emit('newComment', newComment);
            }
          })
          .listen('.CommentWasPatched', (e) => {
            let newComment = e.data.data;
            this.$eventHub.$emit('patchedComment', newComment)
          })
      },

      /**
       * Broadcast "typing".
       *
       * @return void
       */
      whisperTyping() {
        if (this.isGuest) return;

        if (this.isTyping) return;

        if (this.editing) return;

        Echo.private(this.EchoChannelAddress).whisper('typing', {
          username: this.currentUser.name
        });

        this.isTyping = true;
      },

      /**
       * Broadcast "finished-typing".
       *
       * @return void
       */
      whisperFinishedTyping: _.debounce(function () {
        if (this.isGuest) return;

        Echo.private(this.EchoChannelAddress).whisper('finished-typing', {
          username: this.currentUser.name
        });

        this.isTyping = false;
      }, 600),

      handleKey(event, key) {
        if (
          !this.quickEmojiPicker.show &&
          !this.quickMentioner.show &&
          !this.quickChannelPicker.show
        )
          return;

        event.preventDefault();

        this.$eventHub.$emit('keyup:' + key);
      },

      setEditing(comment) {
        this.clear();
        if(!this.parent_id) {
          this.editingComment = comment;
          this.message = this.editingComment.content;
          this.parent = this.editingComment.parent_id;

          this.$refs.input.focus();
        }
      },

      setReplying(comment) {
        this.clear();

        this.replyingComment = comment;
        this.parent = this.replyingComment.id;

        this.$refs.input.focus();
      },

      handleEscapteKeyup() {
        if (this.quickEmojiPicker.show) {
          this.quickEmojiPicker.show = false;
        } else if (this.quickMentioner.show) {
          this.quickMentioner.show = false;
        } else if (this.quickChannelPicker.show) {
          this.quickChannelPicker.show = false;
        } else {
          if (
            !_.isEmpty(this.editingComment) ||
            !_.isEmpty(this.replyingComment)
          ) {
            this.clear();
          }
        }
      },

      /**
       * Like it never happened!
       *
       * @return void
       */
      clear() {
        this.editingComment = [];
        this.replyingComment = [];
        this.message = '';
        this.loading = false;
        this.preview = false;
        this.parent = 0;
        this.fileName = ''
      },

      pick(pickedStr, starterIndex, typedLength, type = '', user = null) {
        this.insertPickedItem(
          this.comment_form_textarea,
          pickedStr + ' ',
          starterIndex,
          typedLength
        );
        if (type === 'mention') {
          this.list_tag_users.push(user.id);
        }
      },

      openEmojiPicker() {
        this.emojiPicker = true;
      },

      closeEmojiPicker() {
        this.emojiPicker = false;
      },

      submit(event) {
        if(!this.isSubmitFile) {
          event.preventDefault();
        }

        // ignore if any quick pciking box is open
        if (
          this.quickEmojiPicker.show ||
          this.quickMentioner.show ||
          this.quickChannelPicker.show ||
          !this.message.trim()
        )
          return;

        this.closeEmojiPicker();

        if (this.isGuest) {
          this.mustBeLogin();
          return;
        }

        this.temp = this.message;
        this.message = '';

        this.loading = true;

        // we're editing, not posting a new comment
        if (this.editing) {
          if (this.temp == this.before) {
            this.message = this.temp;
            this.loading = false;
            this.$eventHub.$emit('patchedComment', this.editingComment);

            return;
          }

          this.patchComment();
          return;
        }

        // new comment
        this.postComment();
      },

      patchComment() {
        put(`/api/post/edit`, {
          content: this.temp,
          post_id: this.editingComment.id
        })
          .then((res) => {
            this.editingComment.content = this.temp;
            this.$eventHub.$emit('patchedComment', this.editingComment);
            if(this.isSubmitFile) {
              this.upload(this.editingComment.id);
            }
          })
          .catch((error) => {
            this.loading = false;
            this.message = this.temp;

          }).finally(() => {
          this.clear();
        })
        ;
      },

      postComment() {
        this.loading = true;
        let payload = {};
        if(!this.parent_id) {
          payload = {
            parent_id: this.parent_id,
            content: this.temp,
            channel_id: this.channel_id,
            tag_users: this.list_tag_users,
          }
        } else {
          payload = {
            parent_id: this.parent_id,
            content: this.temp,
            tag_users: this.list_tag_users,
          }
        }
        post(`/api/post/add`, payload)
          .then((response) => {
            if(!this.parent_id) {
              this.$eventHub.$emit('newPost', response.data.data);
            } else {
              this.$eventHub.$emit('newComment', response.data.data);
            }
            if(this.isSubmitFile) {
              if(response.data.data) {
                this.upload(response.data.data.id);
              }
            }
          })
          .catch((error) => {
            this.loading = false;
            this.message = this.temp;
          }).finally(() => {
          this.clear();
        });
      },

      upload(postId) {
        $('#fileModal').modal('toggle');
        let formData = new FormData();
        formData.append('file', this.files[0]);
        let url = '/api/file/upload'
        let channel_id = this.$route.params.id ? this.$route.params.id : 'ASTEAMK60';
        formData.append('channel_id', channel_id)
        formData.append('post_id', postId);
        post(url, formData)
          .then((response) => {
            //location.reload();
            this.$eventHub.$emit('uploadFile', response.data.data);
          })
          .catch((error) => {
            console.log(error);
            this.$message({
              type: 'error',
              message: 'Some thing error when uploading file'
            });
          }).finally(() => {
            this.isSubmitFile = false;
        });
      }
    }
  }
</script>
