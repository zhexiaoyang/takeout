@extends('layouts.app')

@section('title', '标品库')

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
                    <span>标品库</span>
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    标品库
                    <div class="panel-body">
                        <form class="form-inline" role="form" action="{{route('deopts.index')}}" method="get">
                            <div class="form-group">
                                <label class="sr-only" for="keyword">关键字</label>
                                <input value="{{$keyword or ''}}" type="text" class="form-control" id="keyword" name="keyword" placeholder="关键字...">
                            </div>
                            <button type="submit" class="btn btn-info">搜索</button>
{{--                            <a href="{{route('deopts.create')}}" class="btn btn-success">添加标品</a>--}}
                        </form>
                    </div>
                </header>
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>通用名/商品名称</th>
                        <th>分类</th>
                        <th>规格</th>
                        <th>UPC</th>
                        <th>是否OTC</th>
                        <th>厂家</th>
                        <th>编辑</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($deopts as $deopt)
                        <tr>
                            <td>{{$deopt->id}}</td>
                            <td>
                                {{$deopt->common_name}}
                                <br>
                                {{$deopt->name}}
                            </td>
                            <td>{{$deopt->category}}</td>
                            <td>{{$deopt->spec}}</td>
                            <td>{{$deopt->upc}}</td>
                            <td>
                                @if($deopt->is_otc)
                                    <p class="btn btn-success btn-xs">是</p>
                                @else
                                    <p class="btn btn-error btn-xs">否</p>
                                @endif
                            </td>
                            <td>{{$deopt->company}}</td>
                            <td>
                                <a href="{{ route('deopts.show', $deopt->id) }}" class="btn btn-primary btn-xs">查看</a>
                                <a href="{{ route('goods.deopt', $deopt->id) }}" class="btn btn-primary btn-xs">上传商品</a>
                                @if(Auth::user()->hasPermissionTo('deopt_delete'))
                                    <form action="{{ route('deopts.destroy', $deopt->id) }}" method="post" style="display: inline" onsubmit="return alert(this, '确认删除该商品么？')">
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
                    {!! $deopts->appends(['keyword' => $keyword])->render() !!}
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
