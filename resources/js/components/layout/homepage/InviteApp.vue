<template>
    <div class="col-10 col-md-6 mx-auto mt-5 border-bottom pb-3 overflow-hidden">
        <h2 class="text-center">Invite member to <strong class="appName">App</strong></h2>
        <div class="inviteForm my-2">
            <div class="row formTitle mb-3">
                <div class="col-6"><strong>Email Address</strong></div>
                <div class="col-5"><strong>Fullname (option)</strong></div>
            </div>
            <div class="formElement row" v-for="(user, index) in invite_users" :key="index">
                <div class="col-6 p-0">
                    <input type="email" v-model="user.email" class="form-control" placeholder="email@example.com">
                </div>
                <div class="col-5 p-0">
                    <input type="text" v-model="user.name" class="form-control" placeholder="Optional">
                </div>
                <div class="col-1 p-0">
                    <span class="fas fa-times btn-lg" @click.prevent="destroyElement(index)"></span>
                </div>
            </div>

        </div>
        <a href="" @click.prevent="addMore"> <i class="fas fa-plus-circle mr-2"></i>Add another</a>
        <p></p>
        <div class="col-11 overflow-hidden p-0">
            <button type="button" class="btn btn-success float-right"  @click.prevent="sendInvite">Send invite</button>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                invite_users: [
                    {
                        email: "",
                        name: ""
                    },
                    {
                        email: "",
                        name: ""
                    },
                    {
                        email: "",
                        name: ""
                    }
                ]
            }
        },

        components: {

        },

        methods: {
            addMore(){
                console.log("add more function");
                this.invite_users.push({
                    email: "",
                    name: ""
                })
            },

            sendInvite(){
                console.log("send invite function");
            },

            destroyElement(index){
                console.log("destroy element function");
                this.invite_users.splice(index, 1);
            }
        }
    }
</script>

<style>
    .fas:hover{
        cursor: pointer;
    }
</style>
