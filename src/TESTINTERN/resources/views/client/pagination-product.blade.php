<style>
    .name-product:hover {
        font-weight: bold;
    }
</style>

@foreach ($list as $item)
    <div class="col-md-4">
        <div class="card mb-4 box-shadow">
            @php
                $image = '';
                if (strlen(strstr($item->product_image, 'http')) > 0) {
                    $image = $item->product_image;
                }
                else {
                    $image = asset('storage/product'.$item->product_image);
                }
            @endphp
            <img class="card-img-top" src="{{$image}}" alt="Card image cap" style="cursor: pointer;" onclick="location.href='{{route('detail', ['id' => $item->product_id])}}'">
            <div class="card-body">
                <p class="name-product" class="card-text" style="cursor: pointer;" onclick="location.href='{{route('detail', ['id' => $item->product_id])}}'">{{$item->product_name}}</p>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group d-flex align-items-center">
                        <h4 class="product-row-{{$item->product_id}}">¥ {{$item->product_price}}</h4>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-secondary" onclick="addToCart({{$item->product_id}}, '{{$item->product_image}}', '{{$item->product_name}}', 1, {{$item->product_price}});">カートに入れる</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
