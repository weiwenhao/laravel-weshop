<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/images/icon1.png" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ auth('admin')->user()->name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> 在线</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            @foreach($menus as $value)
                @continue(!auth('admin')->user()->can($value->name) && !auth('admin')->user()->hasRole('admin'))
                <li class="treeview">
                    <a href="#">
                        <i class="fa {{ $value->icon }}"></i> <span>{{ $value->display_name }}</span>
                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        @foreach($value->children as $value2)
                            @continue(!auth('admin')->user()->can($value2->name) && !auth('admin')->user()->hasRole('admin'))
                            <li class="menu {{ active_class(if_uri_pattern('admin/'.$value2->url.'*'), 'active', '') }}"><a href="/admin/{{ $value2->url }}"><i class="fa fa-circle-o"></i> {{ $value2->display_name }}</a></li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>