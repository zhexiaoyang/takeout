@extends('layouts.app')

@section('title', '订单详情')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/order.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/base.v2.0.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/block.v.2.3.css') }}">
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
                    <a href="{{route('shops.index')}}">门店列表</a> <span class="divider">></span>
                </li>
                <li>
                    <span>门店信息</span>
                </li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div id="pageAudit">
            <div class="fix_message">
                <span class="bg-grey-noButton1 mr10">#3 </span>
                <span style="font-size: 17px" class="tags">
            <span>请于2018-05-02 15:06前送达</span>
        </span>
                <span class="moneys">
            <span>客户实付：
                <span style="color: #cc0000; font-size: 18px; font-weight: bold;">￥69.50</span>
            </span>
        </span>
                <div class="fr">
                    <a onclick="_czc.push([&#39;_trackEvent&#39;, &#39;订单详情页&#39;, &#39;打印小票按钮&#39;]);" class="button bg-blue print">
                        <i class="iconfont icon-dayinji"></i>
                        打印小票
                    </a>
                </div>
            </div>
            <div class="titlebar" style="border-width: 2px;background-color: #f5f5f5;">
                <h3 class="hw" style="color: #666; font-size: 16px; border: 0px;">订单管理-订单详情</h3>
            </div>
            <div class="common-page style-blue">
                <!--按钮层-->
                <div style="height: 35px;">
                    <div class="fr" style="display: inline-block;">
                        <a onclick="_czc.push([&#39;_trackEvent&#39;, &#39;订单详情页&#39;, &#39;打印小票按钮&#39;]);" class="button bg-blue print">
                            <i class="iconfont icon-dayinji"></i>
                            打印小票
                        </a>
                        <a onclick="_czc.push([&#39;_trackEvent&#39;, &#39;订单详情页&#39;, &#39;添加备注按钮&#39;]);" class="addNote" href="javascript:void(0)">
                            添加备注
                        </a>
                    </div>
                    <span style="float: right; font-size: 24px; color: #666; margin-right: 20px;">已完成</span>
                </div>
                <!--订单信息-->
                <div class="o-block mt10" style="margin-bottom: 0; border: 0; border-top:1px solid #e1e0e0 ">
                    <div class="o-cont">
                        <ul style="margin-top: 22px;">
                            <li style="width: 100%;" class="jbinfo">
                                <span class="bg-grey-noButton1 mr10">#3 </span>
                                <span class="bussinessTagName mr10" style="font-weight: bolder;font-size: 26px; color: #666">立即送达</span>
                                <span style="font-size: 18px" class="tags">
                            <span class="t-border">请于2018-05-02 15:06前送达</span>
                        </span>
                            </li>
                            <li style="width: 72%; padding: 8px 0 0 56px; color: #666;">
                                订单号：810505125000241
                                <span class="lines"> | </span>
                                <span>所属门店： 快方马甸大药房</span>
                                <span class="lines"> | </span>
                                <span>下单时间：2018-05-02 14:05:24</span>
                            </li>
                            <li style="width: 20%;float: right; text-align: right; margin-right: 20px">
                        <span style="font-size: 18px">客户实付：
                            <span style="color: #cc0000; font-size: 24px">￥69.50
                            </span>
                        </span>
                            </li>
                            <li style="width: 80%; padding-left: 60px">
                                <div class="o-cont">
                                    <ul style="margin-left: -16px;margin-bottom: 6px;margin-top: 0;">
                                </div>
                            </li>
                        </ul>
                        <div class="t-menu-info">
                            <p>拣货完成： 2018-05-02 14:06:09</p>
                            <p>实际送达： 2018-05-02 14:45:38</p>
                        </div>
                    </div>
                </div>
            </div>
            <div id="footer">&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <div class="mc-wrap">
                <!--配送信息-->
                <div class="mc-r">
                    <div class="o-block">
                        <div class="o-title" style="width:97.5%;">
                            配送信息 <div class="o-style">订单时效：一小时达</div>
                        </div>
                        <div class="o-cont">
                            <ul>
                                <li style="width:100%;">运单号：810505125000241</li>
                                <li style="width:100%;">承运商：商家自送</li>
                                <li class="mt20">
                                    <div class="colorDiv">
                                        <!--中间号-->
                                        <p>用户姓名：胡昊</p>
                                        <p>用户电话：<i class="telIcon"></i><a class="l-btn-plain mobile">139****2524</a></p>
                                        <p>收货地址：北京市朝阳区安华里社区-四区12号楼1108</p>
                                    </div>
                                </li>
                                <li class="w100 mt20">
                                    <dl class="o-business w100">
                                        <dt class="pl15 mb10">跟踪信息：</dt>
                                        <dd><i></i><span class="behavDesc b-orderdd">下单成功，订单号:810505125000241</span></dd>
                                        <dd><span class="behavDesc b-orderdd color-grey f12">操作人：JD_115u2f5bdef06</span></dd>
                                        <dd><span class="behavDesc b-orderd-d color-grey f12">2018-05-02 14:05:24 </span></dd>
                                        <dd><i></i><span class="behavDesc b-orderdd">等待用户支付，超过30分钟未支付将自动取消订单</span></dd>
                                        <dd><span class="behavDesc b-orderdd color-grey f12">操作人：JD_115u2f5bdef06</span></dd>
                                        <dd><span class="behavDesc b-orderd-d color-grey f12">2018-05-02 14:05:24 </span></dd>
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
                                <span style="color: #2c3136;">总件数：</span>4
                                <span style="color: #2c3136;margin-left: 10px;">合计：</span>元
                            </div>
                        </div>
                        <div class="o-cont-p">
                            <table class="table_max">
                                <td class="o-p-td" rowspan="1" style="width: 10%; text-align: right; position: relative;">
                                    <img class="img" src="./order_details/5a94cf96N9e97a5a4.jpg" onerror="this.src=&#39;http://misc.360buyimg.com/lib/skin/e/i/error-12.gif&#39;" width="90" height="90">
                                </td>
                                <td class="o-p-td" rowspan="1" style="width: 35%;height: 100px">
                                    <div>
                                        <ul>
                                            <li style="width: 100%;margin-bottom: 5px;font-size: 16px">
                                                <span>商品名称：正意心诚 蒲公英颗粒 15g*9袋/盒</span>
                                            </li>
                                            <li class="f14 grayFont"><span>UPC码：6927024600068</span></li>
                                            <li class="f14 grayFont"><span>京东sku码：2006888562</span></li>
                                            <li class="f14 grayFont"><span>商家sku码：6217</span></li>
                                        </ul>
                                    </div>
                                </td>
                                <td class="o-p-td" style="text-align: right; width: 10%">
                                </td>
                                <td class="o-p-td" style="height: 100px; width: 20%;">
                                    <li>
                                        <span>商品单价：￥16.00</span>
                                    </li>
                                    <li>
                                        <span style="font-size: 10px" class="color-grey">(原价：￥16.00)</span>
                                    </li>
                                </td>
                                <td class="o-p-td" style="width: 5%">
                                    <li><span class="color-grey">×4</span></li>
                                </td>
                                <td class="o-p-td" rowspan="1">
                                    <li>
                                        <p class="ware-look-count" style="text-align: center;">商品数量：<span class="color-grey">4 个</span></p>
                                        <p class="u-add-num ware-count none" style="text-align: center; margin: 0 auto;">
                                            <input type="hidden" value="4" class="orderlist-val">
                                            <span onclick="computeNum(this, -1)" class="compute-btn-left"> - </span>
                                            <span id="numberVal" class="center" data-max="4" data-len="1" data-formula="">4</span>
                                            <span onclick="computeNum(this, +1)" class="compute-btn-right compute-btn-right-disabled"> + </span>
                                        </p>
                                    </li>
                                </td>
                                </tr>
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
                            <span class="extra_tips_right">￥64.00
                            </span>
                         </span>
                                    </li>
                                    <li>
                        <span class="extra_msg_box">
                            <span class="extra_msg_width_tip">运费</span>
                            <span class="extra_tips_right">￥5.00</span>
                        </span>
                                    </li>
                                    <li>
                        <span class="extra_msg_box">
                            <span class="extra_msg_width_tip">包装费</span>
                            <span class="extra_tips_right">￥0.50</span>
                        </span>
                                    </li>
                                    <li>
                        <span class="extra_msg_box">
                            <span class="extra_msg_width_tip">餐盒费</span>
                            <span class="extra_tips_right">￥0.00</span>
                        </span>
                                    </li>
                                    <li>
                                        <p class="tip_p-last">
                                            <span class="extra_msg_width_tip">商品优惠</span>
                                            <span class="extra_tips_right">-￥0.00</span>
                                        </p>
                                        <div class="show_tips_extra" style="display: none">
                                            <p style="text-align: right; font-size: 11px;margin-bottom: 0">
                                                (商家承担：￥0.00)
                                            </p>
                                        </div>
                                    </li>
                                    <li>
                                        <p class="tip_p-last">
                                            <span class="extra_msg_width_tip">运费优惠</span>
                                            <span class="extra_tips_right">-￥0.00</span>
                                        </p>
                                        <div class="show_tips_extra" style="display: none">
                                            <p style="text-align: right; font-size: 11px;margin-bottom: 0px">(商家承担：￥0.00)</p>
                                        </div>
                                    </li>
                                    <li></li>
                                    <li>
                        <span class="line">客户实付金额：&nbsp;&nbsp;&nbsp;&nbsp;
                            <span style="color: #cc0000; font-size: 24px">￥69.50</span>
                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="NewDada">
                © 2017 NewDada 新达达 沪ICP备14033539号-1
            </div>
        </div>
    </div>

@endsection
