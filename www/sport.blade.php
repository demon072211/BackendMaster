<!-- Stored in resources/views/child.blade.php -->
@extends('layouts')
@section('title', __('base.game_stats'))
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{__('base.game_stats')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('base.home')}}</a></li>
                        <li class="breadcrumb-item active">{{__('base.game_stats')}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="row">
                    <div class="col-12 col-sm-12">
                        <div class="card card-primary card-outline card-tabs">
                            @include('gameStatic.tab')
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-three-tabContent">
                                    <div class="tab-pane fade show active" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                                        <div class="card card-primary">
                                            <form method="get" action="{{route('game', ['type' => $params['type']])}}">
                                                <div class="card-body row">
                                                    <div class="form-group col-4">
                                                        <label>{{__('base.since')}} :</label>
                                                        <div class="input-group date" id="fromDate" data-target-input="nearest">
                                                            <input type="text" class="form-control datetimepicker-input" data-target="#fromDate" name="ft" value="{{request()->get('ft')}}">
                                                            <div class="input-group-append" data-target="#fromDate" data-toggle="datetimepicker">
                                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-4">
                                                        <label>{{__('base.to')}} :</label>
                                                        <div class="input-group date" id="toDate" data-target-input="nearest">
                                                            <input type="text" class="form-control datetimepicker-input" data-target="#toDate"  name="et" value="{{request()->get('et')}}">
                                                            <div class="input-group-append" data-target="#toDate" data-toggle="datetimepicker">
                                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-4">
                                                        <label>{{__('base.nick_name')}} :</label>
                                                        <input type="text" class="form-control "  name="nn" value="{{request()->get('nn')}}">
                                                    </div>
                                                </div>
                                                <!-- /.card-body -->
                                                <div class="card-body">

                                                </div>
                                                <!-- /.card-body -->
                                                <div class="card-footer">
                                                    <button type="submit" class="btn btn-primary">{{__('base.search')}}</button>
                                                    <a href="{{route('game', ['type' => $params['type']])}}" class="btn btn-primary">{{__('base.quit_search')}}</a>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                @if (isset($error))
                                                <div class="alert alert-info bg-danger">{{$error}}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 mb-2 text-right">
                                                {{__('base.total_records')}} : @if(!empty($data)) {{$data->total()}} @endif
                                            </div>
                                            <div class="col-12">
                                                <div class="card">
                                                    <!-- /.card-header -->
                                                    <div class="card-body table-responsive p-0">
                                                        <table class="table table-hover text-nowrap">
                                                            <thead>
                                                            <tr>
                                                                <th>{{__('base.no.')}}</th>
                                                                <th>{{__('base.nick_name')}}</th>
                                                                <th>{{__('base.time')}}</th>
                                                                <th>{{__('base.sport_ibc')}}</th>
                                                                <th>{{__('base.sport_cmd')}}</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @if(!empty($data) && $data->total())
                                                            @foreach($data as $item)
                                                            <tr>
                                                                <td>{{$firstItem}}</td>
                                                                <td>{{$item['nick_name']}}</td>
                                                                <td>{{$item['time_report']}}</td>
                                                                <td>{{$item['ibc']}}</td>
                                                                <td>{{$item['cmd']}}</td>
                                                            </tr>
                                                            @php $firstItem++; @endphp
                                                            @endforeach
                                                            @endif
                                                            </tbody>
                                                        </table>
                                                        <div class="float-right mt-3">
                                                            @if(!empty($data))
                                                            {{ $data->appends($params)->links() }}
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('script')
<script>
    $(function () {
        $(function () {
            //Date picker
            $('#fromDate').datetimepicker({
                format: 'Y-MM-DD',
                defaultDate: '{{date("Y-m-d",strtotime("-7 days"))}}'
            });
            $('#toDate').datetimepicker({
                format: 'Y-MM-DD',
                defaultDate:new Date()
            });
        })
    })
</script>
@endsection