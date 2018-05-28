@extends('layouts.app')

@section('title', '打款统计')

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
                    <span>打款统计</span>
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    打款统计
                    <div class="panel-body">
                        <form class="form-inline" role="form" action="{{route('goods.index')}}" method="get">
                            <div class="col-lg-10">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <select class="form-control" name="shop_id">
                                            <option value="" @if(!$shop_id) selected @endif>全部药店</option>
                                            @foreach($shops as $shop)
                                                <option value="{{ $shop->id }}" @if($shop_id == $shop->id) selected @endif>{{ $shop->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <label class="sr-only" for="keyword">打款单号</label>
                                        <input value="{{$keyword or ''}}" type="text" class="form-control" id="keyword" name="keyword" placeholder="关键字...">
                                    </div>
                                    <div class="col-lg-4">
                                        <button type="submit" class="btn btn-info">搜索</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </header>
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th>打款单号</th>
                        <th>药店名称</th>
                        <th>提点</th>
                        <th>账单开始时间</th>
                        <th>账单结束时间</th>
                        <th>销售金额</th>
                        <th>药店收益</th>
                        <th>违规罚款</th>
                        <th>应返金额</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($list))
                    @foreach ($list as $good)
                        <tr>
                            <td>{{$good->deopt->id}}</td>
                        </tr>
                    @endforeach
                    @endif
                    </tbody>
                </table>
                <div style="margin-left: 10px">
{{--                    {!! $list->appends(['keyword' => $keyword])->render() !!}--}}
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
