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
        $total = $product->getCountProduct($condition);
        $loadMore = ($total > 20) ? 1 : 0;
        return view('client.product', compact('list', 'loadMore'));
    }

    public function loadMore(Request $request)
    {
        $product = new ProductModel();
        $condition = [
            'is_sales' => 1,
            'name' => ($request->has('search')) ? $request->get('search') : null,
            'min_price' => null,
            'max_price' => null
        ];
        $page = ($request->has('page')?$request->page:1);
        $list = $product->getProduct($condition, $page);
        $total = $product->getCountProduct($condition);
        $loadMore = ($total > $page * 20) ? 1 : 0;
        $returnHTML = view('client.pagination-product', compact('list', 'loadMore'))->render();
        return response()->json([
            'data' => $returnHTML,
            'loadMore' => $loadMore
        ], 200);
    }

    public function searchProduct(Request $request)
    {
        $nameProduct = $request->get('search');
        $product = new ProductModel();
        $condition = [
            'is_sales' => 1,
            'name' => ($request->has('search')) ? $request->get('search') : null,
            'min_price' => null,
            'max_price' => null
        ];
        $list = $product->getProduct($condition);
        $total = $product->getCountProduct($condition);
        $loadMore = ($total > 20) ? 1 : 0;
        return view('client.search', compact('list', 'loadMore', 'nameProduct'));
    }

    public function detailProduct($id = null)
    {
        if ($id === null) redirect()->route('product');
        $product = new ProductModel();
        $item = $product->product($id);
        return view('client.detail', compact('item'));
    }
}
