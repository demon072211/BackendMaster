
<!-- Stored in resources/views/child.blade.php -->
@extends('layouts')
@section('title', __('base.history'))
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{__('base.history')}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('base.home')}}</a></li>
                            <li class="breadcrumb-item active">{{__('base.history')}}</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <form method="get" action="{{route('transactions')}}">
                        <div class="card-body row">
                            <!-- Date -->
                            <div class="form-group col-3">
                                <label>{{__('base.since')}} :</label>
                                <div class="input-group date" id="fromDate" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" data-target="#fromDate" name="ft" value="{{request()->get('ft')}}">
                                    <div class="input-group-append" data-target="#fromDate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-3">
                                <label>{{__('base.to')}} :</label>
                                <div class="input-group date" id="toDate" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" data-target="#toDate"  name="et" value="{{request()->get('et')}}">
                                    <div class="input-group-append" data-target="#toDate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-3">
                                <label>{{__('base.status')}} :</label>
                                <div class="input-group date" id="toDate" data-target-input="nearest">
                                    <select class="form-control" name="st">
                                        <option @if(request()->get('st') === '') selected @endif value="">Chọn</option>
                                        <option @if(request()->get('st') === '0') selected @endif value="0">Pending</option>
                                        <option @if(request()->get('st') == '3') selected @endif value="3">Failed</option>
                                        <option @if(request()->get('st') == '2') selected @endif value="2">Success</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-body">

                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">{{__('base.search')}}</button>
                            <a href="{{route('transactions')}}" class="btn btn-primary">{{__('base.quit_search')}}</a>
                        </div>
                    </form>
                </div>
                <div class="row">
                    <div class="col-12">
                        @if (isset($error))
                            <div class="alert alert-info bg-danger">{{$error}}</div>
                        @endif
                    </div>
                    <div class="col-12">
                        @include('share.flash')
                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered table-hover table-responsive">
                                    <thead>
                                        <tr>
                                            <th>{{__('base.no.')}}</th>
                                            <th>{{__('base.user')}}</th>
                                            <th>{{__('base.agent_code')}}</th>
                                            <th>{{__('base.point')}}</th>
                                            <th>{{__('base.amount')}}</th>
                                            <th>{{__('base.fee')}}</th>
                                            <th>{{__('base.bonus')}}</th>
                                            <th>{{__('base.status')}}</th>
                                            <th>{{__('base.transferr')}}</th>
                                            <th>{{__('base.receiver')}}</th>
                                            <th>{{__('base.content')}}</th>
                                            <th>{{__('base.verifier')}}</th>
                                            <th>{{__('base.description')}}</th>
                                            <th>{{__('base.request_time')}}</th>
                                            <th>{{__('base.act')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($data) && $data->total())
                                        @php $i = $data->firstItem();@endphp
                                        @foreach($data as $item)
                                            <tr>
                                                <td>{{$i}}</td>
                                                <td>{{$item['Username']}}</td>
                                                <td>{{$item['AgentCode']}}</td>
                                                <td>{{$item['Point']}}</td>
                                                <td>
                                                    @if(!empty($item['Money']))
                                                        {{number_format($item['Money'])}}
                                                    @endif
                                                </td>
                                                <td>{{$item['Fee']}}</td>
                                                <td>{{$item['Bonus']}}</td>
                                                <td>{{maskStatusPoint($item['Status'])}}</td>
                                                <td>{{$item['FromBankNumber']}}</td>
                                                <td>{{$item['ToBankNumber']}}</td>
                                                <td>{{$item['Content']}}</td>
                                                <td>{{$item['UserApprove']}}</td>
                                                <td>{{$item['Description']}}</td>
                                                <td>{{$item['RequestTime']}}</td>
                                                <td>
                                                    @if($item['Status'] == 0)
                                                    <span style="color:#007bff;cursor:pointer" onclick="deleteAction({{$item['Id']}}, '{{$item['Money']}}')">{{__('base.cancel')}}</span>
                                                    @endif
                                                </td>
                                            @php $i++;@endphp
                                        @endforeach
                                    @else
                                        <tr>
                                            <td>
                                                {{__('base.not_found')}}
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                                <div class="float-right mt-3">
                                    @if(!empty($data))
                                        {{ $data->appends($params)->links() }}
                                    @endif
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <!-- Modal -->
    @include("transaction.delete")
    <!-- Modal -->
@endsection
@section('script')
    <script>
        function deleteAction(id, bn) {
            $('#deleteModalCenter').modal('show')
            $('#delete-content').html('{{__('base.are_you_sure_you_want_to_decline_the_transaction')}} : ' + bn);
            $('#delete-modal-bank').val(id);
        }

        $("#form-delete").submit(function( event ) {
            var data = $(this).serializeArray();
            $.ajax({
                    type: 'post',
                    url: '{{route('transaction-reject')}}',
                    data: data,
                    success: function (response) {
                        $('#deleteModalCenter').modal('hide');
                        console.log(response);
                        location.reload()
                    },
                    error: function (error) {
                        $('#deleteModalCenter').modal('hide');
                        console.log(error);
                        alert('{{__('base.fail')}}');
                    }
                }
            );
            event.preventDefault();
        });

        $(function () {
            //Date picker
            $('#fromDate').datetimepicker({
                format: 'Y-MM-DD',
                defaultDate: '{{$carbonNow->startOfMonth()->toDateString()}}'
            });
            $('#toDate').datetimepicker({
                format: 'Y-MM-DD',
                defaultDate:'{{$carbonNow->endOfMonth()->toDateString()}}'
            });
        })
    </script>
@endsection