import Vue from 'vue'
import VueRouter from 'vue-router'
import HomeIndex from "../components/layout/index.vue"
import Channel from "../components/layout/channel/Index.vue"
import Login from "../components/user/auth/Login.vue"
import ForgotPassword from "../components/user/auth/ForgotPassword.vue"
import ResetPassword from "../components/user/auth/ResetPassword.vue"
import Register from "../components/user/auth/Register.vue"
import PageNotFound from "../components/views/404.vue"
import AccessDenied from "../components/views/400.vue"
import NoticeVerifyEmail from "../components/views/NoticeVerifyEmail.vue"
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
    path: '/home', name: 'homeIndex', component: HomeIndex, beforeEnter: middlewares.auth
  },
  {
    path: '/channel', name: 'channel', component: Channel
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
