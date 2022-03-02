<template>
  <div>
    <!-- Send notification button -->
    <button
        :disabled="loading"
        type="button"
        class="btn btn-success btn-send" @click="sendNotification"
    >
      Send Notification
    </button>

    <!-- Enable/Disable push notifications -->
    <button
        :disabled="pushButtonDisabled || loading"
        type="button"
        class="btn btn-primary"
        :class="{ 'btn-primary': !isPushEnabled, 'btn-danger': isPushEnabled }"
        @click="togglePush"
    >
      {{ isPushEnabled ? 'Disable' : 'Enable' }} Push Notifications
    </button>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  data: () => ({
    loading: false,
    isPushEnabled: false,
    pushButtonDisabled: true
  }),
  mounted () {
    this.registerServiceWorker()
  },
  methods: {
    /**
     * Register the service worker.
     */
    registerServiceWorker () {
      if (!('serviceWorker' in navigator)) {
        console.log('Service workers aren\'t supported in this browser.')
        return
      }
      navigator.serviceWorker.register('/sw.js')
          .then(() => this.initialiseServiceWorker())
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
              this.pushButtonDisabled = false
              if (!subscription) {
                return
              }
              this.updateSubscription(subscription)
              this.isPushEnabled = true
            })
            .catch(e => {
              console.log('Error during getSubscription()', e)
            })
      })
    },
    /**
     * Subscribe for push notifications.
     */
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
              this.pushButtonDisabled = false
              this.updateSubscription(subscription)
            })
            .catch(e => {
              if (Notification.permission === 'denied') {
                console.log('Permission for Notifications was denied')
                this.pushButtonDisabled = true
              } else {
                console.log('Unable to subscribe to push.', e)
                this.pushButtonDisabled = false
              }
            })
      })
    },
    /**
     * Unsubscribe from push notifications.
     */
    unsubscribe () {
      navigator.serviceWorker.ready.then(registration => {
        registration.pushManager.getSubscription().then(subscription => {
          if (!subscription) {
            this.isPushEnabled = false
            this.pushButtonDisabled = false
            return
          }
          subscription.unsubscribe().then(() => {
            this.deleteSubscription(subscription)
            this.isPushEnabled = false
            this.pushButtonDisabled = false
          }).catch(e => {
            console.log('Unsubscription error: ', e)
            this.pushButtonDisabled = false
          })
        }).catch(e => {
          console.log('Error thrown while unsubscribing.', e)
        })
      })
    },
    /**
     * Toggle push notifications subscription.
     */
    togglePush () {
      if (this.isPushEnabled) {
        this.unsubscribe()
      } else {
        this.subscribe()
      }
    },
    /**
     * Send a request to the server to update user's subscription.
     *
     * @param {PushSubscription} subscription
     */
    updateSubscription (subscription) {
      const key = subscription.getKey('p256dh')
      const token = subscription.getKey('auth')
      const contentEncoding = (PushManager.supportedContentEncodings || ['aesgcm'])[0]
      const data = {
        endpoint: subscription.endpoint,
        publicKey: key ? btoa(String.fromCharCode.apply(null, new Uint8Array(key))) : null,
        authToken: token ? btoa(String.fromCharCode.apply(null, new Uint8Array(token))) : null,
        contentEncoding
      }
      this.loading = true
      axios.post('/subscriptions', data)
          .then(() => { this.loading = false })
    },
    /**
     * Send a requst to the server to delete user's subscription.
     *
     * @param {PushSubscription} subscription
     */
    deleteSubscription (subscription) {
      this.loading = true
      axios.post('/subscriptions/delete', { endpoint: subscription.endpoint })
          .then(() => { this.loading = false })
    },
    /**
     * Send a request to the server for a push notification.
     */
    sendNotification () {
      this.loading = true
      axios.post('/notifications')
          .catch(error => console.log(error))
          .then(() => { this.loading = false })
    },
    /**
     * https://github.com/Minishlink/physbook/blob/02a0d5d7ca0d5d2cc6d308a3a9b81244c63b3f14/app/Resources/public/js/app.js#L177
     *
     * @param  {String} base64String
     * @return {Uint8Array}
     */
    urlBase64ToUint8Array (base64String) {
      const padding = '='.repeat((4 - base64String.length % 4) % 4)
      const base64 = (base64String + padding)
          .replace(/-/g, '+')
          .replace(/_/g, '/')
      const rawData = window.atob(base64)
      const outputArray = new Uint8Array(rawData.length)
      for (let i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i)
      }
      return outputArray
    }
  }
}
</script>

<style scoped>
.btn {
  margin-right: 10px;
  margin-bottom: 10px;
}
</style>