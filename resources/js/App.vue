<template>
    <router-view :key="$route.fullPath">
        <example-component/>
    </router-view>
</template>
<script>
    import ExampleComponent from "./components/ExampleComponent.vue"
    export default {
        components: {
          ExampleComponent
        },

        created() {
          console.log(this.$route.fullPath)
        }
    }
</script>