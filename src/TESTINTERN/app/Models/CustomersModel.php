<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class CustomersModel extends Model
{
    use HasFactory;

    protected $table = 'MST_CUSTOMER';

    protected $fillable = ['customer_name','email','tel_num','address','password','is_active','created_at','updated_at'];


    public function index() {}

    public function addCustomer($data = null)
    {
        if($data == null) return;
        $result = DB::table($this->table)->where('email', 'like', $data['email'])->get();
        if(count($result) > 0) return array('success' => false, 'message' => 'Email đã tồn tại.');

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

    public function checkExisted($email)
    {
        return DB::table($this->table)->where('email', 'like', $email)->get();
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
            ->select('customer_id', 'customer_name', 'email', 'tel_num', 'address', 'is_active', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get();
        return $result;
    }

    public function getCustomer($condition = null, $page = 1, $recordOnPage = 20)
    {
        if($condition == null) return -1;

        $result = DB::table($this->table)
            ->select('customer_id', 'customer_name', 'email', 'tel_num', 'address', 'is_active', 'created_at')
            ->where('customer_name', 'like', '%'.preg_replace("/[^a-zA-Z0-9]/", "%", (($condition['name'] == null) ? '' : $condition['name'])).'%')
            ->where('email', 'like', '%'.(($condition['email'] == null) ? '' : $condition['email']).'%')
            ->where('address', 'like', '%'.preg_replace("/[^a-zA-Z0-9]/", "%", (($condition['address'] == null) ? '' : $condition['address'])).'%')
            ->where(function($query) use ($condition) {
                $query->where('is_active', '=' ,(($condition['is_active'] == -1) ? 0 : $condition['is_active']))
                      ->orWhere('is_active', '=', (($condition['is_active'] == -1) ? 1 : $condition['is_active']));
                })
                ->orderBy('created_at', 'desc')
                ->paginate($perPage = $recordOnPage, $columns = ['*'], $pageName = 'page', $page = $page);
        return $result;
    }

    public function getCountCustomer($condition = null)
    {
        if($condition == null) return -1;
        $count = DB::table($this->table)
            ->where('customer_name', 'like', '%'.preg_replace("/[^a-zA-Z0-9]/", "%", (($condition['name'] == null) ? '' : $condition['name'])).'%')
            ->where('email', 'like', '%'.(($condition['email'] == null) ? '' : $condition['email']).'%')
            ->where('address', 'like', '%'.preg_replace("/[^a-zA-Z0-9]/", "%", (($condition['address'] == null) ? '' : $condition['address'])).'%')
            ->where(function($query) use ($condition) {
                $query->where('is_active', '=' ,(($condition['is_active'] == -1) ? 0 : $condition['is_active']))
                      ->orWhere('is_active', '=', (($condition['is_active'] == -1) ? 1 : $condition['is_active']));
                })
            ->count();
        return $count;
    }
}
