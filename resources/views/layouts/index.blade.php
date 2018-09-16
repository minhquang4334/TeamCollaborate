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

    <link rel="stylesheet" href="css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="images/favicon.png"/>

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
    
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="js/off-canvas.js"></script>
    <script src="js/misc.js"></script>
    <script src="js/dashboard.js"></script>
</body>
</html>