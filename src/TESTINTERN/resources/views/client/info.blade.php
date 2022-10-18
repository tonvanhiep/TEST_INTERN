@extends('client.layout')


@section('title')
    {{ $info[0]->customer_name }}
@endsection

@section('css')
    <style>
        address {
            margin-bottom: 0;
        }
    </style>
@endsection


@section('main')
@if (session('status'))
    <div class="alert alert-success text-center" role="alert">
        {{ session('status') }}
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger text-center" role="alert">
        {{ session('error') }}
    </div>
@endif

<div class="album py-5 bg-light">
    <div class="container">
        <div class="py-5 text-center">
            <h2>情報</h2>
        </div>

        <div class="untree_co-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mb-5 mb-lg-0">
                        <form method="POST" action="{{route('account.p_saveInfo')}}" id="form-edit-info">
                            @csrf
                            <div class="form-group mb-3">
                                <label class="form-label" for="tel">名前</label>
                                <input type="text" class="form-control info-customer" name="name" id="name" value="{{ old('name') ? old('name') : $info[0]->customer_name }}" disabled>
                                @if($errors->has('name'))
                                    <div class="error" style="color: red;">{{ $errors->first('name') }}</div>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="email">メール</label>
                                <input type="email" class="form-control info-customer" name="email" id="email" value="{{ old('email') ? old('email') : $info[0]->email }}" disabled>
                                @if($errors->has('email'))
                                    <div class="error" style="color: red;">{{ $errors->first('email') }}</div>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="tel">電話番号</label>
                                <input type="tel" class="form-control info-customer" name="phone" id="tel" value="{{ old('phone') ? old('phone') : $info[0]->tel_num }}" disabled>
                                @if($errors->has('phone'))
                                    <div class="error" style="color: red;">{{ $errors->first('phone') }}</div>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="address">住所</label>
                                <input type="text" class="form-control info-customer" name="address" id="address" value="{{ old('address') ? old('address') : $info[0]->address }}" disabled>
                                @if($errors->has('address'))
                                    <div class="error" style="color: red;">{{ $errors->first('address') }}</div>
                                @endif
                            </div>

                            <div class="d-grid gap-2">
                                <button type="reset" class="btn btn-outline-secondary mb-3" id="btn-cancel" onclick="location.href='{{ route('account.info') }}'" hidden>キャンセル</button>
                                <button type="button" class="btn btn-outline-secondary mb-3" onclick="editInfo(this)" id="btn-edit-info">編集</button>
                            </div>
                        </form>
                    </div>

                    <div class="col-lg-1 ml-auto"></div>

                    <div class="col-lg-4 ml-auto">
                        <form method="POST" action="{{route('account.p_savePass')}}">
                            @csrf
                            <div class="form-group mb-3">
                                <label class="form-label" for="cpass">現在のパスワード</label>
                                <input type="password" class="form-control" name="cpass" id="cpass">
                                @if($errors->has('cpass'))
                                    <div class="error" style="color: red;">{{ $errors->first('cpass') }}</div>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="npass">新しいパスワード</label>
                                <input type="password" class="form-control" name="npass" id="npass">
                                @if($errors->has('npass'))
                                    <div class="error" style="color: red;">{{ $errors->first('npass') }}</div>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="repass">再ー新しいパスワード</label>
                                <input type="password" class="form-control" name="repass" id="repass">
                                @if($errors->has('repass'))
                                    <div class="error" style="color: red;">{{ $errors->first('repass') }}</div>
                                @endif
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary mb-3">セーブ</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



@section('js')
    <script src="{{asset('assets/js/info-customer.js')}}"></script>
    @if($errors->has('name') || $errors->has('email') || $errors->has('phone') || $errors->has('address'))
        <script>
            let x = document.getElementById('btn-edit-info');
            editInfo(x);
        </script>
    @endif
@endsection
