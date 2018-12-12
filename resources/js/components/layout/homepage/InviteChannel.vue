<template>
    <div class="col-10 col-md-6 m-auto h-100 text-center">
        <div class="row h-50 justify-content-center align-items-center">
            <div class="w-100">
                <h2 class="text-center mb-5">Invite to <strong class="">Channel name</strong></h2>
                <div class="w-100 row">
                    <div class="col-11 p-0">
                        <multiselect v-model="value" tag-placeholder="Add this as new tag" placeholder="Search or add a tag" label="name" track-by="code" :options="options" :multiple="true" :taggable="true" @tag="addTag"></multiselect>
                    </div>
                    <div class="col-1 px-0">
                        <button type="button" class="btn btn-secondary h-100">Send</button>
                    </div>
                </div>
                <p class="text-muted">
                    Recent conversations or
                    <router-link :to="{name: 'homeIndex'}" >Back</router-link>
                </p>
            </div>
        </div>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'

    export default {
        components: {
            Multiselect
        },
        data () {
            return {
                value: [
                    { name: 'Javascript', code: 'js' }
                ],
                options: [
                    { name: 'Vue.js', code: 'vu' },
                    { name: 'Javascript', code: 'js' },
                    { name: 'Open Source', code: 'os' }
                ]
            }
        },
        methods: {
            addTag (newTag) {
                const tag = {
                    name: newTag,
                    code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
                }
                this.options.push(tag)
                this.value.push(tag)
            }
        }
    }
</script>
