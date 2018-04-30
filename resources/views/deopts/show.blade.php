@extends('layouts.app')

@section('content')

    <div class="row" style="margin: -15px;">
        <div class="span6">
            <ul class="breadcrumb">
                <li>
                    <a href="{{route('deopts.index')}}">主页</a> <span class="divider">></span>
                </li>
                <li>
                    <a href="{{route('deopts.index')}}">品库列表</a> <span class="divider">></span>
                </li>
                <li>
                    <span>品库信息</span>
                </li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    品库信息
                </header>
                <div class="panel-body">

                <label>名称</label>
                <p>
                    {{ $deopt->name }}
                </p> <label>分类</label>
                <p>
                    {{ $deopt->category }}
                </p> <label>单位</label>
                <p>
                    {{ $deopt->unit }}
                </p> <label>价格</label>
                <p>
                    {{ $deopt->price }}
                </p> <label>规格</label>
                <p>
                    {{ $deopt->spec }}
                </p> <label>描述</label>
                <p>
                    {{ $deopt->description }}
                </p> <label>批准文号</label>
                <p>
                    {{ $deopt->approval }}
                </p> <label>是否OTC</label>
                <p>
                    {{ $deopt->is_otc==1?'是':'否' }}
                </p> <label>条码</label>
                <p>
                    {{ $deopt->upc }}
                </p> <label>图片</label>
                <p>
                    {{ $deopt->picture }}
                </p> <label>通用名称</label>
                <p>
                    {{ $deopt->common_name }}
                </p> <label>生产厂家</label>
                <p>
                    {{ $deopt->company }}
                </p> <label>用法用量</label>
                <p>
                    {{ $deopt->yfyl }}
                </p> <label>适用症状</label>
                <p>
                    {{ $deopt->syz }}
                </p> <label>适用人群</label>
                <p>
                    {{ $deopt->syrq }}
                </p> <label>成分</label>
                <p>
                    {{ $deopt->cf }}
                </p> <label>不良反应</label>
                <p>
                    {{ $deopt->blfy }}
                </p> <label>禁忌</label>
                <p>
                    {{ $deopt->jj }}
                </p> <label>注意事项</label>
                <p>
                    {{ $deopt->zysx }}
                </p> <label>药品相互作用</label>
                <p>
                    {{ $deopt->ypxhzy }}
                </p> <label>性状</label>
                <p>
                    {{ $deopt->xz }}
                </p> <label>保证</label>
                <p>
                    {{ $deopt->bz }}
                </p> <label>Jx</label>
                <p>
                    {{ $deopt->剂型 }}
                </p> <label>贮藏</label>
                <p>
                    {{ $deopt->zc }}
                </p> <label>有效期</label>
                <p>
                    {{ $deopt->yxq }}
                </p>
            </div>
        </section>
    </div>

@endsection
