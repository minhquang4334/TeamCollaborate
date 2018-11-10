@extends('admin.auth.master')
@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>Admin {{ config("sales.default_system_name") }}</b></a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Login</p>
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
            <!-- /.social-auth-links -->

            <a href="{{route('admin.forgot_password')}}">Forgot password</a><br>

        </div>
        <!-- /.login-box-body -->
    </div>
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
