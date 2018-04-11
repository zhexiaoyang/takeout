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
                    <a href="{{route('users.index')}}">管理员列表</a> <span class="divider">></span>
                </li>
                <li>
                    <span>
                        @if($user->id)
                            编辑用户
                        @else
                            新建用户
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
                        @if($user->id)
                            编辑用户
                        @else
                            新建用户
                        @endif
                    </h3>
                </header>
                <div class="panel-body">
                    @if($user->id)
                        <form action="{{ route('users.update', $user->id) }}" method="POST" accept-charset="UTF-8">
                            <input type="hidden" name="_method" value="PUT">
                    @else
                        <form action="{{ route('users.store') }}" method="POST" accept-charset="UTF-8">
                    @endif
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label for="exampleInputEmail1">用户名</label>
                            <input class="form-control" type="text" name="name" value="{{ old('name', $user->name ) }}" placeholder="请填写用户名" required/>
                        </div>

                        @if(!$user->id)
                            <div class="form-group">
                                <label for="exampleInputEmail1">密码</label>
                                <input class="form-control" type="text" name="password" value="{{ old('password', $user->password ) }}" placeholder="请填写密码" required/>
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="exampleInputEmail1">手机号</label>
                            <input class="form-control" type="text" name="phone" value="{{ old('phone', $user->phone ) }}" placeholder="请填写手机号" required/>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">邮箱</label>
                            <input class="form-control" type="text" name="email" value="{{ old('email', $user->email ) }}" placeholder="请填写邮箱" required/>
                        </div>
                        <button type="submit" class="btn btn-info">保存</button>
                    </form>
                </div>
            </section>
        </div>
    </div>

@endsection