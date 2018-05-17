
<header class="header white-bg">
    <div class="sidebar-toggle-box">
        <div data-original-title="Toggle Navigation" data-placement="right" class="icon-reorder tooltips"></div>
    </div>
    <!--logo start-->
    <a href="#" class="logo">外卖<span>后台</span></a>
    <!--logo end-->
    <div class="nav notify-row" id="top_menu">
        <!--  notification start -->
        <ul class="nav top-menu">
            <!-- notification dropdown start-->
            <li id="header_notification_bar" class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">

                    <i class="icon-bell-alt"></i>
                    <span class="badge bg-warning">@if(!empty($print_orders)) {{ count($print_orders) }} @else 0 @endif</span>
                </a>
                <ul class="dropdown-menu extended notification">
                    <div class="notify-arrow notify-arrow-yellow"></div>
                    <li>
                        <p class="yellow"><span id="ddy_num">@if(!empty($print_orders)) {{ count($print_orders) }} @else 0 @endif</span>单待打印</p>
                    </li>
                    @foreach($print_orders as $print_order)
                    <li>
                        <a href="{{route('orders.show', $print_order['id'])}}" target="_blank">{{ $print_order['order_id'] }}</a>
                    </li>
                    @endforeach
                    <li>
                        <a href="#">请尽快处理</a>
                    </li>
                </ul>
            </li>
            <!-- notification dropdown end -->
        </ul>
        <!--  notification end -->
    </div>
    <div class="top-nav ">
        <!--search & user info start-->
        <ul class="nav pull-right top-menu">
            <li class="dropdown open">
                <input type="text" class="form-control search" placeholder="订单号..." style="margin-top: 0px;">
                {{--<ul class="dropdown-menu extended inbox">--}}
                    {{--<div class="notify-arrow notify-arrow-red"></div>--}}
                    {{--<li>--}}
                        {{--<p class="red">You have 5 new messages</p>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a href="#">--}}
                            {{--<span class="photo"><img alt="avatar" src="img/avatar-mini.jpg"></span>--}}
                            {{--<span class="subject">--}}
                                    {{--<span class="from">Jonathan Smith</span>--}}
                                    {{--<span class="time">Just now</span>--}}
                                    {{--</span>--}}
                            {{--<span class="message">--}}
                                        {{--Hello, this is an example msg.--}}
                                    {{--</span>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a href="#">See all messages</a>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            </li>
            <!-- user login dropdown start-->
            @guest
                {{--<li><a href="{{ route('login') }}">登录</a></li>--}}
                {{--<li><a href="{{ route('register') }}">注册</a></li>--}}
            @else
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <i class="icon-user"></i>
                        <span class="username">{{ Auth::user()->name }}</span>
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu extended logout">
                        <div class="log-arrow-up"></div>
                        <li><a href="{{ route('user.getReset',Auth::user()->id) }}">修改密码</a></li>
                        <li>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                退出登录
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
            @endguest
            <!-- user login dropdown end -->
        </ul>
        <!--search & user info end-->
    </div>
</header>