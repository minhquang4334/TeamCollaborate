@extends('admin.auth.master')
@section('customCss')
    <style>
        body{
            background-image:url("https://hdwallsource.com/img/2014/9/blur-26347-27038-hd-wallpapers.jpg");
            background-repeat:no-repeat; background-size:cover; padding:10px;
        }

        .form-heading { color:#fff; font-size:23px;}
        .panel h2{ color:#444444; font-size:18px; margin:0 0 8px 0;}
        .panel p { color:#777777; font-size:14px; margin-bottom:30px; line-height:24px;}
        .login-form .form-control {
            background: #f7f7f7 none repeat scroll 0 0;
            border: 1px solid #d4d4d4;
            border-radius: 4px;
            font-size: 14px;
            height: 50px;
            line-height: 50px;
        }
        .main-div {
            background: #ffffff none repeat scroll 0 0;
            border-radius: 2px;
            margin: 10px auto 30px;
            max-width: 38%;
            padding: 50px 70px 70px 71px;
        }

        .login-form .form-group {
            margin-bottom:10px;
        }
        .login-form{ text-align:center;}
        .forgot a {
            color: #777777;
            font-size: 14px;
            text-decoration: underline;
        }
        .login-form  .btn.btn-primary {
            background: #f0ad4e none repeat scroll 0 0;
            border-color: #f0ad4e;
            color: #ffffff;
            font-size: 14px;
            width: 100%;
            height: 50px;
            line-height: 50px;
            padding: 0;
        }
        .forgot {
            text-align: left; margin-bottom:30px;
        }
        .botto-text {
            color: #ffffff;
            font-size: 14px;
            margin: auto;
        }
        .login-form .btn.btn-primary.reset {
            background: #ff9900 none repeat scroll 0 0;
        }
        .back { text-align: left; margin-top:10px;}
        .back a {color: #444444; font-size: 13px;text-decoration: none;}

    </style>
    @endsection
@section('content')
    {{--<div class="login-box">--}}
        {{--<div class="login-logo">--}}
            {{--<a href="#"><b>Admin {{ config("sales.default_system_name") }}</b></a>--}}
        {{--</div>--}}
        {{--<!-- /.login-logo -->--}}
        {{--<div class="login-box-body">--}}
            {{--<p class="login-box-msg">Login</p>--}}
            {{--@if ($errors->has('error'))--}}
                {{--<div class="{{ $errors->has('error') ? ' has-error' : '' }}">--}}
                {{--<span class="help-block">--}}
                                    {{--<strong>{{ $errors->first('error') }}</strong>--}}
                                {{--</span>--}}
                {{--</div>--}}
            {{--@endif--}}
            {{--<form action="{{route('admin.login')}}" method="POST">--}}
                {{--{{csrf_field()}}--}}
                {{--<div class="form-group {{ $errors->has('username') ? ' has-error' : '' }}">--}}
                    {{--<input type="username" class="form-control" name="username" placeholder="Username">--}}
                    {{--<span class="glyphicon glyphicon-envelope form-control-feedback"></span>--}}
                    {{--@if ($errors->has('username'))--}}
                        {{--<span class="help-block">--}}
                                    {{--<strong>{{ $errors->first('username') }}</strong>--}}
                                {{--</span>--}}
                    {{--@endif--}}
                {{--</div>--}}
                {{--<div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">--}}
                    {{--<input type="password" class="form-control" placeholder="Password" name="password">--}}
                    {{--<span class="glyphicon glyphicon-lock form-control-feedback"></span>--}}
                    {{--@if ($errors->has('password'))--}}
                        {{--<span class="help-block">--}}
                                    {{--<strong>{{ $errors->first('password') }}</strong>--}}
                                {{--</span>--}}
                    {{--@endif--}}
                {{--</div>--}}
                {{--<div class="row">--}}
                    {{--<div class="col-xs-8">--}}
                        {{--<div class="checkbox icheck">--}}
                            {{--<label>--}}
                                {{--<input type="checkbox" name="remember_token"> Remember me--}}
                            {{--</label>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<!-- /.col -->--}}
                    {{--<div class="col-xs-4">--}}
                        {{--<button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>--}}
                    {{--</div>--}}
                    {{--<!-- /.col -->--}}
                {{--</div>--}}
            {{--</form>--}}
            {{--<!-- /.social-auth-links -->--}}

            {{--<a href="{{route('admin.forgot_password')}}">Forgot password</a><br>--}}

        {{--</div>--}}
        {{--<!-- /.login-box-body -->--}}
    {{--</div>--}}

    <div class="container">

        <div class="login-form">
            <div class="main-div">
                <div class="panel">
                    <h2>Admin Login</h2>
                </div>
                @if ($errors->has('error'))
                    <div class="{{ $errors->has('error') ? ' has-error' : '' }}">
                <span class="help-block">
                                    <strong>{{ $errors->first('error') }}</strong>
                                </span>
                    </div>
                @endif
                <form action="{{route('admin.login')}}" method="POST">
                    {{csrf_field()}}
                    <div class="form-group {{ $errors->has('username') ? ' has-error' : '' }}">
                        <input type="username" class="form-control" name="username" placeholder="Username">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        @if ($errors->has('username'))
                            <span class="help-block">
                                    <strong>{{ $errors->first('username') }}</strong>
                                </span>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                        <input type="password" class="form-control" placeholder="Password" name="password">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-xs-8">
                            <div class="checkbox icheck">
                                <label>
                                    <input type="checkbox" name="remember_token"> Remember me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>
                        </div>
                        <!-- /.col -->
                    </div>

                </form>

                <a href="{{route('admin.forgot_password')}}">Forgot password</a><br>
            </div>
        </div></div></div>
@endsection
@section('footer')
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
@endsection
