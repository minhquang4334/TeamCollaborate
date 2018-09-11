<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Example Component</div>

                    <div class="card-body cs-pointer text-info" @click="toTest">
                        I'm an example component. Click me to view test site
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
      data() {
        return {

        }
      },

      methods: {
        toTest() {
          this.$router.push({
            name: "test"
          })
        }
      }
    }
</script>
