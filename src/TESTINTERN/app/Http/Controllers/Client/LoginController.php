<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\CustomersModel;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    //
    private $customer;

    public function __construct()
    {
        $this->customer = new CustomersModel();
    }

    public function index()
    {
        return view('client.login');
    }

    public function actionLogin(LoginRequest $request)
    {
        // dd($request);
        $infoLogin = [
            'email' => $request['email'],
            'pass' => md5($request['pass'])
        ];

        $result = $this->customer->checkLogin($infoLogin);

        if(count($result) === 0) {
            return redirect()->back()->withErrors(['msg' => 'Email hoặc mật khẩu không đúng.']);
        }
        else if(is_int($result[0]->customer_id) && $result[0]->customer_id >= 0) {
            session()->put('customer_id', ['id' => $result[0]->customer_id]);
            return redirect()->route('home');
        }
    }

    public function actionLogout(Request $request)
    {
        if($request->session()->has('customer_id')) {
            $request->session()->forget('customer_id');
        }
        return redirect()->route('home');
    }
}
