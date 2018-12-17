<template>
    <li class="notification" v-bind:class="notification.is_read ? 'notification is-read-notification' : 'notification not-read-notification'  " >
        <div class="media">
            <div class="media-left">
                <div class="media-object">
                    <img src="/images/logo_header.png" height="40px" width="80px">
                </div>
            </div>

            <div class="media-body">
                <strong class="notification-title">
                    <a :href="notification.action_url" @click.prevent="markAsRead(notification)">{{ notification.title }}</a>
                </strong>
                <p class="notification-desc">
                    {{ notification.body }}
                </p>

                <div class="notification-meta">
                    <small class="timestamp">
                        <el-tooltip :content="'Created: ' + longDate"
                                    placement="top"
                                    transition="false"
                                    :open-delay="500">
                            <a class="date margin-right-1"
                               @click.prevent="openOrigin">
                                {{ date(notification.created) }}
                            </a>
                        </el-tooltip>
                    </small>
                </div>
            </div>
        </div>
    </li>
</template>

<script>
  import {post} from '../../../helper/request.js'

  export default {
    props: {
      notification: {
        type: Object,
        required: true
      }
    },

    methods: {
      markAsRead (notification) {
        if(notification.is_read == false) {
          this.$emit('read')
        }
        window.open(notification.action_url, '_blank')
      },

      date(time) {
          return moment(time)
            .fromNow(true);
      }
    }
  }
</script>
