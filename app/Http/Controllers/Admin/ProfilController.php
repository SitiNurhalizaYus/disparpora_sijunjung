<?php

namespace App\Http\Controllers\Admin;

use App\Models\Content;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfilController extends Controller
{
    public function __construct() {}

    public function index()
    {
        $has_session = \App\Helpers\AppHelper::instance()->checkSession();
        $session = \App\Helpers\AppHelper::instance()->getSessionData();

        if ($has_session) {
            if ($session['user_level_id'] == 1 || $session['user_level_id'] == 2) {
                $data = [];
                $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
                $data['menu'] = 'profil-list';
                $data['session_data'] = \App\Helpers\AppHelper::instance()->getSessionData();
                $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();
                $data['contents'] = Content::where('type', Content::TYPE_PROFIL)->paginate(10); // Hanya mengambil konten dengan tipe 'profil'
                return view('admin.profil.index', $data);
            } else {
                session()->flash('message', 'Forbidden access.');
                return redirect()->route('admin.error');
            }
        } else {
            session()->flash('message', 'Session expired.');
            return redirect()->route('admin.login');
        }
    }

    public function show($id_content)
    {
        $has_session = \App\Helpers\AppHelper::instance()->checkSession();
        $session = \App\Helpers\AppHelper::instance()->getSessionData();

        if ($has_session) {
            if ($session['user_level_id'] == 1 || $session['user_level_id'] == 2) {
                $data = [];
                $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
                $data['menu'] = 'profil-show';
                $data['session_data'] = \App\Helpers\AppHelper::instance()->getSessionData();
                $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();
                $data['id_content'] = $id_content;

                $content = Content::findOrFail($id_content);

                $data['content'] = $content;

                return view('admin.profil.show', $data);
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
            if ($session['user_level_id'] == 1 || $session['user_level_id'] == 2) {
                $data = [];
                $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
                $data['menu'] = 'profil-create';
                $data['session_data'] = \App\Helpers\AppHelper::instance()->getSessionData();
                $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();

                return view('admin.profil.create', $data);
            } else {
                session()->flash('message', 'Forbidden access.');
                return redirect()->route('admin.error');
            }
        } else {
            session()->flash('message', 'Session expired.');
            return redirect()->route('admin.login');
        }
    }

    public function edit($id_content)
    {
        $has_session = \App\Helpers\AppHelper::instance()->checkSession();
        $session = \App\Helpers\AppHelper::instance()->getSessionData();

        if ($has_session) {
            if ($session['user_level_id'] == 1 || $session['user_level_id'] == 2) {
                $data = [];
                $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
                $data['menu'] = 'profil-edit';
                $data['session_data'] = \App\Helpers\AppHelper::instance()->getSessionData();
                $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();
                $data['id_content'] = $id_content;

                $content = Content::findOrFail($id_content);

                $data['content'] = $content;

                return view('admin.profil.edit', $data);
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
