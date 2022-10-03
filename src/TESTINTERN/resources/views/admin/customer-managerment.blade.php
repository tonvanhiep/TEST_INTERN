@extends('admin.layout-managerment')



@section('title')
    Quản lý khách hàng
@endsection




@section('popup')
    <div class="container mt-5">
        {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">Contact Us</button> --}}
        <div class="modal" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tạo tài khoản khách hàng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" action="http://localhost:8000/taikhoan/dangky">
                            @csrf
                            <div class="form-outline mb-3">
                                <label class="form-label" for="inp-name">Họ và tên *</label>
                                <input type="text" id="inp-name" name="name" class="form-control"/>
                            </div>

                            <div class="form-outline mb-3">
                                <label class="form-label" for="inp-email">Email *</label>
                                <input type="email" id="inp-email" name="email" class="form-control"/>
                            </div>

                            <div class="form-outline mb-3">
                                <label class="form-label" for="inp-tel">Số điện thoại *</label>
                                <input type="tel" id="inp-tel" name="tel" class="form-control"/>
                            </div>

                            <div class="form-outline mb-3">
                                <label class="form-label" for="inp-pass">Mật khẩu *</label>
                                <input type="password" id="inp-pass" name="pass" class="form-control"/>
                            </div>

                            <div class="form-outline mb-3">
                                <label class="form-label" for="inp-repass">Nhập lại mật khẩu *</label>
                                <input type="password" id="inp-repass" name="re-pass" class="form-control"/>
                            </div>

                            <div class="form-outline mb-3">
                                <label class="form-label" for="inp-address">Địa chỉ</label>
                                <input type="text" id="inp-address" name="address" class="form-control"/>
                            </div>

                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-info btn-block">Đăng ký tài khoản</button>
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

    <h3 class="title-category mb-40">
        <button class="btn btn-outline-dark" id="btn-menu-extend" style="display: inline; margin-right:15px">&larr;</button>QUẢN LÝ KHÁCH HÀNG
    </h3>


    <div class="d-flex flex-row-reverse">
        <div class="p-2">
            {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">Contact Us</button> --}}
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
        <form action="" class="d-flex flex-row">
            <div class="p-2">
                <label class="form-label" for="search-name">Họ và tên</label>
                <input class="form-control" id="search-name" name="name" placeholder="Nhập họ tên khách hàng">
            </div>
            <div class="p-2">
                <label class="form-label" for="search-email">Email</label>
                <input class="form-control" id="search-email" placeholder="Nhập email">
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
                <button class="btn btn-outline-dark">Tìm kiếm</button>
            </div>
            <div class="align-self-end p-2">
                <button class="btn btn-outline-dark">Xóa tìm kiếm</button>
            </div>
        </form>
    </div>



    <div class="mt-3" >
        @include('components.pagination')

        <div class="d-flex justify-content-end">
            <p>Hiển thị từ <strong> {{$record['min']}} </strong> đến <strong> {{$record['max']}} </strong> trong tổng số <strong> {{$record['total']}} </strong> khách hàng</p>
        </div>

        <div>
            <table class="table table-hover table-condensed">
                <thead>
                    <tr>
                        <th style="width:7%" class="text-center">ID</th>
                        <th style="width:15%" class="text-center">Họ và tên</th>
                        <th style="width:10%" class="text-center">Số đt</th>
                        <th style="width:15%" class="text-center">Email</th>
                        <th style="width:23%" class="text-center">Địa chỉ</th>
                        <th style="width:10%" class="text-center">Trạng thái</th>
                        <th style="width:12%" class="text-center">Ngày tạo</th>
                        <th style="width:4%" class="text-center"></th>
                        <th style="width:4%" class="text-center"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listCustomer as $item)
                    <tr>
                        <td data-th="ID">
                            #{{$item->customer_id}}
                        </td>
                        <td data-th="Name">
                            <input class="form-control inp-row-{{$item->customer_id}} inp-name" value="{{$item->customer_name}}" name="name" disabled>
                        </td>
                        <td data-th="Subtotal" class="Tel">
                            <input class="form-control inp-row-{{$item->customer_id}} inp-tel" value="{{$item->tel_num}}" name="tel" disabled>
                        </td>
                        <td class="actions" data-th="Email">
                            <input class="form-control inp-row-{{$item->customer_id}} inp-email" value="{{$item->email}}" name="email" disabled>
                        </td>
                        <td class="actions" data-th="Address">
                            <input class="form-control inp-row-{{$item->customer_id}} inp-address" value="{{$item->address}}" name="address" disabled>
                        </td>
                        <td class="actions" data-th="Status">
                            <select class="form-select inp-row-{{$item->customer_id}} inp-status" name="status" aria-label="Disabled select example" disabled>
                                <option value="1" {{($item->is_active == 1)?'selected':''}}>Hoạt động</option>
                                <option value="0" {{($item->is_active == 0)?'selected':''}}>Tạm khóa</option>
                            </select>
                        </td>
                        <td class="actions" data-th="CreatedAt">
                            {{$item->created_at}}
                        </td>
                        <td class="actions" data-th="Edit">
                            <button class="btn btn-outline-warning" id="btn-edit-inp-{{$item->customer_id}}" onclick="editCustomerId({{$item->customer_id}});">Sửa</button>
                        </td>
                        <td class="actions" data-th="Remove">
                            <button class="btn btn-outline-danger" id="btn-edit-inp-{{$item->customer_id}}" onclick="deleteCustomerId({{$item->customer_id}});">Xóa</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @include('components.pagination')

    </div>
</div>



@endsection



@section('js')
    <script src="{{asset('assets/js/customer-managerment.js')}}"></script>
@endsection

