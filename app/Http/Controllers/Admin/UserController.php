<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $has_session = \App\Helpers\AppHelper::instance()->checkSession();
        $session = \App\Helpers\AppHelper::instance()->getSessionData();

        if($has_session) {
            if($session['user_level_id'] == 1) {
                $data = [];
                $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
                $data['menu'] = 'user-list';
                $data['session_data'] = \App\Helpers\AppHelper::instance()->getSessionData();
                $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();
                return view('admin.user.index', $data);
            } else {
                session()->flash('message', 'Forbidden access.');
                return redirect()->route('admin.error');
            }
        } else {
            session()->flash('message', 'Session expired.');
            return redirect()->route('admin.login');
        }
    }

    public function show($id)
    {
        $has_session = \App\Helpers\AppHelper::instance()->checkSession();
        $session = \App\Helpers\AppHelper::instance()->getSessionData();

        if($has_session) {
            if($session['user_level_id'] == 1) {
                $data = [];
                $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
                $data['menu'] = 'user-show';
                $data['session_data'] = \App\Helpers\AppHelper::instance()->getSessionData();
                $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();
                $data['id'] = $id;
                return view('admin.user.show', $data);
            } else {
                session()->flash('message', 'Forbidden access.');
                return redirect()->route('admin.error');
            }
        } else {
            session()->flash('message', 'Session expired.');
            return redirect()->route('admin.login');
        }
    }

    public function create()
    {
        $has_session = \App\Helpers\AppHelper::instance()->checkSession();
        $session = \App\Helpers\AppHelper::instance()->getSessionData();

        if($has_session) {
            if($session['user_level_id'] == 1) {
                $data = [];
                $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
                $data['menu'] = 'user-create';
                $data['session_data'] = \App\Helpers\AppHelper::instance()->getSessionData();
                $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();
                return view('admin.user.create', $data);
            } else {
                session()->flash('message', 'Forbidden access.');
                return redirect()->route('admin.error');
            }
        } else {
            session()->flash('message', 'Session expired.');
            return redirect()->route('admin.login');
        }
    }

    public function edit($id)
    {
        $has_session = \App\Helpers\AppHelper::instance()->checkSession();
        $session = \App\Helpers\AppHelper::instance()->getSessionData();

        if($has_session) {
            if($session['user_level_id'] == 1) {
                $data = [];
                $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
                $data['menu'] = 'user-edit';
                $data['session_data'] = \App\Helpers\AppHelper::instance()->getSessionData();
                $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();
                $data['id'] = $id;
                return view('admin.user.edit', $data);
            } else {
                session()->flash('message', 'Forbidden access.');
                return redirect()->route('admin.error');
            }
        } else {
            session()->flash('message', 'Session expired.');
            return redirect()->route('admin.login');
        }
    }

}
