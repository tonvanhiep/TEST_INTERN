@extends('client.layout')


@section('title')
    {{$item[0]->product_name}}
@endsection


@section('main')
<div class="alert alert-success" style="position: fixed; bottom: 0px; right:0px; z-index:1; width:40vw; min-width:400px;" id="div-alert" hidden role="alert">
    商品がカートに追加されました。
</div>

<div class="album py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                @php
                    $image = '';
                    if (strlen(strstr($item[0]->product_image, 'http')) > 0) {
                        $image = $item[0]->product_image;
                    }
                    else {
                        $image = asset('storage/'.$item[0]->product_image);
                    }
                @endphp
                <img style="width: 95%" src="{{$image}}" alt="{{$item[0]->product_name}}">
            </div>
            <div class="col-lg-6">
                <h2>{{$item[0]->product_name}}</h2>

                <h2 class="mt-5">値段 :  {{number_format($item[0]->product_price)}}  円</h2>


                @php
                    if ($item[0]->is_sales == 1) {
                        echo "<div class=\"row\">
                            <div class=\" mt-5 col-lg-4 text-center\" role=\"group\" aria-label=\"Basic outlined example\">
                                <div class=\"btn-group\" style=\"max-width:250px;\">
                                    <input type=\"button\" class=\"btn btn-outline-dark\" onclick=\"deCrease(0, 0)\" value=\"-\">
                                    <input type=\"text\" class=\"btn btn-outline-dark\" id=\"inp-count-0\" style=\"width: 4rem; border-color:black; color:black;\" disabled value=\"1\">
                                    <input type=\"button\" class=\"btn btn-outline-dark\" onclick=\"inCrease(0, 0)\" value=\"+\">
                                </div>
                            </div>
                            <div class=\"d-grid gap-2 mt-5 col-lg-8\">
                                <button type=\"button\" class=\"btn btn-outline-success\" onclick=\"addToCart(" . $item[0]->product_id . ", '$image', '" . $item[0]->product_name . "', null, " . $item[0]->product_price . ");\">カートに入れる</button>
                            </div>
                        </div>";
                    }
                    else {
                        echo "<div class=\"alert alert-danger mt-5\" role=\"alert\">
                                The product has stopped selling.
                            </div>";
                    }
                @endphp


            </div>
        </div>

        <div class="mt-5 mb-5">
            <div class="text-center">
                <h2>説明</h2>
            </div>
            <p class="mt-2">{{$item[0]->description}}</p>
        </div>

    </div>
</div>
@endsection

@section('js')
    <script src="{{asset('assets/js/cart.js')}}"></script>
@endsection
