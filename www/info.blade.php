<!-- Stored in resources/views/child.blade.php -->
@extends('layouts')
@section('title', __('base.account_information'))
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{__('base.account_information')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('base.home')}}</a></li>
                        <li class="breadcrumb-item active">{{__('base.account_information')}}</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>

<!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            @include('share.flash')
            <div class="card card-primary">
                <form class="col-sm-6" action="{{route('user-info')}}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>{{__('base.agent_name')}}</label>
                            <input type="text" name="na" class="form-control" value="{{empty($userInfo['nameagent']) ? '' : $userInfo['nameagent']}}">
                        </div>

                        <div class="form-group">
                            <label>{{__('base.address')}}</label>
                            <input type="text" name="adr" class="form-control" value="{{empty($userInfo['address']) ? '' : $userInfo['address']}}">
                        </div>
                        <div class="form-group">
                            <label>{{__('base.phone_number')}}</label>
                            <input type="text" name="ph" class="form-control" value="{{empty($userInfo['phone']) ? '' : $userInfo['phone']}}">
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="em" class="form-control" value="{{empty($userInfo['email']) ? '' : $userInfo['email']}}">
                        </div>

                        <div class="form-group">
                            <label>{{__('base.facebook')}}</label>
                            <input type="text" name="fa" class="form-control" value="{{empty($userInfo['facebook']) ? '' : $userInfo['facebook']}}">
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="col-12">
                        @if (isset($error))
                            <div class="alert alert-info bg-danger">{{$error}}</div>
                        @endif
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">{{__('base.confirm')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection