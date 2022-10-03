<?php

namespace App\Http\Controllers;

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

        for($i = 0; $i < 250; $i++) {
            $customer = new CustomersModel();
            $dataCustomer = [
                'name' => 'NAVE LOPI HANUI',
                'email' => $this->generate_string($permitted_chars, 16).'@gmail.com',
                'tel' => '0'.$this->generate_string('0123456789', 9),
                'pass' => 'e807f1fcf82d132f9bb018ca6738a19f',
                'address' => 'ABC XYZ, ABC MNG, CDN WOP, FGH CSV'
            ];
            $customer->addCustomer($dataCustomer);
        }

        return 'Success';
    }
}
