<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use App\Models\CustomersModel;
use Illuminate\Http\Request;

class TestController extends Controller
{

    function generate_string($input, $strength = 16) {
        $input_length = strlen($input);
        $random_string = '';
        for($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }
        return $random_string;
    }


    public function index()
    {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        for($i = 0; $i < 100; $i++) {
            $admin = new AdminModel();
            $dataAdmin = [
                'name' => $this->generate_string('ABCDEFGHIJKLMNOPQRSTUVWXYZ ', 12),
                'email' => $this->generate_string($permitted_chars, 12).'@gmail.com',
                'pass' => md5(123456789),
                'is_active' => rand(0, 1),
                'group' => rand(1, 3),
            ];
            $admin->addAdmin($dataAdmin);
        }

        return 'Success';
    }
}
