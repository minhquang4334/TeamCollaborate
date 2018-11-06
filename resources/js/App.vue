<template>
    <div>
        <router-view :key="$route.fullPath">
            <example-component/>
        </router-view>
    </div>
</template>
<script>
    import ExampleComponent from "./components/Test.vue"
    export default {
        components: {
          ExampleComponent
        },

        created() {
          console.log(this.$route.fullPath)
        }
    }
</script>