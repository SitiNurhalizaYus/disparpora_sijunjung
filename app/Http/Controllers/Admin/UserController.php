<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserLevel;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct() {}

    public function index()
    {
        $has_session = \App\Helpers\AppHelper::instance()->checkSession();
        $session = \App\Helpers\AppHelper::instance()->getSessionData();

        if ($has_session) {
            if ($session['user_level_id'] == 1) {
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

    public function show($id_user)
    {
        $has_session = \App\Helpers\AppHelper::instance()->checkSession();
        $session = \App\Helpers\AppHelper::instance()->getSessionData();

        if ($has_session) {
            if ($session['user_level_id'] == 1) {
                $data = [];
                $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
                $data['menu'] = 'user-show';
                $data['session_data'] = \App\Helpers\AppHelper::instance()->getSessionData();
                $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();
                $data['id_user'] = $id_user;
                $user = User::findOrFail($id_user);

                $category = UserLevel::find($user->level_id);

                $data['user'] = $user;
                $data['name_category'] = $category ? $category->name : 'Peran tidak ditemukan';

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

        if ($has_session) {
            if ($session['user_level_id'] == 1) {
                $data = [];
                $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
                $data['menu'] = 'user-create';
                $data['session_data'] = \App\Helpers\AppHelper::instance()->getSessionData();
                $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();

                $categories = UserLevel::all()->unique('name');
                $data['categories'] = $categories;

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

    public function edit($id_user)
    {
        $has_session = \App\Helpers\AppHelper::instance()->checkSession();
        $session = \App\Helpers\AppHelper::instance()->getSessionData();

        if ($has_session) {
            if ($session['user_level_id'] == 1) {
                $data = [];
                $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
                $data['menu'] = 'user-edit';
                $data['session_data'] = \App\Helpers\AppHelper::instance()->getSessionData();
                $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();
                $data['id_user'] = $id_user;

                $user = User::findOrFail($id_user);
                $categories = UserLevel::all()->unique('name');

                $data['user'] = $user;
                $data['categories'] = $categories;

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
