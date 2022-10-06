<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\CustomersModel;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    //

    public function index()
    {
        return view('client.register');
    }

    public function register(RegisterRequest $request)
    {
        $this->actionRegister($request);

        return redirect()->route('home');
    }

    public function actionRegister(RegisterRequest $request)
    {
        // dd($request);
        $customer = new CustomersModel();
        $dataCustomer = [
            'name' => $request->name,
            'email' => $request->email,
            'tel' => $request->tel,
            'pass' => md5($request->pass),
            'address' => $request->address
        ];
        $customer->addCustomer($dataCustomer);

        return "Success";
    }
}
