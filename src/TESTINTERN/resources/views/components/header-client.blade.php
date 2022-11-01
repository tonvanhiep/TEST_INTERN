<header class="p-3 bg-dark text-white">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
            </a>

            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="{{ route('home') }}" class="nav-link px-2 text-white">ホームページ</a></li>
                <li><a href="{{ route('product') }}" class="nav-link px-2 text-white">製品</a></li>
                <li><a href="{{ route('contact') }}" class="nav-link px-2 text-white">接触</a></li>
                <li><a href="https://rivercrane.vn/" class="nav-link px-2 text-white">当社について</a></li>
            </ul>

            <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" method="GET" action="{{ route('search') }}">
                <input type="search" class="form-control form-control-dark" name="search" placeholder="探す。。。" aria-label="Search">
            </form>

            <div class="text-end">
                <button type="button" class="btn btn-outline-success me-4" onclick="location.href='{{ route('cart') }}'">カート (<span id="total-items">0</span>)</button>

                @if (session()->has('customer'))
                    <div class="dropdown">
                        <button onclick="dropDown()" class="nut_dropdown btn btn-secondary dropdown-toggle" style="width:120px; text-overflow: ellipsis; overflow:hidden;">{{ session()->get('customer')['name'] }}</button>
                        <div class="noidung_dropdown">
                            <a href=" {{ route('account.info') }}">アカウント</a>
                            <a href=" {{ route('account.logout') }}">ログアウト</a>
                        </div>
                    </div>
                @else
                    <button type="button" class="btn btn-outline-light me-2" onclick="location.href='{{ route('account.login') }}'">ログイン</button>
                    <button type="button" class="btn btn-outline-warning" onclick="location.href='{{ route('account.register') }}'">レジスター</button>
                @endif

            </div>
        </div>
    </div>
</header>
