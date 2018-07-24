@extends('layouts.app')

@section('title', ($shop->id?'编辑':'新建').'门店财务信息')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-reset.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert.css') }}">
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
                    <a href="{{route('shops.index')}}">门店列表</a> <span class="divider">></span>
                </li>
                <li>
                    <span>
                        @if($shop_detail->id)
                            编辑门店财务信息
                        @else
                            新建门店财务信息
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
                        @if($shop_detail->id)
                            编辑门店财务信息（{{$shop->name}}）
                        @else
                            新建门店财务信息（{{$shop->name}}）
                        @endif
                    </h3>
                </header>
                <div class="panel-body">
                @if($shop_detail->id)
                    <form action="{{ route('shop_details.update', $shop_detail->id) }}" method="POST" accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PUT">
                @else
                    <form action="{{ route('shop_details.store') }}" method="POST" accept-charset="UTF-8">
                @endif

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="shop_id", value="{{ $shop->id }}">

                    
                <div class="form-group">
                    <label for="shop_id-field">门店名称</label>
                    <input class="form-control" type="text" disabled value="{{ $shop->name }}" />
                </div> 
                <div class="form-group">
                	<label for="opening_bank-field">开户行</label>
                	<input class="form-control" type="text" name="opening_bank" id="opening_bank-field" value="{{ old('opening_bank', $shop_detail->opening_bank ) }}" />
                </div> 
                <div class="form-group">
                	<label for="username-field">开户名</label>
                	<input class="form-control" type="text" name="username" id="username-field" value="{{ old('username', $shop_detail->username ) }}" />
                </div> 
                <div class="form-group">
                	<label for="account_number-field">打款账号</label>
                	<input class="form-control" type="text" name="account_number" id="account_number-field" value="{{ old('account_number', $shop_detail->account_number ) }}" />
                </div> 
                <div class="form-group">
                    <label for="is_invoice-field">是否开发票</label>
                    <div class="radios">
                        <input name="is_invoice" id="radios-07" value="1" type="radio" @if(old('type', $shop_detail->is_invoice ) == 1) checked @endif />是
                        <input name="is_invoice" id="radios-08" value="2" type="radio" @if(old('type', $shop_detail->is_invoice ) === 2) checked @endif />否
                    </div>
                </div> 
                <div class="form-group">
                    <label for="type-field">开票类型</label>
                    <div class="radios">
                        <input name="type" id="radios-05" value="1" type="radio" @if(old('type', $shop_detail->type ) == 1) checked @endif />普通
                        <input name="type" id="radios-06" value="2" type="radio" @if(old('type', $shop_detail->type ) === 2) checked @endif />专用
                    </div>
                </div> 
                <div class="form-group">
                	<label for="name-field">开票名称</label>
                	<input class="form-control" type="text" name="name" id="name-field" value="{{ old('name', $shop_detail->name ) }}" />
                </div>
                <div class="form-group">
                	<label for="number-field">纳税识别号</label>
                	<input class="form-control" type="text" name="number" id="number-field" value="{{ old('number', $shop_detail->number ) }}" />
                </div> 
                <div class="form-group">
                    <label for="coefficient-field">打款系数（整数，如：15）</label>
                    <input class="form-control" type="text" name="coefficient" id="coefficient-field" value="{{ old('coefficient', $shop_detail->coefficient ) }}" />
                </div>
                        <button type="submit" class="btn btn-info">保存</button>
                </form>
                </div>
            </section>
        </div>
    </div>

@endsection