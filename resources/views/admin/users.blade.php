@extends('admin.layouts.master')
@section('customcss')
    <link rel="stylesheet" href="/admin/css/toggle-switch.css">
    @endsection
@section('pagename')
User Manager
@endsection
@section('content')
    <div class="container">
        <table id="listtable" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th class="th-sm">Name
                    <i class="fa fa-sort float-right" aria-hidden="true"></i>
                </th>
                <th class="th-sm">Email
                    <i class="fa fa-sort float-right" aria-hidden="true"></i>
                </th>
                <th class="th-sm">Phone
                    <i class="fa fa-sort float-right" aria-hidden="true"></i>
                </th>
                <th class="th-sm">Address
                    <i class="fa fa-sort float-right" aria-hidden="true"></i>
                </th>
                <th class="th-sm">Status
                    <i class="fa fa-sort float-right" aria-hidden="true"></i>
                </th>
                <th class="th-sm">Action
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->phone_number}}</td>
                    <td>{{$user->address}}</td>
                    <td>
                        <label class="switch">
                            <input class="user-status" type="checkbox" @if ($user->status == 1) checked @endif id="{{$user->id}}">
                            <span class="slider round"></span>
                        </label>
                    </td>
                    <td>
                        <button type="button" class="btn btn-info info-btn" value="{{$user->id}}">Info</button>
                        <button type="button" class="btn btn-primary order-btn" value="{{$user->id}}">Order</button>
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
                    <h4 class="modal-title">User Infomation</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <td>ID</td>
                            <td id="info-id"></td>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td id="info-name"></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td id="info-mail"></td>
                        </tr>
                        <tr>
                            <td>Avatar</td>
                            <td><img src="" id="info-avatar" style="width: 70px;height: 70px;" alt="avatar"></td>
                        </tr>
                        <tr>
                            <td>Phone</td>
                            <td id="info-phone"></td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td id="info-address"></td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td id="info-status"></td>
                        </tr>
                        <tr>
                            <td>Description</td>
                            <td id="info-description"></td>
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

    <div class="modal fade" id="order-modal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Order list of user</h4>
                </div>
                <div class="modal-body">
                   order list
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
                var status = ($(this).is(':checked')==1) ? 1 : 0;
                $.ajax({
                    type:'PUT',
                    url: 'update-status',
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
                $("#info-modal").modal("show");
                $.ajax({
                    type: 'get',
                    url: 'users/'+$(this).val(),
                    success: function (response) {
                        $user=response.data;
                        $("#info-id").html($user.id);
                        $("#info-name").html($user.name);
                        $("#info-mail").html($user.email);
                        $("#info-avatar").attr("src",$user.avatar);
                        $("#info-phone").html($user.phone_number);
                        $("#info-address").html($user.address);
                        $("#info-status").html(($user.status==1)?"Active":"Blocked");
                        $("#info-description").html($user.description);
                    }
                });
            })

            $(".order-btn").on("click",function () {
                $("#order-modal").modal("show");
                $.ajax({

                });
            })
        });
    </script>
@endsection
