import Vue from 'vue'
import VueRouter from 'vue-router'
import HomeIndex from "../components/layout/homepage/Index.vue"
import Channel from "../components/layout/homepage/CreateChannel.vue"
import InviteChannel from "../components/layout/homepage/InviteChannel.vue"
import InviteApp from "../components/layout/homepage/InviteApp.vue"
import DirectMessage from "../components/layout/homepage/DirectMessage.vue"
import Login from "../components/user/auth/Login.vue"
import ForgotPassword from "../components/user/auth/ForgotPassword.vue"
import ResetPassword from "../components/user/auth/ResetPassword.vue"
import Register from "../components/user/auth/Register.vue"
import PageNotFound from "../components/views/404.vue"
import AccessDenied from "../components/views/400.vue"
import NoticeVerifyEmail from "../components/views/NoticeVerifyEmail.vue"
import Preferences from "../components/user/Preferences.vue"
import ChannelDetail from "../components/layout/homepage/Index.vue"
import store from '../store/index'
import middlewares from './middleware'

Vue.use(VueRouter)
let routes = [
  {
    path: '/', name: 'dashboard', component: Login, beforeEnter: middlewares.guest
  },
  {
    path: '/login', name: 'login', component: Login, beforeEnter: middlewares.guest
  },
  {
    path: '/general', name: 'homeIndex', component: HomeIndex, beforeEnter: middlewares.auth
  },
  {
    path: '/channel/:id', name: 'ChannelDetail', component: ChannelDetail, beforeEnter: middlewares.auth
  },
  {
    path: '/channel', name: 'channel', component: Channel, beforeEnter: middlewares.auth
  },
  {
    path: '/direct-message', name: 'derectMessage', component: DirectMessage, beforeEnter: middlewares.auth
  },
  {
    path: '/invite-channel/:channel_id', name: 'inviteToChannel', component: InviteChannel, beforeEnter: middlewares.auth
  },
  {
    path: '/invite-app', name: 'inviteToApp', component: InviteApp, beforeEnter: middlewares.auth
  },
  {
    path: '/preferences', name: 'preferences', component: Preferences, beforeEnter: middlewares.auth
  },

  {
    path: '/forgot-password', name: 'forgot_password', component: ForgotPassword, beforeEnter: middlewares.guest
  },
  {
    path: '/password/reset/:token', name: 'reset_password', component: ResetPassword, beforeEnter: middlewares.guest
  },
  {
    path: '/register', name: 'register', component: Register, beforeEnter: middlewares.guest
  },
  {
    path: '/not-found', name: 'PageNotFound', component: PageNotFound
  },
  {
    path: '/permission-denied', name: 'AccessDenied', component: AccessDenied
  },
  {
    path: '/notice-verify-email', name: 'NoticeVerifyEmail', component: NoticeVerifyEmail
  },




]

const router = new VueRouter({
  routes
});

export default router;
