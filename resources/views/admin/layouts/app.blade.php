<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title')</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{url('/public/admin')}}/plugins/fontawesome-free/css/all.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{url('/public/admin')}}/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{url('/public/admin')}}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="{{url('/public/admin')}}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- jQuery confirm -->
  <link rel="stylesheet" href="{{url('/public/admin')}}/plugins/jquery-confirm/jquery-confirm.min.css">
  <!-- PNotify -->
  <link rel="stylesheet" href="{{url('/public/admin')}}/plugins/pnotify/core/dist/PNotify.css">
  <link rel="stylesheet" href="{{url('/public/admin')}}/plugins/pnotify/core/dist/BrightTheme.css">
  <link rel="stylesheet" href="{{url('/public/admin')}}/plugins/pnotify/mobile/dist/PNotifyMobile.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{url('/public/admin')}}/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="{{url('/public/admin')}}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{url('/public/admin')}}/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="{{url('/public/admin')}}/css/custom.css">
  @yield('header')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

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
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-comments"></i>
                <span class="badge badge-danger navbar-badge">3</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="{{url('/public/admin')}}/dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                Nguyễn Nam
                                <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">Tôi cần mua laptop...</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 giờ trước</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="{{url('/public/admin')}}/dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                Trần Hùng
                                <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">Tôi thấy sản phẩm khá đẹp...</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 giờ trước</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="{{url('/public/admin')}}/dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                Linh Thư
                                <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">Bên cửa hàng còn MAC...</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 giờ trước</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">Xem tất cả tin nhắn</a>
            </div>
        </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-header">15 thông báo</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 tin nhắn mới
            <span class="float-right text-muted text-sm">3 phút</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 lời mời kết bạn
            <span class="float-right text-muted text-sm">12 giờ</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 báo cáo mới
            <span class="float-right text-muted text-sm">2 ngày</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">Xem tất cả thông báo</a>
        </div>
      </li>
        @auth()
            <li class="nav-item">
                <form action="{{action('Admin\UserController@destroy')}}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-link">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </li>
        @endauth
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <i class="fas fa-laptop ml-3"></i>
        <span class="brand-text font-weight-light">Quản Lý Cửa Hàng</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{url('/public/admin')}}/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">ThanhBr</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{action('Admin\DashboardController@index')}}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Trang chủ</p>
            </a>
          </li>
{{--          <li class="nav-item">--}}
{{--            <a href="{{action('Admin\BannerController@index')}}" class="nav-link">--}}
{{--              <i class="nav-icon far fa-list-alt"></i>--}}
{{--              <p>Banner</p>--}}
{{--            </a>--}}
{{--          </li>--}}
{{--          <li class="nav-item">--}}
{{--            <a href="{{action('Admin\CategoryController@index')}}" class="nav-link">--}}
{{--              <i class="nav-icon far fa-list-alt"></i>--}}
{{--              <p>Category</p>--}}
{{--            </a>--}}
{{--          </li>--}}
            <li class="nav-item">
                <a href="{{action('Admin\InventoryController@index')}}" class="nav-link">
                    <i class="nav-icon fas fa-boxes"></i>
                    <p>Kho</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{action('Admin\BrandController@index')}}" class="nav-link">
                    <i class="nav-icon fab fa-bandcamp"></i>
                    <p>Thương hiệu</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{action('Admin\ProductController@index')}}" class="nav-link">
                    <i class="nav-icon fab fa-product-hunt"></i>
                    <p>Sản phẩm</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{action('Admin\InvoiceController@index')}}" class="nav-link">
                    <i class="nav-icon fas fa-file-invoice-dollar"></i>
                    <p>Hóa đơn</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{action('Admin\CustomerController@index')}}" class="nav-link">
                    <i class="nav-icon fas fa-people-arrows"></i>
                    <p>Khách hàng</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{action('Admin\CommentController@index')}}" class="nav-link">
                    <i class="nav-icon far fa-comments"></i>
                    <p>Bình luận</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{action('Admin\UserController@indexUser')}}" class="nav-link">
                    <i class="nav-icon fas fa-user"></i>
                    <p>Nhân viên</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{action('Admin\RoleController@index')}}" class="nav-link">
                    <i class="nav-icon fas fa-vote-yea"></i>
                    <p>Chức vụ</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{action('Admin\PermissionController@index')}}" class="nav-link">
                    <i class="nav-icon fab fa-critical-role"></i>
                    <p>Quyền</p>
                </a>
            </li>
{{--            <li class="nav-item">--}}
{{--                <a href="{{action('Admin\PermissionRoleController@index')}}" class="nav-link">--}}
{{--                    <i class="nav-icon far fa-list-alt"></i>--}}
{{--                    <p>Permission Role</p>--}}
{{--                </a>--}}
{{--            </li>--}}
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm">
            <h1 class="text-center font-weight-bolder">@yield('pageTitle')</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        @yield('content')

      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      version 0.1
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2021 <a href="https://www.linkedin.com/in/thanh-ma-the-9104611b0/">ThanhBr</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->
@yield('footer')
<!-- jQuery -->
<script src="{{url('/public/admin')}}/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{url('/public/admin')}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="{{url('/public/admin')}}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{url('/public/admin')}}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{url('/public/admin')}}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{url('/public/admin')}}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
{{-- Bootstrap Switch --}}
<script src="{{url('/public/admin')}}/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- jQuery confirm -->
<script src="{{url('/public/admin')}}/plugins/jquery-confirm/jquery-confirm.min.js"></script>
<!-- PNotify -->
<script src="{{url('/public/admin')}}/plugins/pnotify/core/dist/PNotify.js"></script>
<script src="{{url('/public/admin')}}/plugins/pnotify/mobile/dist/PNotifyMobile.js"></script>
<!-- Select2 -->
<script src="{{url('/public/admin')}}/plugins/select2/js/select2.full.min.js"></script>
<!-- jQuery Validation -->
<script src="{{url('/public/admin')}}/plugins/jquery-validation/jquery.validate.min.js"></script>
{{-- jquery serializeJSON --}}
<script src="{{url('/public/admin')}}/plugins/jquery.serializeJSON/jquery.serializejson.min.js"></script>
<!-- AdminLTE App -->
<script src="{{url('/public/admin')}}/dist/js/adminlte.min.js"></script>
<script src="{{url('/public/admin')}}/js/site.min.js"></script>


<!-- OPTIONAL SCRIPTS -->
<script src="{{url('/public/admin')}}/plugins/chart.js/Chart.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{url('/public/admin')}}/dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{url('/public/admin')}}/dist/js/pages/dashboard3.js"></script>


<script>
    var base_url = '{{url('')}}';
    var api_url = base_url + '/internal';

    var infoData;
    PNotify.defaultModules.set(PNotifyMobile, {});
</script>
@yield('js')
</body>
</html>
