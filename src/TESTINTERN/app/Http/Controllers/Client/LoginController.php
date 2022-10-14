<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\CustomersModel;
use Illuminate\Http\Request;

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
            $active = $this->customer->checkActive($result[0]->customer_id);

            if(count($active) === 0) {
                return redirect()->back()->withErrors(['msg' => 'Tài khoản của bạn đã bị khóa.']);
            }

            session()->put('customer', [
                'id' => $result[0]->customer_id,
                'name' => $result[0]->customer_name,
            ]);
            return redirect()->route('home');
        }
    }

    public function actionLogout(Request $request)
    {
        if($request->session()->has('customer')) {
            $request->session()->forget('customer');
            return redirect()->route('home');
        }
        return redirect()->route('account.login');
    }

    public function infoCustomer(Request $request)
    {
        $info = $this->customer->getInfoCustomer($request->session()->get('customer')['id']);
        return view('client.info', compact('info'));
    }

    public function saveInfo(Request $request)
    {
        // dd($request);
        $request->validate([
            'name' => 'bail|required',
            'email' => 'bail|required|email',
            'phone' => 'bail|required|numeric',
            'address' => 'bail|required'
        ]);
        $data = [
            'id' => $request->session()->get('customer')['id'],
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'date' => date('Y-m-d H:i:s')
        ];

        $result = $this->customer->editInfoCustomer($data);
        if ($result == -2) return redirect()->back()->with('error', 'Email is existed.');
        return redirect()->back()->with('status', 'Update information success!!!');
    }

    public function savePass(Request $request)
    {
        $request->validate([
            'cpass' => 'bail|required|min:8|max:32',
            'npass' => 'bail|required|regex:/^[a-zA-Z0-9]+$/u|min:8|max:32',
            'repass' => 'bail|required|same:npass'
        ]);

        $data = [
            'id' => $request->session()->get('customer')['id'],
            'pass' => md5($request->cpass),
            'npass' => md5($request->npass),
            'date' => date('Y-m-d H:i:s')
        ];

        $result = $this->customer->editPassCustomer($data);
        if ($result == -2) return redirect()->back()->with('error', 'Password incorrect.');
        return redirect()->back()->with('status', 'Change password success!!!');
    }
}
