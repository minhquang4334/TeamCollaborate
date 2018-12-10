<template>
    <div id="accordion" class="about-channel overflow-auto">
        <div class="p-3">
            <strong>About <span>{{ channelDetail.channelName }}</span></strong>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#channeldetail" aria-expanded="false" aria-controls="collapseTwo">
                        <span class="fas fa-info mx-2"></span>Channel Detail
                    </button>
                </h5>
            </div>
            <div id="channeldetail" class="collapse" data-parent="#accordion">
                <div class="card-body">
                    {{ channelDetail.channelPurpose }}
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#pinned" aria-expanded="false" aria-controls="collapseTwo">
                        <span class="fas fa-thumbtack mx-2"></span>Pinned
                    </button>
                </h5>
            </div>
            <div id="pinned" class="collapse" data-parent="#accordion">
                <div class="card-body">
                    No items have been pinned yet! Open the context menu on important messages or files and choose Pin to channel to stick them here.                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <button class="btn btn-link" data-toggle="collapse" data-target="#memberlist" aria-expanded="true" aria-controls="collapseOne">
                        <span class="fas fa-user mx-2"></span>Member
                    </button>
                </h5>
            </div>

            <div id="memberlist" class="collapse" data-parent="#accordion">
                <div class="card-body">
                    <div class="list-group">
                        <span
                                class="fas fa-user list-group-item list-group-item-action cursor-pointer"
                                v-for="(user, index) in channelDetail.listUsers" :key="index">

                            {{user.name}}
                        </span>
                    </div>
                    <a class="dropdown-item mt-3" data-toggle="modal" data-target="#inviteModal">
                        <p>
                            <span class="fas fa-hand-holding-heart mr-2"></span>
                            Invite
                        </p>
                    </a>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#files" aria-expanded="false" aria-controls="collapseTwo">
                        <span class="fas fa-file mx-2"></span>Files
                    </button>
                </h5>
            </div>
            <div id="files" class="collapse" data-parent="#accordion">
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <span class="dropdown float-right">
                                <a href="#" role="button"data-toggle="dropdown" class="text-dark" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#">Share</a>
                                    <a class="dropdown-item" href="#">Copy link</a>
                                    <a class="dropdown-item" href="#">Star file</a>
                                    <a class="dropdown-item" href="#">View detail</a>
                                    <a class="dropdown-item" href="#">Download</a>
                                    <a class="dropdown-item" href="#">Create external link</a>
                                </div>
                            </span>
                            <i class="far fa-file mr-2"></i>
                            File 1
                            <p class="text-muted">
                                <strong class="username">Thanh Binh</strong> <small class="timeOfFile">Sep 30th at 8:40</small>
                            </p>
                        </li>
                        <li class="list-group-item">
                            <span class="dropdown float-right">
                                <a href="#" role="button"data-toggle="dropdown" class="text-dark" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#">Share</a>
                                    <a class="dropdown-item" href="#">Copy link</a>
                                    <a class="dropdown-item" href="#">Star file</a>
                                    <a class="dropdown-item" href="#">View detail</a>
                                    <a class="dropdown-item" href="#">Download</a>
                                    <a class="dropdown-item" href="#">Create external link</a>
                                </div>
                            </span>
                            <i class="far fa-file mr-2"></i>
                            File 1
                            <p class="text-muted">
                                <strong class="username">Thanh Binh</strong> <small class="timeOfFile">Sep 30th at 8:40</small>
                            </p>
                        </li>
                        <li class="list-group-item">
                            <span class="dropdown float-right">
                                <a href="#" role="button"data-toggle="dropdown" class="text-dark" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#">Share</a>
                                    <a class="dropdown-item" href="#">Copy link</a>
                                    <a class="dropdown-item" href="#">Star file</a>
                                    <a class="dropdown-item" href="#">View detail</a>
                                    <a class="dropdown-item" href="#">Download</a>
                                    <a class="dropdown-item" href="#">Create external link</a>
                                </div>
                            </span>
                            <i class="far fa-file mr-2"></i>
                            File 1
                            <p class="text-muted">
                                <strong class="username">Thanh Binh</strong> <small class="timeOfFile">Sep 30th at 8:40</small>
                            </p>
                        </li>
                        <li class="list-group-item">
                            <span class="dropdown float-right">
                                <a href="#" role="button"data-toggle="dropdown" class="text-dark" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#">Share</a>
                                    <a class="dropdown-item" href="#">Copy link</a>
                                    <a class="dropdown-item" href="#">Star file</a>
                                    <a class="dropdown-item" href="#">View detail</a>
                                    <a class="dropdown-item" href="#">Download</a>
                                    <a class="dropdown-item" href="#">Create external link</a>
                                </div>
                            </span>
                            <i class="far fa-file mr-2"></i>
                            File 1
                            <p class="text-muted">
                                <strong class="username">Thanh Binh</strong> <small class="timeOfFile">Sep 30th at 8:40</small>
                            </p>
                        </li>
                        <li class="list-group-item">
                            <span class="dropdown float-right">
                                <a href="#" role="button"data-toggle="dropdown" class="text-dark" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#">Share</a>
                                    <a class="dropdown-item" href="#">Copy link</a>
                                    <a class="dropdown-item" href="#">Star file</a>
                                    <a class="dropdown-item" href="#">View detail</a>
                                    <a class="dropdown-item" href="#">Download</a>
                                    <a class="dropdown-item" href="#">Create external link</a>
                                </div>
                            </span>
                            <i class="far fa-file mr-2"></i>
                            File 1
                            <p class="text-muted">
                                <strong class="username">Thanh Binh</strong> <small class="timeOfFile">Sep 30th at 8:40</small>
                            </p>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import {get} from '../../../helper/request.js'
    export default {
      props: ['channelDetail'],

      data() {
        return {

        }
      }
    }

</script>
