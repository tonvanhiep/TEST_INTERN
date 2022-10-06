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
            ->where('name', 'like', '%'.preg_replace("/[^a-zA-Z0-9]/", "%", (($condition['name'] == null) ? '' : $condition['name'])).'%')
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
}
