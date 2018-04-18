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
                    <a href="{{route('deopts.index')}}">标品库</a> <span class="divider">></span>
                </li>
                <li>
                    <span>
                        @if($deopt->id)
                            编辑商品（{{$deopt->id}}）
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
                        @if($deopt->id)
                            编辑商品
                        @else
                            新建商品
                        @endif
                    </h3>
                </header>
                <div class="panel-body">
                    @if($deopt->id)
                        <form action="{{ route('deopts.update', $deopt->id) }}" method="POST" accept-charset="UTF-8">
                            <input type="hidden" name="_method" value="PUT">
                    @else
                        <form action="{{ route('deopts.store') }}" method="POST" accept-charset="UTF-8">
                    @endif

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">


                    <div class="form-group">
                        <label for="name-field">名称</label>
                        <input class="form-control" type="text" name="name" id="name-field" value="{{ old('name', $deopt->name ) }}" />
                    </div>
                    <div class="form-group">
                        <label for="category-field">分类</label>
                        <input class="form-control" type="text" name="category" id="category-field" value="{{ old('category', $deopt->category ) }}" />
                    </div>
                    <div class="form-group">
                        <label for="unit-field">单位</label>
                        <input class="form-control" type="text" name="unit" id="unit-field" value="{{ old('unit', $deopt->unit ) }}" />
                    </div>
                    {{--<div class="form-group">--}}
                        {{--<label for="price-field">价格</label>--}}
                        {{--<input class="form-control" type="text" name="price" id="price-field" value="{{ old('price', $deopt->price ) }}" />--}}
                    {{--</div>--}}
                    <div class="form-group">
                        <label for="spec-field">规格</label>
                        <input class="form-control" type="text" name="spec" id="spec-field" value="{{ old('spec', $deopt->spec ) }}" />
                    </div>
                    <div class="form-group">
                        <label for="description-field">描述</label>
                        <textarea name="description" id="description-field" class="form-control" rows="3">{{ old('description', $deopt->description ) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="approval-field">国药准字号</label>
                        <input class="form-control" type="text" name="approval" id="approval-field" value="{{ old('approval', $deopt->approval ) }}" />
                    </div>
                    <div class="form-group">
                        <label for="is_otc-field">是否OTC</label>
                        <input class="form-control" type="text" name="is_otc" id="is_otc-field" value="{{ old('is_otc', $deopt->is_otc ) }}" />
                    </div>
                    <div class="form-group">
                        <label for="upc-field">Upc</label>
                        <input class="form-control" type="text" name="upc" id="upc-field" value="{{ old('upc', $deopt->upc ) }}" />
                    </div>
                    {{--<div class="form-group">--}}
                        {{--<label for="mt_id-field">Mt_id</label>--}}
                        {{--<input class="form-control" type="text" name="mt_id" id="mt_id-field" value="{{ old('mt_id', $deopt->mt_id ) }}" />--}}
                    {{--</div>--}}
                    {{--<div class="form-group">--}}
                        {{--<label for="status-field">Status</label>--}}
                        {{--<input class="form-control" type="text" name="status" id="status-field" value="{{ old('status', $deopt->status ) }}" />--}}
                    {{--</div>--}}
                    {{--<div class="form-group">--}}
                        {{--<label for="picture-field">Picture</label>--}}
                        {{--<textarea name="picture" id="picture-field" class="form-control" rows="3">{{ old('picture', $deopt->picture ) }}</textarea>--}}
                    {{--</div>--}}
                    <div class="form-group">
                        <label for="common_name-field">Common_name</label>
                        <input class="form-control" type="text" name="common_name" id="common_name-field" value="{{ old('common_name', $deopt->common_name ) }}" />
                    </div>
                    <div class="form-group">
                        <label for="company-field">Company</label>
                        <input class="form-control" type="text" name="company" id="company-field" value="{{ old('company', $deopt->company ) }}" />
                    </div>
                    <div class="form-group">
                        <label for="brand-field">Brand</label>
                        <input class="form-control" type="text" name="brand" id="brand-field" value="{{ old('brand', $deopt->brand ) }}" />
                    </div>
                    <div class="form-group">
                        <label for="yfyl-field">Yfyl</label>
                        <textarea name="yfyl" id="yfyl-field" class="form-control" rows="3">{{ old('yfyl', $deopt->yfyl ) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="syz-field">Syz</label>
                        <textarea name="syz" id="syz-field" class="form-control" rows="3">{{ old('syz', $deopt->syz ) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="syrq-field">Syrq</label>
                        <textarea name="syrq" id="syrq-field" class="form-control" rows="3">{{ old('syrq', $deopt->syrq ) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="cf-field">Cf</label>
                        <textarea name="cf" id="cf-field" class="form-control" rows="3">{{ old('cf', $deopt->cf ) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="blfy-field">Blfy</label>
                        <textarea name="blfy" id="blfy-field" class="form-control" rows="3">{{ old('blfy', $deopt->blfy ) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="jj-field">Jj</label>
                        <textarea name="jj" id="jj-field" class="form-control" rows="3">{{ old('jj', $deopt->jj ) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="zysx-field">Zysx</label>
                        <textarea name="zysx" id="zysx-field" class="form-control" rows="3">{{ old('zysx', $deopt->zysx ) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="ypxhzy-field">Ypxhzy</label>
                        <textarea name="ypxhzy" id="ypxhzy-field" class="form-control" rows="3">{{ old('ypxhzy', $deopt->ypxhzy ) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="etyy-field">Etyy</label>
                        <textarea name="etyy" id="etyy-field" class="form-control" rows="3">{{ old('etyy', $deopt->etyy ) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="rsybr-field">Rsybr</label>
                        <textarea name="rsybr" id="rsybr-field" class="form-control" rows="3">{{ old('rsybr', $deopt->rsybr ) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="lnryy-field">Lnryy</label>
                        <textarea name="lnryy" id="lnryy-field" class="form-control" rows="3">{{ old('lnryy', $deopt->lnryy ) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="xz-field">Xz</label>
                        <input class="form-control" type="text" name="xz" id="xz-field" value="{{ old('xz', $deopt->xz ) }}" />
                    </div>
                    <div class="form-group">
                        <label for="bz-field">Bz</label>
                        <input class="form-control" type="text" name="bz" id="bz-field" value="{{ old('bz', $deopt->bz ) }}" />
                    </div>
                    <div class="form-group">
                        <label for="jx-field">Jx</label>
                        <input class="form-control" type="text" name="jx" id="jx-field" value="{{ old('jx', $deopt->jx ) }}" />
                    </div>
                    <div class="form-group">
                        <label for="zc-field">Zc</label>
                        <input class="form-control" type="text" name="zc" id="zc-field" value="{{ old('zc', $deopt->zc ) }}" />
                    </div>
                    <div class="form-group">
                        <label for="ylzy-field">Ylzy</label>
                        <input class="form-control" type="text" name="ylzy" id="ylzy-field" value="{{ old('ylzy', $deopt->ylzy ) }}" />
                    </div>
                    <div class="form-group">
                        <label for="yxq-field">Yxq</label>
                        <input class="form-control" type="text" name="yxq" id="yxq-field" value="{{ old('yxq', $deopt->yxq ) }}" />
                    </div>

                        <div class="well well-sm">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a class="btn btn-link pull-right" href="{{ route('deopts.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>

@endsection