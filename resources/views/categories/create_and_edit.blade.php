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
                    <a href="{{route('categories.index')}}">分类列表</a> <span class="divider">></span>
                </li>
                <li>
                    <span>
                        @if($category->id)
                            编辑分类（{{$category->id}}）
                        @else
                            新建分类
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
                {{--<header class="panel-heading">--}}
                    {{--<h3>--}}
                        {{--<i class="icon-edit"></i>--}}
                        {{--@if($category->id)--}}
                            {{--编辑分类--}}
                        {{--@else--}}
                            {{--新建分类--}}
                        {{--@endif--}}
                    {{--</h3>--}}
                {{--</header>--}}
                <div class="panel-body">
                    @if($category->id)
                        <form action="{{ route('categories.update', $category->id) }}" method="POST" accept-charset="UTF-8">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="id" value="{{$category->id}}">
                            <input type="hidden" name="shop_id" value="{{$category->shop->id}}">
                    @else
                        <form action="{{ route('categories.store') }}" method="POST" accept-charset="UTF-8">
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
                                <label for="name-field">门店</label>
                                <div class="checkboxes">
                                    @if($category->id)
                                        {{$category->shop->name}}
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
                            <label for="invoice_min_price-field">分类名称</label>
                            <input class="form-control" type="text" name="name" id="name-field" value="{{ old('name', $category->name ) }}" />
                        </div>
                        <div class="form-group">
                            <label for="invoice_min_price-field">分类排序</label>
                            <input class="form-control" type="text" name="sort" id="sort-field" value="{{ old('sort', $category->sort ) }}" />
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