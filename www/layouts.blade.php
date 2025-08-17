<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{__('base.agent')}} - @yield('title')</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{url('/')}}/plugins/fontawesome-free/css/all.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{url('/')}}/plugins/daterangepicker/daterangepicker.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{url('/')}}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="{{url('/')}}/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{url('/')}}/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{url('/')}}/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{url('/')}}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="{{url('/')}}/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <!-- BS Stepper -->
    <link rel="stylesheet" href="{{url('/')}}/plugins/bs-stepper/css/bs-stepper.min.css">
    <!-- dropzonejs -->
    <link rel="stylesheet" href="{{url('/')}}/plugins/dropzone/min/dropzone.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{url('/')}}/dist/css/adminlte.min.css">
</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

<!-- Preloader -->
<div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="{{url('/')}}/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
</div>

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item language">
            <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect" data-toggle="dropdown" href="javascript:void();">
                <i class="fa fa-flag mr-2"></i>{{getLocale()}}
            </a>
            <ul class="dropdown-menu dropdown-menu-right">
                <li class="dropdown-item" onclick="setLocale('en')"> <i class="flag-icon flag-icon-gb mr-2" ></i> English</li>
                <li class="dropdown-item" onclick="setLocale('vi')"> <i class="flag-icon flag-icon-fr mr-2" ></i> Viet Nam</li>
                <li class="dropdown-item" onclick="setLocale('my')" > <i class="flag-icon flag-icon-cn mr-2" ></i> Myanmar</li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-slide="true" href="{{route('logout')}}" role="button">
                {{__('base.log_out')}}
            </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->
    
@section('menu')
<!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{route('home')}}" class="brand-link">
            <img src="/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">{{__('base.agent')}} roy247</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="{{route('info')}}" class="d-block">{{session('info.nameagent', 'null')}}</a>
                    <span>{{empty(session('balance')) ? '' : number_format(session('balance'))}}</span><br>
                    <span>{{__('base.code')}} : {{session('info.code')}}</span>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item menu-open">
                        <a href="{{route('home')}}" class="nav-link @if(\Request::route()->getName() === 'home') {{'active'}} @endif">
                            <i class="nav-icon fas fa-tachometer-alt"></i>

                            <p>
                                {{__('base.dashboard')}}
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('users')}}" class="nav-link @if(\Request::route()->getName() === 'users') {{'active'}} @endif">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                {{__('base.manage_member')}}
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('game', ['type' => 'MINIGAME'])}}" class="nav-link @if(\Request::route()->getName() === 'game') {{'active'}} @endif">
                            <i class="nav-icon fas fa-chart-pie"></i>
                            <p>
                                {{__('base.game_stats')}}
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('daily-report')}}" class="nav-link @if(\Request::route()->getName() === 'daily-report') {{'active'}} @endif">
                            <i class="nav-icon far fa-plus-square"></i>
                            <p>
                                {{__('base.day_report')}}
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('income')}}" class="nav-link @if(\Request::route()->getName() === 'income') {{'active'}} @endif">
                            <i class="nav-icon fas fa-book"></i>
                            <p>
                                {{__('base.my_income')}}
                            </p>
                        </a>
                    </li>
                    <li class="nav-item @if(request()->is('agent*')) menu-open @endif">
                        <a href="#" class="nav-link @if(request()->is('agent*')) active @endif">
                            <i class="nav-icon fas fa-book"></i>
                            <p>
                                {{__('base.management_agent')}}
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ">
                            <li class="nav-item">
                                <a href="{{route('agent')}}" class="nav-link @if(\Request::route()->getName() === 'agent') {{'active'}} @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{__('base.agent_list')}}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('agent-create')}}" class="nav-link @if(\Request::route()->getName() === 'agent-create') {{'active'}} @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{__('base.add_new_agent')}}</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item @if(request()->is('bank*')) menu-open @endif">
                        <a href="#" class="nav-link @if(request()->is('bank*')) active @endif">
                            <i class="nav-icon fas fa-book"></i>
                            <p>
                                {{__('base.bank_management')}}
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ">
                            <li class="nav-item">
                                <a href="{{route('banks')}}" class="nav-link @if(\Request::route()->getName() === 'banks') {{'active'}} @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{__('base.list_banks')}}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('bank-create')}}" class="nav-link @if(\Request::route()->getName() === 'bank-create') {{'active'}} @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{__('base.add_new_bank')}}</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item @if(request()->is('transaction*')) menu-open @endif">
                        <a href="#" class="nav-link @if(request()->is('transaction*')) active @endif">
                            <i class="nav-icon fas fa-book"></i>
                            <p>
                                {{__('base.buy_point')}}
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ">
                            <li class="nav-item">
                                <a href="{{route('transactions')}}" class="nav-link @if(\Request::route()->getName() === 'transactions') {{'active'}} @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{__('base.buy_point')}}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('transaction-create')}}" class="nav-link @if(\Request::route()->getName() === 'transaction-create') {{'active'}} @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{__('base.add')}}</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item @if(request()->is('topup*')) menu-open @endif">
                        <a href="#" class="nav-link @if(request()->is('topup*')) active @endif">
                            <i class="nav-icon fas fa-book"></i>
                            <p>
                                {{__('base.transaction_management')}}
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ">
                            <li class="nav-item">
                                <a href="{{route('deposit')}}" class="nav-link @if(\Request::route()->getName() === 'deposit') {{'active'}} @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{__('base.recharge_history')}}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('withdraw')}}" class="nav-link @if(\Request::route()->getName() === 'withdraw') {{'active'}} @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{__('base.withdrawal_history')}}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('topup-user')}}" class="nav-link @if(\Request::route()->getName() === 'topup-user') {{'active'}} @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{__('base.top_up_user')}}</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('change-pass')}}" class="nav-link @if(\Request::route()->getName() === 'change-pass') {{'active'}} @endif">
                            <i class="nav-icon fas fa-book"></i>
                            <p>
                                {{__('base.change_pass')}}
                            </p>
                        </a>
                    </li>

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
@show

@yield('content')

<!-- Main Footer -->
<footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="#">rol88.club</a>.</strong>
    Hotline : 0989 860 3768
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1    .1.0
    </div>
</footer>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{url('/')}}/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{url('/')}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="{{url('/')}}/plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="{{url('/')}}/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="{{url('/')}}/plugins/moment/moment.min.js"></script>
<script src="{{url('/')}}/plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- date-range-picker -->
<script src="{{url('/')}}/plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="{{url('/')}}/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{url('/')}}/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="{{url('/')}}/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- BS-Stepper -->
<script src="{{url('/')}}/plugins/bs-stepper/js/bs-stepper.min.js"></script>
<!-- dropzonejs -->
<script src="{{url('/')}}/plugins/dropzone/min/dropzone.min.js"></script>
<!-- AdminLTE App -->
<script src="{{url('/')}}/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{url('/')}}/dist/js/demo.js"></script>
<script>
    function setLocale(lan) {
        console.log(lan);
        $.ajax({
                headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                type: 'post',
                url: '{{route('set-locale')}}',
                data: {
                    'locale' : lan
                },
                success: function (response) {
                    console.log(response);
                    location.reload()
                },
                error: function (error) {
                    console.log(error);
                }
            }
        );
    }
</script>
@yield('script')
</body>
</html>