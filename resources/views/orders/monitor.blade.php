@extends('layouts.app')

@section('title', '订单监控')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-reset.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert.css') }}">
    <style type="text/css">
        .ft[_v-1fbece8c]{border-top:1px dashed #ccc;padding:10px 25px}.btnCode[_v-1fbece8c]{padding:5px;font-size:12px}
        .redColor[_v-1fbece8c] {color: #db2828!important;}
        .t-condition-detail ul li[_v-1fbece8c]{border:1px solid #ccc;position:relative;margin-bottom:20px}
        .t-condition-detail ul li .title[_v-1fbece8c]{color:#777;padding:10px 20px;background-color:#eee}
        .t-condition-detail .content[_v-1fbece8c]{margin:0 20px}
        .t-condition-detail ul li .orderName[_v-1fbece8c]{width:84px;height:84px;background-color:#ff9b9b;float:left;color:#fff;border-radius:50%;padding:4px}
        .t-condition-detail ul li .orderName span[_v-1fbece8c]{width:100%;height:100%;background-color:#fa4e4e;border-radius:50%;border:4px solid #fff;display:block;text-align:center;font-size:14px;padding:17px 6px;box-sizing: border-box}
        .t-condition-detail ul li .orderName strong[_v-1fbece8c]{font-size:22px}
        .right[_v-1fbece8c]{margin:10px 0 0 136px;position:relative}
        .orderState[_v-1fbece8c]{margin-left:26px;padding:2px 5px;border:1px solid #db2828;color:#db2828;border-radius:16px;font-size:12px}
        .info[_v-1fbece8c] span{margin-left:26px}
        .orderTimes[_v-1fbece8c]{margin-left:26px}
        .replay-msg p[_v-1fbece8c]{text-align:right}
        .right .comment[_v-1fbece8c]{margin-bottom:12px}
        .right .comment .info[_v-1fbece8c]{float:right;width:auto}
        .right .comment .info strong[_v-1fbece8c]{color:#666}
        .right .comment span[_v-1fbece8c]{width:80px;display:inline-block;color:#999}
        .ui.basic.primary.button, .ui.basic.primary.buttons .button {box-shadow: 0 0 0 1px #2185D0 inset;color: #2185D0;border: none;}
        .layui-row .layui-col-md2 {width: 14%}
        .layui-btn+.layui-btn { margin-left: 0px;}
        .layui-form-pane .layui-row .layui-col-md1 {width: 8.33333333%}
        .ui.basic.primary.button, .ui.basic.primary.buttons .button {
            box-shadow: 0 0 0 1px #2185D0 inset!important;
            color: #2185D0!important;
        }
    </style>
@stop

@section('content')

    <div class="row" style="margin: -15px;">
        <div class="span6">
            <ul class="breadcrumb">
                <li>
                    <a href="{{route('index.index')}}">主页</a> <span class="divider">></span>
                </li>
                <li>
                    <span>订单监控</span>
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    订单监控
                    <div class="panel-body">
                        <form class="form-inline" role="form" action="{{route('index.index')}}" method="get">
                            <div class="col-lg-10">
                                <div class="row">
                                    <div class="col-lg-2">
                                        <label class="sr-only" for="keyword">关键字</label>
                                        <input value="{{$keyword or ''}}" type="text" class="form-control" id="keyword" name="keyword" placeholder="关键字...">
                                    </div>
                                    <div class="col-lg-2">
                                        <select class="form-control" name="status">
                                            <option value="" @if(!$status) selected @endif>全部</option>
                                            <option value="3" @if($status == 3) selected @endif>待打印</option>
                                            <option value="8" @if($status == 8) selected @endif>配送中</option>
                                            <option value="25" @if($status == 25) selected @endif>已取消</option>
                                            <option value="33" @if($status == 33) selected @endif>已完成</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <button type="submit" class="btn btn-info">搜索</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </header>

                <div class="ui bottom attached tab segment active" data-tab="seven" _v-5873fc14="">
                    <div class="content-pick-box dimmable" id="content-pick-box1" _v-1fbece8c="" _v-5873fc14="">
                        <div class="t-condition-detail" _v-1fbece8c="">
                            <ul _v-1fbece8c="">
                                @if(!empty($orders))
                                @foreach($orders as $order)
                                <li _v-1fbece8c="">
                                    <div class="content-box content-box-checkbox" _v-1fbece8c="">
                                        <div class="title" _v-1fbece8c="">
                                            <span _v-1fbece8c="">
                                                @if($order->delivery_time)
                                                    <strong _v-1fbece8c="" style="color: #db2828">送达时间：{{date("Y-m-d H:i:s", $order->delivery_time)}}</strong>
                                                @else
                                                    <strong _v-1fbece8c="">立即送达</strong>
                                                @endif
                                            </span>
                                            <span class="orderTimes" _v-1fbece8c="">创建订单时间：{{ $order->created_at }}</span>
                                            <strong class="time redColor" style="float: right" _v-1fbece8c="">{{ config('wm.order_status')[$order->status] }}</strong>
                                        </div>
                                        <div class="content" _v-1fbece8c="">
                                            <span _v-1fbece8c="">
                                                <span class="orderName grayBg" _v-1fbece8c="">
                                                    <span class="grayBg" style="line-height: 30px; font-size: 18px" _v-1fbece8c="">
                                                        @if($order->status == 25)
                                                            已取消
                                                        @elseif($order->status > 30)
                                                            已完成
                                                        @else
                                                            {{ floor((time() - strtotime($order->created_at))/60) }}
                                                        @endif
                                                    </span>
                                                </span>
                                            </span>
                                            <div class="right" _v-1fbece8c="">
                                                <p class="comment" _v-1fbece8c="">
                                                    <span class="info" _v-1fbece8c="">
                                                        客户实付：
                                                        <strong _v-1fbece8c="">¥ {{$order->total or 0}}</strong>
                                                    </span>
                                                </p>
                                                <p class="comment" _v-1fbece8c="">
                                                    <span _v-1fbece8c="">客户：</span>
                                                    {{$order->recipient_name or ''}}
                                                    （电话：{{$order->recipient_phone or ''}}）
                                                </p>
                                                <p class="comment" _v-1fbece8c="">
                                                    <span _v-1fbece8c="">地址：</span>{{$order->recipient_address or ''}}
                                                </p>
                                                <p class="comment" _v-1fbece8c="">
                                                    <span _v-1fbece8c="">订单编号：</span>

                                                    <a target="_blank" _v-1fbece8c="" href="{{route('orders.show', $order->id)}}">{{$order->order_id}}</a>
                                                </p>
                                                <p class="comment" _v-1fbece8c="">
                                                    <span _v-1fbece8c="">门店：</span>{{$order->shop->name}}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="ft" _v-1fbece8c="">
                                            @if($order->status < 20)
                                                <form action="{{ route('orders.confirm', $order->id) }}" method="post" style="display: inline" onsubmit="return alert(this, '确认该订单么？')">
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="btn btn-success btn-xs">确认订单</button>
                                                </form>
                                                <form action="{{ route('orders.delivering', $order->id) }}" method="post" style="display: inline" onsubmit="return alert(this, '确认配送该订单么？')">
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="btn btn-info btn-xs">配送订单</button>
                                                </form>
                                                <form action="{{ route('orders.cancel', $order->id) }}" method="post" style="display: inline" onsubmit="return alert(this, '确认取消订单么？')">
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="btn btn-danger btn-xs">取消订单</button>
                                                </form>
                                            @endif
                                            <a target="_blank" _v-1fbece8c="" href="{{route('orders.printOrder', $order->id)}}">
                                                <button class="btn btn-success btn-xs">打印小票</button>
                                            </a>
                                            <a target="_blank" _v-1fbece8c="" href="{{route('orders.show', $order->id)}}">
                                                <button class="btn btn-success btn-xs">查看订单</button>
                                            </a>
                                            @if( $order->apply_cancel)
                                                <span _v-1fbece8c="" style="margin-left: 20px">
                                                    <strong _v-1fbece8c="" style="color: #db2828">申请取消</strong>
                                                </span>
                                                <a target="_blank" _v-1fbece8c="" href="{{route('orders.show', $order->id)}}">
                                                    <button class="btn btn-danger btn-xs" style="margin-left: 10px">处理问题</button>
                                                </a>
                                            @endif
                                            @if( $order->apply_refund)
                                                <span _v-1fbece8c="" style="margin-left: 20px">
                                                    <strong _v-1fbece8c="" style="color: #db2828">申请退款:{{ $order->refund_money }}元</strong>
                                                </span>
                                                    <a target="_blank" _v-1fbece8c="" href="{{route('orders.show', $order->id)}}">
                                                        <button class="btn btn-danger btn-xs" style="margin-left: 10px">处理问题</button>
                                                    </a>
                                            @endif
                                            @if($order->status < 20)
                                                @if($order->shop->dc == 1)
                                                    <form action="{{ route('orders.arrived', $order->id) }}" method="post" style="display: inline" onsubmit="return alert(this, '确认完成订单么？')">
                                                        {{ csrf_field() }}
                                                        <button type="submit" class="btn btn-success btn-xs">完成订单</button>
                                                    </form>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <div style="margin-left: 10px">
                    {!! $orders->appends(['keyword' => $keyword])->render() !!}
                </div>
            </section>
        </div>
    </div>
    {{--<audio id="waitPrintMusic" src="{{ asset('img/waitPrintMusic.mp3') }}"></audio>--}}
    <div id="audioBox" style="display: none"></div>
@endsection

@section('scripts')

    <script type="text/javascript"  src="{{ asset('js/sweetalert.min.js') }}"></script>

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
        var music = new Array();
        @if(count($print_orders) > 0)
            music[0] = "{{ asset('img/waitPrintMusic.mp3') }}";
        @endif

        @if(count($apply_cancels) > 0)
            music[1] = "{{ asset('img/qxsqMusic.mp3') }}";
        @endif

        @if(count($refunds) > 0)
            music[2] = "{{ asset('img/shdMusic.mp3') }}";
        @endif
        {{--var arr = ["{{ asset('img/waitPrintMusic.mp3') }}","{{ asset('img/shdMusic.mp3') }}","{{ asset('img/qxsqMusic.mp3') }}"];--}}
        var myAudio = new Audio();
        setTimeout(function(){
            openMusic();
        },3000);

        function openMusic() {
            myAudio.preload = true;
            myAudio.controls = true;
            myAudio.src = music.pop();
            myAudio.addEventListener('ended', playEndedHandler, false);
            myAudio.play();
            document.getElementById("audioBox").appendChild(myAudio);
            myAudio.loop = false;
        }
        function playEndedHandler(){
            myAudio.src = music.pop();
            myAudio.play();
            !music.length && myAudio.removeEventListener('ended',playEndedHandler,false);
        }
    </script>

    <script>
            setTimeout(function () {
                history.go(0)
            },30000)
    </script>

@stop