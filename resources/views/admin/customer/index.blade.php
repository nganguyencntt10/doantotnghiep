@extends('admin.layout')
@section('title', 'Nhân Viên')
@section('menu-data')
<input type="hidden" name="" class="menu-data" value="customer-group | customer">
@endsection()

@section('css')

<!-- page css -->
<link href="{{ asset('assets/vendors/datatables/dataTables.bootstrap.min.css') }}" rel="stylesheet">

<!-- <link href="{{ asset('assets/css/dragula.min.css') }}" rel="stylesheet"> -->

@endsection()

@section('body')

<div class="page-header no-gutters has-tab">
    <div class="d-md-flex m-b-15 align-items-center justify-content-between notification relative">
        <div class="media align-items-center justify-content-between m-b-15 w-100">
            <div class="m-l-15">
                <h4 class="m-b-0">Danh mục nhân viên</h4>
            </div>
            @include('admin.alert')
        </div>
    </div>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#services-overview" atr="Services List">Danh sách</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#services-create" atr="Services Create"><i class="anticon anticon-plus-circle"></i> Tạo tài khoản nhân viên</a>
        </li>
    </ul>
</div>
<?php 
    $token = Request::cookie('token');
?>
<div class="container-fluid">
    <div class="tab-content m-t-15">
        <div class="tab-pane fade active show" id="services-overview">
            <div class="card">
                <div class="card-body">
                    <div class="m-t-25">
                        <table id="data-table" class="table"> </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade oop-create" id="services-create">
            <div class="card col-xs-12 col-md-8 offset-2">
                <div class="card-body">
                    <form class="m-b-25" method="post" action="{{ route('admin.customer.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label >Email</label>
                            <input type="text" class="form-control" name="email" placeholder="email" required="">
                        </div>
                        <div class="form-group">
                            <label >Mật khẩu</label>
                            <input type="text" class="form-control" name="password" placeholder="password" required="">
                        </div>
                        <div class="form-group">
                            <label >Phân quyền</label>
                            <select name="middleware" class="form-control">
                                <option value="admin">Admin</option>
                                <option value="manage">Manage</option>
                                <option value="doctor">Doctor</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="" class="m-t-10" style="font-weight: bold;">Thông tin cá nhân</label>
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label >Tên đăng nhập</label>
                                        <input type="text" class="form-control" name="username" placeholder="Tên đăng nhập" required="">
                                    </div>
                                    <div class="form-group">
                                        <label >Họ và tên</label>
                                        <input type="text" class="form-control" name="name" placeholder="Họ và tên" required="">
                                    </div>
                                    <div class="form-group">
                                        <div class="align-justify-center ">
                                            <label class="m-0">Hình ảnh</label>
                                            <span class="flex-right image-selected">
                                                <label class="upload-global" for="image-upload" atr="Image Upload"><i class="anticon anticon-upload"></i></label>
                                            </span>
                                        </div>
                                        <div class="image-preview m-t-10">
                                            <div class="image-preview-wrapper align-justify-center">
                                                <img src="{{ asset('images_global/noimage.jpg') }}">
                                            </div>
                                        </div>
                                        <input type="file" class="form-control image_global services-image" name="avatar" id="image-upload" style="display: none;" accept="image/*">
                                    </div>
                                    <div class="form-group">
                                        <label >Số chứng minh nhân dân</label>
                                        <input type="text" class="form-control" name="code" placeholder="Số cmnd" required="">
                                    </div>
                                    <div class="form-group">
                                        <label >Địa chỉ</label>
                                        <input type="text" class="form-control" name="address" placeholder="Địa chỉ" required="">
                                    </div>
                                    <div class="form-group">
                                        <label >Ngày sinh</label>
                                        <input type="date" class="form-control" name="dob" placeholder="Sinh nhật" required="">
                                    </div>
                                    <div class="form-group">
                                        <label >Số điện thoại</label>
                                        <input type="text" class="form-control" name="telephone" placeholder="Số điện thoại" required="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="align-justify-center">
                            <button class="btn btn-primary btn-tone m-t-10 flex-right">
                                Tạo tài khoản
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection()

@section('sub_layout')


@endsection()


@section('js')
<!-- page js -->
<script src="{{ asset('assets/vendors/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendors/datatables/dataTables.bootstrap.min.js') }}"></script>

<script src="{{ asset('assets/js/page/customer.js') }}"></script>

@endsection()