@extends('layouts.app')

@section('title', '商品列表')

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
                    <span>商品列表</span>
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    商品列表
                    <div class="panel-body">
                        <form class="form-inline" role="form" action="{{route('goods.index')}}" method="get">
                            <div class="form-group">
                                <label class="sr-only" for="keyword">关键字</label>
                                <input value="{{$keyword or ''}}" type="text" class="form-control" id="keyword" name="keyword" placeholder="关键字...">
                            </div>
                            <button type="submit" class="btn btn-info">搜索</button>
                            <a href="{{route('deopts.index')}}" class="btn btn-success">品库列表</a>
                            <a href="#myModal" data-toggle="modal" class="btn btn-warning">导入商品</a>
                        </form>
                    </div>
                </header>
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th>GID</th>
                        <th>门店</th>
                        <th>通用名/商品名称</th>
                        <th>分类</th>
                        <th>规格</th>
                        <th>排序</th>
                        <th>百度ID</th>
                        <th>美团ID</th>
                        <th>饿了么ID</th>
                        <th>编辑</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($goods as $good)
                        <tr>
                            <td>{{$good->deopt->id}}</td>
                            <td>{{$good->shop->name}}</td>
                            <td>
                                {{$good->deopt->common_name}}
                                <br>
                                {{$good->deopt->name}}
                            </td>
                            <td>{{$good->category->name}}</td>
                            <td>{{$good->deopt->spec}}</td>
                            <td>{{$good->sort}}</td>
                            <td>{{$good->baidu_id}}</td>
                            <td>{{$good->meituan_id}}</td>
                            <td>{{$good->ele_id}}</td>
                            <td>
                                <a href="{{ route('goods.edit', $good->id) }}" class="btn btn-primary btn-xs">编辑</a>
                                @if(Auth::user()->hasPermissionTo('good_delete'))
                                    <form action="{{ route('goods.destroy', $good->id) }}" method="post" style="display: inline" onsubmit="return alert(this, '确认删除该商品么？')">
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
                    {!! $goods->appends(['keyword' => $keyword])->render() !!}
                </div>
                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                <h4 class="modal-title">导入商品</h4>
                            </div>
                            <div class="modal-body">
                                <form role="form" action="{{ route('goods.file') }}" accept-charset="UTF-8" enctype="multipart/form-data" target="_blank" method="post">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="name-field">门店</label>
                                        <br>
                                        @if(!empty($shops))
                                            @foreach($shops as $shop)
                                                <label class="radio-inline">
                                                    <input type="radio" name="shop_id" value="{{$shop->id}}"> {{$shop->name}}
                                                </label>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputFile">选择文件</label>
                                        <input type="file" id="exampleInputFile3" name="goods">
                                        <a href="" target="_blank" class="help-block">点击下载模板</a>
                                    </div>
                                    <button type="submit" class="btn btn-success" onclick="up_goods()">上传</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
@section('scripts')

    <script type="text/javascript"  src="{{ asset('js/sweetalert.min.js') }}"></script>

    <script>
        function up_goods() {
            $(".close").click();
            return false;
        }
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
    @if (Session::has('alert_err'))
    <script>
        swal("出错啦！", "{{ Session::get('alert_err') }}")
    </script>
    @endif

@stop
