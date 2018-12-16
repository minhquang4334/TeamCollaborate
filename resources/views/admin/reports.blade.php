@extends('admin.layouts.master')
@section('customcss')
    <link rel="stylesheet" href="/admin/css/toggle-switch.css">
@endsection
@section('pagename')
    Report Manager
@endsection
@section('content')
    <div class="container">
        <table id="listtable" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th class="th-sm">Reporter
                    <i class="fa fa-sort float-right" aria-hidden="true"></i>
                </th>
                <th class="th-sm">Channel
                    <i class="fa fa-sort float-right" aria-hidden="true"></i>
                </th>
                <th class="th-sm">Post Content
                    <i class="fa fa-sort float-right" aria-hidden="true"></i>
                </th>
                <th class="th-sm">Description
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
            @foreach($reports as $report)
                <tr id="row{{$report->id}}">
                    <td>{{($report->creator == null)?"":$report->creator->name}}</td>
                    <td>{{($report->channel == null)?"":$report->channel->channel_id}}</td>
                    <td>{{($report->post == null)?"":$report->post->content}}</td>
                    <td>{{$report->description}}</td>
                    <td id="status{{$report->id}}">{{($report->status == \App\Model\Report::RESOLVED)?"Resolved":"Pending"}}</td>
                    <td>
                        @if($report->status == \App\Model\Report::YET)
                        <button type="button" class="btn btn-info process-btn" data-action="1" value="{{$report->id}}" >Accept</button>
                        <button type="button" class="btn btn-info process-btn" data-action="0" value="{{$report->id}}" >Ignore</button>
                        @endif
                        <button type="button" class="btn btn-danger delete-btn"  value="{{$report->id}}">Delete</button>
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

    <div class="modal fade" id="confirm-modal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Confirm delete</h4>
                </div>
                <div class="modal-body" id="confirm-content">
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


            $(".delete-btn").on("click",function () {
                $("#confirm-modal").modal("show");
                $("#confirm-content").html('You really want to delete the report #' + $(this).val() +'?');
                $("#delete-id").attr('data-id', $(this).val());
            });

            $("#delete-id").on("click", function () {
                var id = $(this).data('id');
                $.ajax({
                    type: 'delete',
                    url: '{{route('admin.reports-manager.destroy', '')}}/' + id,
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
                            case 404: toastr.error("Report " + thrownError);
                                break;
                            default: toastr.error(xhr.responseJSON.message);
                        }
                    }
                });
            });

            $(".process-btn").on("click", function () {
                var id = $(this).val();
                var action = $(this).data('action');
                $.ajax({
                    type: 'put',
                    url: '{{route('admin.reports-manager.update', '')}}/' + id,
                    data:{
                        id: id,
                        action: action
                    },
                    success: function (response) {
                        if(!response.error)
                        {
                            toastr.success('Processed!');
                            $(".process-btn").hide();
                            $('#status' + id).html("Resolved");
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log(xhr.status);
                        switch (xhr.status) {
                            case 404: toastr.error("Report " + thrownError);
                                break;
                            default: toastr.error(xhr.responseJSON.message);
                        }
                    }
                });
            });


        });
    </script>
@endsection
