<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductModel extends Model
{
    use HasFactory;

    protected $table = 'MST_PRODUCT';

    public function getCountProduct($condition = null)
    {
        if($condition == null) return 0;
        $count = DB::table($this->table)
            ->where('product_name', 'like', '%'.preg_replace("/[^a-zA-Z0-9]/", "%", (($condition['name'] == null) ? '' : $condition['name'])).'%')
            ->where('product_price', '>=', (($condition['min_price'] == null) ? 0 : $condition['min_price']))
            ->where('product_price', '<=', (($condition['max_price'] == null) ? 1000000000000 : $condition['max_price']))
            ->where(function($query) use ($condition) {
                $query->where('is_sales', '=' ,(($condition['is_sales'] == -1) ? 0 : $condition['is_sales']))
                      ->orWhere('is_sales', '=', (($condition['is_sales'] == -1) ? 1 : $condition['is_sales']));
                })
            ->count();
        return $count;
    }

    public function getProduct($condition = null, $page = 1, $recordOnPage = 20)
    {
        if($condition == null) return 0;
        $result = DB::table($this->table)
            ->select('product_id', 'product_name', 'product_image', 'product_price', 'description', 'is_sales', 'created_at')
            ->where('product_name', 'like', '%'.preg_replace("/[^a-zA-Z0-9]/", "%", (($condition['name'] == null) ? '' : $condition['name'])).'%')
            ->where('product_price', '>=', (($condition['min_price'] == null) ? 0 : $condition['min_price']))
            ->where('product_price', '<=', (($condition['max_price'] == null) ? 1000000000000 : $condition['max_price']))
            ->where(function($query) use ($condition) {
                $query->where('is_sales', '=' ,(($condition['is_sales'] == -1) ? 0 : $condition['is_sales']))
                      ->orWhere('is_sales', '=', (($condition['is_sales'] == -1) ? 1 : $condition['is_sales']));
                })
            ->paginate($perPage = $recordOnPage, $columns = ['*'], $pageName = 'page', $page = $page);
        return $result;
    }

    public function updateProduct($id = -1, $data = null)
    {
        if($id == -1 || $data == null) return array('success' => false, 'message' => 'ID sản phẩm không hợp lệ.');

        DB::table($this->table)
              ->where('product_id', $id)
              ->update(
                [
                    'product_name' => $data['name'],
                    'description' => $data['description'],
                    'product_price' => $data['price'],
                    'is_sales' => $data['is_sales'],
                    'updated_at' => date('Y-m-d H:i:s')
                ]
            );
        return array('success' => true, 'message' => 'Success');
    }

    public function addProduct($data = null)
    {
        if ($data == null) return;
        DB::table($this->table)->insert([
            [
                'product_name' => $data['name'],
                'product_image' => $data['image'],
                'product_price' => $data['price'],
                'is_sales' => $data['is_sales'],
                'description' => $data['description'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ]);
    }

    public function deleteProduct($id = -1)
    {
        if ($id == -1 || $id < 0) return;

        DB::table($this->table)->where('product_id', '=', $id)->delete();
    }
}
