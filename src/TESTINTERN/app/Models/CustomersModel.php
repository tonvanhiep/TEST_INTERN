<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class CustomersModel extends Model
{
    use HasFactory;

    protected $table = 'MST_CUSTOMER';

    public function index()
    {

    }

    public function addCustomer($data = null)
    {
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

    public function checkLogin($data)
    {
        $result = DB::table($this->table)->select('customer_id')
                                         ->where('email', '=', $data['email'])
                                         ->where('password', '=', $data['pass'])
                                         ->get();
        return $result;
    }

    public function getAllCustomer()
    {
        $result = DB::table($this->table)->select('customer_id', 'customer_name', 'email', 'tel_num', 'address', 'is_active', 'created_at')->get();
        return $result;
    }

    public function getCustomer($page = null, $recordOnPage = 20)
    {
        $result = DB::table($this->table)->select('customer_id', 'customer_name', 'email', 'tel_num', 'address', 'is_active', 'created_at')->paginate($perPage = $recordOnPage, $columns = ['*'], $pageName = 'page', $page = $page);
        return $result;
    }

    public function getCountCustomer()
    {
        $count = DB::table($this->table)->count();
        return $count;
    }
}
