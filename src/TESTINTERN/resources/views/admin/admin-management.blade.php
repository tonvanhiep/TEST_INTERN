@extends('admin.layout-management')





@section('title')
    管理者アカウントの管理
@endsection





@section('popup')
    <div class="container">
        <div class="modal" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tạo tài khoản admin</h5>
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
                                <label class="form-label" for="inp-pass">Mật khẩu *</label>
                                <input type="password" id="inp-pass" class="form-control"/>
                            </div>

                            <div class="form-outline mb-3">
                                <label class="form-label" for="inp-repass">Nhập lại mật khẩu *</label>
                                <input type="password" id="inp-repass" class="form-control"/>
                            </div>

                            <div class="form-outline mb-3">
                                <label class="form-label" for="inp-group">Group *</label>
                                <select class="form-select" name="group" id="inp-group">
                                    <option value="1" selected>Admin</option>
                                    <option value="2" >Editer</option>
                                    <option value="3" >Reviewer</option>
                                </select>
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

    <div class="container">
        <div class="modal" id="myModal2">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Import csv</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div id="div-alert"></div>
                        <form id="form-uploadfile" enctype="multipart/form-data" method="POST" action="{{route('admin.admin.p_importCsv')}}">
                            <p hidden id="token-uploadfile">{{ csrf_token() }}</p>
                            @csrf
                            <div class="input-group">
                                <input name="filecsv" type="file" class="form-control" id="file-csv" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                                <button class="btn btn-outline-secondary" type="submit" id="inputGroupFileAddon04">Tải lên</button>
                                {{-- onclick="importCsv();" --}}
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
    <p hidden id="url-pagination">{{route('admin.admin.p_pagination')}}</p>
    <p hidden id="token-pagination">{{csrf_token()}}</p>

    <h3 class="title-category mb-40">
        <button class="btn btn-outline-dark" id="btn-menu-extend" style="display: inline; margin-right:15px">&larr;</button>管理者アカウントの管理
    </h3>


    <div class="d-flex flex-row-reverse">
        <div class="p-2">
            <button class="btn btn-info" type="button" data-bs-toggle="modal" data-bs-target="#myModal">Tạo tài khoản</button>
        </div>
        <div class="p-2">
            <button class="btn btn-info" onclick="location.href='{{route('admin.admin.exportCsv')}}'">Xuất CSV</button>
        </div>
        <div class="p-2">
            <button class="btn btn-info" type="button" data-bs-toggle="modal" data-bs-target="#myModal2">Thêm CSV</button>
        </div>
    </div>

    <div class="options">
        <form class="d-flex flex-row" id="search-form" action="{{route('admin.admin.p_search')}}">
            <p hidden id="token-search">{{ csrf_token() }}</p>
            <div class="p-2">
                <label class="form-label" for="search-name">Họ và tên</label>
                <input class="form-control" id="search-name" type="search" placeholder="Nhập họ tên">
            </div>
            <div class="p-2">
                <label class="form-label" for="search-email">Email</label>
                <input class="form-control" id="search-email" type="search" placeholder="Nhập email">
            </div>
            <div class="p-2">
                <label class="form-label" for="filter-group">Group</label>
                <select class="form-select" id="filter-group">
                    <option value="-1" selected>Tất cả</option>
                    <option value="1">Admin</option>
                    <option value="2">Editer</option>
                    <option value="3">Reviewer</option>
                </select>
            </div>
            <div class="p-2">
                <label class="form-label" for="filter-status">Trạng thái</label>
                <select class="form-select" id="filter-status">
                    <option value="-1" selected>Tất cả</option>
                    <option value="1">Hoạt động</option>
                    <option value="0">Tạm khóa</option>
                </select>
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
        @include('admin.pagination-admin-management')
    </div>
</div>

@endsection





@section('js')
    <script src="{{asset('assets/js/admin-management.js')}}"></script>
@endsection

