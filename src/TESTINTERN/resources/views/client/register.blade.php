@extends('client.layout-login')



@section('title')
    Đăng ký tài khoản
@endsection



@section('content')
    <h2 class="text-uppercase text-center mb-4 mt-4">Đăng ký tài khoản</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{route('account.register')}}">
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
            Bạn đã có tài khoản? <a href="{{route('account.login')}}" class="fw-bold text-body"><u>Đăng nhập</u></a>
        </p>
    </form>
@endsection
