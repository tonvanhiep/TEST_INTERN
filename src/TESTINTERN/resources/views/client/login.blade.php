@extends('client.layout-login')



@section('title')
    Đăng nhập tài khoản
@endsection



@section('content')
    <h2 class="text-uppercase text-center mb-4 mt-4">Đăng nhập</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{route('account.p_login')}}">
        @csrf
        <div class="form-outline mb-3">
            <label class="form-label" for="inp-email">Email *</label>
            <input type="email" id="inp-email" name="email" class="form-control"/>
        </div>

        <div class="form-outline mb-3">
            <label class="form-label" for="inp-pass">Mật khẩu *</label>
            <input type="password" id="inp-pass" name="pass" class="form-control"/>
        </div>

        <div class="form-check d-flex justify-content mb-4">
            <input class="form-check-input me-2" type="checkbox" name="remember-me" value="remember" id="remember-me" />
            <label class="form-check-label" for="remember-me">
                Lưu đăng nhập
            </label>
        </div>

        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-info btn-block">Đăng nhập</button>
        </div>

        <p class="text-center text-muted mt-4 mb-0">
            Bạn đã chưa tài khoản? <a href="{{route('account.register')}}" class="fw-bold text-body"><u>Đăng ký</u></a>
        </p>
    </form>
@endsection
