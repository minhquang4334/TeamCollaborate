<template>
    <div>
        <router-view>
            <home/>
        </router-view>
    </div>
</template>
<script>
    import Home from "./components/layout/index.vue"
    export default {
        components: {
          Home
        },

        created() {

        }
    }
</script>