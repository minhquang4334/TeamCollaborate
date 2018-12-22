<template>
    <transition name="el-fade-in-linear">
        <div class="comment v-comment-wrapper"
             v-show="visible"
             @mouseover="seen"
             :id="'comment' + list.id"
             :class="bookmarked ? `background-bookmark` : ``"
             >
            <div class="content"
                 @dblclick="doubleClicked">
                <div class="v-comment-info">
                    <div class="display-flex">
                        <div class="left">
                            <router-link :to="'/' + '@' + list.creator.data.name"
                                         class="avatar user-select">
                                <img v-bind:src="list.creator.data.avatar">
                            </router-link>
                            <span class="dropdown" data-toggle="collapse" data-target="">
                                <a style="cursor: pointer" data-toggle="dropdown">
                                    <strong class="ml-3">@{{ list.creator.data.name }}</strong>
                                </a>
                                <div class="dropdown-menu navbar-dropdown dropdownAnimation p-0" style="width:300px">
                                    <div class="card">
                                      <img class="card-img-top" v-bind:src="list.creator.data.avatar"
                                           alt="Card image cap">
                                      <div class="card-body">
                                        <h5 class="card-title">{{ list.creator.data.name }}</h5>
                                        <ul class="nav flex-column">
                                            <li class="nav-item cursor-pointer lighter-on-hover" @click.prevent="showProfile(list.creator.data)"><span>View profile</span></li>
                                            <li class="nav-item cursor-pointer lighter-on-hover" v-show="showDirectMess"><span @click="directMess(list.creator.data)">Direct Message</span></li>
                                            <li class="nav-item cursor-pointer lighter-on-hover" v-show="showDeleteUser"><span href="#" @click="removeUser(list.creator.data)">Remove User </span></li>
                                        </ul>
                                      </div>
                                    </div>

                                </div>

                            </span>

                            <span class="separator">
								&#183;
							</span>
                            <a class="like-button"
                               @click="like">
                                <i class="v-icon"
                                   :class="liked ? 'v-heart-filled go-red animated bounceIn' : 'v-heart go-gray'"></i>

                                <span class="count">{{ points }}</span>
                            </a>
                            <template v-if="!is_children">
                                <a class="like-button"
                                   @click.prevent="showComment">
                                    <i class="far fa-comment-dots text-muted"></i>
                                </a>

                                <el-tooltip :content="bookmarked ? 'Unbookmark' : 'Bookmark'"
                                            placement="top"
                                            transition="false"
                                            v-show="isShowBookMark"
                                            :open-delay="500">
                                    <i class="v-icon margin-left-1"
                                       :class="{ 'go-yellow v-unbookmark': bookmarked, 'v-bookmark': !bookmarked }"
                                       @click="bookmark"></i>
                                </el-tooltip>

                                <el-tooltip content="Reply"
                                            placement="top"
                                            transition="false"
                                            :open-delay="500">
                                    <i class="v-icon v-reply margin-left-1"
                                       @click="commentReply"
                                       v-if="list.nested_level < 8 && full"></i>
                                </el-tooltip>

                                <el-tooltip content="Submission"
                                            placement="top"
                                            transition="false"
                                            :open-delay="500">
                                    <a class="reply margin-left-1"
                                       v-if="!full"
                                       @click.prevent="openOrigin">
                                        <i class="v-icon v-link h-purple"></i>
                                    </a>
                                </el-tooltip>

                                <el-button size="mini"
                                           class="margin-left-1"
                                           v-if="owns && full"
                                           @click="edit"
                                           round>
                                    Edit
                                </el-button>
                            </template>
                        </div>
                    </div>

                    <div class="actions-right">
                        <el-tooltip :content="'Edited: ' + editedDate"
                                    placement="top"
                                    transition="false"
                                    :open-delay="500"
                                    v-if="isEdited">
							<span class="edited go-gray">
								Edited
							</span>
                        </el-tooltip>

                        <span class="separator"
                              v-if="isEdited">
							&#183;
						</span>

                        <el-tooltip :content="'Created: ' + longDate"
                                    placement="top"
                                    transition="false"
                                    :open-delay="500">
                            <a class="date margin-right-1"
                               @click.prevent="openOrigin">
                                {{ date }}
                            </a>
                        </el-tooltip>

                        <el-dropdown size="mini"
                                     type="primary"
                                     trigger="click"
                                     :show-timeout="0"
                                     :hide-timeout="0">
                            <i class="el-icon-more-outline"></i>

                            <el-dropdown-menu slot="dropdown">
                                <el-dropdown-item v-if="!owns"
                                                  @click.native="report">
                                    Report
                                </el-dropdown-item>

                                <el-dropdown-item class="go-red"
                                                  @click.native="destroy"
                                                  v-if="canDelete">
                                    Delete
                                </el-dropdown-item>

                                <el-dropdown-item class="go-green"
                                                  @click.native="approve"
                                                  v-if="showApprove"
                                                  divided>
                                    Approve
                                </el-dropdown-item>

                                <el-dropdown-item class="go-red"
                                                  @click.native="disapprove"
                                                  v-if="showDisapprove">
                                    Delete
                                </el-dropdown-item>
                            </el-dropdown-menu>
                        </el-dropdown>
                    </div>
                </div>

                <div class="text ml-5">
                    <markdown :text="list.content"></markdown>

                </div>
                <template v-if="list.files.data.length">
                    <div class="comment-image m-auto" v-if="list.files.data[0].is_image" @click="showImage(list.files.data[0])">
                        <img :src="list.files.data[0].file_path" class="img-fluid">
                    </div>
                    <div v-else>
                        <span class="cursor-pointer link-color" @click="download(list.files.data[0])">
                        {{list.files.data[0].file_name}}
                        </span>
                    </div>
                </template>

                <div class="media cursor-pointer margin-top-10" v-show="!is_children && list.number_children_posts">
                    <p class="media-body small ml-5" @click.prevent="showComment">
                        <strong class="d-block text-gray-dark">{{list.number_children_posts}} reply <i class="fas fa-reply"></i></strong>

                    </p>
                </div>
            </div>
            <image-show
                    v-show="isShowImage"
                    :image="imageShow"
                    @close="isShowImage = false"
                    :visible="isShowImage"/>
            <div class="comments"
                 v-if="isShowChild">
                <message :list="c"
                         v-for="c in sortedComments"
                         :is_children="true"
                         :key="c.id"
                         :full="full"/>
            </div>
            <el-button type="text"
                       v-if="hasMoreCommentsToLoad"
                       @click="loadMoreComments">
                Load More Comments ({{ children.length - childrenLimit }} more replies)
            </el-button>
            <report-comment
                    @close="closeReport"
                    :visible="isReportComment"
                    :comment="commentReport"/>
        </div>
    </transition>
</template>


<script>
  import Markdown from '../../includes/Markdown.vue';
  import ImageShow from '../../includes/ImageShow.vue';
  import ReportComment from '../../includes/ReportComment.vue';
  import Helpers from '../../../mixins/Helpers';
  import {get, put, post, del} from '../../../helper/request'

  export default {
    name: 'message',

    props: ['list', 'comments-order', 'full', 'is_children', 'creatorId'],

    components: {
      Markdown,
      ReportComment,
      ImageShow
    },

    mixins: [Helpers],

    data() {
      return {
        isShowImage: false,
        editing: false,
        body: this.list.content.text,
        visible: true,
        reply: false,
        childrenLimit: 6,
        highlighted: false,
        currentUser: this.$store.state.auth.user,
        children: [],
        commentReport: {},
        isReportComment: false,
        react: [],
        imageShow: {},
        EchoChannelAddress: 'channel.' + (this.$route.params.id ? this.$route.params.id : 'ASTEAMK60'),


      };
    },

    created() {

      if (_.isUndefined(this.children)) {
        this.children = [];
      }
      this.$eventHub.$on('newComment', this.newComment);
      this.$eventHub.$on('patchedComment', this.patchedComment);
      this.$eventHub.$on('deletedComment', this.deletedComment);
    },

    beforeDestroy() {
      this.$eventHub.$off('newComment', this.newComment);
      this.$eventHub.$off('patchedComment', this.patchedComment);
      this.$eventHub.$off('deletedComment', this.deletedComment);
    },

    watch: {
      'list': function() {
        this.loadComment();
        this.react = this.list.react.data;
      },

      '$route.params.id': function () {
        this.EchoChannelAddress = 'channel.' + (this.$route.params.id ? this.$route.params.id : 'ASTEAMK60');
        this.subscribeToEcho();
      }
    },

    mounted() {
      this.$nextTick(() => {
        this.setHighlighted();
        this.scrollToComment();
        if(this.is_children) {
          this.loadComment()
        }
        this.react = this.list.react.data;
      });
    },

    computed: {
      isShowBookMark: function() {
        if(this.creatorId === 0) {
          return true;
        }
        return this.creatorId === this.currentUser.id;
      },

      isShowChild: function() {
        return this.children.length > 0;
      },

      url() {
      },

      liked: function() {
        if(this.react) {
          let check = false;
          this.react.forEach((r) => {
            if((r.user_id === this.currentUser.id) && (r.react_code === 'like')) {
              check = true;
            }
          })
          return check
        }
      },

      comment() {
        this.$emit('comment');
      },

      bookmarked: function () {
        return this.list.type === 1;
      },

      isParent() {
        return this.list.parent_id === null;
      },

      highlightClass() {
        if (this.highlighted && !this.isParent) {
          return 'child-broadcasted-comment';
        }

        if (this.highlighted && this.isParent) {
          return 'broadcasted-comment';
        }

        return '';
      },

      isEdited() {
        return this.list.edited_at;
      },

      editedDate() {
        return this.parseFullDate(this.list.edited_at);
      },

      points() {
        let listLike = this.list.react.data.filter((r) => r.react_code === 'like');
        return listLike.length;
      },

      canDelete() {
        return this.owns || !this.showDeleteUser;
      },
      /**
       * Does the auth user own the submission
       *
       * @return Boolean
       */
      owns() {
        return this.currentUser.id === this.list.creator.data.id;
      },

      /**
       * is there more children to load
       *
       * @return bool
       */
      hasMoreCommentsToLoad() {
        return this.children.length > this.childrenLimit;
      },

      /**
       * The sorted version of comments
       *
       * @return {Array} comments
       */
      sortedComments() {
        return _.orderBy(this.uniqueList, this.commentsOrder, 'desc').slice(0, this.childrenLimit);
      },

      /**
       * Due to the issue with duplicate notifiactions (cuz the present ones have diffrent
       * timestamps) we need a different approch to make sure the list is always unique.
       * This ugly coded methods does it! Maybe move this to the Helpers.js mixin?!
       *
       * @return object
       */
      uniqueList() {
        let unique = [];
        let temp = [];

        this.children.forEach(function (element, index, self) {
          if (temp.indexOf(element.id) === -1) {
            unique.push(element);
            temp.push(element.id);
          }
        });

        return unique;
      },

      date() {
        return moment(this.list.created_at.date)
          .fromNow(true);
      },

      /**
       * Calculates the long date to display for hover over date.
       *
       * @return String
       */
      longDate() {
        return this.parseFullDate(this.list.created_at.date);
      },

      /**
       * whether or not the approve button shoud be displayed
       *
       * @return boolean
       */
      showApprove() {
        return (
          !this.list.approved_at &&
          (this.$store.state.moderatingAt.indexOf(this.list.channel_id) != -1 || meta.isVotenAdministrator) &&
          !this.owns
        );
      },

      showDirectMess() {
        return this.list.creator.data.id !== this.currentUser.id;
      },

      showDeleteUser() {
        return this.currentUser.id !== this.creatorId
      },

      /**
       * whether or not the disapprove button shoud be displayed
       *
       * @return boolean
       */
      showDisapprove() {
        return (
          !this.list.disapproved_at &&
          (this.$store.state.moderatingAt.indexOf(this.list.channel_id) != -1 || meta.isVotenAdministrator) &&
          !this.owns
        );
      }
    },

    methods: {

      showImage(image) {
        this.isShowImage = true;
        this.imageShow = image;
      },

      subscribeToEcho() {

      },


      directMess(user) {
        let type = 2;
        let invited_users = [];
        invited_users.push(user.id);
        let name = this.currentUser.name + ', ' + user.name;
        let payload = {
          type : type,
          purpose: 'Direct Messages between ' + name,
          description: '',
          name: name,
          invited_users: invited_users
        }
        let url = '/api/channel/create'
        post(url, payload).then((res) => {
          console.log('res: ', res);
          if(res.data.data) {
            this.$router.push({
              name: 'ChannelDetail',
              params: {
                id: res.data.data.channel_id
              }
            })
            this.$eventHub.$emit('newDirectMessage', res.data.data);
          }
        }).catch((err) => {
          console.log('err: ', err);
          this.$message({
            type: 'error',
            message: 'Something error: ', err
          })
        })
      },

      removeUser(user) {

      },

      openOrigin() {
        app.$Progress.start();

        get(`/submissions/${this.list.submission_id}`)
          .then(response => {
            this.$router.push(this.submissionUrl(response.data.data));

            app.$Progress.finish();
          })
          .catch(error => {
            app.$Progress.fail();
          });
      },

      echoDelete(id) {

      },

      loadComment() {
        if(!this.list.is_parent) {
          this.children = [];
          let url = '/api/post/list-comment?post_id=' +  + this.list.id
          get(url).then((res) => {
            console.log('res: ', res);
            res.data.data.forEach((c) => {
              this.children.unshift(c);
            })
          }).catch((err) => {
            this.$message({
              type: 'error',
              message: 'Something error when get list comment in this thread!!'
            });
          })
        }
      },

      showComment() {
        this.$emit('comment', this.list);
      },
      showProfile(user) {
        this.$emit('showProfile', user);
      },



      doubleClicked() {
        if (this.isGuest) return;

        if (!this.liked) {
          this.like();
        }
      },

      /**
       * Sets the initial values for whether or not highlight the comment.
       *
       * @return void
       */
      setHighlighted() {
        if (this.list.broadcasted == true || this.$route.query.comment == this.list.id) {
          this.highlighted = true;
        }
      },

      /**
       * Scrolls the page to the comment
       *
       * @return void
       */
      scrollToComment() {
        if (this.$route.query.comment == this.list.id) {
          document.getElementById('comment' + this.list.id).scrollIntoView();
        }
      },

      /**
       * renders more comments
       *
       * @return void
       */
      loadMoreComments() {
        this.childrenLimit += 6;
      },

      /**
       * seen the comment
       *
       * @return void
       */
      seen() {
        this.highlighted = false;
      },

      /**
       * Send record to be fetched by CommentForm.
       *
       * @return void
       */
      edit() {
        this.editing = !this.editing;

        this.$eventHub.$emit('edit-comment', this.list);
      },

      newComment(comment) {
        // if (comment.parent_id == null) return;
        // if (this.list.id != comment.parent_id) return;

        // owns the comment
        // if (comment.author.id == auth.id) {
        //   this.reply = false;
        //   this.$store.state.comments.likes.push(comment.id);
        //   this.children.unshift(comment);
        //
        //   this.$nextTick(function () {
        //     document.getElementById('comment' + comment.id).scrollIntoView();
        //   });
        //
        //   return;
        // }

        // add broadcasted (used for styling)
        // comment.broadcasted = true;
        if((comment.parent_id === this.list.id) && this.is_children) {
          this.list.number_children_posts ++;
          this.children.unshift(comment);
          this.$nextTick(function () {
            if(document.getElementById('comment' + comment.id)) {
              document.getElementById('comment' + comment.id).scrollIntoView();
            }
          });
        }

      },

      /**
       * patches the broadcasted comment.
       *
       * @return void
       */
      patchedComment(comment) {
        if (this.list.id != comment.id) return;

        this.editing = false;
        this.list.content = comment.content;
        this.list.edited_at = this.now();
      },

      /**
       *  Report(and block) comment
       */
      report() {
        if (this.isGuest) {
          this.mustBeLogin();
          return;
        }

        this.isReportComment = true;
        if(this.isReportComment) {
          this.commentReport = this.list;
        } else {
          this.commentReport = {}
        }
      },

      closeReport() {
        this.isReportComment = false;
      },

      /**
       *  Send comment to CommentForm to be replied to.
       *
       * @return void
       */
      commentReply() {
        if (this.isGuest) {
          this.mustBeLogin();
          return;
        }

        this.reply = !this.reply;

        this.$eventHub.$emit('reply-comment', this.list);
      },

      bookmark: _.debounce(
        function () {
          if (this.isGuest) {
            this.mustBeLogin();
            return;
          }

          this.list.type = (this.list.type === 1) ? 0 : 1;
          let payload = {
            post_id: this.list.id,
            type: this.list.type
          }

          post(`/api/post/pin`, payload).then((res) => {
              this.$eventHub.$emit('remove-pin-thread', this.list, this.list.type);
            })
            .catch(() => {
              this.list.type = (this.list.type === 1) ? 0 : 1;
          });

        },
        200,
        {leading: true, trailing: false}

      ),

      like: _.debounce(
        function () {
          if (this.isGuest) {
            this.mustBeLogin();
            return;
          }

          post(`/api/post/like`, {
            post_id: this.list.id,
            react_code: 'like'
          })
            .then((res) => {
              console.log('like: ', res);
              if(!this.liked) {
                let newReact = {
                  user_id: this.currentUser.id,
                  post_id: this.list.id,
                  react_code: 'like'
                }
                this.react.push(newReact)
              } else {
                let removeReact = this.react.filter((r) => {
                  return (this.currentUser.id === r.user_id) && (r.react_code === 'like');
                })
                if(removeReact.length) {
                  let rm = removeReact[0];
                  let index = this.react.indexOf(rm);
                  if(index > -1) {
                    this.react.splice(index, 1);
                  }
                }
              }
            })
            .catch(error => {
              this.$message({
                type: 'error',
                message: 'Something error!! :', error
              })
            this.liked = !this.liked;
          })
        },
        200,
        {leading: true, trailing: false}
      ),

      /**
       * Deletes the comment. Only the author is allowed to make such decision.
       *
       * @return void
       */
      destroy() {
        this.visible = false;

        del(`/api/post/destroy?post_id=${this.list.id}`).then(() => {
            this.$message({
              type: 'success',
              message: 'Delete Success'
            })
          })
          .catch((err) => {
            this.$message({
              type: 'error',
              message: 'Something error: ', err
            })
            this.visible = true
          }).finally(() => {
            if(this.is_children && !this.list.is_parent) {
              this.$eventHub.$emit('remove-parent-comment');
            }
          this.$eventHub.$emit('deletedComment', this.list);
        });
      },

      /**
       * deletes the broadcasted comment
       *
       * @return void
       */
      deletedComment(comment) {
        if(comment.parent_id === this.list.id && !this.is_children) {
          this.list.number_children_posts --;
        }
        if (comment.id != this.list.id) return;
        this.visible = false;
        if(this.is_children) {
          if(!comment.is_parent) {
            this.$eventHub.$emit('remove-parent-comment');
            return;
          }
        }
      },

      /**
       * Approves the comment. Only the moderators of channel are allowed to do this.
       *
       * @return void
       */
      approve() {
        this.list.approved_at = this.now();
        post(`/comments/${this.list.id}/approve`).catch(() => (this.list.approved_at = null));
      },

      /**
       * Disapproves the comment. Only the moderators of channel are allowed to do this.
       *
       * @return void
       */
      disapprove() {
        this.visible = false;
        post(`/comments/${this.list.id}/disapprove`).catch(() => (this.visible = true));
      },
    }
  };
</script>

<style lang="scss" scoped>
    .background-bookmark {
        background: #f9f9f9;
        border: 2px dashed #e9e9e9 !important;
        padding-bottom: 0.7em !important;
        padding-right: 1em !important;
        border-left: 2px dashed #e9e9e9 !important;
    }

    .comment-image {
        display: block;
        position: relative;
        overflow: hidden;
        border-radius: 4px;
        background-color: #e8e8e8;
        height: 100%;
        cursor: zoom-in;
        max-width: 90%;
        max-height: 500px;
    }
</style>

