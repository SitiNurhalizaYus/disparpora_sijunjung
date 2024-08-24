<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Content;

class ProfilController extends Controller
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
            $data['menu'] = 'profil-list';
            $data['session_data'] = \App\Helpers\AppHelper::instance()->getSessionData();
            $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();
            $data['contents'] = Content::where('type', Content::TYPE_PROFIL)->paginate(10); // Hanya mengambil konten dengan tipe 'profil'
            return view('admin.profil.index', $data);
        } else {
            session()->flash('message', 'Session expired.');
            return redirect()->route('admin.login');
        }
    }

    public function create()
    {
        $data = [];
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['menu'] = 'profil-create';
        $data['session_data'] = \App\Helpers\AppHelper::instance()->getSessionData();
        $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();
        return view('admin.profil.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'slug' => 'required|unique:contents,slug',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['type'] = 'profil'; // Mengatur tipe sebagai profil

        Content::create($data);

        session()->flash('message', 'Profil berhasil ditambahkan.');
        return redirect()->route('admin.profil.index');
    }

    public function edit($id)
    {
        $data = [];
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['menu'] = 'profil-edit';
        $data['session_data'] = \App\Helpers\AppHelper::instance()->getSessionData();
        $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();
        $data['content'] = Content::where('type', Content::TYPE_PROFIL)->findOrFail($id);

        return view('admin.profil.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $content = Content::where('type', Content::TYPE_PROFIL)->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'slug' => 'required|unique:contents,slug,' . $content->id,
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $content->update($data);

        session()->flash('message', 'Profil berhasil diperbarui.');
        return redirect()->route('admin.profil.index');
    }

    public function show($id)
    {
        $data = [];
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['menu'] = 'profil-show';
        $data['session_data'] = \App\Helpers\AppHelper::instance()->getSessionData();
        $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();
        $data['content'] = Content::where('type', Content::TYPE_PROFIL)->findOrFail($id);

        return view('admin.profil.show', $data);
    }

    public function destroy($id)
    {
        $content = Content::where('type', Content::TYPE_PROFIL)->findOrFail($id);
        $content->delete();

        session()->flash('message', 'Profil berhasil dihapus.');
        return redirect()->route('admin.profil.index');
    }
}
