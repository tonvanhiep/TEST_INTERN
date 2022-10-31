@extends('client.layout')


@section('title')
    Thank you very much
@endsection


@section('main')
<div class="album py-5 bg-light" style="min-height: 80vh">
    <div class="container">
        <div class="py-5 text-center">
            <h2>ありがとうございます。</h2>
            <p>注文 #{{ $id_dh }} が正常に行われました。 ご注文を確認するために、できるだけ早くご連絡いたします。 信頼してご注文いただきありがとうございます。</p>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script>
        cart = new Array();
        localStorage.setItem('cart', JSON.stringify(cart))
        displayTotalCart();
    </script>
@endpush
