<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Content;

class ArtikelController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $has_session = \App\Helpers\AppHelper::instance()->checkSession();

        if ($has_session) {
            $data = [];
            $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
            $data['menu'] = 'artikel-list';
            $data['session_data'] = \App\Helpers\AppHelper::instance()->getSessionData();
            $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();
            $data['contents'] = Content::where('type', Content::TYPE_ARTIKEL)->paginate(10); // Fetching artikel content
            return view('admin.artikel.index', $data);
        } else {
            session()->flash('message', 'Session expired.');
            return redirect()->route('admin.login');
        }
    }

    public function create()
    {
        $data = [];
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['menu'] = 'artikel-create';
        $data['session_data'] = \App\Helpers\AppHelper::instance()->getSessionData();
        $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();
        return view('admin.artikel.create', $data);
    }

    public function edit($id)
    {
        $data = [];
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['menu'] = 'artikel-edit';
        $data['session_data'] = \App\Helpers\AppHelper::instance()->getSessionData();
        $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();
        $data['content'] = Content::where('type', Content::TYPE_ARTIKEL)->findOrFail($id); // Fetching artikel content by id
        return view('admin.artikel.edit', $data);
    }

    public function show($id)
    {
        $data = [];
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['menu'] = 'artikel-show';
        $data['session_data'] = \App\Helpers\AppHelper::instance()->getSessionData();
        $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();
        $data['content'] = Content::where('type', Content::TYPE_ARTIKEL)->findOrFail($id); // Fetching artikel content by id
        return view('admin.artikel.show', $data);
    }
}
