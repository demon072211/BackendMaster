
<!-- Stored in resources/views/child.blade.php -->
@extends('layouts')
@section('title', __('base.add'))
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{__('base.add')}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('base.home')}}</a></li>
                            <li class="breadcrumb-item active">{{__('base.add')}}</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <form class="col-sm-6" action="{{route('transaction-store')}}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>{{__('base.amount')}} (*)</label>
                                <input type="text" name="m" class="form-control" required autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label>{{__('base.transferr')}} (*)</label>
                                <select class="form-control" name="fbn" required>
                                    @foreach($bankFrom as $value)
                                        <option @if(request()->get('fbn') == $value['bank_number']) @endif value="{{$value['bank_number']}}">{{$value['bank_acount']}} - {{$value['bank_branch']}}</option>
                                    @endforeach
                                </select>
                                {{--<input type="text" name="fbn" class="form-control"  required autocomplete="off">--}}
                            </div>
                            <div class="form-group">
                                <label>{{__('base.receiver')}} (*)</label>
                                <select class="form-control" name="tbn">
                                    @foreach($banks as $key => $value)
                                        <option @if(request()->get('tbn') == $value) @endif value="{{$value}}">{{$key}}</option>
                                    @endforeach
                                </select>
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
@section('script')
@endsection