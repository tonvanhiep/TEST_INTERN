@extends('client.layout-login')



@section('title')
    ログインアカウント
@endsection



@section('content')
    <h2 class="text-uppercase text-center mb-4 mt-4">ログイン</h2>

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
            <label class="form-label" for="inp-email">メール *</label>
            <input type="email" id="inp-email" name="email" class="form-control"/>
        </div>

        <div class="form-outline mb-3">
            <label class="form-label" for="inp-pass">パスワード  *</label>
            <input type="password" id="inp-pass" name="pass" class="form-control"/>
        </div>

        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-info btn-block">ログイン</button>
        </div>

        <p class="text-center text-muted mt-4 mb-0">
            まだアカウントを持っていませんか？<a href="{{route('account.register')}}" class="fw-bold text-body"><u>レジスター</u></a>
        </p>
    </form>
@endsection
