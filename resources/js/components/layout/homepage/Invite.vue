<template>
    <div class="modal fade" id="inviteModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Invite</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <label class="typo__label">Invite mail address</label>
                    <multiselect v-model="mailValue" tag-placeholder="Add email" placeholder="Search or add mail" label="name" track-by="code" :options="mailOptions" :multiple="true" :taggable="true" @tag="addTag"></multiselect>
                    <label class="typo__label mt-3">Invite to:</label>
                    <multiselect v-model="typeValue"  track-by="name" label="name" placeholder="Select one" :options="typeInvites" :searchable="false" :allow-empty="false">
                        <template slot="singleLabel" slot-scope="{ option }"><strong>{{ option.name }}</strong></template>
                    </multiselect>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="inviteBtn">Send</button>
                </div>

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
                mailValue: [

                ],
                typeValue: [
                    { name: 'This Channel', code: 'channel' },
                ],
                mailOptions: [
                    { name: 'Vue.js', code: 'vu' },
                    { name: 'Javascript', code: 'js' },
                    { name: 'Open Source', code: 'os' }
                ],
                typeInvites: [
                    { name: 'This Channel', code: 'channel' },
                    { name: 'This App', code: 'app' }
                ],
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

<!-- New step!
     Add Multiselect CSS. Can be added as a static asset or inside a component. -->
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

