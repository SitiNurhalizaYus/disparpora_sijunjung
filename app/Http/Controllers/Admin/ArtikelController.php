<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\Category;

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
        $data['kategoris'] = Category::all(); // Ambil semua kategori untuk dipilih
        return view('admin.artikel.create', $data);
    }

    public function edit($id_content)
    {
        $data = [];
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['menu'] = 'artikel-edit';
        $data['session_data'] = \App\Helpers\AppHelper::instance()->getSessionData();
        $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();
        $data['content'] = Content::where('type', Content::TYPE_ARTIKEL)->findOrFail($id_content); // Fetching artikel content by id_content
        $data['kategoris'] = Category::all(); // Ambil semua kategori untuk dipilih
        return view('admin.artikel.edit', $data);
    }

    public function show($id_content)
    {
        // Ambil data artikel dari model berdasarkan id_content
        $content = Content::find($id_content);

        // Jika data tidak ditemukan, redirect dengan pesan error
        if (!$content) {
            return redirect()->route('admin.artikel.index')->with('error', 'Artikel tidak ditemukan');
        }

        // Kirim variabel $id_content ke view
        $data = [];
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['menu'] = 'artikel-show';
        $data['session_data'] = \App\Helpers\AppHelper::instance()->getSessionData();
        $data['content'] = $content;
        $data['id_content'] = $id_content;
        $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();
        
        return view('admin.artikel.show', $data);
    }
}
