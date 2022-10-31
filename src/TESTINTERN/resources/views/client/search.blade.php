@extends('client.layout')


@section('title')
    製品を検索: {{ $nameProduct }}
@endsection

@push('css')
    <style>
        address {
            margin-bottom: 0;
        }
    </style>
@endpush


@section('main')
<div class="alert alert-success" style="position: fixed; bottom: 0px; right:0px; z-index:1; width:40vw; min-width:400px;" id="div-alert" hidden role="alert">
    商品がカートに追加されました。
</div>

<div class="album py-5 bg-light">
    <div class="container">
        <div class="py-5 text-center">
            <h2>結果 : "{{ $nameProduct }}"</h2>
        </div>

        <div class="row" id="display-product">
            <p id="url-load-more" hidden>{{ route('loadMoreProduct') }}</p>
            <p id="token-load-more" hidden>{{ csrf_token() }}</p>

            @include('client.pagination-product')

        </div>

        <div class="d-flex justify-content-center">
            <button id="btn-load-more" style="width: 120px" class="btn btn-block btn-outline-secondary" onclick="loadMoreProduct();" {{ ($loadMore == 1) ? '' : 'hidden' }}>もっと。。。</button>
        </div>

    </div>
</div>
@endsection
