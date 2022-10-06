<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterAdminRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\AdminModel;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    private $admin;

    public function __construct()
    {
        $this->admin = new AdminModel();
    }

    public function index()
    {
        return view('admin.login');
    }

    public function actionLogin(LoginRequest $request)
    {
        $infoLogin = [
            'email' => $request['email'],
            'pass' => md5($request['pass'])
        ];
        $result = $this->admin->checkLogin($infoLogin);

        if(count($result) === 0) {
            return redirect()->back()->withErrors(['msg' => 'Email hoặc mật khẩu không đúng.']);
        }
        else if(is_int($result[0]->admin_id) && $result[0]->admin_id >= 0) {
            session()->put('admin_id', ['id' => $result[0]->admin_id]);
            return redirect()->route('admin.customerManagement');
        }
    }

    public function actionLogout(Request $request)
    {
        if($request->session()->has('admin_id')) {
            $request->session()->forget('admin_id');
        }
        return redirect()->route('home');
    }

    public function actionRegister(RegisterAdminRequest $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'pass' => $request->pass,
            'group' => $request->group
        ];
        $this->admin->addAdmin($data);
    }
}
