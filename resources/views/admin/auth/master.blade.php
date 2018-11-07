<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{config('sales.default_system_name')}} | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="/admin/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/admin/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="/admin/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/admin/css/adminlte.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/admin/css/blue.css">
    <link rel="stylesheet" href="{{ mix('admin/css/app.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
</head>
<body class="hold-transition login-page">

@yield('content')
@section('script')
    <script src={{ mix('admin/js/app.js') }}></script>
    <script src="/admin/js/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="/admin/js/jquery-ui.min.js"></script>    <!-- Bootstrap 3.3.7 -->
    <script src="/admin/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="/admin/js/icheck.min.js"></script>
@show
@yield('footer')
</body>
</html>