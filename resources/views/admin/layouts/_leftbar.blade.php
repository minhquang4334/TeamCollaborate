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
                <a href="{{config('menubar.user_manager_path')}}"><span class="fa fa-user"></span>{{config('menubar.user')}}</a>
            </li>
            <li>
                <a href="{{config('menubar.admin_manager_path')}}"><span class="fa fa-user-circle-o"></span>{{config('menubar.admin')}}</a>
            </li>
            <li>
                <a href="{{config('menubar.product_manager_path')}}"><span class="fa fa-product-hunt"></span>{{config('menubar.product')}}</a>
            </li>
            <li>
                <a href="{{config('menubar.category_manager_path')}}"><span class="fa fa-tags"></span>{{config('menubar.category')}}</a>
            </li>
            <li>
                <a href="{{config('menubar.order_manager_path')}}"><span class="fa fa-file"></span>{{config('menubar.order')}}</a>
            </li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
