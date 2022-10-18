@extends('client.layout')


@section('title')
接触
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

<div class="album py-5 bg-light">
    <div class="container">
        <div class="py-5 text-center">
            <h2>接触</h2>
        </div>

        <div class="untree_co-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mb-5 mb-lg-0">
                        <form method="POST" action="{{route('p_contact')}}">
                            @csrf
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <div class="form-group">
                                        <label class="form-label" for="fname">ファーストネーム</label>
                                        <input type="text" class="form-control" name="fname" id="fname">
                                        @if($errors->has('fname'))
                                            <div class="error" style="color: red;">{{ $errors->first('fname') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="form-group">
                                        <label class="form-label" for="lname">ラストネーム</label>
                                        <input type="text" class="form-control" name="lname" id="lname">
                                        @if($errors->has('lname'))
                                            <div class="error" style="color: red;">{{ $errors->first('lname') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="tel">電話番号</label>
                                <input type="tel" class="form-control" name="phone" id="tel">
                                @if($errors->has('phone'))
                                    <div class="error" style="color: red;">{{ $errors->first('phone') }}</div>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="email">メール</label>
                                <input type="email" class="form-control" name="email" id="email">
                                @if($errors->has('email'))
                                    <div class="error" style="color: red;">{{ $errors->first('email') }}</div>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="message">メッセージ</label>
                                <textarea class="form-control" name="message" id="message" cols="30" rows="5"></textarea>
                                @if($errors->has('message'))
                                    <div class="error" style="color: red;">{{ $errors->first('message') }}</div>
                                @endif
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary mb-3">送信</button>
                            </div>
                        </form>
                    </div>

                    <div class="col-lg-6 ml-auto">
                        <div class="d-flex align-items-center mb-4 align-self-center">
                            <span style="font-size: 2rem; margin-right:1rem;" class="material-symbols-outlined">home_work</span>
                            <address class="text">
                                155 Market St #101, Paterson, NJ 07505, United States
                            </address>
                        </div>
                        <div class="d-flex align-items-center mb-4 align-self-center">
                            <span style="font-size: 2rem; margin-right:1rem;" class="material-symbols-outlined">call</span>
                            <address class="text">
                                +84 36 303 84 85
                            </address>
                        </div>
                        <div class="d-flex align-items-center mb-4 align-self-center">
                            <span style="font-size: 2rem; margin-right:1rem;" class="material-symbols-outlined">mail</span>
                            <address class="text">
                                ton.hiep@rivercrane.com.vn
                            </address>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
