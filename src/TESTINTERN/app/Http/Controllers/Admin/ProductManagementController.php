<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductModel;
use Illuminate\Http\Request;

class ProductManagementController extends Controller
{
    private $product;
    public $productOnPage = 10;

    public function __construct()
    {
        $this->product = new ProductModel();
    }

    public function index(Request $request)
    {
        $nameRoute = $request->route()->getName();
        $page = (!$request->has('page') ? 1 : $request->page);
        $condition = array(
            'name' => (!$request->has('name') ? null : $request->name),
            'min_price' => (!$request->has('min_price') ? null : $request->min_price),
            'max_price' => (!$request->has('max_price') ? null : $request->max_price),
            'is_sales' => (!$request->has('is_sales') ? -1 : $request->is_sales)
        );
        $totalProduct = $this->product->getCountProduct($condition);
        $totalPage = intval($totalProduct / $this->productOnPage + (($totalProduct % $this->productOnPage == 0) ? 0 : 1));
        $currentPage = ($page <= $totalPage) ? $page : $totalPage;

        $record = [
            'min' => ($currentPage - 1) * $this->productOnPage + 1,
            'max' => ($currentPage * $this->productOnPage <= $totalProduct) ? ($currentPage * $this->productOnPage) : $totalProduct,
            'total' => $totalProduct
        ];
        $listProduct = $this->product->getProduct($condition, $currentPage, $this->productOnPage);
        return view('admin.product-management', compact('listProduct', 'record', 'totalPage', 'currentPage', 'nameRoute'));
    }

    public function paginationProduct(Request $request)
    {
        $condition = array(
            'is_sales' => (!$request->has('isSales') ? null : $request->isSales),
            'name' => (!$request->has('name') ? null : $request->name),
            'min_price' => (!$request->has('minPrice') ? null : $request->minPrice),
            'max_price' => (!$request->has('maxPrice') ? null : $request->maxPrice)
        );

        $page = ($request->page >= 1) ? $request->page : 1;
        $totalProduct = $this->product->getCountProduct($condition);
        $totalPage = intval($totalProduct / $this->productOnPage + (($totalProduct % $this->productOnPage == 0) ? 0 : 1));
        $currentPage = ($page <= $totalPage) ? $page : $totalPage;

        $record = [
            'min' => ($currentPage - 1) * $this->productOnPage + 1,
            'max' => ($currentPage * $this->productOnPage <= $totalProduct) ? ($currentPage * $this->productOnPage) : $totalProduct,
            'total' => $totalProduct
        ];
        $listProduct = $this->product->getProduct($condition, $currentPage, $this->productOnPage);

        $returnHTML = view('admin.pagination-product-management', compact('listProduct', 'record', 'totalPage', 'currentPage'))->render();
        return response()->json($returnHTML);
    }

    public function editProduct(Request $request)
    {
        $request->validate([
            'id' => 'required|min:0',
            'name' => 'required',
            'price' => 'required|numeric|min:0',
            'is_sales' => 'required|numeric|min:0|max:1'
            ]
        );

        $id = $request->id;
        $data = [
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'is_sales' => $request->is_sales
            ];
        $result = $this->product->updateProduct($id, $data);

        if($result['success'] == false) {
            return response()->json([
                'message' => $result['message'],
                'errors' => [
                    'email' => [$result['message']]
                ]
            ], 422);
        }
        return 'Success';
    }

    public function deleteProduct(Request $request)
    {
        $request->validate([
            'id' => 'required|min:0'
            ]
        );
        $this->product->deleteProduct($request->id);

        return 'Success';
    }

    public function searchProduct(Request $request)
    {
        $condition = array(
            'is_sales' => (!$request->has('isSales') ? -1 : $request->isSales),
            'max_price' => (!$request->has('maxPrice') ? null : $request->maxPrice),
            'min_price' => (!$request->has('minPrice') ? null : $request->minPrice),
            'name' => (!$request->has('name') ? null : $request->name)
        );
        $page = ($request->page >= 1) ? $request->page : 1;
        $totalProduct = $this->product->getCountProduct($condition);
        $totalPage = intval($totalProduct / $this->productOnPage + (($totalProduct % $this->productOnPage == 0) ? 0 : 1));
        $currentPage = ($page <= $totalPage) ? $page : $totalPage;

        $record = [
            'min' => ($currentPage - 1) * $this->productOnPage + 1,
            'max' => ($currentPage * $this->productOnPage <= $totalProduct) ? ($currentPage * $this->productOnPage) : $totalProduct,
            'total' => $totalProduct
        ];
        $listProduct = $this->product->getProduct($condition, $currentPage, $this->productOnPage);

        $returnHTML = view('admin.pagination-product-management', compact('listProduct', 'record', 'totalPage', 'currentPage'))->render();
        return response()->json($returnHTML);
        return 'Success';
    }

    public function actionAddProduct(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric|min:0',
            'is_sales' => 'required|numeric|min:0|max:1',
            'file' => 'required',
            'description' => 'required'
            ]
        );
        $data = [
            'name' => $request->name,
            'price' => $request->price,
            'is_sales' => $request->is_sales,
            'image' => $this->storeImage($request),
            'description' => $request->description
        ];

        $this->product->addProduct($data);
        return 'Success';
    }

    protected function storeImage(Request $request) {
        $fileName = preg_replace("/[ ]/", "_", $request->name) . preg_replace("/[ ]/", "_", date('Y-m-d H:i:s')) . '.' . $request->file('file')->extension();
        $path = $request->file('file')->storeAs('public/productImage', $fileName);
        return substr($path, strlen('public/'));
    }

    public function product(Request $request)
    {
        $request->validate([
            'id' => 'required'
            ]
        );

        $result = $this->product->product($request->id);

        return response()->json([
            'id' => $result[0]->product_id,
            'name' => $result[0]->product_name,
            'image' => $result[0]->product_image,
            'price' => $result[0]->product_price,
            'description' => $result[0]->description,
            'is_sales' => $result[0]->is_sales
        ]);
    }
}
