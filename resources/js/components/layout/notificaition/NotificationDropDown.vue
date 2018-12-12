<template>
    <li ref="dropdown" class="dropdown dropdown-notifications notifications-menu">
        <a class="dropdown-toggle" href="#">
            <i class="fa fa-bell notification-icon"></i>
            <span class="label label-danger" v-bind:class="numberNotify ? 'count-active' : 'count-hide'">{{ total }}</span>
        </a>

        <div class="dropdown-container dropdown-menu">
            <div class="dropdown-toolbar">
                <div v-show="numberNotify" class="dropdown-toolbar-actions">
                    <a href="#" @click.prevent="markAllRead">Mark all as read</a>
                </div>

                <h3 class="dropdown-toolbar-title">Notifications ({{ total }})</h3>
            </div>

            <ul class="dropdown-menu">
                <notification v-for="notification in notifications"
                              :key="notification.id"
                              :notification="notification"
                              v-on:read="markAsRead(notification)"
                ></notification>

                <li v-if="!numberNotify" class="notification">
                    You don't have any unread notifications.
                </li>
            </ul>

            <div class="dropdown-footer text-center">
                <a href="#" @click.prevent="fetchAll(null)">View More</a>
            </div>
        </div>
    </li>
</template>

<script>
  import $ from 'jquery'
  import axios from 'axios'
  import Notification from './Notification.vue'
  import {get,post,patch} from '../../helper/request.js'

  export default {
    components: { Notification },

    data: () => ({
      total: 0,
      notifications: []
    }),

    mounted () {
      this.fetch()

      if (window.Echo) {
        this.listen()
      }

      this.initDropdown()
    },

    computed: {
      numberNotify () {
        return this.total > 0
      },

      countNoty () {
        return this.notifications.length
      },

      isRead (notification) {
        return notification.is_read
      },

    },
    watch: {
      updateTotal () {
        let total = 0;
        this.notifications.forEach(function(notification) {
          if(notification.is_read == false) total ++;
        })
        this.total = total;
      }
    },
    methods: {
      /**
       * Fetch notifications.
       *
       * @param {Number} limit
       */
      fetch (limit = 5) {
        get('/api/user/get-notifications', { params: { limit }})
          .then(({ data: { total, notifications }}) => {
            this.total = total
            this.notifications = notifications.map(({ id, data, created, is_read }) => {
              return {
                id: id,
                title: data.title,
                body: data.body,
                created: created,
                action_url: data.action_url,
                is_read: is_read,
              }
            })
          })
      },

      /**
       * Mark the given notification as read.
       *
       * @param {Object} notification
       */
      markAsRead ({ id }) {
        const index = this.notifications.findIndex(n => n.id === id)
        this.notifications.forEach(function(notification) {
          if(notification.id == id) {
            notification.is_read = true;
          }
        })
        this.total --;
        if (index > -1) {
          this.notifications.splice(index, 1)
          patch(`/api/user/notifications/${id}/read`)
        }
      },

      /**
       * Mark all notifications as read.
       */
      markAllRead () {
        post('/api/user/notifications/mark-all-read')
        this.notifications.forEach(function(notification) {
          notification.is_read = true;
        })
        this.total = 0;
      },

      /**
       * Listen for Echo push notifications.
       */
      listen () {
        window.Echo.private(`App.User.${window.Laravel.user.id}`)
          .notification(notification => {
            this.total++
            this.notifications.unshift(notification)
          })
          .listen('NotificationRead', ({ notificationId }) => {
            /*
                                    this.total--
            */

            const index = this.notifications.findIndex(n => n.id === notificationId)
            if (index > -1) {
              this.notifications.splice(index, 1)
            }
          })
          .listen('NotificationReadAll', () => {
            /*this.total = 0
            this.notifications = []*/
            this.notifications.forEach(function(notification) {
              notification.is_read = true;
            })
          })
      },

      /**
       * Initialize the notifications dropdown.
       */
      initDropdown () {
        const dropdown = $(this.$refs.dropdown)
        $(document).on('click', (e) => {
          if (!dropdown.is(e.target) && dropdown.has(e.target).length === 0 &&
            !$(e.target).parent().hasClass('notification-mark-read')) {
          }
        })
      },

    }
  }
</script>
