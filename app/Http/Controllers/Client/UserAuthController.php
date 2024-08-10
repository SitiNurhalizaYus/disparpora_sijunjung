<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Helpers;

class UserAuthController extends Controller
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
        return redirect()->route('client.login');
    }

    public function login()
    {
        $has_session = \App\Helpers\AppHelper::instance()->checkSession();

        if($has_session) {
            return redirect()->route('client.dashboard');
        } else {
            $data = [];
            $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
            $data['message'] = session('message', null);
            return view('client.auth.login', $data);
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
            return redirect()->route('client.dashboard');
        } else {
            session()->flash('message', $data['message']);
            return redirect()->route('client.login');
        }
    }

    public function forgot()
    {
        $data = [];
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        return view('client.auth.forgot', $data);
    }

    public function error()
    {
        $data = [];
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        return view('client.auth.error', $data);
    }
}