@extends('admin.layouts.master')
@section('customcss')
    <link rel="stylesheet" href="/admin/css/toggle-switch.css">
@endsection
@section('pagename')
    File Manager
@endsection
@section('content')
    <div class="container">
        <table id="listtable" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th class="th-sm">Name
                    <i class="fa fa-sort float-right" aria-hidden="true"></i>
                </th>
                <th class="th-sm">Owner
                    <i class="fa fa-sort float-right" aria-hidden="true"></i>
                </th>
                <th class="th-sm">Channel
                    <i class="fa fa-sort float-right" aria-hidden="true"></i>
                </th>
                <th class="th-sm">Type
                    <i class="fa fa-sort float-right" aria-hidden="true"></i>
                </th>
                <th class="th-sm">Created Time
                    <i class="fa fa-sort float-right" aria-hidden="true"></i>
                </th>

                <th class="th-sm">Action
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($files as $file)
                <tr id="row{{$file->id}}">
                    <td>{{$file->file_name}}</td>
                    <td>{{($file->user != null)?$file->user->name:""}}</td>
                    <td>{{$file->channel->channel_id}}</td>
                    <td>{{pathinfo($file->file_path, PATHINFO_EXTENSION)}}</td>
                    <td>{{$file->created_at}}</td>
                    <td>
                        <a href="/admin/download/{{$file->id}}" type="button" class="btn btn-info"><i class="fa fa-cloud-download" aria-hidden="true"></i></a>
                        <button type="button" class="btn btn-danger delete-btn" data-id="{{$file->id}}" data-name="{{$file->file_name}}" value="{{$file->id}}">Delete</button>
                        @if ($file->is_image == 1)
                            <button type="button" class="btn btn-info info-btn" value="{{$file->file_path}}">Preview</button>
                        @elseif(in_array(pathinfo($file->file_path, PATHINFO_EXTENSION), ['pdf']))
                            <a type="button" class="btn btn-info" href="{{$file->file_path}}">Preview</a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="preview-modal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Image Preview</h4>
                </div>
                <div class="modal-body">
                    <img id="im-preview" style="width: 100%" src=""/>
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
                <div class="modal-body" id="delete-file-id">
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

            $(".info-btn").on("click",function () {
                $("#preview-modal").modal("show");
                $("#im-preview").attr('src', $(this).val());
            });

            $(".delete-btn").on("click",function () {
                $("#delete-modal").modal("show");
                $("#delete-file-id").html('You really want to delete the file "' + $(this).data('name') +'"?');
                $("#delete-id").attr('data-id', $(this).data('id'));
            });

            $("#delete-id").on("click", function () {
                var id = $(this).data('id');
                $.ajax({
                    type: 'delete',
                    url: 'files/' + id,
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
                            case 404: toastr.error("File " + thrownError);
                            break;
                            default: toastr.error(xhr.responseJSON.message);
                        }
                    }
                });
            });
        });
    </script>
@endsection
