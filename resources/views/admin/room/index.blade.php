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
                <h4 class="m-b-0">Danh mục phòng khám</h4>
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
                    <form class="m-b-25" method="post" action="{{ route('admin.room.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label >Số phòng khám</label>
                            <input type="text" class="form-control" name="name" placeholder="Số phòng khám" required="">
                        </div>
                        <div class="form-group">
                            <label >Loại phòng khám</label>
                            <select name="services_procedure_id" class="services_procedure form-control"> </select>
                        </div>
                        <div class="align-justify-center">
                            <button class="btn btn-primary btn-tone m-t-10 flex-right">
                                Tạo phòng khám
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



<!-- <script src="{{ asset('assets/js/dragula.min.js') }}"></script> -->
<script src="{{ asset('assets/js/page/room.js') }}"></script>


@endsection()