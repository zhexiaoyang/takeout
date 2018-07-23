@extends('layouts.app')

@section('title', '打款统计')

@section('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                    <span>打款统计</span>
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    打款统计
                </header>
                <div class="row">
                    <form class="form-inline" role="form" action="{{route('finance.hit')}}" method="get">
                            <div class="col-lg-2">
                                <label class="sr-only" for="keyword">打款单号</label>
                                <input value="{{$keyword or ''}}" type="text" class="form-control" id="keyword" name="keyword" placeholder="打款单号...">
                            </div>
                            <div class="col-lg-2">
                                <select class="form-control pharmacy" name="shop_id">
                                    <option value="" @if(!$shop_id) selected @endif>全部药店</option>
                                    @foreach($shops as $shop)
                                        <option value="{{ $shop->id }}" @if($shop_id == $shop->id) selected @endif>{{ $shop->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <select class="form-control" name="status">
                                    <option value="-1" @if($status == (-1)) selected @endif>打款状态</option>
                                    <option value="0" @if($status === '0') selected @endif>未打款</option>
                                    <option value="1" @if($status === '1') selected @endif>已打款</option>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <input value="{{$stime or ''}}" type="text" class="form-control" id="stime" name="stime" placeholder="起始时间..." autocomplete="off">
                            </div>
                            <div class="col-lg-2">
                                <input value="{{$etime or ''}}" type="text" class="form-control" id="etime" name="etime" placeholder="结束时间..." autocomplete="off">
                            </div>
                            <div class="col-lg-2">
                                <button type="submit" class="btn btn-info">搜索</button>
                                <span type="submit" class="btn btn-info" onclick="bills()">批量打款</span>
                            </div>
                    </form>
                </div>
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th>选择</th>
                        <th>打款单号</th>
                        <th>药店名称</th>
                        <th>提点</th>
                        <th>账单开始时间</th>
                        <th>账单结束时间</th>
                        <th>销售金额</th>
                        <th>药店收益</th>
                        <th>应返金额</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($list))
                    @foreach ($list as $v)
                        <tr>
                            <td>
                                <input type="checkbox" class="hit" name="hid" value="{{ $v->id }}" shop_id="{{ $v->shop_id }}" returns="{{$v->return}}">
                            </td>
                            <td>{{$v->remit_id}}</td>
                            <td>{{$v->shop_name}}</td>
                            <td>{{$v->coefficient}}%</td>
                            <td>{{$v->start_time}}</td>
                            <td>{{$v->end_time}}</td>
                            <td>{{$v->sale_amount}}</td>
                            <td>{{$v->earnings}}</td>
                            <td>{{$v->return}}</td>
                            <td>
                                @if($v->status)
                                    <span class="btn btn-primary btn-xs">已打款</span>
                                @else
                                    @if(Auth::user()->hasRole('Superman'))
                                        <form action="{{ route('bill.status', $v->id) }}" method="post" style="display: inline" onsubmit="return alert(this, '确定打款么？')">
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-danger btn-xs">未打款</button>
                                        </form>
                                        @else
                                        <button type="submit" class="btn btn-danger btn-xs">未打款</button>
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if(Auth::user()->hasRole('Superman'))
                                    <form action="{{ route('bill.reset', $v->id) }}" method="post" style="display: inline" onsubmit="return alert(this, '确定重新生成账单么？')">
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn btn-info btn-xs">重新生成</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    @endif
                    </tbody>
                </table>
                <div style="margin-left: 10px">
                    {!! $list->appends(['keyword' => $keyword,'status' => $status,'shop_id' => $shop_id,'stime' => $stime,'etime' => $etime])->render() !!}
                </div>
            </section>
        </div>
    </div>
@endsection
@section('scripts')

    <script type="text/javascript"  src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script type="text/javascript"  src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script type="text/javascript"  src="{{ asset('js/bootstrap-datetimepicker.zh-CN.js') }}"></script>
    <script type="text/javascript" src="https://cdn.bootcss.com/select2/4.0.5/js/select2.min.js"></script>

    <script>
        function up_goods() {
            $(".close").click();
            return false;
        }
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

        function bills() {
            var shop_id = '';
            var break_each = 0;
            $("input:checkbox:checked").each(function () {
                if (shop_id == '')
                {
                    shop_id = $(this).attr('shop_id');
                }
                if (shop_id != $(this).attr('shop_id'))
                {
                    break_each = 1;
                    return false;
                }
            })
            if (break_each == 1)
            {
                swal({
                    title: "所选记录不是同一药店",
                    type: "error",
                    timer: 2000,
                    showConfirmButton: false
                });
                return;
            }
            if (shop_id == '')
            {
                swal("请选择需要打款记录");
                return;
            }else{
                $.get("{{ route('shop_details.info') }}/"+ shop_id, function (res){
                    if (res == [] || !res.account_number || !res.opening_bank || !res.username)
                    {
                        swal({
                            title: "该药店暂无打款帐号",
                            type: "error",
                            timer: 2000,
                            showConfirmButton: false
                        });
                        return;
                    }else{
                        var total = 0;
                        $("input:checkbox:checked").each(function(){
                            total += parseFloat($(this).attr('returns'));
                        });
                        total = total.toFixed(2);
                        swal({
                            title: '打款确认',
                            html:true,
                            text: "<p style='text-align: left'>开户名："+res.username+"<span style='margin-left: 40px;color: red;font-weight: 600;'>金额："+total+"</span></p><p style='text-align: left'>打款账号："+res.account_number+"</p><p style='text-align: left'>开户行："+res.opening_bank+"</p>",
                            showCancelButton: true,
                            closeOnConfirm: false,
                            confirmButtonColor: '#53bee6',
                            cancelButtonColor: '#d33',
                            cancelButtonText: '取消打款',
                            confirmButtonText: '确定打款',
                        },
                        function(){
                            var bids = new Array();
                            var i=0;
                            $("input:checkbox:checked").each(function(){
                                // console.log($(this).val());
                                bids[i++] = $(this).val();
                            });
                            $.post("{{ route('bill.updates') }}", {'bids':bids,'_token': $('meta[name="csrf-token"]').attr('content')}, function (res) {
                                if (res.code == 0)
                                {
                                    swal({
                                        title: "打款成功",
                                        type: "success",
                                        timer: 1500,
                                        showConfirmButton: false
                                    }, function () {
                                        setTimeout(function () {
                                            history.go(0)
                                        },500)
                                    });
                                }else{
                                    swal({
                                        title: "打款失败",
                                        type: "error",
                                        timer: 1500,
                                        showConfirmButton: false
                                    });
                                }
                            })
                        });
                    }
                })
            }
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
    @if (Session::has('alert_err'))
        <script>
            swal("出错啦！", "{{ Session::get('alert_err') }}")
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
