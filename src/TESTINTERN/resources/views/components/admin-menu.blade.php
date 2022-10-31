<div class="col-md-2 div-menu" id="div-menu" style="padding-right: 10px;">
    <div>
        <ul class="left-sidebar nav flex-column nav-pills nav-fill">
            <li class="nav-item">
                <a class="nav-link {{ $nameRoute == 'admin.admin.management' ? 'active' : ''}}" href="{{ route('admin.admin.management') }}">管理者アカウントの管理</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $nameRoute == 'admin.customerManagement' ? 'active' : ''}}" href="{{ route('admin.customerManagement') }}">顧客アカウントの管理</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $nameRoute == 'admin.product.management' ? 'active' : ''}}" href="{{ route('admin.product.management') }}">製品の管理</a>
            </li>
        </ul>
    </div>

    <div>
        <ul class="left-sidebar nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.logout') }}">ログアウト</a>
            </li>
        </ul>
    </div>
</div>

<style>
    .nav-fill .nav-item, .nav-fill>.nav-link {
        text-align: left;
    }
</style>
