<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AdminModel extends Model
{
    use HasFactory;

    protected $table = 'MST_ADMIN';

    protected $fillable = ['name','email','password','is_active','group_role','is_delete','created_at','updated_at'];



    public function addAdmin($data = null)
    {
        if ($data == null) return;
        DB::table($this->table)->insert([
            [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['pass'],
                'is_active' => (isset($data['is_active']) && $data['is_active'] != null) ? $data['is_active'] : 1,
                'group_role' => $data['group'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ]);
    }

    public function checkLogin($data = null)
    {
        $result = DB::table($this->table)
                    ->select('admin_id', 'group_role')
                    ->where('email', '=', $data['email'])
                    ->where('password', '=', $data['pass'])
                    ->get();

        if(count($result) == 1) {
            DB::table($this->table)->where('admin_id', $result[0]->admin_id)
            ->update(
              [
                'remember_token' => $data['remember']
              ]
          );
        }
        return $result;
    }

    public function getCountAdmin($condition = null)
    {
        if($condition == null) return 0;
        $count = DB::table($this->table)
            ->where('is_delete', '=' , 0)
            ->where('name', 'like', '%'.$condition['name'].'%')
            ->where('email', 'like', '%'.(($condition['email'] == null) ? '' : $condition['email']).'%')
            ->where(function($query) use ($condition) {
                $query->where('group_role', '=' ,(($condition['group'] == -1) ? 1 : $condition['group']))
                      ->orWhere('group_role', '=', (($condition['group'] == -1) ? 2 : $condition['group']))
                      ->orWhere('group_role', '=', (($condition['group'] == -1) ? 3 : $condition['group']));
                })
            ->where(function($query) use ($condition) {
                $query->where('is_active', '=' ,(($condition['is_active'] == -1) ? 0 : $condition['is_active']))
                      ->orWhere('is_active', '=', (($condition['is_active'] == -1) ? 1 : $condition['is_active']));
                })
            ->count();
        return $count;
    }

    public function getAdmin($condition = null, $page = 1, $recordOnPage = 20)
    {
        if($condition == null) return 0;
        // dd($condition);
        $result = DB::table($this->table)
            ->select('admin_id', 'name', 'email', 'group_role', 'is_active', 'created_at')
            ->where('is_delete', '=' , 0)
            ->where('name', 'like', '%'.(($condition['name'] == null) ? '' : $condition['name']).'%')
            ->where('email', 'like', '%'.(($condition['email'] == null) ? '' : $condition['email']).'%')
            ->where(function($query) use ($condition) {
                $query->where('group_role', '=' ,(($condition['group'] == -1) ? 1 : $condition['group']))
                      ->orWhere('group_role', '=', (($condition['group'] == -1) ? 2 : $condition['group']))
                      ->orWhere('group_role', '=', (($condition['group'] == -1) ? 3 : $condition['group']));
                })
            ->where(function($query) use ($condition) {
                $query->where('is_active', '=' ,(($condition['is_active'] == -1) ? 0 : $condition['is_active']))
                      ->orWhere('is_active', '=', (($condition['is_active'] == -1) ? 1 : $condition['is_active']));
                })
            ->orderBy('admin_id', 'desc')
            ->paginate($perPage = $recordOnPage, $columns = ['*'], $pageName = 'page', $page = $page);
        return $result;
    }

    public function updateAdmin($id = -1, $data = null)
    {
        if($id == -1 || $data == null) return array('success' => false, 'message' => 'IDは正しくない。');
        $result = DB::table($this->table)->where('admin_id', '!=', $id)->where('email', 'like', $data['email'])->get();
        if(count($result) > 0) return array('success' => false, 'message' => 'メールの値は既に存在しています。');

        DB::table($this->table)
              ->where('admin_id', $id)
              ->update(
                [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'is_active' => $data['is_active'],
                    'group_role' => $data['group'],
                    'updated_at' => date('Y-m-d H:i:s')
                ]
            );
        return array('success' => true, 'message' => 'Success');
    }

    public function checkExisted($email = '')
    {
        if ($email == null) return;
        return DB::table($this->table)->where('email', 'like', $email)->get();
    }

    public function deleteAdmin($id = 0)
    {
        if ($id < 0) return;
        DB::table($this->table)
                ->where('admin_id', $id)
                ->update(
                [
                    'is_delete' => 1
                ]
            );
        return array('success' => true, 'message' => '成功');
    }

    public function updateLastLogin($data = null)
    {
        if($data == null) return array('success' => false, 'message' => 'IDは正しくない。');

        DB::table($this->table)
            ->where('admin_id', $data['id'])
            ->update(
            [
                'last_login_ip' => $data['ip'],
                'last_login_at' => $data['time']
            ]
        );
    }
}
