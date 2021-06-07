@extends('admin.layout')
@section('title', 'Dịch vụ')
@section('menu-data')
<input type="hidden" name="" class="menu-data" value="services-group | services">
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
                <h4 class="m-b-0">Danh mục dịch vụ</h4>
            </div>
            @include('admin.alert')
        </div>
    </div>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#services-overview" atr="Services List">Danh sách</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#services-create" atr="Services Create"><i class="anticon anticon-plus-circle"></i> Tạo dịch vụ</a>
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
                    <form class="m-b-25" method="post" action="{{ route('admin.services.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label >Tên danh mục</label>
                            <input type="text" class="form-control stone-name" name="name" placeholder="Tên dịch vụ" required="">
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
                            <input type="file" class="form-control image_global services-image" name="image" id="image-upload" style="display: none;" accept="image/*">
                        </div>
                        <div class="form-group">
                            <div class="align-justify-center ">
                                <label class="m-0">Ảnh mô tả</label>
                                <span class="flex-right image-selected">
                                    <label class="select-gallery product-image-list" for="images" atr="Image Select"><i class="anticon anticon-upload"></i></label>
                                    <input type="file" class="form-control image_global services-images" name="images[]" id="images" style="display: none;" multiple="" accept="image/*">
                                </span>
                            </div>
                            <div class="card m-t-10 border-blue">
                                <div class="card-body">
                                    <div class="image-list">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label >Giới thiệu</label>
                            <input type="text" class="form-control" name="description" required="">
                        </div>
                        <div class="form-group">
                            <label >Mô tả</label>
                            <textarea class="form-control" id="detail" name="detail" required=""></textarea>
                        </div>
                        <div class="form-group">
                            <label >Quy trình</label>
                            <div class="card border-blue">
                                <div class="card-body">
                                    <div class="services-sub-wrapper border-bottom-blue p-b-30">

                                    </div>
                                    <div class="services-sub-action p-t-20">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-4">
                                                    <label for="">Tên quy trình</label>
                                                    <input type="text" class="form-control procedure-name">
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <label for="">Thời gian thực hiện</label>
                                                    <input type="number" class="form-control procedure-time">
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <label for="">Đơn giá</label>
                                                    <input type="number" class="form-control procedure-prices">
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-2">
                                                    <div class="btn btn-tone btn-success pointer procedure-create float-right m-t-30" atr="Create Procedure">
                                                        + Quy trình
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="align-justify-center">
                            <button class="btn btn-primary btn-tone m-t-10 flex-right">
                                Tạo dịch vụ
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

<!-- UPDATE CATEGORY -->
<div class="modal fade" id="edit-category">
    <div class="modal-dialog">
        <div class="modal-content" id="category-form-update">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Category</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="anticon anticon-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="category_id" class="category_id">
                <div class="form-group">
                    <label >Category name ( Vi )</label>
                    <input type="text" class="form-control vi_name" name="vi_name" placeholder="Category name" required="">
                </div>
                <div class="form-group">
                    <label >Category name ( En )</label>
                    <input type="text" class="form-control en_name" name="en_name" placeholder="Category name" required="">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default modal-action" data-dismiss="modal">Close</button>
                <button class="btn btn-primary modal-action" atr="Save">Save</button>
            </div>
        </div>
    </div>
</div>
@endsection()


@section('js')
<!-- page js -->
<script src="{{ asset('assets/vendors/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendors/datatables/dataTables.bootstrap.min.js') }}"></script>



<!-- <script src="{{ asset('assets/js/dragula.min.js') }}"></script> -->
<script src="{{ asset('assets/js/page/services.js') }}"></script>


@endsection()