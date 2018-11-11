<template>
    <div class="">
        <div class="d-flex align-center justify-content-center" style="min-height: 100vh;">
            <div>
                <img src="/assets/images/404-new.png" alt="" class="margin-bottom-20">
                <h4 class="text-center"><strong>The requested page does not exist.</strong></h4>
            </div>
            <br>
            <router-link :to="{name: 'homeIndex'}">
                <p class="text-center text-primary">Quay lại trang chủ.</p>
            </router-link>
        </div>
    </div>
</template>

<script>
  export default {
    name: "PageNotFound"
  }
</script>

<style scoped>

</style>