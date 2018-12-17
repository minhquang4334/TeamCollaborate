<template>
    <div>
        <div class="modal-header">
            <h4 class="modal-title">Notification Setting</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>

        </div>
        <div class="modal-body">

            <div class=" m-auto form-group can-toggle demo-rebrand-2">
                <input
                        id="ispublic"
                        type="checkbox"
                        v-model="isPushEnabled"
                >
                <label for="ispublic">
                    <div class="can-toggle__switch" data-checked="On" data-unchecked="Off"></div>
                </label>
            </div>

            If select on notification, you will be notified for every new message!

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal" @click="togglePush">Save</button>
        </div>
    </div>
</template>
<script>
  import {get, post, del} from '../../../helper/request.js'
  export default {
    data () {
      return {
        isPushEnabled: false,
      }
    },

    mounted () {
      this.registerServiceWorker();
    },

    methods: {
      registerServiceWorker() {
        let myWorker = new Worker('/service-worker.js');
        //myWorker.addEventListener('message', );
        let data = {
          token: window.localStorage.getItem('token'),
        }
        myWorker.postMessage({
          data: data
        })
        if(!('serviceWorker' in navigator)) {
          console.log('Service workers aren\'t supported in this browser.');
          return
        }

        navigator.serviceWorker.register('/service-worker.js')
          .then(() => {
            this.initialiseServiceWorker();
          })
      },

      initialiseServiceWorker () {
        if (!('showNotification' in ServiceWorkerRegistration.prototype)) {
          console.log('Notifications aren\'t supported.')
          return
        }

        if (Notification.permission === 'denied') {
          console.log('The user has blocked notifications.')
          return
        }

        if (!('PushManager' in window)) {
          console.log('Push messaging isn\'t supported.')
          return
        }

        navigator.serviceWorker.ready.then(registration => {
          registration.pushManager.getSubscription()
            .then(subscription => {
              console.log('subscription: ', subscription);
              if (!subscription) {
                return
              }
              this.updateSubscription(subscription)

              this.isPushEnabled = true;
            })
            .catch(e => {
              console.log('Error during getSubscription()', e)
            })
        })
      },

      subscribe () {
        navigator.serviceWorker.ready.then(registration => {
          const options = { userVisibleOnly: true }
          const vapidPublicKey = window.Laravel.vapidPublicKey

          if (vapidPublicKey) {
            options.applicationServerKey = this.urlBase64ToUint8Array(vapidPublicKey)
          }

          registration.pushManager.subscribe(options)
            .then(subscription => {
              this.isPushEnabled = true

              this.updateSubscription(subscription)
            })
            .catch(e => {
              console.log('error')
              if (Notification.permission === 'denied') {
                console.log('Permission for Notifications was denied')
              } else {
                console.log('Unable to subscribe to push.', e)
              }
              this.isPushEnabled = false
            }).finally(() => {
          })
        })
      },

      unsubscribe () {
        navigator.serviceWorker.ready.then(registration => {
          registration.pushManager.getSubscription().then(subscription => {
            if (!subscription) {
              this.isPushEnabled = false
              return
            }

            subscription.unsubscribe().then(() => {
              this.deleteSubscription(subscription)

              this.isPushEnabled = false
            }).catch(e => {
              console.log('Unsubscription error: ', e)
            })
          }).catch(e => {
            console.log('Error thrown while unsubscribing.', e)
          })
        })
      },

      updateSubscription (subscription) {
        const key = subscription.getKey('p256dh')
        const token = subscription.getKey('auth')

        let data = {
          endpoint: subscription.endpoint,
          key: key ? btoa(String.fromCharCode.apply(null, new Uint8Array(key))) : null,
          token: token ? btoa(String.fromCharCode.apply(null, new Uint8Array(token))) : null
        }
        post('/api/user/subscriptions', data)
      },

      deleteSubscription (subscription) {

        del('/api/user/subscriptions/delete?endpoint='+ subscription.endpoint)
      },

      urlBase64ToUint8Array (base64String) {
        const padding = '='.repeat((4 - base64String.length % 4) % 4);
        const base64 = (base64String + padding)
          .replace(/\-/g, '+')
          .replace(/_/g, '/')

        const rawData = window.atob(base64)
        const outputArray = new Uint8Array(rawData.length)

        for (let i = 0; i < rawData.length; ++i) {
          outputArray[i] = rawData.charCodeAt(i)
        }

        return outputArray
      },

      togglePush () {
        if (!this.isPushEnabled) {
          this.unsubscribe()
          console.log('toogle false')

        } else {
          this.subscribe()
          console.log('toogle true')

        }
      },

    }

  }

</script>