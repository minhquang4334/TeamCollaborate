<template>
    <div>
        <router-view>
            <home/>
        </router-view>
    </div>
</template>
<script>
    import Home from "./components/layout/index.vue"
    import {interceptors} from "./helper/request.js";

    export default {
        components: {
          Home
        },

      created() {
        interceptors((err) => {
          console.log("err.responese: " ,err.response);
          if (err.response.status === 401) {
            this.$store.commit('resetData');
            this.$router.push({name: 'login'});
          }

          if (err.response.status === 500) {
            this.$router.push({name: 'homeIndex'});
          }

          if (err.response.status === 404) {
            this.$router.push({name: 'PageNotFound'})
          }

          if(err.response.status === 400) {
            this.$router.push({name: 'AccessDenied'});
          }

          if(err.response.status === 403) {
            if(err.response.data.verified === false) {
              this.$router.push({name: 'NoticeVerifyEmail'});
            } else {
              this.$router.push({name: 'PageNotFound'})
            }
          }
        });

      },    }
</script>