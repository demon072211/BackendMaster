<!-- Stored in resources/views/child.blade.php -->
@extends('layouts')
@section('title', __('base.withdrawal_history'))
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{__('base.withdrawal_history')}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('base.home')}}</a></li>
                            <li class="breadcrumb-item active">{{__('base.withdrawal_history')}}</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <form method="get" action="{{route('withdraw')}}">
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
                                <label>{{__('base.nick_name')}} :</label>
                                <div class="input-group date" id="toDate" data-target-input="nearest">
                                    <input type="text" class="form-control "   name="nn" value="{{request()->get('nn')}}">
                                </div>
                            </div>

                            <div class="form-group col-3">
                                <label>{{__('base.status')}} :</label>
                                <div class="input-group date" id="toDate" data-target-input="nearest">
                                    <select class="form-control" name="st">
                                        <option @if(request()->get('st') === '') selected @endif value="">Chọn</option>
                                        <option @if(request()->get('st') === '0') selected @endif value="0">Pending</option>
                                        <option @if(request()->get('st') == '3') selected @endif value="3">Failed</option>
                                        <option @if(request()->get('st') == '4') selected @endif value="4">Success</option>
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
                            <a href="{{route('withdraw')}}" class="btn btn-primary">{{__('base.quit_search')}}</a>
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
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>{{__('base.no.')}}</th>
                                        <th>{{__('base.nick_name')}}</th>
                                        <th>{{__('base.bank_code')}}</th>
                                        <th>{{__('base.type')}}</th>
                                        <th>{{__('base.amount')}}</th>
                                        <th>{{__('base.status')}}</th>
                                        <th>{{__('base.account_number')}}</th>
                                        <th>{{__('base.account_name')}}</th>
                                        <th>{{__('base.transaction_id')}}</th>
                                        <th>{{__('base.date_created')}}</th>
                                        <th>{{__('base.act')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($data) && $data->total())
                                        @php $i = $data->firstItem();@endphp
                                        @foreach($data as $item)
                                            <tr>
                                                <td>
                                                    {{$i}}
                                                </td>
                                                <td>{{$item['Nickname']}}</td>
                                                <td>{{$item['BankCode']}}</td>
                                                <td>
                                                    @if($item['ProviderName'] == "manual")
                                                        {{__('base.transfera')}}
                                                    @else
                                                        {{$item['ProviderName']}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty($item['Amount']))
                                                        {{number_format($item['Amount'])}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($item['Status'] == 0)
                                                        Pending
                                                    @elseif($item['Status'] == 3)
                                                        Failed
                                                    @elseif($item['Status'] == 4)
                                                        Success
                                                    @endif
                                                </td>
                                                <td>{{$item['BankAccountNumber']}}</td>
                                                <td>{{$item['BankAccountName']}}</td>
                                                <td>{{empty($item['CartId']) ? '' : $item['CartId']}}</td>
                                                <td>{{$item['CreatedAt']}}</td>
                                                <td>
                                                    @if($item['Status'] == 0)
                                                        <span style="color:#007bff;cursor:pointer" onclick="rejectAction({{$item['Id']}}, '{{$item['Amount']}}')" class="mr-2">
                                                            {{__('base.cancel')}}
                                                        </span>
                                                        <span style="color:#007bff;cursor:pointer" onclick="approveAction({{$item['Id']}}, '{{$item['Amount']}}')">
                                                            {{__('base.approve')}}
                                                        </span>
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
    @include("topup.reject")
    @include("topup.approveWithDraw")
    <!-- Modal -->
@endsection
@section('script')
    <script>
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

        function rejectAction(id, bn) {
            $('#rejectModalCenter').modal('show')
            $('#delete-content').html('{{__('base.are_you_sure_you_want_to_decline_the_transaction')}} : ' + bn);
            $('#reject-modal').val(id);
        }

        $("#form-reject").submit(function( event ) {
            var data = $(this).serializeArray();
            $.ajax({
                    type: 'post',
                    url: '{{route('withdraw-reject')}}',
                    data: data,
                    success: function (response) {
                        $('#rejectModalCenter').modal('hide');
                        console.log(response);
                        location.reload()
                    },
                    error: function (error) {
                        $('#rejectModalCenter').modal('hide');
                        console.log(error);
                        alert('{{__('base.fail')}}');
                    }
                }
            );
            event.preventDefault();
        });


        function approveAction(id, bn) {
            $('#approveModalCenter').modal('show')
            $('#approve-content').html('{{__('base.are_you_sure_you_want_to_approve_the_transaction')}} : ' + bn);
            $('#approve-modal').val(id);
        }

        $("#form-approve").submit(function( event ) {
            var data = $(this).serializeArray();
            $.ajax({
                    type: 'post',
                    url: '{{route('withdraw-approve')}}',
                    data: data,
                    success: function (response) {
                        $('#approveModalCenter').modal('hide');
                        console.log(response);
                        location.reload()
                    },
                    error: function (error) {
                        $('#approveModalCenter').modal('hide');
                        console.log(error);
                        alert('{{__('base.fail')}}');
                    }
                }
            );
            event.preventDefault();
        });
    </script>
@endsection