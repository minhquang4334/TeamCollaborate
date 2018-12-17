<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>

    <link rel="shortcut icon" href="{{ config('collaborate.default_icon') }}">


    <!-- endinject -->
    <link rel="stylesheet" href="/adminlte/css/custom.css">
    {{--<link rel="stylesheet" href="/css/AdminLTE.min.css"/>--}}
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/0.10.0/lodash.min.js"></script>


    <script>

        window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
                'vapidPublicKey' => config('webpush.vapid.public_key'),
                'pusher' => [
            'key' => config('broadcasting.connections.pusher.key'),
                'cluster' => config('broadcasting.connections.pusher.options.cluster'),
        ],
        ]) !!};
        window.User = {!! Auth::user() !!}

        window.Language = "{{ config('app.locale') }}"
    </script>
</head>
<body>
    <div id="app"></div>

    @include('php-to-js-data')
    <!-- plugins:js -->

    <script src="{{ mix('js/app.js') }}"></script>

</body>
<script>

</script>
</html>
