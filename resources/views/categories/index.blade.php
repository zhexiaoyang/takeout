@extends('layouts.app')

@section('title', '商品分类列表')

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
                    <span>商品分类列表</span>
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    商品分类列表
                    <div class="panel-body">
                        <form class="form-inline" role="form" action="{{route('categories.index')}}" method="get">
                            <div class="form-group">
                                <label class="sr-only" for="keyword">关键字</label>
                                <input value="{{$keyword or ''}}" type="text" class="form-control" id="keyword" name="keyword" placeholder="关键字...">
                            </div>
                            <button type="submit" class="btn btn-info">搜索</button>
{{--                            <a href="{{route('categories.create')}}" class="btn btn-success">添加商品分类</a>--}}
                        </form>
                    </div>
                </header>
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>名称</th>
                        <th>门店</th>
                        <th>排序</th>
                        <th>百度ID</th>
                        <th>美团ID</th>
                        <th>饿了么ID</th>
                        <th>编辑</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($categories as $shop)
                        <tr>
                            <td>{{$shop->id}}</td>
                            <td>{{$shop->name}}</td>
                            <td>{{$shop->shop->name}}</td>
                            <td>{{$shop->sort}}</td>
                            <td>{{$shop->baidu_id}}</td>
                            <td>{{$shop->meituan_id}}</td>
                            <td>{{$shop->ele_id}}</td>
                            <td>
                                <a href="{{ route('categories.edit', $shop->id) }}" class="btn btn-primary btn-xs">编辑</a>
                                @if(Auth::user()->hasRole('Superman'))
                                <form action="{{ route('categories.destroy', $shop->id) }}" method="post" style="display: inline" onsubmit="return alert(this, '确认删除该商品分类么？')">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-danger btn-xs">删除</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div style="margin-left: 10px">
                    {!! $categories->appends(['keyword' => $keyword])->render() !!}
                </div>
            </section>
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

@stop
