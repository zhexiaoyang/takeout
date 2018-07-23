@extends('layouts.app')

@section('title', '订单列表')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-reset.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="https://cdn.bootcss.com/select2/4.0.6-rc.1/css/select2.min.css">
@stop

@section('content')
    @include('common.error')
    <div class="row" style="margin: -15px;">
        <div class="span6">
            <ul class="breadcrumb">
                <li>
                    <a href="{{route('index.index')}}">主页</a> <span class="divider">></span>
                </li>
                <li>
                    <span>订单列表</span>
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    订单列表
                    <div class="panel-body">
                        <form class="form-inline" role="form" action="{{route('orders.index')}}" method="get">
                            <div class="col-lg-3">
                                <select class="form-control pharmacy" name="shop_id">
                                    <option value="" @if(!$shop_id) selected @endif>全部药店</option>
                                    @foreach($shops as $shop)
                                        <option value="{{ $shop->id }}" @if($shop_id == $shop->id) selected @endif>{{ $shop->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label class="sr-only" for="keyword">关键字</label>
                                <input value="{{$keyword or ''}}" type="text" class="form-control" id="keyword" name="keyword" placeholder="关键字...">
                            </div>
                            <div class="col-lg-2">
                                <input value="{{$stime or ''}}" type="text" class="form-control" id="stime" name="stime" placeholder="起始时间..." autocomplete="off">
                            </div>
                            <div class="col-lg-2">
                                <input value="{{$etime or ''}}" type="text" class="form-control" id="etime" name="etime" placeholder="结束时间..." autocomplete="off">
                            </div>
                            <button type="submit" class="btn btn-info">搜索</button>
                        </form>
                    </div>
                </header>
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th>订单号</th>
                        <th>门店</th>
                        <th>支付金额</th>
                        @if(Auth::user()->hasAnyRole(\Spatie\Permission\Models\Role::all()))
                        <th>药店收益</th>
                        <th>应返金额</th>
                        @endif
                        <th>状态</th>
                        <th>创建时间</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>
                                <a target="_blank" href="{{route('orders.show', $order->id)}}">{{$order->order_id}}</a>
                            </td>
                            <td>{{$order->shop->name}}</td>
                            <td>{{$order->total}}</td>
                            @if(Auth::user()->hasAnyRole(\Spatie\Permission\Models\Role::all()))
                            <td>{{$order->earnings($order->id)}}</td>
                            <td>{{$order->refunds($order->id)}}</td>                        @endif

                            <td>{{ config('wm.order_status')[$order->status] }}</td>
                            <td>{{$order->created_at}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div style="margin-left: 10px">
                    {!! $orders->appends(['keyword' => $keyword,'stime' => $stime,'etime' => $etime])->render() !!}
                </div>
            </section>
        </div>
    </div>
@endsection

@section('scripts')

    <script type="text/javascript" src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap-datetimepicker.zh-CN.js') }}"></script>
    <script type="text/javascript" src="https://cdn.bootcss.com/select2/4.0.5/js/select2.min.js"></script>

    <script>
        function alert(obj, mes) {
            swal({
                    title: mes,
                    text: "",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "确定！",
                    cancelButtonText: "取消！",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm){
                    if (isConfirm) {
                        obj.submit();
                    } else {
                        swal("操作被取消!", "","error");
                        swal({
                            title: "操作被取消！",
                            type: "error",
                            timer: 1000,
                            showConfirmButton: false
                        });
                    }
                });
            return false;
        }
    </script>
    @if (Session::has('alert'))
        <script>
            swal({
                title: "{{ Session::get('alert') }}",
                type: "success",
                timer: 1000,
                showConfirmButton: false
            });
        </script>
    @endif
    @if (Session::has('errors'))
        <script>
            swal({
                title: "{{ Session::get('errors') }}",
                type: "error",
                timer: 2000,
                showConfirmButton: false
            });
        </script>
    @endif
    <script>
        $(function () {
            $('#stime').datetimepicker({
                language:"zh-CN",
                format:'yyyy-mm-dd',
                autoclose: true,
                minView: 2
            }).on('changeDate',function(e){
                var startTime = e.date;
                $('#etime').datetimepicker('setStartDate',startTime);
            });
            $('#etime').datetimepicker({
                language:"zh-CN",
                format:'yyyy-mm-dd',
                autoclose: true,
                minView: 2
            }).on('changeDate',function(e){
                var endTime = e.date;
                $('#stime').datetimepicker('setEndDate',endTime);
            });
            $('.pharmacy').select2();
        })
    </script>

@stop