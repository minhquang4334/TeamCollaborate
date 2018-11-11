<template>
    <div class="">
        <div class="d-flex align-center justify-content-center" style="min-height: 100vh;">
            <div>
                <img src="/assets/images/400-new.png" alt="" class="margin-bottom-20">
                <h1 class="text-center"><strong>Bạn không có quyền truy cập.</strong></h1>
                <br>
                <router-link :to="{name: 'homeIndex'}">
                    <p class="text-center text-primary">Quay lại trang chủ.</p>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    name: "AccessDenied"
  }
</script>

<style scoped>

</style>