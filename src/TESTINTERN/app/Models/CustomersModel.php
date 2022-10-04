<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class CustomersModel extends Model
{
    use HasFactory;

    protected $table = 'MST_CUSTOMER';

    public function index() {}

    public function addCustomer($data = null)
    {
        if($data == null) return;
        DB::table($this->table)->insert([
            [
                'customer_name' => $data['name'],
                'email' => $data['email'],
                'tel_num' => $data['tel'],
                'address' => $data['address'],
                'password' => $data['pass'],
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ]);
    }

    public function updateCustomer($id = -1, $data)
    {
        if($id == -1 || $data == null) return array('success' => false, 'message' => 'ID khách hàng không hợp lệ.');
        $result = DB::table($this->table)->where('customer_id', '!=', $id)->where('email', 'like', $data['email'])->get();
        if(count($result) > 0) return array('success' => false, 'message' => 'Email đã tồn tại.');

        DB::table($this->table)
              ->where('customer_id', $id)
              ->update(
                [
                    'customer_name' => $data['name'],
                    'email' => $data['email'],
                    'tel_num' => $data['tel'],
                    'address' => $data['address'],
                    'is_active' => $data['is_active'],
                    'updated_at' => date('Y-m-d H:i:s')
                ]
            );
        return array('success' => true, 'message' => 'Success');
    }

    public function deleteCustomer($id = -1)
    {
        if($id == -1 || $id <= 0) return;
        DB::table($this->table)->where('customer_id', '=', $id)->delete();
    }

    public function checkLogin($data)
    {
        if($data == null) return;

        $result = DB::table($this->table)->select('customer_id')
                                         ->where('email', '=', $data['email'])
                                         ->where('password', '=', $data['pass'])
                                         ->get();
        return $result;
    }

    public function getAllCustomer()
    {
        $result = DB::table($this->table)
            ->select('customer_id', 'customer_name', 'email', 'tel_num', 'address', 'is_active', 'created_at')->get();
        return $result;
    }

    public function getCustomer($page = 1, $recordOnPage = 20)
    {
        $result = DB::table($this->table)
            ->select('customer_id', 'customer_name', 'email', 'tel_num', 'address', 'is_active', 'created_at')
            ->paginate($perPage = $recordOnPage, $columns = ['*'], $pageName = 'page', $page = $page);
        return $result;
    }

    public function getCountCustomer()
    {
        $count = DB::table($this->table)->count();
        return $count;
    }
}
