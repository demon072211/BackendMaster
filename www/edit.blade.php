
<!-- Stored in resources/views/child.blade.php -->
@extends('layouts')
@section('title', 'Trang chủ')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{__('base.bank_edit')}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('base.home')}}</a></li>
                            <li class="breadcrumb-item active">{{__('base.bank_edit')}}</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <form class="col-sm-6" action="{{route('bank-update', $data['id'])}}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>{{__('base.bank_account')}} (*)</label>
                                <input type="text" name="ba" value="{{$data['bank_acount']}}" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>{{__('base.bank_code')}} (*)</label>
                                <select class="form-control" name="bc" required>
                                    @foreach($listCodeBank as $item)
                                        <option value="{{$item['code']}}" @if($item['code'] == $data['bank_code']) selected @endif>{{$item['code']}}</option>
                                    @endforeach
                                </select>
                                {{--<input type="text" name="bc" value="{{$data['bank_code']}}" class="form-control" required>--}}
                            </div>
                            <div class="form-group">
                                <label>{{__('base.account_number')}} (*)</label>
                                <input type="text" name="bn" value="{{$data['bank_number']}}" class="form-control"  required>
                            </div>
                            <div class="form-group">
                                <label>{{__('base.branch')}} (*)</label>
                                <input type="text" name="br" value="{{$data['bank_branch']}}" class="form-control" required>
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