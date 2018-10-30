import Vue from 'vue'
import VueRouter from 'vue-router'
import HomeIndex from "../components/layout/index.vue"
import Channel from "../components/layout/channel/Index.vue"
import Login from "../components/user/auth/Login.vue"
import store from '../store/index'
import middlewares from './middleware'

Vue.use(VueRouter)
let routes = [
  {
    path: '/login', name: 'login', component: Login, beforeEnter: middlewares.guest
  },
  {
    path: '/home', name: 'homeIndex', component: HomeIndex, beforeEnter: middlewares.auth
  },
  {
    path: '/channel', name: 'channel', component: Channel
  }
]

const router = new VueRouter({
  routes
});

export default router;
