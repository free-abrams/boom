        <!--左侧导航开始-->
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="nav-close"><i class="fa fa-times-circle"></i>
            </div>
            <div class="sidebar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                            <span><img alt="image" class="img-circle" src="{{Auth::guard('admin')->user()->avatar}}" /></span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear">
                               <span class="block m-t-xs"><strong class="font-bold">Beaut-zihan</strong></span>
                                <span class="text-muted text-xs block">超级管理员<b class="caret"></b></span>
                                </span>
                            </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a class="J_menuItem" href="form_avatar.html">修改头像</a>
                                </li>
                                <li><a class="J_menuItem" href="profile.html">个人资料</a>
                                </li>
                                <li><a class="J_menuItem" href="contacts.html">联系我们</a>
                                </li>
                                <li><a class="J_menuItem" href="mailbox.html">信箱</a>
                                </li>
                                <li class="divider"></li>
                                <li><a href="{{route('logout')}}">安全退出</a>
                                </li>
                            </ul>
                        </div>
                        <div class="logo-element">H+
                        </div>
                    </li>


                    <li>
                        <a href="#"><i class="fa fa-cutlery"></i> <span class="nav-label">角色与权限 </span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a class="J_menuItem" href="{{route('role.index')}}" >角色</a>
                            </li>
                            <li>
                                <a class="J_menuItem" href="{{route('permission.index')}}">权限</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <!--左侧导航结束-->