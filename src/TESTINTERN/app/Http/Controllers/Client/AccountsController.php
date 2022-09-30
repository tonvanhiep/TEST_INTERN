<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountsController extends Controller
{
    //
    private $data;

    public function index()
    {

    }

    public function registerAccount(Request $request)
    {
        return 'trang dang ky';
    }


    public function loginAccount(Request $request)
    {
        return 'trang dang nhap';
    }

}
