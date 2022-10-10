<div class="col-md-2 div-menu" id="div-menu">
    <div>
        <ul class="left-sidebar nav flex-column nav-pills nav-fill">
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.admin.management')}}">Quản lý quản trị viên</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="{{route('admin.customerManagement')}}">Quản lý khách hàng</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.product.management')}}">Quản lý sản phẩm</a>
            </li>
        </ul>
    </div>

    <div>
        <ul class="left-sidebar nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.logout')}}">Đăng xuất</a>
            </li>
        </ul>
    </div>
</div>

<style>
    .nav-fill .nav-item, .nav-fill>.nav-link {
        text-align: left;
    }
</style>
