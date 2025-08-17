<!-- Stored in resources/views/child.blade.php -->
@extends('layouts')
@section('title', __('base.change_pass'))
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{__('base.change_pass')}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('base.home')}}</a></li>
                            <li class="breadcrumb-item active">{{__('base.change_pass')}}</li>
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
                    <form class="col-sm-6" action="{{route('change-password')}}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>{{__('base.old_pass')}} (*)</label>
                                <input type="text" name="op" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>{{__('base.new_pass')}} (*)</label>
                                <input type="text" name="np" class="form-control" required>
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