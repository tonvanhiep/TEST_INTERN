@extends('admin.layout-managerment')



@section('title')
    Quản lý khách hàng
@endsection




@section('popup')
    {{-- <div class="bg-image position-fixed" style="margin: auto; display:none;" id="pop-up">
        <div class="mask d-flex align-items-center h-100 gradient-custom-3">
            <div class="container h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                        <div class="card" style="border-radius: 15px;">
                            <div class="card-body p-5">
                                <button class="btn btn-outline-dark" onclick="closePopUp();"> Đóng </button>

                                <h2 class="text-uppercase text-center mb-4 mt-4">Đăng ký tài khoản</h2>

                                <form method="POST" action="http://localhost:8000/taikhoan/dangky">
                                    <input type="hidden" name="_token" value="EDH4xZ7fUH3UHtvhkzROVwReTGiIxSo79KlYh9Wc">        <div class="form-outline mb-3">
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

                                    <div class="form-check d-flex justify-content mb-4">
                                        <input class="form-check-input me-2" type="checkbox" name="agree-rule" value="agree" id="agree-rule"/>
                                        <label class="form-check-label" for="agree-rule">
                                            Tôi đã đọc và đồng ý với các <a href="#!" class="text-body"><u>điều khoản</u></a>
                                        </label>
                                    </div>

                                    <div class="d-flex justify-content-center">
                                        <button type="submit" class="btn btn-info btn-block">Đăng ký tài khoản</button>
                                    </div>

                                    <p class="text-center text-muted mt-4 mb-0">
                                        Bạn đã có tài khoản? <a href="http://localhost:8000/taikhoan/dangnhap" class="fw-bold text-body"><u>Đăng nhập</u></a>
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
    Launch static backdrop modal
  </button>

  <!-- Modal -->
  <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Understood</button>
        </div>
      </div>
    </div>
  </div>
@endsection



@section('content')
<div class="right-sidebar">

    <h3 class="title-category mb-40">
        <button class="btn btn-outline-dark" id="btn-menu-extend" style="display: inline">&larr;</button>QUẢN LÝ KHÁCH HÀNG
    </h3>


    <div class="d-flex flex-row-reverse">
        <div class="p-2">
            <button class="btn btn-info" onclick="openPopUp();">Tạo tài khoản</button>
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
    <script>
        var myModal = document.getElementById('myModal')
        var myInput = document.getElementById('myInput')

        myModal.addEventListener('shown.bs.modal', function () {
        myInput.focus()
        })
    </script>
    <script src="{{asset('assets/js/customer-managerment.js')}}"></script>
@endsection
