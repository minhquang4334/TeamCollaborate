<template>
    <div id="accordion" class="about-channel">
        <div class="p-3">
            <strong>About <span>Channel name</span></strong>
            <a href=""><span class="float-right fas fa-times"></span></a>
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
                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <button class="btn btn-link" data-toggle="collapse" data-target="#memberlist" aria-expanded="true" aria-controls="collapseOne">
                        <span class="far fa-user mx-2"></span>Member
                    </button>
                </h5>
            </div>

            <div id="memberlist" class="collapse" data-parent="#accordion">
                <div class="card-body">
                    <div class="list-group">
                        <button type="button" class="list-group-item list-group-item-action">Member 1</button>
                        <button type="button" class="list-group-item list-group-item-action">Member 2</button>
                        <button type="button" class="list-group-item list-group-item-action">Member 3</button>
                        <button type="button" class="list-group-item list-group-item-action">Member 4</button>
                        <button type="button" class="list-group-item list-group-item-action">Member 5</button>
                    </div>
                    <a href="">Invite</a>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

</script>
