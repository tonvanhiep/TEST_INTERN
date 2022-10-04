@extends('admin.layout-management')



@section('title')
    Quản lý khách hàng
@endsection




@section('popup')
    <div class="container">
        {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">Contact Us</button> --}}
        <div class="modal" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tạo tài khoản khách hàng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div id="div-alert"></div>
                        <form id="register-form" action="{{route('admin.p_registerManagement')}}">
                            <p hidden id="token-register">{{ csrf_token() }}</p>
                            <div class="form-outline mb-3">
                                <label class="form-label" for="inp-name">Họ và tên *</label>
                                <input type="text" id="inp-name" class="form-control"/>
                            </div>

                            <div class="form-outline mb-3">
                                <label class="form-label" for="inp-email">Email *</label>
                                <input type="email" id="inp-email" class="form-control"/>
                            </div>

                            <div class="form-outline mb-3">
                                <label class="form-label" for="inp-tel">Số điện thoại *</label>
                                <input type="tel" id="inp-tel" class="form-control"/>
                            </div>

                            <div class="form-outline mb-3">
                                <label class="form-label" for="inp-pass">Mật khẩu *</label>
                                <input type="password" id="inp-pass" class="form-control"/>
                            </div>

                            <div class="form-outline mb-3">
                                <label class="form-label" for="inp-repass">Nhập lại mật khẩu *</label>
                                <input type="password" id="inp-repass" class="form-control"/>
                            </div>

                            <div class="form-outline mb-3">
                                <label class="form-label" for="inp-address">Địa chỉ</label>
                                <input type="text" id="inp-address" class="form-control"/>
                            </div>

                            <div class="d-flex justify-content-center">
                                <button type="button" class="btn btn-info btn-block" onclick="submitRegisterFormAjax();">Đăng ký tài khoản</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection




@section('content')
<div class="right-sidebar">
    <p hidden id="url-pagination">{{route('admin.p_paginationCustomerManagement')}}</p>
    <p hidden id="token-pagination">{{csrf_token()}}</p>

    <h3 class="title-category mb-40">
        <button class="btn btn-outline-dark" id="btn-menu-extend" style="display: inline; margin-right:15px">&larr;</button>QUẢN LÝ KHÁCH HÀNG
    </h3>


    <div class="d-flex flex-row-reverse">
        <div class="p-2">
            <button class="btn btn-info" type="button" data-bs-toggle="modal" data-bs-target="#myModal">Tạo tài khoản</button>
        </div>
        <div class="p-2">
            <button class="btn btn-info">Xuất CSV</button>
        </div>
        <div class="p-2">
            <button class="btn btn-info">Thêm CSV</button>
        </div>
    </div>

    <div class="options">
        <form class="d-flex flex-row" id="search-form" action="{{route('admin.p_searchcustomerManagement')}}">
            <div class="p-2">
                <label class="form-label" for="search-name">Họ và tên</label>
                <input class="form-control" id="search-name" type="search" placeholder="Nhập họ tên khách hàng">
            </div>
            <div class="p-2">
                <label class="form-label" for="search-email">Email</label>
                <input class="form-control" id="search-email" type="search" placeholder="Nhập email">
            </div>
            <div class="p-2">
                <label class="form-label" for="filter-status">Trạng thái</label>
                <select class="form-select" id="filter-status">
                    <option selected>Hoạt động</option>
                    <option>Tạm khóa</option>
                </select>
            </div>
            <div class="p-2">
                <label class="form-label" for="search-address">Địa chỉ</label>
                <input class="form-control" id="search-address" type="search" placeholder="Nhập địa chỉ">
            </div>
            <div class="align-self-end p-2">
                <button class="btn btn-outline-dark" type="button" onclick="submitSearchFormAjax();">Tìm kiếm</button>
            </div>
            <div class="align-self-end p-2">
                <button class="btn btn-outline-dark" type="reset" onclick="deleteSearchFormAjax();">Xóa tìm kiếm</button>
            </div>
        </form>
    </div>



    <div class="mt-3" id="pagination-content">
        @include('admin.pagination-customer-management')
    </div>
</div>



@endsection



@section('js')
    <script src="{{asset('assets/js/customer-managerment.js?v=003')}}"></script>
@endsection

