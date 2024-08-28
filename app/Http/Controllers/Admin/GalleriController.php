<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\Gallery;

class GalleriController extends Controller
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
            $data['menu'] = 'gallery-list';
            $data['session_data'] = \App\Helpers\AppHelper::instance()->getSessionData();
            $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();
            $data['galleries'] = Gallery::where('type', Gallery::TYPE_GAMBAR, Gallery::TYPE_VIDEO)->paginate(10); // Hanya mengambil konten dengan tipe 'profil'
            return view('admin.gallery.index', $data);
        } else {
            session()->flash('message', 'Session expired.');
            return redirect()->route('admin.login');
        }
    }

    public function create()
    {
        $data = [];
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['menu'] = 'gallery-create';
        $data['session_data'] = \App\Helpers\AppHelper::instance()->getSessionData();
        $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();
        return view('admin.gallery.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['type'] = 'gambar'; // Mengatur tipe sebagai profil

        Gallery::create($data);

        session()->flash('message', 'Galeri berhasil ditambahkan.');
        return redirect()->route('admin.gallery.index');
    }

    public function edit($id)
    {
        $data = [];
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['menu'] = 'gallery-edit';
        $data['session_data'] = \App\Helpers\AppHelper::instance()->getSessionData();
        $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();
        $data['galleries'] = Gallery::where('type', Gallery::TYPE_GAMBAR, Gallery::TYPE_VIDEO)->findOrFail($id);

        return view('admin.gallery.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $galleries = Gallery::where('type', Gallery::TYPE_GAMBAR, Gallery::TYPE_VIDEO)->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $galleries->update($data);

        session()->flash('message', 'Galeri berhasil diperbarui.');
        return redirect()->route('admin.gallery.index');
    }

    public function show($id)
    {   
        // Ambil data profil dari model berdasarkan id_content
        $galleries = Gallery::find($id);

        // Jika data tidak ditemukan, redirect dengan pesan error
        if (!$galleries) {
            return redirect()->route('admin.gallery.index')->with('error', 'Galeri tidak ditemukan');
        }

        // Kirim variabel $id_content ke view
        $data = [];
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['menu'] = 'gallery-show';
        $data['session_data'] = \App\Helpers\AppHelper::instance()->getSessionData();
        $data['galleries'] = Gallery::where('type', Gallery::TYPE_GAMBAR, Gallery::TYPE_VIDEO)->findOrFail($id);
        $data['id'] = $id;
        $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();
        
        return view('admin.gallery.show', $data);
    
    }

    public function destroy($id)
    {
        $galleries = Content::where('type', Gallery::TYPE_GAMBAR, Gallery::TYPE_VIDEO)->findOrFail($id);
        $galleries->delete();

        session()->flash('message', 'Galeri berhasil dihapus.');
        return redirect()->route('admin.gallery.index');
    }
}
