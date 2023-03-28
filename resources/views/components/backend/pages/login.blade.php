<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> {{ env('APP_NAME') }} </title>
    <link rel="icon" href="upload/favicon.ico">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('backend_assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('backend_assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('backend_assets/dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition login-page" style="height: 70vh;">
    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>{{env('APP_NAME')}}</b></a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <!-- <p class="login-box-msg">Sign in to start your session</p> -->
                <p class="login-box-msg"> Please Login With Your Credentials.</p>

                {{ Form::open(array('url'=>URL::to('backend/authenticate'))) }}
                <div class="input-group mb-3">
                    <span id="exampleInputEmail1-error" class="error invalid-feedback">Please enter a email address</span>
                    <input type="email" class="form-control" name="email" placeholder="Email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="password" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-8">
                        <p class="mb-1">
                            <!-- <a href="forgot-password.html">Forgot Password..?</a> -->
                            @if (Session::has('message_error'))
                            <label class="text-red">{!! session('message_error') !!}</label>
                            @endif
                        </p>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" name="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>

                    </div>
                    <!-- /.col -->
                </div>
                {{ Form::close() }}


            </div>
            <!-- /.login-card-body -->
        </div>
    </div>


    <!-- jQuery -->
    <script src="{{asset('backend_assets/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('backend_assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('backend_assets/dist/js/adminlte.min.js')}}"></script>
</body>

</html>
