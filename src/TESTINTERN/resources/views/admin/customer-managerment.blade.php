@extends('admin.layout-managerment')



@section('title')
    Quản lý khách hàng
@endsection



@section('content')
<div class="right-sidebar">

    <h3 class="title-category mb-40">
        <button class="btn btn-outline-dark" id="btn-menu-extend" style="display: inline"><</button>QUẢN LÝ KHÁCH HÀNG
    </h3>


    <div class="d-flex flex-row-reverse">
        <div class="p-2">
            <button class="btn btn-info">Tạo tài khoản</button>
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
                <label for="search-name">Họ và tên</label>
                <input id="search-name" name="name" placeholder="Nhập họ tên khách hàng">
            </div>
            <div class="p-2">
                <label for="search-email">Email</label>
                <input id="search-email" placeholder="Nhập email">
            </div>
            <div class="p-2">
                <label for="filter-status">Trạng thái</label>
                <select id="filter-status">
                    <option>Hoạt động</option>
                    <option>Tạm khóa</option>
                </select>
            </div>
            <div class="p-2">
                <label for="search-address">Địa chỉ</label>
                <input id="search-address" type="search" placeholder="Nhập địa chỉ">
            </div>
            <div class="p-2">
                <button class="btn btn-outline-dark">Tìm kiếm</button>
            </div>
            <div class="p-2">
                <button class="btn btn-outline-dark">Xóa tìm kiếm</button>
            </div>
        </form>
    </div>

    @php
        $currentpage = 10;
        $totalpage = 50;
    @endphp

    <div>

        @include('components.pagination')

        <div>
            <p>Hiển thị từ ... đến ... trong tổng số ... khách hàng</p>
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
                        <th style="width:12%" class="text-center">Trạng thái</th>
                        <th style="width:13%" class="text-center">Ngày tạo</th>
                        <th style="width:5%" class="text-center"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listCustomer as $item)
                    <tr>
                        <td data-th="ID">
                            #{{$item->customer_id}}
                        </td>
                        <td data-th="Name">
                            <input class="inp-row-{{$item->customer_id}} inp-name" value="{{$item->customer_name}}" name="name" disabled>
                        </td>
                        <td data-th="Subtotal" class="Tel">
                            <input class="inp-row-{{$item->customer_id}} inp-tel" value="{{$item->tel_num}}" name="tel" disabled>
                        </td>
                        <td class="actions" data-th="Email">
                            <input class="inp-row-{{$item->customer_id}} inp-email" value="{{$item->email}}" name="email" disabled>
                        </td>
                        <td class="actions" data-th="Address">
                            <input class="inp-row-{{$item->customer_id}} inp-address" value="{{$item->address}}" name="address" disabled>
                        </td>
                        <td class="actions" data-th="Status">
                            <input class="inp-row-{{$item->customer_id}} inp-status" value="{{$item->is_active}}" name="status" disabled>
                        </td>
                        <td class="actions" data-th="CreatedAt">
                            {{$item->created_at}}
                        </td>
                        <td class="actions" data-th="Edit">
                            <button class="btn btn-outline-danger" id="btn-edit-inp-{{$item->customer_id}}" onclick="editCustomerId({{$item->customer_id}});">Sửa</button>
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
