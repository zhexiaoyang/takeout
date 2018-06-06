@extends('layouts.app')

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
        <section class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    药店信息
                </header>
                <div class="panel-body">

                <label>药店名称</label>
                <p>
                    {{ $shop->name }}
                </p> <label>地址</label>
                <p>
                    {{ $shop->address }}
                </p> <label>经度</label>
                <p>
                    {{ $shop->latitude }}
                </p> <label>纬度</label>
                <p>
                    {{ $shop->longitude }}
                </p> <label>Logo图片</label>
                <p>
                    <img src="{{ $shop->pic_url }}" alt="" style="width: 200px">
                </p> <label>客服电话</label>
                <p>
                    {{ $shop->phone }}
                </p> <label>门店电话</label>
                <p>
                    {{ $shop->standby_tel }}
                </p> <label>配送费</label>
                <p>
                    {{ $shop->shipping_fee }}
                </p> <label>配送时间</label>
                <p>
                    {{ $shop->shipping_time }}
                </p> <label>推广信息</label>
                <p>
                    {{ $shop->promotion_info }}
                </p> <label>营业状态</label>
                <p>
                    {{ $shop->open_level==1?'营业':'休息' }}
                </p> <label>上线状态</label>
                <p>
                    {{ $shop->is_online==1?'上线':'下线' }}
                </p> <label>是否支持发票</label>
                <p>
                    {{ $shop->invoice_support==1?'是':'否' }}
                </p> <label>开发票最小金额</label>
                <p>
                    {{ $shop->invoice_min_price }}
                </p>
            </div>
        </section>
</div>

@endsection
