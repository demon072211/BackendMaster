<!-- Stored in resources/views/child.blade.php -->
@extends('layouts')
@section('title', __('base.home'))
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{__('base.dashboard')}}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('base.home')}}</a></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    
                    <div class="info-box mb-3 bg-warning">
                        <span class="info-box-icon"><i class="fas fa-tag"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">{{__('base.referral_link')}}</span>
                            <span class="info-box-text"><a href="https://rol88.club/?refcode={{session('info.code')}}" target="_blank">https://rol88.club/?refcode={{session('info.code')}}</a></span>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>
</div>
<!-- /.content-wrapper -->
@endsection
@section('script')
    <script>
        function myFunction(text, option) {
            /* Copy the text inside the text field */
            navigator.clipboard.writeText(text);
            if (option == '1') {
                $('#one').css("color", "red");
                $('#two').css("color", "white");
                $('#three').css("color", "white");
            }
            if (option == '2') {
                $('#two').css("color", "red");
                $('#one').css("color", "white");
                $('#three').css("color", "white");
            }
            if (option == '3') {
                $('#three').css("color", "red");
                $('#one').css("color", "white");
                $('#two').css("color", "white");
            }
        }
    </script>
@endsection
