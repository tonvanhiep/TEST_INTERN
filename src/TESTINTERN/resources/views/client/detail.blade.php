@extends('client.layout')


@section('title')
    {{$item[0]->product_name}}
@endsection


@section('main')
<div class="album py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-6">
                @php
                    $image = '';
                    if (strlen(strstr($item[0]->product_image, 'http')) > 0) {
                        $image = $item[0]->product_image;
                    }
                    else {
                        $image = asset('storage/product'.$item[0]->product_image);
                    }
                @endphp
                <img style="width: 95%" src="{{$image}}" alt="{{$item[0]->product_name}}">
            </div>
            <div class="col-6">
                <h2>{{$item[0]->product_name}}</h2>

                <h2 class="mt-5">{{number_format($item[0]->product_price)}}  円</h2>

                <div class="btn-group mt-5" role="group" aria-label="Basic outlined example">
                    <input type="button" class="btn btn-outline-dark"  value="-">
                    <input type="text" class="btn btn-outline-dark" style="width: 4rem; border-color:black; color:black;" disabled value="1">
                    <input type="button" class="btn btn-outline-dark" onclick="" value="+">
                </div>
                <div class="d-grid gap-2 mt-5">
                    <button type="button" class="btn btn-outline-success mb-3">Add to Cart</button>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <h2>&rsaquo; Description</h2>
            <p class="mt-2">{{$item[0]->description}}</p>
        </div>

    </div>
</div>
@endsection
