<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đại Lý | Đăng nhập</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{url('/')}}/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{url('/')}}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{url('/')}}/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page back-ground">
<div class="login-box">
    <div class="text-center">
        <img src="/dist/img/favicon.ico" class="logo-login">
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Đăng nhập đại lý</p>
            {{-- Hiển thị thông tin trạng thái tạo bài viết --}}
            @if (session('error'))
                <div class="alert alert-info bg-danger">{{session('error')}}</div>
            @endif
            <form action="{{route('auth')}}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Tên đăng nhập" required name="user_name" >
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Mật khẩu" required name="pass" id="pass">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-eye" onclick="passChange()" id="pass-eye"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!--<div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember">
                            <label for="remember">
                                Nhớ mật khẩu
                            </label>
                        </div>
                    </div>-->
                    <!-- /.col -->
                    <div class="col-5">
                        <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            <!--<p class="mb-1">
                <a href="forgot-password.html">I forgot my password</a>
            </p>-->
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{url('/')}}/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{url('/')}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="{{url('/')}}/dist/js/adminlte.min.js"></script>
<script>
    function passChange() {
        var x = document.getElementById("pass");
        var eyePass = document.getElementById("pass-eye");
        if (x.type === "password") {
            x.type = "text";
            eyePass.className = "fas fa-eye-slash";
        } else {
            x.type = "password";
            eyePass.className = "fas fa-eye";
        }
    }
</script>
<style>
    .back-ground {
        width: 100%;
        float: left;
        background: url("/dist/img/bg.jpg") no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
    }
    .logo-login {
        width: 143px;
        margin-bottom: 20px;
    }
</style>
</body>
</html>
