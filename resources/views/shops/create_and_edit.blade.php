@extends('layouts.app')

@section('content')

    @include('common.error')
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
                    <span>
                        @if($shop->id)
                            编辑门店（{{$shop->id}}）
                        @else
                            新建门店
                        @endif
                    </span>
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            @include('layouts._message')
            <section class="panel">
                <header class="panel-heading">
                    <h3>
                        <i class="icon-edit"></i>
                        @if($shop->id)
                            编辑门店
                        @else
                            新建门店
                        @endif
                    </h3>
                </header>
                <div class="panel-body">
                    @if($shop->id)
                        <form action="{{ route('shops.update', $shop->id) }}" method="POST" accept-charset="UTF-8">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="id" value="{{$shop->id}}">
                    @else
                        <form action="{{ route('shops.store') }}" method="POST" accept-charset="UTF-8">
                    @endif
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                	<label for="name-field">同步到平台</label>
                    <div class="checkboxes">
                        <input name="sync[]" id="checkbox-01" value="1" type="checkbox" />美团
                        <input name="sync[]" id="checkbox-02" value="2" type="checkbox" />百度
                        <input name="sync[]" id="checkbox-03" value="3" type="checkbox" />饿了么
                    </div>
                </div>
                <div class="form-group">
                    <label for="name-field">名称</label>
                    <input class="form-control" type="text" name="name" id="name-field" value="{{ old('name', $shop->name ) }}" />
                </div>
                <div class="form-group">
                	<label for="address-field">地址</label>
                	<input class="form-control" type="text" name="address" id="address-field" value="{{ old('address', $shop->address ) }}" />
                </div>
                <div class="form-group">
                    <label for="longitude-field">经度</label>
                    <input class="form-control" type="text" name="longitude" id="longitude-field" value="{{ old('longitude', $shop->longitude ) }}" />
                </div>
                <div class="form-group">
                    <label for="latitude-field">纬度</label>
                    <input class="form-control" type="text" name="latitude" id="latitude-field" value="{{ old('latitude', $shop->latitude ) }}" />
                </div>
                <div class="form-group">
                	<label for="pic_url-field">Logo图片地址</label>
                	<input class="form-control" type="text" name="pic_url" id="pic_url-field" value="{{ old('pic_url', $shop->pic_url ) }}" />
                </div>
                <div class="form-group">
                	<label for="phone-field">客服电话</label>
                	<input class="form-control" type="text" name="phone" id="phone-field" value="{{ old('phone', $shop->phone ) }}" />
                </div> 
                <div class="form-group">
                	<label for="standby_tel-field">门店电话</label>
                	<input class="form-control" type="text" name="standby_tel" id="standby_tel-field" value="{{ old('standby_tel', $shop->standby_tel ) }}" />
                </div>
                <div class="form-group">
                    <label for="shipping_fee-field">配送费</label>
                    <input class="form-control" type="text" name="shipping_fee" id="shipping_fee-field" value="{{ old('shipping_fee', $shop->shipping_fee ) }}" />
                </div>
                <div class="form-group">
                    <label for="shipping_fee-field">起送价</label>
                    <input class="form-control" type="text" name="min_price" id="min_price-field" value="{{ old('min_price', $shop->min_price ) }}" />
                </div>
                <div class="form-group">
                	<label for="shipping_time-field">营业时间 （ 7:00-9:00,11:30-19:00 ）</label>
                	<input class="form-control" type="text" name="shipping_time" id="shipping_time-field" value="{{ old('shipping_time', $shop->shipping_time ) }}" />
                </div>
                <div class="form-group">
                	<label for="promotion_info-field">门店公告</label>
                	<input class="form-control" type="text" name="promotion_info" id="promotion_info-field" value="{{ old('promotion_info', $shop->promotion_info ) }}" />
                </div>
                <div class="form-group">
                    <label for="open_level-field">门店的营业状态</label>
                    <div class="radios">
                            <input name="open_level" id="radios-01" value="1" type="radio" @if(old('open_level', $shop->open_level ) == 1) checked @endif />可配送
                            <input name="open_level" id="radios-02" value="3" type="radio" @if(old('open_level', $shop->open_level ) == 3) checked @endif />休息中
                    </div>
                </div> 
                <div class="form-group">
                    <label for="is_online-field">门店上下线状态</label>
                    <div class="radios">
                            <input name="is_online" id="radios-04" value="1" type="radio" @if(old('is_online', $shop->is_online ) == 1) checked @endif />上线
                            <input name="is_online" id="radios-03" value="0" type="radio" @if(old('is_online', $shop->is_online ) === 0) checked @endif />下线
                    </div>
                </div> 
                <div class="form-group">
                    <label for="invoice_support-field">门店是否支持发票</label>
                    <div class="radios">
                            <input name="invoice_support" id="radios-05" value="1" type="radio" @if(old('invoice_support', $shop->invoice_support ) == 1) checked @endif />支持
                            <input name="invoice_support" id="radios-06" value="0" type="radio" @if(old('invoice_support', $shop->invoice_support ) === 0) checked @endif />不支持
                    </div>
                </div> 
                <div class="form-group">
                    <label for="invoice_min_price-field">门店支持开发票的最小订单价</label>
                    <input class="form-control" type="text" name="invoice_min_price" id="invoice_min_price-field" value="{{ old('invoice_min_price', $shop->invoice_min_price ) }}" />
                </div>
                <button type="submit" class="btn btn-info">保存</button>
            </form>
            </div>
        </section>
    </div>
</div>

@endsection

@section('scripts')
    <script src="{{ asset('js/form-component.js') }}"></script>
@endsection