@extends('admin.layouts.master')
@section('customcss')
    <link rel="stylesheet" href="/admin/css/toggle-switch.css"/>
    <link rel="stylesheet" href="/admin/css/startmin.css"/>
    <style >
        .row{
            font-size: medium;
        }
    </style>
@endsection
@section('pagename')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Dashboard</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-user fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{$count->user}}</div>
                                <div>Number Users!</div>
                            </div>
                        </div>
                    </div>
                    <a href="#">
                        <div class="panel-footer">
                            <a href="{{route('admin.users-manager')}}" class="pull-left">View Details</a>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-comments fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{$count->channel}}</div>
                                <div>Number Channels!</div>
                            </div>
                        </div>
                    </div>
                    <a href="#">
                        <div class="panel-footer">
                            <a href="{{route('admin.channels-manager')}}" class="pull-left">View Details</a>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-file-text fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{$count->file}}</div>
                                <div>Number Files!</div>
                            </div>
                        </div>
                    </div>
                    <a href="#">
                        <div class="panel-footer">
                            <a href="{{route('admin.files-manager')}}" class="pull-left">View Details</a>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-red">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-flag fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{$count->report}}</div>
                                <div>Number Reports!</div>
                            </div>
                        </div>
                    </div>
                    <a href="#">
                        <div class="panel-footer">
                            <a href="{{route('admin.reports-manager.index')}}" class="pull-left">View Details</a>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-bar-chart-o fa-fw"></i> Order Chart
                        <div class="pull-right">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                    Chart Type
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu pull-right" role="menu">
                                    <li><a href="#" id="yearly">Yearly</a></li>
                                    <li><a href="#" id="monthly">Monthly this year</a></li>
                                    <li><a href="#" id="daily">Daily this month</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div id="morris-area-chart" style="position: relative; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">

                        </div>
                    </div>
                    <!-- /.panel-body -->
                </div>


                <!-- /.panel -->
            </div>
            <!-- /.col-lg-8 -->
            <div class="col-lg-4">
            </div>
            <!-- /.col-lg-4 -->
        </div>
        <!-- /.row -->
    </div>
@endsection
@section('content')
@endsection
@section('customscript')
    <script src="/admin/js/raphael.min.js"></script>
    <script src="/admin/js/morris.min.js"></script>
    <script src="/admin/js/metisMenu.min.js"></script>
    <script src="/admin/js/startmin.js"></script>

    <script>
        $(function() {

            function ajaxGetChart(type){
                $('#morris-area-chart').empty();
                $.ajax({
                    type:'get',
                    url: '/admin/dashboard/get-chart',
                    data:{
                        type: type
                    },
                    success: function (response) {
                        if(!response.error)
                        {
                            Morris.Area({
                                element: 'morris-area-chart',
                                data: response.data,
                                xkey: 'period',
                                ykeys: ['model'],
                                labels: ['User count'],
                                pointSize: 2,
                                hideHover: 'auto',
                                resize: true
                            });
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log(xhr.status);
                        switch (xhr.status) {
                            case 404: toastr.error("Data " + thrownError);
                                break;
                            default: toastr.error(xhr.responseJSON.message);
                        }
                    }
                });
            }
            $('#yearly').click(function () {
                ajaxGetChart('yearly');
            });
            $('#monthly').click(function () {
                ajaxGetChart('monthly');
            });
            $('#daily').click(function () {
                ajaxGetChart('daily');
            });
            ajaxGetChart('yearly');
        });
    </script>
@endsection
