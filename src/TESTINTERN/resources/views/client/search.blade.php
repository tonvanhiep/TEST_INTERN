@extends('client.layout')


@section('title')
    Search product: {{$nameProduct}}
@endsection

@section('css')
    <style>
        address {
            margin-bottom: 0;
        }
    </style>
@endsection


@section('main')
<div class="album py-5 bg-light">
    <div class="container">
        <div class="py-5 text-center">
            <h2>Result : "{{$nameProduct}}"</h2>
        </div>

        <div class="row" id="display-product">
            <p id="url-load-more" hidden>{{route('loadMoreProduct')}}</p>
            <p id="token-load-more" hidden>{{ csrf_token() }}</p>

            @include('client.pagination-product')

        </div>

        <div class="d-flex justify-content-center">
            <button id="btn-load-more" style="width: 100px" class="btn btn-block btn-outline-secondary" onclick="loadMoreProduct();" {{ ($loadMore == 1) ? '' : 'hidden'}}>More...</button>
        </div>

    </div>
</div>
@endsection
