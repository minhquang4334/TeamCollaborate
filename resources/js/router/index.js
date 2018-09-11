import Vue from 'vue'
import VueRouter from 'vue-router'
import Example from "../components/ExampleComponent.vue"
import Test from "../components/Test.vue"
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
  }
]

const router = new VueRouter({
  routes
});

export default router;
