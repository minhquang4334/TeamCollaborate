import Vue from 'vue'
import VueRouter from 'vue-router'
import Example from "../components/ExampleComponent.vue"
import Test from "../components/Test.vue"
import TestLayout from "../components/testLayout.vue"
import HomeIndex from "../components/layout/index.vue"
import Channel from "../components/layout/channel/Index.vue"
import store from '../store/index'

Vue.use(VueRouter)
let routes = [
  {
    path: '/example', name: 'example', component: Example
  },
  {
    path: '/test', name: 'test', component: Test
  },
  {
    path: '/', name: 'example1', component: Example
  },
  {
    path: '/testLayout', name: 'testLayout', component: TestLayout
  },
  {
    path: '/home', name: 'homeIndex', component: HomeIndex
  },
  {
    path: '/channel', name: 'channel', component: Channel
  }
]

const router = new VueRouter({
  routes
});

export default router;
