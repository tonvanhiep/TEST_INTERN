@extends('client.layout')


@section('title')
    All Product
@endsection


@section('main')
<div class="alert alert-success" style="position: fixed; bottom: 0px; right:0px; z-index:1; width:40vw; min-width:400px;" id="div-alert" hidden role="alert">
    Product added to cart successfully!!
</div>

<div class="album py-5 bg-light">
    <div class="container">
        <div class="py-5 text-center">
            <h2>All Products</h2>
        </div>
        <div class="row" id="display-product">
            <p id="url-load-more" hidden>{{route('loadMoreProduct')}}</p>
            <p id="token-load-more" hidden>{{ csrf_token() }}</p>

            @include('client.pagination-product')

        </div>

        <div class="d-flex justify-content-center">
            <button style="width: 100px" class="btn btn-block btn-outline-secondary" onclick="loadMoreProduct();">More...</button>
        </div>

    </div>
</div>
@endsection
