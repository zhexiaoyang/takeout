
<aside>
    <div id="sidebar"  class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu">
            <li class="active">
                <a class="" href="index.html">
                    <i class="icon-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="sub-menu">
                <a href="javascript:;" class="">
                    <i class="icon-book"></i>
                    <span>UI Elements</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub">
                    <li><a class="" href="general.html">General</a></li>
                    <li><a class="" href="buttons.html">Buttons</a></li>
                    <li><a class="" href="widget.html">Widget</a></li>
                    <li><a class="" href="slider.html">Slider</a></li>
                    <li><a class="" href="font_awesome.html">Font Awesome</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="javascript:;" class="">
                    <i class="icon-user"></i>
                    <span>商品管理</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub">
                    <li><a class="" href="{{route('deopts.index')}}">品库列表</a></li>
                </ul>
            </li>
            @if(Auth::user()->hasPermissionTo('manage_users'))
                <li class="sub-menu">
                    <a href="javascript:;" class="">
                        <i class="icon-user"></i>
                        <span>门店管理</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub">
                        <li><a class="" href="{{route('users.index')}}">门店列表</a></li>
                    </ul>
                </li>
            @endif
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