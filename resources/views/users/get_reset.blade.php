@extends('layouts.app')

@section('title', '修改密码')

@section('content')
    <div class="row" style="margin: -15px;">
        <div class="span6">
            <ul class="breadcrumb">
                <li>
                    <a href="{{route('index.index')}}">主页</a> <span class="divider">></span>
                </li>
                <li>
                    <span>修改密码</span>
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            @include('layouts._message')
            <section class="panel">
                <header class="panel-heading">
                    <h3>
                        <i class="icon-edit"></i>
                        修改密码
                    </h3>
                </header>
                <div class="panel-body">
                    <form class="layui-form layui-form-pane" action="{{route('user.postReset')}}" style="margin: 20px 0px;" method="post">
                        {{csrf_field()}}
                        <div class="col-lg-6">
                            @include('common.error')
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label class="control-label visible-ie8 visible-ie9">原始密码</label>
                                <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Old Password" name="oldpassword"> </div>
                            <div class="form-group">
                                <label class="control-label visible-ie8 visible-ie9">新密码</label>
                                <input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="register_password" placeholder="New password" name="password"> </div>
                            <div class="form-group">
                                <label class="control-label visible-ie8 visible-ie9">重复密码</label>
                                <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Repeat password" name="password_confirmation"> </div>
                            <div class="form-actions">
                                <button type="submit" id="register-submit-btn" class="btn btn-success uppercase pull-right">确定</button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>

@endsection