@extends('client.layout')


@section('title')
チェックアウト
@endsection


@section('main')
<div class="album py-5 bg-light">
    <div class="container">
        <div class="py-5 text-center">
            <h2>チェックアウト</h2>
            <p></p>
        </div>

        <div class="row">
            <div class="col-md-4 order-md-2 mb-4">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">カート</span>
                    <span class="badge badge-secondary badge-pill">3</span>
                </h4>
                <ul class="list-group mb-3" id="cart-checkout">

                    <li class="list-group-item d-flex justify-content-between bg-light">
                        <div class="text-success">
                            <h6 class="my-0">配送手数料</h6>
                            <small>フリーシップ >= 10,000 円</small>
                        </div>
                        <span class="text-success" id="shipping-fee">300 円</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span><strong>合計</strong></span>
                        <strong id="total-price">0 円</strong>
                    </li>
                </ul>

                {{-- <form class="card p-2">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Promo code">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-secondary">Redeem</button>
                        </div>
                    </div>
                </form> --}}
            </div>

            <div class="col-md-8 order-md-1">
                <h4 class="mb-3">情報</h4>
                <form method="POST" action="{{route('p_checkout')}}" onsubmit="saveCartToCookie();">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="firstName">ファーストネーム</label>
                            <input type="text" class="form-control" name="firstName" id="firstName" placeholder="RC" value="">
                            @if($errors->has('firstName'))
                                <div class="error" style="color: red;">{{ $errors->first('firstName') }}</div>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lastName">ラストネーム</label>
                            <input type="text" class="form-control" name="lastName" id="lastName" placeholder="VN" value="">
                            @if($errors->has('lastName'))
                                <div class="error" style="color: red;">{{ $errors->first('lastName') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email">メール</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="you@example.com">
                        @if($errors->has('email'))
                            <div class="error" style="color: red;">{{ $errors->first('email') }}</div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="tel" class="form-label">電話番号</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon3">+84</span>
                            <input type="tel" class="form-control" name="tel" id="tel" aria-describedby="basic-addon3" placeholder="337480664">
                        </div>
                        @if($errors->has('tel'))
                            <div class="error" style="color: red;">{{ $errors->first('tel') }}</div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="address">住所</label>
                        <input type="text" class="form-control" name="address" id="address" placeholder="1234 Main St">
                        @if($errors->has('address'))
                            <div class="error" style="color: red;">{{ $errors->first('address') }}</div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="massage">メッセージ</label>
                        <textarea type="text" class="form-control" name="massage" id="message" placeholder="..." rows="2"></textarea>
                        @if($errors->has('massage'))
                            <div class="error" style="color: red;">{{ $errors->first('massage') }}</div>
                        @endif
                    </div>

                    <hr class="mb-4">

                    <h4 class="mb-3">支払方法</h4>

                    <div class="d-block my-3">
                        <div class="custom-control custom-radio">
                            <input id="cod" name="paymentMethod" type="radio" class="custom-control-input" checked value="1">
                            <label class="custom-control-label" for="credit">COD</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input id="visa" name="paymentMethod" type="radio" class="custom-control-input" value="2">
                            <label class="custom-control-label" for="debit">VISA/Mastercard</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input id="momo" name="paymentMethod" type="radio" class="custom-control-input" value="3">
                            <label class="custom-control-label" for="momo">Momo</label>
                        </div>
                        @if($errors->has('paymentMethod'))
                            <div class="error" style="color: red;">{{ $errors->first('paymentMethod') }}</div>
                        @endif
                    </div>
                    <hr class="mb-4">
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" type="submit">送信</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script src="{{asset('assets/js/checkout.js')}}"></script>
    <script>
        getCartLocalStorage();
        displayCartCheckout();
    </script>
@endsection
