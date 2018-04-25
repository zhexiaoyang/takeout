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
                    <a href="{{route('goods.index')}}">商品列表</a> <span class="divider">></span>
                </li>
                <li>
                    <span>
                        @if($good->id)
                            编辑商品（{{$good->id}}）
                        @else
                            新建商品
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
                        @if($good->id)
                            编辑商品
                        @else
                            新建商品
                        @endif
                    </h3>
                </header>
                <div class="panel-body">
                    @if($good->id)
                    <form action="{{ route('goods.update', $good->id) }}" method="POST" accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="id" value="{{$good->id}}">
                        <input type="hidden" name="shop_id" value="{{$good->shop_id}}">
                    @else
                    <form action="{{ route('goods.store') }}" method="POST" accept-charset="UTF-8">
                    @endif
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="deopt_id" value="{{$deopt->id or $good->deopt->id}}">
                        <div class="form-group">
                            <label for="name-field">同步到平台</label>
                            <div class="checkboxes">
                                <input name="sync[]" id="checkbox-01" value="1" type="checkbox" />美团
                                <input name="sync[]" id="checkbox-02" value="2" type="checkbox" />百度
                                <input name="sync[]" id="checkbox-03" value="3" type="checkbox" />饿了么
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name-field">门店</label>
                            <div class="checkboxes">
                                @if($good->id)
                                    {{$good->shop->name}}
                                @else
                                    @if(!empty($shops))
                                        @foreach($shops as $shop)
                                            <input name="shop_id[]" value="{{$shop->id}}" type="checkbox" />{{$shop->name}}
                                        @endforeach
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="invoice_min_price-field">名称</label>
                            <input class="form-control" type="text" name="name" id="name-field" value="{{ $deopt->name or $good->deopt->name }}" readonly />
                        </div>
                        <div class="form-group">
                            <label for="invoice_min_price-field">分类</label>
                            <input class="form-control" type="text" name="category" id="category-field" value="{{ $deopt->category or $good->deopt->category }}" readonly />
                        </div>
                        <div class="form-group">
                            <label for="invoice_min_price-field">upc</label>
                            <input class="form-control" type="text" name="upc" id="upc-field" value="{{ $deopt->upc or $good->deopt->upc }}" readonly />
                        </div>
                        <div class="form-group">
                            <label for="invoice_min_price-field">国药准字号</label>
                            <input class="form-control" type="text" name="approval" id="approval-field" value="{{ $deopt->approval or $good->deopt->approval }}" readonly />
                        </div>
                        <div class="form-group">
                            <label for="invoice_min_price-field">规格</label>
                            <input class="form-control" type="text" name="spec" id="spec-field" value="{{ $deopt->spec or $good->deopt->spec }}" readonly />
                        </div>
                        <div class="form-group">
                            <label for="invoice_min_price-field">价格</label>
                            <input class="form-control" type="text" name="price" id="price-field" value="{{ old('price', $good->price ) }}" />
                        </div>
                        <div class="form-group">
                            <label for="invoice_min_price-field">库存</label>
                            <input class="form-control" type="text" name="stock" id="stock-field" value="{{ old('stock', isset($good->stock)?$good->stock:1000 ) }}" />
                        </div>
                        <div class="form-group">
                            <label for="invoice_min_price-field">商品排序</label>
                            <input class="form-control" type="text" name="sort" id="sort-field" value="{{ old('sort', isset($good->sort)?$good->sort:1000 ) }}" />
                        </div>
                        <div class="form-group">
                            <label for="invoice_min_price-field">上下架</label>
                            <div class="radios">
                                <label class="label_radio" for="radios-05" style="display: inline;margin-right: 20px;">
                                    <input name="online" id="radios-05" value="1" type="radios" @if(old('online', $good->online ) == 1 || !isset($good->online)) checked @endif />上架
                                </label>
                                <label class="label_radio" for="radios-06" style="display: inline;margin-right: 20px;">
                                    <input name="online" id="radios-06" value="0" type="radios" @if(old('online', $good->online ) === 0) checked @endif />下架
                                </label>
                            </div>
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