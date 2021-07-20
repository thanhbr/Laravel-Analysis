@extends('admin.layouts.app')
@section('title', 'Trang chủ')
@section('pageTitle', 'Trang chủ')
@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>150</h3>
                    <p>Đơn hàng mới</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <div class="d-flex justify-content-center">
                        <h3>650,000,000</h3><span> vnđ</span>
                    </div>
                    <p>Doanh thu hôm trước</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>53<sup style="font-size: 20px">%</sup></h3>
                    <p>Tỷ lệ truy cập</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>44</h3>
                    <p>Người dùng đăng ký mới</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">Bán hàng theo tuần</h3>
                        <a href="javascript:void(0);">Xem báo cáo</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex">
                        <p class="d-flex flex-column">
                            <span class="text-bold text-lg">820,000,000 vnđ</span>
                            <span>Bán hàng theo thời gian</span>
                        </p>
                        <p class="ml-auto d-flex flex-column text-right">
                    <span class="text-success">
                      <i class="fas fa-arrow-up"></i> 12.5%
                    </span>
                            <span class="text-muted">Kể từ tuần trước</span>
                        </p>
                    </div>
                    <!-- /.d-flex -->

                    <div class="position-relative mb-4">
                        <canvas id="visitors-chart" height="200"></canvas>
                    </div>

                    <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square text-primary"></i> Tuần này
                  </span>

                        <span>
                    <i class="fas fa-square text-gray"></i> Tuần trước
                  </span>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">Bán hàng theo tháng</h3>
                        <a href="javascript:void(0);">Xem báo cáo</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex">
                        <p class="d-flex flex-column">
                            <span class="text-bold text-lg">18,000,000,000 vnđ</span>
                            <span>Bán hàng theo thời gian</span>
                        </p>
                        <p class="ml-auto d-flex flex-column text-right">
                            <span class="text-success"><i class="fas fa-arrow-up"></i> 33.1%</span>
                            <span class="text-muted">Kể từ tháng trước</span>
                        </p>
                    </div>
                    <div class="position-relative mb-4">
                        <canvas id="sales-chart" height="200"></canvas>
                    </div>
                    <div class="d-flex flex-row justify-content-end">
                        <span class="mr-2"><i class="fas fa-square text-primary"></i> Năm nay</span>
                        <span><i class="fas fa-square text-gray"></i> Năm trước</span>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- TABLE: LATEST ORDERS -->
            <div class="card" style="height: max-content">
                <div class="card-header border-transparent">
                    <h3 class="card-title">Đơn hàng mới</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                            <tr>
                                <th>Mã</th>
                                <th>Sản phẩm</th>
                                <th>Trạng thái</th>
                                <th>Địa chỉ giao hàng</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><a href="pages/examples/invoice.html">OR9842</a></td>
                                <td>Laptop Lenovo Yoga 6 13ARE05</td>
                                <td><span class="badge badge-warning">Đã vận chuyển</span></td>
                                <td>
                                    <div class="sparkbar" data-color="#00a65a" data-height="20">Số 1, Tô Ký, Quận 12</div>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="pages/examples/invoice.html">OR1848</a></td>
                                <td>Apple MacBook Pro 13 M1 256GB</td>
                                <td><span class="badge badge-danger">Đang xử lý</span></td>
                                <td>
                                    <div class="sparkbar" data-color="#f39c12" data-height="20">Số 2, Bình An, Quận 2</div>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="pages/examples/invoice.html">OR7429</a></td>
                                <td>Laptop MSI Gaming BRAVO</td>
                                <td><span class="badge badge-success">Đã nhận</span></td>
                                <td>
                                    <div class="sparkbar" data-color="#f56954" data-height="20">Số 3, Tân Định, Quận 3</div>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="pages/examples/invoice.html">OR7429</a></td>
                                <td>Surface Pro 7 Core i5 / 8GB</td>
                                <td><span class="badge badge-success">Đã nhận</span></td>
                                <td>
                                    <div class="sparkbar" data-color="#00c0ef" data-height="20">Số 5, Khánh Hội, Quận 4</div>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="pages/examples/invoice.html">OR9842</a></td>
                                <td>Laptop Lenovo Yoga 6 13ARE05</td>
                                <td><span class="badge badge-warning">Đã vận chuyển</span></td>
                                <td>
                                    <div class="sparkbar" data-color="#00a65a" data-height="20">Số 10, Tô Ký, Quận 12</div>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="pages/examples/invoice.html">OR1848</a></td>
                                <td>Apple MacBook Pro 13 M1 256GB</td>
                                <td><span class="badge badge-danger">Đang xử lý</span></td>
                                <td>
                                    <div class="sparkbar" data-color="#f39c12" data-height="20">Số 20, Bình An, Quận 2</div>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="pages/examples/invoice.html">OR7429</a></td>
                                <td>Laptop MSI Gaming BRAVO</td>
                                <td><span class="badge badge-success">Đã nhận</span></td>
                                <td>
                                    <div class="sparkbar" data-color="#f56954" data-height="20">Số 30, Tân Định, Quận 3</div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Đơn hàng mới</a>
                    <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">Xem tất cả đơn hàng</a>
                </div>
                <!-- /.card-footer -->
            </div>
            <!-- /.card -->
        </div>

        <div class="col-lg-4">
            <!-- PRODUCT LIST -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Sản phẩm mới</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <ul class="products-list product-list-in-card pl-2 pr-2">
                        <li class="item">
                            <div class="product-img">
                                <img src="{{url('/public/admin')}}/dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                            </div>
                            <div class="product-info">
                                <a href="javascript:void(0)" class="product-title">Laptop Surface Pro 7
                                    <span class="badge badge-warning float-right">30,000,000 vnđ</span></a>
                                <span class="product-description">Hàng nhập khẩu chính hãng bởi nhà phân phối.</span>
                            </div>
                        </li>
                        <li class="item">
                            <div class="product-img">
                                <img src="{{url('/public/admin')}}/dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                            </div>
                            <div class="product-info">
                                <a href="javascript:void(0)" class="product-title">Apple MacBook Pro 13
                                    <span class="badge badge-warning float-right">45,000,000 vnđ</span></a>
                                <span class="product-description">Hàng nhập khẩu chính hãng bởi nhà phân phối.</span>
                            </div>
                        </li>
                        <li class="item">
                            <div class="product-img">
                                <img src="{{url('/public/admin')}}/dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                            </div>
                            <div class="product-info">
                                <a href="javascript:void(0)" class="product-title">Laptop MSI Gaming
                                    <span class="badge badge-warning float-right">29,000,000 vnđ</span></a>
                                <span class="product-description">Hàng nhập khẩu chính hãng bởi nhà phân phối.</span>
                            </div>
                        </li>
                        <li class="item">
                            <div class="product-img">
                                <img src="{{url('/public/admin')}}/dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                            </div>
                            <div class="product-info">
                                <a href="javascript:void(0)" class="product-title">Laptop Surface Pro 7
                                    <span class="badge badge-warning float-right">30,000,000 vnđ</span></a>
                                <span class="product-description">Hàng nhập khẩu chính hãng bởi nhà phân phối.</span>
                            </div>
                        </li>
                        <li class="item">
                            <div class="product-img">
                                <img src="{{url('/public/admin')}}/dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                            </div>
                            <div class="product-info">
                                <a href="javascript:void(0)" class="product-title">Apple MacBook Pro 13
                                    <span class="badge badge-warning float-right">45,000,000 vnđ</span></a>
                                <span class="product-description">Hàng nhập khẩu chính hãng bởi nhà phân phối.</span>
                            </div>
                        </li>
                        <li class="item">
                            <div class="product-img">
                                <img src="{{url('/public/admin')}}/dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                            </div>
                            <div class="product-info">
                                <a href="javascript:void(0)" class="product-title">Laptop MSI Gaming
                                    <span class="badge badge-warning float-right">29,000,000 vnđ</span></a>
                                <span class="product-description">Hàng nhập khẩu chính hãng bởi nhà phân phối.</span>
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- /.card-body -->
                <div class="card-footer text-center">
                    <a href="javascript:void(0)" class="uppercase">Xem tất cả sản phẩm</a>
                </div>
                <!-- /.card-footer -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>

@endsection
