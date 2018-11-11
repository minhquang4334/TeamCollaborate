<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} Dashboard</title>

    <link rel="shortcut icon" href="{{ config('blog.default_icon') }}">


    <!-- endinject -->

    <link rel="stylesheet" href="/adminlte/css/materialdesignicons.min.css">
    {{--<link rel="stylesheet" href="/adminlte/css/simple-line-icons.css">--}}
    <link rel="stylesheet" href="/adminlte/css/flag-icon.min.css">
    <link rel="stylesheet" href="/adminlte/css/chartist.min.css" />
    <link rel="stylesheet" href="/adminlte/css/jquery-jvectormap.css" />
    <link rel="stylesheet" href="/adminlte/css/style.css">
    <link rel="shortcut icon" href="/adminlte/images/favicon.png"/>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script>
        window.Laravel = {
        csrfToken: "{{ csrf_token() }}"
        }

        window.User = {!! Auth::user() !!}

        window.Language = "{{ config('app.locale') }}"
    </script>
</head>
<body>
    <div id="app"></div>

    @include('php-to-js-data')
    <!-- plugins:js -->

    <script src="{{ mix('js/app.js') }}"></script>
    <script src="/adminlte/js/popper.min.js"></script>
    <!-- endinject -->
    <script src="/adminlte/js/jquery.flot.js"></script>
    <script src="/adminlte/js/jquery.flot.resize.js"></script>
    <script src="/adminlte/js/curvedLines.js"></script>
    <script src="/adminlte/js/off-canvas.js"></script>
    <script src="/adminlte/js/misc.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="/adminlte/js/dashboard.js"></script>
</body>

</html>
