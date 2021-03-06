@extends('layouts.app')

@section('title', '订单详情')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/order.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/base.v2.0.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/block.v2.0.css') }}">
    <style type="text/css">
        #pageAudit {background: #fff;}
        #pageAudit .titlebar,.titlebar h3{border-color:#39f}
        #pageAudit .common-page{background-color:#FFF;padding:18px 15px}
        #pageAudit .lines{padding:0 16px;color:#d7d7d7}
        #pageAudit .changeEdit,.complaintDadaDeliver,.print{background-color:#3399FE;border-radius:15px;padding:3px 12px;color:#fff}
        #pageAudit .print i{font-size:20px;margin-right:10px;display:inline-block;vertical-align:bottom}
        #pageAudit .complaintDadaDeliver:hover,.print:hover{background-color:#2288ED!important}
        #pageAudit .fr{float:none}
        #pageAudit .addNote,.cancelOrder,.editCancel{margin-left:20px;color:#3399FE}
        #pageAudit .t-border{border:1px solid #bbb;padding:2px 10px;border-radius:25px;color:#666}
        #pageAudit .compute-btn-left{border-right:1px solid #39f;color:#39f}
        #pageAudit .compute-btn-right{border-left:1px solid #39f;color:#39f}
        #pageAudit .compute-btn-left-disabled{border-right:1px solid #ccc;color:#ccc!important}
        #pageAudit .compute-btn-right-disabled{border-left:1px solid #ccc;color:#ccc!important}
        #pageAudit .none{display:none}
        #pageAudit .platefrom-icons:hover{color:#39f}
        #pageAudit *,:after,:before{box-sizing:initial}
        #pageAudit h1,h2,h3,h4,h5,h6{line-height:inherit}
        #pageAudit .tip_p{border-bottom:1px dashed #ddd;margin:0;padding:0;padding-bottom:10px}
        #pageAudit .tip_p-last{border-bottom:0}
        #pageAudit .tip_p label{font-weight:700;width:150px;text-align:right;display:inline-block}
        #pageAudit .tip_p span{color:#aaa}
        #pageAudit .o-cont-p .table_max tbody tr:last-child td{border-bottom:0}
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
                    <a href="{{route('orders.index')}}">订单列表</a> <span class="divider">></span>
                </li>
                <li>
                    <span>订单详情</span>
                </li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div id="pageAudit" style="min-width: 1200px; overflow-x: auto;">
            <div class="common-page style-blue">
                <!--按钮层-->
                <div style="height: 35px;">
                    <div class="fr" style="display: inline-block;">
                        <a href="{{route('orders.printOrder', $order->id)}}" target="_blank" class="button bg-blue print">
                            <i class="icon-print"></i>
                            打印小票
                        </a>
                    </div>
                    <span style="float: right; font-size: 24px; color: #666; margin-right: 20px;">
                        @if($order->status == 25)
                            已取消
                        @elseif($order->status > 30)
                            已完成
                        @else
                            已用时：{{ floor((time() - strtotime($order->created_at))/60) }}分钟
                        @endif
                    </span>
                </div>
                <!--订单信息-->
                <div class="o-block mt10" style="margin-bottom: 0; border: 0; border-top:1px solid #e1e0e0 ">
                    <div class="o-cont">
                        <ul style="margin-top: 22px;">
                            <li style="width: 100%;" class="jbinfo">
                                <span class="bussinessTagName mr10" style="font-weight: bolder;font-size: 26px; color: #666">
                                    @if($order->delivery_time)
                                        <strong _v-1fbece8c="" style="color: #db2828">送达时间：{{date("Y-m-d H:i:s", $order->delivery_time)}}</strong>
                                    @else
                                        <strong _v-1fbece8c="">立即送达</strong>
                                    @endif
                                </span>
                                <span style="font-size: 18px" class="tags">
                                    <span class="orderTimes" _v-1fbece8c="">创建订单时间：{{ $order->created_at }}</span>
                                </span>
                            </li>
                            <li style="width: 72%; color: #666;">
                                订单号：{{ $order->order_id }}
                                <span class="lines"> | </span>
                                <span>所属门店： {{ $order->shop->name }}</span>
                                <span class="lines"> | </span>
                                <span>平台下单时间：{{ date("Y-m-d H:i:s", $order->ctime) }}</span>
                            </li>
                            <li style="width: 20%;float: right; text-align: right; margin-right: 20px">
                                <span style="font-size: 18px">客户实付：
                                    <span style="color: #cc0000; font-size: 24px">￥{{ $order->total - $order->package_bag_money }}
                                    </span>
                                </span>
                            </li>

                            <li style="width: 100%;">
                                <span style="color: red;font-weight: 800;font-size: 16px;">备注：{{ $order->caution }}</span>
                            </li>
                        </ul>
                        <div class="t-menu-info">
                            @if($order->over_time)
                                <p>完成时间： {{ date("Y-m-d H:i:s", $order->complete_time) }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                @if( ($order->apply_cancel || $order->apply_refund) && ((1800 - time() + strtotime($order->cancel_at)) > 0 || (1800 - time() + strtotime($order->refund_at)) > 0))
                <div class="o-block mt10" style="margin-bottom: 0; border: 0; border-top:1px solid #e1e0e0 ">
                    <div class="o-cont">
                        <ul style="margin-top: 22px;">
                            @if( $order->apply_cancel)
                                <li style="width: 100%;" class="jbinfo">
                                <span style="font-size: 18px" class="tags">
                                    <span class="orderTimes" _v-1fbece8c="">申请取消订单：</span>
                                    @if ((1800 - time() + strtotime($order->cancel_at)) > 60)
                                        <span class="orderTimes" _v-1fbece8c="">还有 {{ intval((1800 - time() + strtotime($order->cancel_at))/60) }} 分钟自动同意</span>
                                    @else
                                        <span class="orderTimes" _v-1fbece8c="">还有 {{ (1800 - time() + strtotime($order->cancel_at)) }} 秒自动同意</span>
                                    @endif
                                    <form action="{{ route('orders.reject', $order->id) }}" method="post" style="display: inline" onsubmit="return alert(this, '确认拒绝退款么？')">
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn btn-danger btn-xs">拒绝申请</button>
                                    </form>
                                    <form action="{{ route('orders.agree', $order->id) }}" method="post" style="display: inline" onsubmit="return alert(this, '确认同意退款么？')">
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn btn-success btn-xs">同意申请</button>
                                    </form>
                                </span>
                                </li>
                            @endif
                            @if( $order->apply_refund)
                                <li style="width: 100%;" class="jbinfo">
                                <span style="font-size: 18px" class="tags">
                                    <span class="orderTimes" _v-1fbece8c="">申请退款订单({{ $order->refund_money }}元)：</span>
                                    @if ((1800 - time() + strtotime($order->refund_at)) > 60)
                                        <span class="orderTimes" _v-1fbece8c="">还有 {{ intval((1800 - time() + strtotime($order->refund_at))/60) }} 分钟自动同意</span>
                                    @else
                                        <span class="orderTimes" _v-1fbece8c="">还有 {{ (1800 - time() + strtotime($order->refund_at)) }} 秒自动同意</span>
                                    @endif
                                    <form action="{{ route('orders.reject', $order->id) }}" method="post" style="display: inline" onsubmit="return alert(this, '确认拒绝退款么？')">
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn btn-danger btn-xs">拒绝申请</button>
                                    </form>
                                    <form action="{{ route('orders.agree', $order->id) }}" method="post" style="display: inline" onsubmit="return alert(this, '确认同意退款么？')">
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn btn-success btn-xs">同意申请</button>
                                    </form>
                                </span>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
                @endif
            </div>
            <div id="footer">&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <div class="mc-wrap">
                <!--配送信息-->
                <div class="mc-r">
                    <div class="o-block">
                        <div class="o-title" style="width:97.5%;">
                            配送信息 <div class="o-style"></div>
                        </div>
                        <div class="o-cont">
                            <ul>
                                <li class="mt20">
                                    <div class="colorDiv">
                                        <!--中间号-->
                                        <p>用户姓名：{{ $order->recipient_name }}</p>
                                        <p>用户电话：<i class="telIcon"></i><a class="l-btn-plain mobile">{{ $order->recipient_phone }}</a></p>
                                        <p>收货地址：{{ $order->recipient_address }}</p>
                                    </div>
                                </li>
                                <li class="w100 mt20">
                                    <dl class="o-business w100">
                                        <dt class="pl15 mb10">跟踪信息：</dt>
                                        @if(!empty($order->logs))
                                            @foreach($order->logs as $log)
                                               <dd><i></i><span class="behavDesc b-orderdd">{{ $log->message }}</span></dd>
                                               <dd><span class="behavDesc b-orderdd color-grey f12">操作人：{{ $log->operator }}</span></dd>
                                               <dd><span class="behavDesc b-orderd-d color-grey f12">{{ $log->created_at }} </span></dd>
                                            @endforeach
                                        @endif
                                    </dl>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="mc-l">
                    <!--商品信息-->
                    <div class="o-block o-block-blue">
                        <div class="o-title">
                            商品信息
                            <div class="o-style">
                                <span style="color: #2c3136;">总件数：</span>{{ count($order->goods) or 0 }}
                            </div>
                        </div>
                        <div class="o-cont-p">
                            <table class="table_max">
                                <tbody>
                                    @foreach($order->goods as $goods)
                                    <tr class="o-block1">
                                        <td class="o-p-td" rowspan="1" style="width: 10%; text-align: right; position: relative;">
                                            <img class="img" src="{{ explode(',', $goods->goods->picture)[0] }}" width="90" height="90" alt="{{ $goods->goods->upc }}">
                                        </td>
                                        <td class="o-p-td" rowspan="1" style="width: 35%;height: 100px">
                                            <div>
                                                <ul>
                                                    <li style="width: 100%;margin-bottom: 5px;font-size: 16px">
                                                        <span>商品名称：{{ $goods->good_name }}</span>
                                                    </li>
                                                    <li class="f14 grayFont"><span>商品ID：{{ $goods->goods_id }}</span></li>
                                                    <li class="f14 grayFont"><span>UPC：{{ $goods->goods->upc }}</span></li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td class="o-p-td" style="text-align: right; width: 10%">
                                        </td>
                                        <td class="o-p-td" style="height: 100px; width: 20%;">
                                            <li>
                                                <span>
                                                    商品单价：
                                                    <script type="text/javascript">
                                                    </script>￥{{ $goods->price }}
                                                </span>
                                            </li>
                                        </td>
                                        <td class="o-p-td" rowspan="1">
                                            <li>
                                                <p class="ware-look-count" style="text-align: center;">
                                                    商品数量：<span class="color-grey">{{ $goods->quantity }} 个</span>
                                                </p>
                                            </li>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="o-block o-block-blue">
                        <div class="od-cont">
                            <div class="od-cont od-cont-small od-cont-line">
                                <ul>
                                    <li>
                                        <span class="extra_msg_box">
                                            <span class="extra_msg_width_tip">商品金额</span>
                                            <span class="extra_tips_right">￥{{ $order->original_price - $order->shipping_fee - $order->package_bag_money }}
                                            </span>
                                         </span>
                                    </li>
                                    <li>
                                        <span class="extra_msg_box">
                                            <span class="extra_msg_width_tip">运费</span>
                                            <span class="extra_tips_right">￥{{ $order->shipping_fee }}</span>
                                        </span>
                                    </li>
                                    @if($arr = json_decode(trim(urldecode($order->poi_receive_detail),'"'), true))
                                        @if(!empty($arr['actOrderChargeByMt']))
                                            @foreach($arr['actOrderChargeByMt'] as $mt)
                                                @if($mt['moneyCent'])
                                                    <li>
                                                        <span class="extra_msg_box">
                                                            <span class="extra_msg_width_tip">{{ $mt['comment'] }}（美团承担）</span>
                                                            <span class="extra_tips_right">￥-{{ $mt['moneyCent']/100 }}</span>
                                                        </span>
                                                    </li>
                                                @endif
                                            @endforeach
                                        @endif
                                        @if(!empty($arr['actOrderChargeByPoi']))
                                            @foreach($arr['actOrderChargeByPoi'] as $mt)
                                                <li>
                                                    <span class="extra_msg_box">
                                                        <span class="extra_msg_width_tip">{{ $mt['comment'] }}（商家承担）</span>
                                                        <span class="extra_tips_right">￥-{{ $mt['moneyCent']/100 }}</span>
                                                    </span>
                                                </li>
                                            @endforeach
                                        @endif
                                    @endif
                                    <li>
                                        <span class="line">客户实付金额：&nbsp;&nbsp;&nbsp;&nbsp;
                                            <span style="color: #cc0000; font-size: 24px">￥{{ $order->total - $order->package_bag_money }}</span>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

@stop
