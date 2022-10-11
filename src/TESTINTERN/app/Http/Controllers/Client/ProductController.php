<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ProductModel;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $product = new ProductModel();
        $condition = [
            'is_sales' => 1,
            'name' => null,
            'min_price' => null,
            'max_price' => null
        ];
        $list = $product->getProduct($condition);
        return view('client.product', compact('list'));
    }

    public function loadMore(Request $request)
    {
        $product = new ProductModel();
        $condition = [
            'is_sales' => 1,
            'name' => null,
            'min_price' => null,
            'max_price' => null
        ];
        $page = ($request->has('page')?$request->page:1);
        $list = $product->getProduct($condition, $page);
        $returnHTML = view('client.pagination-product', compact('list'))->render();
        return response()->json($returnHTML);
    }

    public function detailProduct($id)
    {
        return $id;
    }
}
