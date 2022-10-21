<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ContactModel extends Model
{
    protected $table = 'MST_CONTACT';

    public function addContact($data = null)
    {
        if($data === null) return;

        DB::table($this->table)->insert([
            [
                'name' => $data['name'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'message' => $data['message'],
                'created_at' => date('Y-m-d H:i:s')
            ]
        ]);
    }
}
