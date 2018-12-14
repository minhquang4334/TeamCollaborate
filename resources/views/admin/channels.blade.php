@extends('admin.layouts.master')
@section('customcss')
<link rel="stylesheet" href="/admin/css/toggle-switch.css">
@endsection
@section('pagename')
Channel Manager
@endsection
@section('content')
<div class="container">
    <table id="listtable" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th class="th-sm">ID
                <i class="fa fa-sort float-right" aria-hidden="true"></i>
            </th>
            <th class="th-sm">Name
                <i class="fa fa-sort float-right" aria-hidden="true"></i>
            </th>
            <th class="th-sm">Creator
                <i class="fa fa-sort float-right" aria-hidden="true"></i>
            </th>
            <th class="th-sm">Type
                <i class="fa fa-sort float-right" aria-hidden="true"></i>
            </th>
            <th class="th-sm">Created Time
                <i class="fa fa-sort float-right" aria-hidden="true"></i>
            </th>
            <th class="th-sm">Active
                <i class="fa fa-sort float-right" aria-hidden="true"></i>
            </th>
            <th class="th-sm">Action
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($channels as $channel)
        <tr id="row{{$channel->id}}">
            <td>{{$channel->channel_id}}</td>
            <td>{{$channel->name}}</td>
            <td>{{$channel->creator == '0' ? 'General' : $channel->getCreator->name}}
            <td>{{$channel->type==0?"Public":($channel->type==1?"Private":"Protected")}}</td>
            <td>{{$channel->created_at}}</td>
            <td>
                <label class="switch">
                    <input class="user-status" type="checkbox" @if ($channel->status === 1) checked @endif id="{{$channel->id}}">
                    <span class="slider round"></span>
                </label>
            </td>
            <td>
                <button type="button" class="btn btn-info info-btn" value="{{$channel->id}}">Info</button>
                <button type="button" class="btn btn-danger delete-btn" data-id="{{$channel->id}}" data-name="{{$channel->channel_id}}" value="{{$channel->id}}">Delete</button>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="modal fade" id="info-modal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Channel Information</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <td>ID</td>
                        <td id="info-id"></td>
                    </tr>
                    <tr>
                        <td>Creator</td>
                        <td id="info-creator"></td>
                    </tr>
                    <tr>
                        <td>Type</td>
                        <td id="info-type"></td>
                    </tr>
                    <tr>
                        <td>Members</td>
                        <td id="info-mem"></td>
                    </tr>
                    <tr>
                        <td>Posts</td>
                        <td id="info-post"></td>
                    </tr>
                    <tr>
                        <td>Created Time</td>
                        <td id="info-time"></td>
                    </tr>
                    <tr>
                        <td>Active</td>
                        <td id="info-status"></td>
                    </tr>
                    <tr>
                        <td>Purpose</td>
                        <td id="info-purpose"></td>
                    </tr>
                    <tr>
                        <td>Description</td>
                        <td id="info-description"></td>
                    </tr>
                    </tbody>
                </table>
                <h3>Files</h3>
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <th>Owner</th>
                        <th>File</th>
                        <th>Time</th>
                    </tr>
                    </tbody>
                    <tbody id="file-list">
                    <tr>
                        <td>1</td>
                        <td>2</td>
                        <td>3</td>
                    </tr>
                    </tbody>
                </table>
                <h3>Report</h3>
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <th>User</th>
                        <th>Reason</th>
                        <th>Time</th>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="delete-modal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Confirm delete</h4>
            </div>
            <div class="modal-body" id="delete-channel-id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" id="delete-id" >Delete</button>
            </div>
        </div>

    </div>
</div>

@endsection
@section('customscript')
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(".user-status").on("change",function () {
            var id = $(this).attr('id');
            var status = ($(this).is(':checked') ? 1 : 0);
            $.ajax({
                type:'PUT',
                url: 'update-channel-status',
                data:{
                    id:id,
                    status:status,
                },
                success: function (response) {
                    if(!response.error)
                    {
                        toastr.success('Status was changed!');
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    toastr.error(xhr.responseJSON.message);
                }
            });
        })

        $(".info-btn").on("click",function () {
            $.ajax({
                type: 'get',
                url: 'channels/'+$(this).val(),
                success: function (response) {
                    $("#info-modal").modal("show");
                    $channel=response.data;
                    $("#info-id").html($channel.channel_id);
                    $("#info-creator").html($channel.creator==0 ? "General" : $channel.get_creator.name);
                    $("#info-time").html($channel.created_at || "None");
                    $("#info-mem").html($channel.members_count);
                    $("#info-post").html($channel.posts_count);
                    $("#info-type").html($channel.type===0?"Public":($channel.type==1?"Private":"Protected"));
                    $("#info-status").html(($channel.status==1)?"Active":"Blocked");
                    $("#info-purpose").html($channel.purpose || "None");
                    $("#info-description").html($channel.description || "None");
                    $("#file-list").empty();
                    $channel.files.forEach( function (file) {
                        $("#file-list").append('<tr><td>'+
                                                file.creator.name+'</td><td><a href="/admin/download/' +
                                                file.id + '">' +
                                                file.file_name +'</a></td><td>' +
                                                file.created_at +'</td></tr>');
                    });
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    toastr.error(xhr.responseJSON.message);
                }
            });
        });

        $(".delete-btn").on("click",function () {
            $("#delete-modal").modal("show");
            $("#delete-channel-id").html('You really want to delete the channel "' + $(this).data('name') +'"?');
            $("#delete-id").attr('data-id', $(this).data('id'));
        });

        $("#delete-id").on("click", function () {
            var id = $(this).data('id');
            $.ajax({
                type: 'delete',
                url: 'channels/' + id,
                data:{
                    id: id,
                },
                success: function (response) {
                    if(!response.error)
                    {
                        toastr.success('Deleted!');
                        $('#row' + id).remove();
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    switch (xhr.status) {
                        case 404: toastr.error("Channel " + thrownError);
                            break;
                        default: toastr.error(xhr.responseJSON.message);
                    }
                }
            });
        });
    });
</script>
@endsection
