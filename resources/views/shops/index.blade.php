@extends('layouts.app')

@section('title', '门店列表')

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
                    <span>门店列表</span>
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    门店列表
                    <div class="panel-body">
                        <form class="form-inline" role="form" action="{{route('shops.index')}}" method="get" style="display: inline;">
                            <div class="form-group">
                                <label class="sr-only" for="keyword">关键字</label>
                                <input value="{{$keyword or ''}}" type="text" class="form-control" id="keyword" name="keyword" placeholder="关键字...">
                            </div>
                            <button type="submit" class="btn btn-info">搜索</button>
                            @if(Auth::user()->hasPermissionTo('shop_add'))
{{--                                <a href="{{route('shops.create')}}" class="btn btn-success">添加门店</a>--}}
                            @endif
                        </form>
                        @if(Auth::user()->hasRole('Superman'))
                            <form role="form" action="{{ route('shops.syncMeituan') }}" method="post" onsubmit="return alert(this, '确认同步药店么？')" style="display: inline;">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-warning">同步药店</button>
                            </form>
                        @endif
                        @if(Auth::user()->hasRole('Superman'))
                            <a href="#myModal" data-toggle="modal" class="btn btn-danger">导入财务信息</a>
                            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                            <h4 class="modal-title">导入结算信息</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form role="form" action="{{ route('shops.file') }}" accept-charset="UTF-8" enctype="multipart/form-data" target="_blank" method="post">
                                                {{ csrf_field() }}
                                                <div class="form-group">
                                                    <label for="exampleInputFile">选择文件</label>
                                                    <input type="file" id="exampleInputFile3" name="shops">
                                                    <span>美团配送：0，自配送：1</span>
                                                    <br>
                                                    <a href="{{ route('download.detail') }}" target="_blank">点击下载模板</a>
                                                </div>
                                                <button type="submit" class="btn btn-success" onclick="up_goods()">上传</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </header>
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>名称</th>
                        <th>状态</th>
                        <th>地址</th>
                        <th>美团</th>
                        @if(Auth::user()->hasRole('Finance') || Auth::user()->hasRole('Superman'))
                            <th>系数</th>
                        @endif
                        @if(Auth::user()->hasRole('Superman'))
                            <th>配送方式</th>
                        @endif
                        <th>编辑</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($shops as $shop)
                            <tr>
                                <td>{{$shop->id}}</td>
                                <td>{{$shop->name}}</td>
                                <td>
                                    @if(isset($shops_status[$shop->meituan_id]['line']))
                                        @if($shops_status[$shop->meituan_id]['line'] === 1)
                                            <span class="btn btn-success btn-xs">上线</span>
                                        @else
                                            <span class="btn btn-danger btn-xs">下线</span>
                                        @endif
                                    @endif
                                    @if(isset($shops_status[$shop->meituan_id]['open']))
                                        @if($shops_status[$shop->meituan_id]['open'] === 1)
                                            <span class="btn btn-success btn-xs">营业</span>
                                        @else
                                            <span class="btn btn-danger btn-xs">休息</span>
                                        @endif
                                    @endif
                                </td>
                                <td>{{$shop->address}}</td>
                                <td>{{$shop->meituan_id}}</td>
                                @if(Auth::user()->hasRole('Finance') || Auth::user()->hasRole('Superman'))
                                <td>{{$shop->detail->coefficient or 15}}</td>
                                @endif

                                @if(Auth::user()->hasRole('Superman'))
                                    <td>
                                        @if($shop->dc)
                                            自配送
                                        @else
                                            美团配送
                                        @endif
                                    </td>
                                @endif
                                <td>
                                    <a href="{{ route('shops.show', $shop->id) }}" class="btn btn-primary btn-xs">查看</a>
                                    @if(Auth::user()->hasPermissionTo('shop_edit'))
                                        <a href="{{ route('shops.edit', $shop->id) }}" class="btn btn-primary btn-xs">编辑</a>
                                    @endif

                                    @if(Auth::user()->hasPermissionTo('manage_users'))
                                        <a href="{{ route('shop_details.show', $shop->id) }}" class="btn btn-primary btn-xs">财务信息</a>
                                    @endif


                                    @if(Auth::user()->hasRole('Superman'))

                                        @if($shop->dc == 1)
                                            <form action="{{ route('shops.psmt', $shop->id) }}" method="post" style="display: inline" onsubmit="return alert(this, '确认修改成美团配送么？')">
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-primary btn-xs">美团配送</button>
                                            </form>
                                        @else
                                            <form action="{{ route('shops.psyd', $shop->id) }}" method="post" style="display: inline" onsubmit="return alert(this, '确认修改成自配送么？')">
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-primary btn-xs">自配送</button>
                                            </form>
                                        @endif
                                    @endif

                                    {{--@if(Auth::user()->hasAnyRole(\Spatie\Permission\Models\Role::all()))--}}
                                        @if(isset($shops_status[$shop->meituan_id]['open']))
                                            @if($shops_status[$shop->meituan_id]['open'] === 1)
                                                <form action="{{ route('shops.close', $shop->id) }}" method="post" style="display: inline" onsubmit="return alert(this, '确认休息么？')">
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="btn btn-primary btn-xs">休息</button>
                                                </form>
                                            @else
                                                <form action="{{ route('shops.open', $shop->id) }}" method="post" style="display: inline" onsubmit="return alert(this, '确认开店营业么？')">
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="btn btn-primary btn-xs">营业</button>
                                                </form>
                                            @endif
                                        @endif
                                    {{--@endif--}}

                                    @if(0)
                                        <a href="{{ route('shops.goods', $shop->id) }}" class="btn btn-primary btn-xs">清空</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="margin-left: 10px">
                    {!! $shops->appends(['keyword' => $keyword])->render() !!}
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
    @if (Session::has('sync_shop'))
        <script>
            swal({
                title: "{{ Session::get('sync_shop') }}",
                type: "success",
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif

@stop
