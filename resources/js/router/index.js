import Vue from 'vue'
import VueRouter from 'vue-router'
import Example from "../components/ExampleComponent.vue"
import Test from "../components/Test.vue"
import testLayout from "../components/testLayout.vue"
import homeIndex from "../components/layout/index.vue"
import channel from "../components/layout/channel/Index.vue"
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
    path: '/testLayout', name: 'testLayout', component: testLayout
  },
  {
    path: '/home', name: 'homeIndex', component: homeIndex
  },
  {
    path: '/channel', name: 'channel', component: channel
  }
]

const router = new VueRouter({
  routes
});

export default router;
