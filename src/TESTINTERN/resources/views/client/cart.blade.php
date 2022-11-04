@extends('client.layout')


@section('title')
    カード
@endsection

@push('css')
    <style>
        address {
            margin-bottom: 0;
        }
        td, th {
            vertical-align: middle;
        }
    </style>
@endpush


@section('main')
<div class="album py-5 bg-light">
    <div class="container">
        <div class="py-5 text-center">
            <h2>カード</h2>
        </div>

        <div style="overflow-x: auto;">
            <table class="table text-center">
                <thead>
                    <tr>
                        <th style="width: 5%;" scope="col">#</th>
                        <th style="width: 20%;" scope="col">画像</th>
                        <th style="width: 25%;" scope="col">名前</th>
                        <th style="width: 12%;" scope="col">単価</th>
                        <th style="width: 22%;" scope="col">額</th>
                        <th style="width: 12%;" scope="col">値段</th>
                        <th style="width: 4%;" scope="col">削除</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider" id="table-cart"></tbody>
                <tfoot>
                    <tr>
                        <th colspan="5" class="text-end">合計:</th>
                        <th id="total-price">0</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="d-flex justify-content-between mt-5">
            <button class="btn btn-warning" style="width: 10rem" onclick="location.href='{{ route('product') }}'">買い続ける</button>
            <button class="btn btn-success" style="width: 10rem" onclick="location.href='{{ route('checkout') }}'" id="btn-checkout" hidden>チェックアウト</button>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script src="{{ asset('assets/js/cart.js') }}"></script>
    <script>
        displayCart();
    </script>
@endpush
