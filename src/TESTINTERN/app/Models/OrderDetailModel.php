<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrderDetailModel extends Model
{
    use HasFactory;

    protected $table = 'MST_ORDER_DETAIL';

    public function addOrderDetail($data = null)
    {
        if($data == null) return -1;

        DB::table($this->table)->insert([
            [
                'order_id' => $data['order_id'],
                'detail_line' => $data['detail_line'],
                'product_id' => $data['product_id'],
                'price_buy' => $data['price_buy'],
                'quantity' => $data['quantity'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at']
            ]
        ]);
    }
}
