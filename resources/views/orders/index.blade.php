@extends('layouts.app')

@section('title', '订单列表')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-reset.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert.css') }}">
    <style type="text/css">
        .ft[_v-1fbece8c]{border-top:1px dashed #ccc;padding:10px 25px}.btnCode[_v-1fbece8c]{padding:5px;font-size:12px}
        .redColor[_v-1fbece8c] {color: #db2828!important;}
        .t-condition-detail ul li[_v-1fbece8c]{border:1px solid #ccc;position:relative;margin-bottom:20px}
        .t-condition-detail ul li .title[_v-1fbece8c]{color:#777;padding:16px 20px;background-color:#eee}
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
    </style>
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
                            <div class="form-group">
                                <label class="sr-only" for="keyword">关键字</label>
                                <input value="{{$keyword or ''}}" type="text" class="form-control" id="keyword" name="keyword" placeholder="关键字...">
                            </div>
                            <button type="submit" class="btn btn-info">搜索</button>
                        </form>
                    </div>
                </header>

                <ul _v-1fbece8c="">
                    <li _v-1fbece8c="">
                        <div class="content-box content-box-checkbox" _v-1fbece8c="">
                            <div class="title" _v-1fbece8c="">
                                <button class="ui primary basic button btnCode" _v-1fbece8c=""># 11</button>
                                <span _v-1fbece8c="">
                    <strong _v-1fbece8c="" style="margin-left: 10px">123123123</strong>
                </span>
                                <strong class="orderTimes" _v-1fbece8c="">门店：yaof</strong>
                                <span class="orderTimes" _v-1fbece8c="">配送员：来 总订单：11</span>
                                <span class="orderState" _v-1fbece8c="">允许超时</span>
                                <span class="orderState" _v-1fbece8c="">第三方允许超时</span>
                                <strong class="time redColor" style="float: right" _v-1fbece8c="">订单状态：正常</strong>
                            </div>
                            <div class="content" _v-1fbece8c="">
                <span _v-1fbece8c="">
                    <div _v-1fbece8c="">
                        <div _v-1fbece8c="">
                                <span class="orderName redBg" _v-1fbece8c="" style="background: #09cf0e">
                                    <span class="redBg" _v-1fbece8c="" style="background: #09b20d">配送剩余<strong _v-1fbece8c="">12</strong></span>
                                </span>
                        </div>
                    </div>
                </span>
                                <div class="right" _v-1fbece8c="">
                                    <p class="comment" _v-1fbece8c="">
                        <span class="info" _v-1fbece8c="">
                            <span>金额：<strong _v-1fbece8c="">¥ 11</strong></span>
                            <span>支付：<strong _v-1fbece8c="">11、22</strong></span>
                            <span>来源：<strong _v-1fbece8c="">美团</strong></span>
                        </span>
                                    </p>
                                    <p class="comment" _v-1fbece8c=""><span _v-1fbece8c="">时间：</span>2019-5-1</p>
                                    <p class="comment @{{#  if( order.USER_BL ){ }} redColor @{{#  } }}" _v-1fbece8c=""><span _v-1fbece8c="">客户：</span>张三</p>
                                    <p class="comment" _v-1fbece8c=""><span _v-1fbece8c="">地址：</span>苏州街</p>
                                    @{{#  if( order.DHBZ ){ }}
                                    <p class="comment" _v-1fbece8c=""><strong _v-1fbece8c="">备注：多放辣</strong></p>
                                    @{{#  } }}
                                </div>
                            </div>
                            <div class="ft" _v-1fbece8c="">
                                <a href="@{{ order.URL_ORDER_DETAIL }}" target="_blank" class="layui-btn layui-btn-xs">订单查询</a>
                            </div>
                        </div>
                    </li>
                </ul>

                <div style="margin-left: 10px">
                    {!! $orders->appends(['keyword' => $keyword])->render() !!}
                </div>
            </section>
        </div>
    </div>
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

@stop