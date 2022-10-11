<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ProductModel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $condition = [
            'is_sales' => 1,
            'name' => null,
            'min_price' => null,
            'max_price' => null
        ];
        $product = new ProductModel();
        $list = $product->getViewProduct();
        return view('client.home', compact('list'));
    }

    public function cart()
    {
        return view('client.cart');
    }

    public function checkOut()
    {
        return view('client.checkout');
    }

    public function thankYou()
    {
        return 'Thank you!!!';
    }

    public function contact()
    {
        return view('client.contact');
    }
}
