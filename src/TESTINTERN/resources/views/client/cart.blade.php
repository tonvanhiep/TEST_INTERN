@extends('client.layout')


@section('title')
    Cart
@endsection

@section('css')
    <style>
        address {
            margin-bottom: 0;
        }
        td, th {
            vertical-align: middle;
        }
    </style>
@endsection


@section('main')
<div class="album py-5 bg-light">
    <div class="container">
        <div class="py-5 text-center">
            <h2>Cart</h2>
        </div>

        <table class="table text-center">
            <thead>
                <tr>
                    <th style="width: 5%;" scope="col">#</th>
                    <th style="width: 20%;" scope="col">Image</th>
                    <th style="width: 25%;" scope="col">Name</th>
                    <th style="width: 12%;" scope="col">Unit Price</th>
                    <th style="width: 22%;" scope="col">Count</th>
                    <th style="width: 12%;" scope="col">Price</th>
                    <th style="width: 4%;" scope="col">Delete</th>
                </tr>
            </thead>
            <tbody class="table-group-divider" id="table-cart"></tbody>
            <tfoot>
                <tr>
                    <th colspan="5" class="text-end">Total price:</th>
                    <th id="total-price">0</th>
                </tr>
            </tfoot>
        </table>

        <div class="d-flex justify-content-between mt-5">
            <button class="btn btn-warning" style="width: 10rem" onclick="location.href='{{route('product')}}'">Continue to Buy</button>
            <button class="btn btn-success" style="width: 10rem" onclick="location.href='{{route('checkout')}}'" id="btn-checkout" hidden>Check Out</button>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{asset('assets/js/cart.js')}}"></script>
@endsection
