@extends('client.layout')


@section('title')
    Thank you very much
@endsection


@section('main')
<div class="album py-5 bg-light" style="min-height: 80vh">
    <div class="container">
        <div class="py-5 text-center">
            <h2>Thank you</h2>
            <p>Your order #{{$id_dh}} has been placed successfully. We will contact you to confirm your order as soon as possible. Thank you for your trust and order.</p>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script>
        cart = new Array();
        localStorage.setItem('cart', JSON.stringify(cart))
        displayTotalCart();
    </script>
@endsection
