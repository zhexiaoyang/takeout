
<aside>
    <div id="sidebar"  class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu">
            <li class="sub-menu">
                <a href="javascript:;" class="">
                    <i class="icon-user"></i>
                    <span>商品管理</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub">
                    <li><a class="" href="{{route('goods.index')}}">商品列表</a></li>
                    <li><a class="" href="{{route('deopts.index')}}">品库列表</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="javascript:;" class="">
                    <i class="icon-user"></i>
                    <span>订单管理</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub">
                    <li><a class="" href="{{route('orders.index')}}">订单列表</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="javascript:;" class="">
                    <i class="icon-user"></i>
                    <span>门店管理</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub">
                    <li><a class="" href="{{route('shops.index')}}">门店列表</a></li>
                </ul>
            </li>
                <li class="sub-menu">
                    <a href="javascript:;" class="">
                        <i class="icon-user"></i>
                        <span>财务管理</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub">
                        @if(Auth::user()->hasPermissionTo('finance_view'))
                        <li><a class="" href="{{route('finance.hit')}}">打款统计</a></li>
                        @endif
                        <li><a class="" href="{{route('finance.sales')}}">销售药品统计</a></li>
                    </ul>
                </li>
            @if(Auth::user()->hasPermissionTo('manage_users'))
                <li class="sub-menu">
                    <a href="javascript:;" class="">
                        <i class="icon-user"></i>
                        <span>权限管理</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub">
                        <li><a class="" href="{{route('users.index')}}">用户管理</a></li>
                    </ul>
                </li>
            @endif
        </ul>
        <!-- sidebar menu end-->
    </div>
</aside>