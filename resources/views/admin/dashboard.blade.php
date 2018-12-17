@extends('admin.layouts.master')
@section('customcss')
    <link rel="stylesheet" href="/admin/css/toggle-switch.css"/>
    <link rel="stylesheet" href="/admin/css/startmin.css"/>
    <style >
        .row{
            font-size: medium;
        }
        .yearly{
            width: 100%;
        }
        .daily{
            width: 100%;
        }
        .monthly{
            width: 100%;
        }
        .xchart{
            float: left;
            width: 100%;
            margin: auto;
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
        <div class="row xchart">
            <div class="col-lg-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-bar-chart-o fa-fw"></i>User Count Chart
                        <div class="pull-right">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                    Chart Type
                                    <span class="caret"></span>
                                </button>
                                <ul data-name="user" class="dropdown-menu pull-right" role="menu">
                                    <li><button  class="btn btn-default btn-xs yearly">Yearly</button></li>
                                    <li><button  class="btn btn-default btn-xs monthly">Monthly this year</button></li>
                                    <li><button  class="btn btn-default btn-xs daily">Daily this month</button></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div id="user-area-chart" style="position: relative; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">

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
        <div class="row xchart">
            <div class="col-lg-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-bar-chart-o fa-fw"></i>Channel Count Chart
                        <div class="pull-right">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                    Chart Type
                                    <span class="caret"></span>
                                </button>
                                <ul data-name="channel" class="dropdown-menu pull-right" role="menu">
                                    <li><button  class="btn btn-default btn-xs yearly">Yearly</button></li>
                                    <li><button  class="btn btn-default btn-xs monthly">Monthly this year</button></li>
                                    <li><button  class="btn btn-default btn-xs daily">Daily this month</button></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div id="channel-area-chart" style="position: relative; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">

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
        <div class="row xchart">
            <div class="col-lg-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-bar-chart-o fa-fw"></i>Post Count Chart
                        <div class="pull-right">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                    Chart Type
                                    <span class="caret"></span>
                                </button>
                                <ul data-name="post" class="dropdown-menu pull-right" role="menu">
                                    <li><button  class="btn btn-default btn-xs yearly">Yearly</button></li>
                                    <li><button  class="btn btn-default btn-xs monthly">Monthly this year</button></li>
                                    <li><button  class="btn btn-default btn-xs daily">Daily this month</button></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div id="post-area-chart" style="position: relative; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">

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
        <div class="row xchart">
            <div class="col-lg-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-bar-chart-o fa-fw"></i>Report Count Chart
                        <div class="pull-right">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                    Chart Type
                                    <span class="caret"></span>
                                </button>
                                <ul data-name="report" class="dropdown-menu pull-right" role="menu">
                                    <li><button  class="btn btn-default btn-xs yearly">Yearly</button></li>
                                    <li><button  class="btn btn-default btn-xs monthly">Monthly this year</button></li>
                                    <li><button  class="btn btn-default btn-xs daily">Daily this month</button></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div id="report-area-chart" style="position: relative; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">

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

            function ajaxGetChart(chartId, model, type){
                $('#' + chartId).empty();
                $.ajax({
                    type:'get',
                    url: '/admin/dashboard/get-chart',
                    data:{
                        type: type,
                        model: model
                    },
                    success: function (response) {
                        if(!response.error)
                        {
                            Morris.Area({
                                element: chartId,
                                data: response.data,
                                xkey: 'period',
                                ykeys: ['model'],
                                labels: ['Number of ' + model],
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
            $('.yearly').click(function () {
                let model = $(this).closest('ul').data('name');
                ajaxGetChart(model + '-area-chart', model, 'yearly');
            });
            $('.monthly').click(function () {
                let model = $(this).closest('ul').data('name');
                ajaxGetChart(model + '-area-chart', model, 'monthly');
            });
            $('.daily').click(function () {
                let model = $(this).closest('ul').data('name');
                ajaxGetChart(model + '-area-chart', model, 'daily');
            });
            let array = ['user', 'channel', 'post', 'report'];
            for (let i = 0; i < array.length; i++) {
                ajaxGetChart(array[i] + '-area-chart', array[i], 'yearly');
            }
        });
    </script>
@endsection
