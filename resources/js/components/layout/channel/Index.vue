<template>
    <div class="container d-flex h-100">
        <div class="row align-self-center w-100">
            <div class="col-9 mx-auto my-3">
                <div class="jumbotron">
                    <h2>Create a channel</h2>
                    <div class="text-muted mb-2">Channels are where your members communicate.
                        They're best when organized around a topic - #leads, for example</div>
                    <form>
                        <div class="form-group can-toggle demo-rebrand-2">
                            <input
                                id="ispublic"
                                type="checkbox"
                                v-model="toggle"
                                true-value="public"
                                false-value="private"
                            >
                            <label for="ispublic">
                                <div class="can-toggle__switch" data-checked="public" data-unchecked="private"></div>
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName">Name</label>
                            <input id="name" class="form-control" v-model="name" type="text" name="name" placeholder="# e.g leads">
                            <small id="nameHelp" class="form-text text-muted">Names must be lowercase, without spaces or periods, and shoter than 22 characters</small>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPurpose">Purpose <span class="text-muted">(optional)</span></label>
                            <input id="purpose" class="form-control" v-model="purpose" type="text" name="purpose">
                            <small id="purposeHelp" class="form-text text-muted">What's channle about?</small>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName">Send invites to: <span class="text-muted">(optional)</span></label>
                            <input id="invites" class="form-control" v-model="invites" type="text" name="invites" placeholder="# Search by name">
                            <small id="nameHelp" class="form-text text-muted">Select up to 1000 people to add this channel</small>
                        </div>
                        <button type="submit" class="btn btn-p  rimary">Submit</button>
                    </form>
                    <div class="card-body cs-pointer text-info" @click="toHome">
                        <font-awesome-icon icon="coffee">Back</font-awesome-icon>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name: 'App',
        methods: {
            toHome() {
                this.$router.push({
                    name: "homeIndex"
                })
            }
        }
    }
</script>
