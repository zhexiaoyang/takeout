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
                            <select class="form-control" name="category" id="category-field">
                                <option value="感冒用药">感冒用药</option>
                                <option value="清热解毒">清热解毒</option>
                                <option value="呼吸系统">呼吸系统</option>
                                <option value="性福生活">性福生活</option>
                                <option value="妇科用药">妇科用药</option>
                                <option value="儿童用药">儿童用药</option>
                                <option value="皮肤用药">皮肤用药</option>
                                <option value="五官用药">五官用药</option>
                                <option value="医疗器械">医疗器械</option>
                                <option value="消化系统">消化系统</option>
                                <option value="风湿骨科">风湿骨科</option>
                                <option value="个人护理">个人护理</option>
                                <option value="营养保健">营养保健</option>
                                <option value="滋养调补">滋养调补</option>
                                <option value="男科用药">男科用药</option>
                                <option value="养心安神">养心安神</option>
                                <option value="中药饮片">中药饮片</option>
                                <option value="血管用药">血管用药</option>
                                <option value="分泌系统">分泌系统</option>
                                <option value="泌尿系统">泌尿系统</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="approval-field">国药准字号</label>
                            <input class="form-control" type="text" name="approval" id="approval-field" value="{{ old('approval', $deopt->approval ) }}" />
                        </div>
                        <div class="form-group">
                            <label for="is_otc-field">是否OTC</label>
                            <select class="form-control" name="is_otc" id="is_otc-field">
                                <option value="1">是</option>
                                <option value="0">否</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="upc-field">条形码</label>
                            <input class="form-control" type="text" name="upc" id="upc-field" value="{{ old('upc', $deopt->upc ) }}" />
                        </div>
                        <div class="form-group">
                            <label for="spec-field">规格</label>
                            <input class="form-control" type="text" name="spec" id="spec-field" value="{{ old('spec', $deopt->spec ) }}" />
                        </div>
                        <div class="form-group">
                            <label for="unit-field">单位</label>
                            <input class="form-control" type="text" name="unit" id="unit-field" value="{{ old('unit', $deopt->unit ) }}" />
                        </div>
                        <div class="form-group">
                            <label for="price-field">建议零售价</label>
                            <input class="form-control" type="text" name="price" id="price-field" value="{{ old('price', $deopt->price ) }}" />
                        </div>
                        <div class="form-group">
                            <label for="description-field">描述</label>
                            <textarea name="description" id="description-field" class="form-control" rows="3">{{ old('description', $deopt->description ) }}</textarea>
                        </div>

                        <div class="well well-sm">
                            <button type="submit" class="btn btn-primary">保存</button>
                            <a class="btn btn-link pull-right" href="{{ route('deopts.index') }}"><i class="glyphicon glyphicon-backward"></i>  返回</a>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>

@endsection