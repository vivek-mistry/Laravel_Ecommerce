<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

        <li class="dropdown user user-menu open">
            <a href="#" data-toggle="dropdown" aria-expanded="true">
                <span>{{ Auth::guard('ecommerce_admin')->user()->name }}</span>
            </a>
            <ul class="dropdown-menu" style="width: 100% !important">
                <li class="user-footer">
                    <div class="pull-right">
                        <a href="{{ url('backend/change-profile') }}" class="btn btn-default btn-right w-100">Change Profile</a>
                    </div>
                </li>
                <li class="user-footer">
                    <div class="pull-right">
                        <a href="{{ url('backend/sign-out') }}" class="btn btn-default btn-right w-100" >Sign out</a>
                    </div>
                </li>
            </ul>
        </li>
    </ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.html" class="brand-link">
        <img src="{{ asset('backend_assets/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ env('APP_NAME') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('backend_assets/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::guard('ecommerce_admin')->user()->name }}</a>
            </div>
        </div>



        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <?php
                $current_route = Illuminate\Support\Facades\Request::segment(2);
                ?>
                <x-backend-navigation menu-title="Dashboard" fa-class="fa-tachometer-alt" routes="{{ url('backend/dashboard') }}" active-route='dashboard' />
                <x-backend-navigation menu-title="Users" fa-class="fa-users" routes="{{ url('backend/user/list') }}" active-route='user' />
                <x-backend-navigation menu-title="Orders" fa-class="fa-shopping-cart" routes="{{ url('backend/order/list') }}" active-route='order' />
                <x-backend-navigation menu-title="Coupons" fa-class="fa-percent" routes="{{ url('backend/coupon/list') }}" active-route='coupon' />
                <x-backend-navigation menu-title="Category" fa-class="fa-circle" routes="{{ url('backend/category/list') }}" active-route='category' />
                <x-backend-navigation menu-title="Product" fa-class="fa-asterisk" routes="{{ url('backend/product/list') }}" active-route='product' />
            </ul>
        </nav>

        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
