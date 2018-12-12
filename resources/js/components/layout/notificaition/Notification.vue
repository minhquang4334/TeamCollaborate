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
                        <timeago :since="notification.created" :auto-update="30"></timeago>
                    </small>
                </div>
            </div>
        </div>
    </li>
</template>

<script>
  import {post} from '../../helper/request.js'

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
      }
    }
  }
</script>
