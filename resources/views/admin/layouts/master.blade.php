<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="/admin/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/admin/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="/admin/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/admin/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the /admin/css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="/admin/css/_all-skins.min.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="/admin/css/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="/admin/css/jquery-jvectormap.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="/admin/css/bootstrap-datepicker.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="/admin/css/daterangepicker.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="/admin/css/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap.min.css">
    @yield('customcss')
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    @include('admin.layouts._header')
  <!-- Left side column. contains the logo and sidebar -->
    @include('admin.layouts._leftbar')


  <div class="content-wrapper">
  <section class="content-header " style="margin-bottom: 10px;">
      <h1>
          @yield('pagename')
      </h1>
  </section>
   @yield('content')
    <!-- /.content -->
  </div>
   @include('admin.layouts._footer')
  <!-- Control Sidebar -->

  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="/admin/js/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="/admin/js/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="/admin/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="/admin/js/raphael.min.js"></script>
<script src="/admin/js/morris.min.js"></script>
<!-- Sparkline -->
<script src="/admin/js/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="/admin/js/jquery-jvectormap-1.2.2.min.js"></script>
<script src="/admin/js/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="/admin/js/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="/admin/js/moment.min.js"></script>
<script src="/admin/js/daterangepicker.js"></script>
<!-- datepicker -->
<script src="/admin/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="/admin/js/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="/admin/js/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="/admin/js/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/admin/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="/admin/js/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/admin/js/demo.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

@yield('customscript')
    <script>
    // Basic example
    $(document).ready(function () {
        $('#listtable').DataTable({
        });
    });
</script>
</body>
</html>
