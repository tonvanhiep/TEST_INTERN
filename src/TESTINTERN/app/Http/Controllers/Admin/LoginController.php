<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterAdminRequest;
use App\Models\AdminModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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
            'pass' => md5($request['pass']),
            'remember' => $request->has('remember-me') ? Session::getId() : null
        ];
        $result = $this->admin->checkLogin($infoLogin);

        if(count($result) === 0) {
            return redirect()->back()->withErrors(['msg' => 'メールアドレスまたはパスワードが正しくありません']);
        }
        else if(count($result) === 1 && is_int($result[0]->admin_id) && $result[0]->admin_id >= 0) {
            session()->put('admin', ['id' => $result[0]->admin_id, 'role' => $result[0]->group_role]);

            $data = [
                'id' => $result[0]->admin_id,
                'ip' => request()->ip(),
                'time' => date('Y-m-d H:i:s')
            ];
            $this->admin->updateLastLogin($data);

            return redirect()->route('admin.product.management');
        }

        return redirect()->back()->withErrors(['msg' => 'ログインできませんでした']);
    }

    public function actionLogout(Request $request)
    {
        if($request->session()->has('admin')) {
            $request->session()->forget('admin');
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
