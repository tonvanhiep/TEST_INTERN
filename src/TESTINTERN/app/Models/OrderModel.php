<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrderModel extends Model
{
    use HasFactory;

    protected $table = 'MST_ORDER';

    public function addOrder($data = null)
    {
        if ($data == null) return -1;

        DB::table($this->table)->insert([
            [
                'customer_id' => $data['customer_id'],
                'customer_name' => $data['customer_name'],
                'customer_email' => $data['customer_email'],
                'customer_tel' => $data['customer_tel'],
                'address' => $data['address'],
                'total_price' => $data['total_price'],
                'payment_method' => $data['payment_method'],
                'ship_charge' => $data['ship_charge'],
                'order_date' => $data['order_date'],
                'note_customer' => $data['note_customer'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at'],
                'order_status' => $data['order_status']
            ]
        ]);

        $result = DB::table($this->table)->select('order_id')
            ->where('customer_id', $data['customer_id'])
            ->where('customer_name', $data['customer_name'])
            ->where('customer_email', $data['customer_email'])
            ->where('customer_tel', $data['customer_tel'])
            ->where('address', $data['address'])
            ->where('total_price', $data['total_price'])
            ->where('payment_method', $data['payment_method'])
            ->where('ship_charge', $data['ship_charge'])
            ->where('order_date', $data['order_date'])
            ->where('note_customer', $data['note_customer'])
            ->where('created_at', $data['created_at'])
            ->where('updated_at', $data['updated_at'])
            ->where('order_status', $data['order_status'])
            ->get();

        return $result[0]->order_id;

    }
}
