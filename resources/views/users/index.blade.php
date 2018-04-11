@extends('layouts.app')

@section('title', '用户列表')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-reset.css') }}">
@stop

@section('content')

    <div class="row" style="margin: -15px;">
        <div class="span6">
            <ul class="breadcrumb">
                <li>
                    <a href="{{route('index.index')}}">主页</a> <span class="divider">></span>
                </li>
                <li>
                    <span>管理员列表</span>
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    用户列表
                    <div class="panel-body">
                        <form class="form-inline" role="form" action="{{route('users.index')}}" method="get">
                            <div class="form-group">
                                <label class="sr-only" for="keyword">关键字</label>
                                <input type="text" class="form-control" id="keyword" name="keyword" placeholder="关键字...">
                            </div>
                            <button type="submit" class="btn btn-info">搜索</button>
                            <a href="{{route('users.create')}}" class="btn btn-success">添加用户</a>
                        </form>
                    </div>
                </header>
                <table class="table table-striped table-advance table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>用户名</th>
                            <th>电话</th>
                            <th>创建时间</th>
                            <th>编辑</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{$user->id}}</td>
                                <td>{{$user->name}}</td>
                                <td class="hidden-phone">{{$user->phone}}</td>
                                <td>{{$user->created_at}}</td>
                                <td>
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-xs"><i class="icon-pencil"></i></a>
                                    <button class="btn btn-info btn-xs"><i class="icon-refresh"></i></button>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="post" style="display: inline">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="btn btn-danger btn-xs">
                                            <i class="icon-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="margin-left: 10px">
                    {!! $users->render() !!}
                </div>
            </section>
        </div>
    </div>
@endsection