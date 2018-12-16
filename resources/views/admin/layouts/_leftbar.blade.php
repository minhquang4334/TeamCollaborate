<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/admin/images/avatar.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li>
                <a href="/admin/dashboard"><span class="fa fa-dashboard"></span>Dashboard</a>
            </li>
            <li>
                <a href="{{config('menubar.users_manager_path')}}"><span class="fa fa-user"></span>{{config('menubar.users')}}</a>
            </li>
            <li>
                <a href="{{config('menubar.channels_manager_path')}}"><span class="fa fa-comments"></span>{{config('menubar.channels')}}</a>
            </li>
            <li>
                <a href="{{config('menubar.files_manager_path')}}"><span class="fa fa-file-text"></span>{{config('menubar.files')}}</a>
            </li>
            <li>
                <a href="{{config('menubar.reports_manager_path')}}"><span class="fa fa-flag"></span>{{config('menubar.reports')}}</a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
