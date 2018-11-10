@extends('admin.layouts.master')
@section('customcss')
    <link rel="stylesheet" href="/admin/css/toggle-switch.css">
@endsection
@php ($currentAdmin = Auth::guard('admin')->user())
@section('pagename')
Admin Manager
@if($currentAdmin->level == 1)
    <a href="{{route('admin.admin-manager.create')}}"><button type="button" class="btn btn-primary">Create New</button></a>
@endif
@endsection
@section('content')
    <div class="container">
        @if (Session::has('message'))
            <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif
        <table id="listtable" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th class="th-sm">UserName
                    <i class="fa fa-sort float-right" aria-hidden="true"></i>
                </th>
                <th class="th-sm">Name
                    <i class="fa fa-sort float-right" aria-hidden="true"></i>
                </th>
                <th class="th-sm">Level
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
            @foreach($admins as $admin)
                <tr>
                    <td>{{$admin->username}}</td>
                    <td>{{$admin->name}}</td>
                    <td>
                        @if ($admin->level == 1) Admin @else Staff @endif
                    </td>
                    <td>
                        <label class="switch">
                            <input class="user-status" type="checkbox" @if ($admin->status == 1) checked @endif id="{{$admin->id}}">
                            <span class="slider round"></span>
                        </label>
                    </td>
                    <td>
                        <a href="{{route('admin.admin-manager.edit', ['id' => $admin->id])}}"><button type="button" class="btn btn-info">Change</button></a>
                        <button type="button" class="btn btn-danger" data-username="{{$admin->username}}" data-id="{{$admin->id}}" data-toggle="modal" data-target="#askDeleteModal">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="askDeleteModal" tabindex="-1" role="dialog" aria-labelledby="askDeleteModal" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="askDeleteModal">Delete?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true" ></span>
            </button>
          </div>
          <div class="modal-body" id="ModalMessage">
            ...
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-danger" onclick="deleteAdmin(this.getAttribute('data-id'))" data-dismiss="modal">Delete</button>
          </div>
        </div>
      </div>
    </div>


@endsection

@section('customscript')
<script type="text/javascript">
    $(document).ready(function () {
        $('#askDeleteModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var username = button.data('username')
        var id = button.data('id') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('#ModalMessage').text('Do you really want to delete account ' + username + ' from db?')
        modal.find('.btn-danger').attr('data-id', id)
        })
    })
    function deleteAdmin(id) {
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
                $.ajax({
                    type:'post',
                    url: '/admin/admin-manager/' + id,
                    data:{
                        id:id,
                        _method: 'delete'
                    },
                    success: function (response) {
                        if(!response.error)
                        {
                            toastr.success('Deleted!');
                            location.reload();
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        toastr.error(xhr.responseJSON.message);
                    }
                });
        }
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
                    url: '/admin/update-admin-status',
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
        });
</script>
@endsection