<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use App\Models\CustomersModel;
use App\Models\ProductModel;
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
            $product = new ProductModel();
            $data = [
                'name' => $this->generate_string('ABCDEFGHIJKLMNOPQRSTUVWXYZ ', rand(10, 50)),
                'price' => $this->generate_string('0123456789', rand(2, 5)).'0',
                'is_sales' => rand(0, 1),
                'image' => 'https://cdn.motor1.com/images/mgl/8AAPg2/s1/audi-a6-e-tron-rendering-by-kolesa-front.jpg',
                'description' => 'Moo tar cuar sanr phaamr '
            ];
            $product->addProduct($data);
        }

        return 'Success';
    }
}
