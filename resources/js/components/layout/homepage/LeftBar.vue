<template>
    <div class="d-md-block d-none col-md-2 bg-side-bar pl-3 pr-0 text-white overflow-auto">
        <a class="navbar-brand px-3" href="#">
            <h3 class="title">ASK60</h3>
        </a>
        <menuList :channel_id="channel_id" :isVertical="isVertical"/>
    </div>

</template>
<script>
  import {get} from '../../../helper/request'
  import menuList from "./Menu.vue"

  export default {
    name: 'LeftBar',
    props: [
      'channel_id',
    ],

    data(){
      return {
          isVertical: true,
        }
    },


      components:{
          menuList
      },

  }
</script>
