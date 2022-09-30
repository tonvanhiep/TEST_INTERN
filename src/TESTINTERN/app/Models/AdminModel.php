<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AdminModel extends Model
{
    use HasFactory;

    protected $table = 'MST_ADMIN';

    public function addAdmin($data = null)
    {
        // DB::table($this->table)->insert([
        //     [
        //         'customer_name' => $data['name'],
        //         'email' => $data['email'],
        //         'tel_num' => $data['tel'],
        //         'address' => $data['address'],
        //         'password' => $data['pass'],
        //         'is_active' => 1,
        //         'created_at' => date('Y-m-d H:i:s'),
        //         'updated_at' => date('Y-m-d H:i:s')
        //     ]
        // ]);
    }

    public function checkLogin($data = null)
    {
        $result = DB::table($this->table)->select('admin_id')
                                         ->where('email', '=', $data['email'])
                                         ->where('password', '=', $data['pass'])
                                         ->get();
        return $result;
    }
}
