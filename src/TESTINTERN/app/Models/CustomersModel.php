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
        if(count($result) > 0) return array('success' => false, 'message' => 'メールの値は既に存在しています。');

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
        if($id == -1 || $data == null) return array('success' => false, 'message' => 'IDは正しくない。');
        $result = DB::table($this->table)->where('customer_id', '!=', $id)->where('email', 'like', $data['email'])->get();
        if(count($result) > 0) return array('success' => false, 'message' => 'メールの値は既に存在しています。');

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

        $result = DB::table($this->table)->select('customer_id', 'customer_name')
                                         ->where('email', '=', $data['email'])
                                         ->where('password', '=', $data['pass'])
                                         ->get();
        return $result;
    }

    public function checkActive($id = null)
    {
        if($id == null) return;

        $result = DB::table($this->table)->select('customer_id')
                                         ->where('customer_id', '=', $id)
                                         ->where('is_active', '=', 1)
                                         ->get();
        return $result;
    }

    public function getAllCustomer()
    {
        $result = DB::table($this->table)
            ->select('customer_id', 'customer_name', 'email', 'tel_num', 'address', 'is_active', 'created_at')
            ->orderBy('customer_id', 'desc')
            ->get();
        return $result;
    }

    public function getCustomer($condition = null, $page = 1, $recordOnPage = 20)
    {
        if($condition == null) return -1;

        $result = DB::table($this->table)
            ->select('customer_id', 'customer_name', 'email', 'tel_num', 'address', 'is_active', 'created_at')
            ->where('customer_name', 'like', '%' . $condition['name'] . '%')
            ->where('email', 'like', '%' . $condition['email'] . '%')
            ->where('address', 'like', '%' . $condition['address'] . '%')
            ->where(function($query) use ($condition) {
                $query->where('is_active', '=' ,(($condition['is_active'] == -1) ? 0 : $condition['is_active']))
                      ->orWhere('is_active', '=', (($condition['is_active'] == -1) ? 1 : $condition['is_active']));
                })
                ->orderBy('customer_id', 'desc')
                ->paginate($perPage = $recordOnPage, $columns = ['*'], $pageName = 'page', $page = $page);
        return $result;
    }

    public function getInfoCustomer($id = null)
    {
        if ($id == null) return;

        $result = DB::table($this->table)
            ->select('customer_name', 'email', 'tel_num', 'address', 'is_active', 'created_at')
            ->where('customer_id', '=', $id)
            ->where('is_active', '=', 1)
            ->get();
        return $result;
    }

    public function getCountCustomer($condition = null)
    {
        if($condition == null) return -1;
        $count = DB::table($this->table)
            ->where('customer_name', 'like', '%' . $condition['name'] . '%')
            ->where('email', 'like', '%' . $condition['email'] . '%')
            ->where('address', 'like', '%' . $condition['address'] . '%')
            ->where(function($query) use ($condition) {
                $query->where('is_active', '=' ,(($condition['is_active'] == -1) ? 0 : $condition['is_active']))
                      ->orWhere('is_active', '=', (($condition['is_active'] == -1) ? 1 : $condition['is_active']));
                })
            ->count();
        return $count;
    }

    public function editPassCustomer($data = null)
    {
        if ($data == null) return -1;

        $result = DB::table($this->table)->select('customer_id')
            ->where('customer_id', '=', $data['id'])
            ->where('is_active', '=', 1)
            ->where('password', '=', $data['pass'])
            ->get();

        if(count($result) == 0) return -2;

        DB::table($this->table)->where('customer_id', '=', $data['id'])
            ->update([
                'password' => $data['npass'],
                'updated_at' => $data['date']
            ]);
        return 0;
    }

    public function editInfoCustomer($data = null)
    {
        if ($data == null) return -1;

        $result = DB::table($this->table)->select('customer_id')
            ->where('customer_id', '!=', $data['id'])
            ->where('email', '=', $data['email'])
            ->get();

        if(count($result) > 0) return -2;

        DB::table($this->table)->where('customer_id', '=', $data['id'])
            ->update([
                'customer_name' => $data['name'],
                'email' => $data['email'],
                'tel_num' => $data['phone'],
                'address' => $data['address'],
                'updated_at' => $data['date']
            ]);
        return 0;
    }
}
