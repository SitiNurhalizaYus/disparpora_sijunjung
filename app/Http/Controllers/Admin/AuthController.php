<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        return $this->login();
    }

    public function logout()
    {
        $has_session = \App\Helpers\AppHelper::instance()->removeSession();
        return redirect()->route('admin.login');
    }

    public function login()
    {
        $has_session = \App\Helpers\AppHelper::instance()->checkSession();

        if($has_session) {
            return redirect()->route('admin.dashboard');
        } else {
            $data = [];
            $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
            $data['message'] = session('message', null);
            return view('admin.auth.login', $data);
        }

    }

    public function action_login(Request $request)
    {
        $data = [];
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();

        $payload = $request->all();
        $result = \App\Helpers\AppHelper::instance()->requestApiLogin('/api/login', $payload);
        $data['result'] = $result[0];
        $data['message'] = $result[1];

        if($data['result']) {
            \App\Helpers\AppHelper::instance()->setSession($data['result']['user'], $data['result']['token']);
            return redirect()->route('admin.dashboard');
        } else {
            session()->flash('message', $data['message']);
            return redirect()->route('admin.login');
        }
    }

    public function forgot()
    {
        $data = [];
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        return view('admin.auth.forgot', $data);
    }

    public function error()
    {
        $data = [];
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        return view('admin.auth.error', $data);
    }
}
