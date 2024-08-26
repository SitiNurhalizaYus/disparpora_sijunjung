<?php

namespace App\Http\Controllers\Admin;

use App\Models\Content;
use App\Models\Category;
use App\Helpers\AppHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class  BeritaController extends Controller
{
    public function __construct() {}

    public function index()
    {
        $has_session = \App\Helpers\AppHelper::instance()->checkSession();

        if ($has_session) {
            $data = [];
            $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
            $data['menu'] = 'berita-list';
            $data['session_data'] = \App\Helpers\AppHelper::instance()->getSessionData();
            $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();
            $data['contents'] = Content::where('type', Content::TYPE_BERITA)->paginate(10); // Hanya mengambil konten dengan tipe 'berita'
            return view('admin.berita.index', $data);
        } else {
            session()->flash('message', 'Session expired.');
            return redirect()->route('admin.login');
        }
    }

    public function create()
    {
        $data = [];
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['menu'] = 'berita-create';
        $data['session_data'] = \App\Helpers\AppHelper::instance()->getSessionData();
        $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();

        $data['kategoris'] = Category::all(); // Ambil semua kategori untuk dipilih

        return view('admin.berita.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'slug' => 'required|unique:contents,slug',
            'is_active' => 'boolean',
        ]);

        $data['kategoris'] = Category::all(); // Ambil semua kategori untuk dipilih
        $data = $request->all();
        $data['type'] = 'berita'; // Mengatur tipe sebagai berita

        Content::create($data);

        session()->flash('message', 'Berita berhasil ditambahkan.');
        return redirect()->route('admin.berita.index');
    }

    public function edit($id_content)
    {
        $data = [];
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['menu'] = 'berita-edit';
        $data['session_data'] = \App\Helpers\AppHelper::instance()->getSessionData();
        $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();
        $data['content'] = Content::where('type', Content::TYPE_BERITA)->findOrFail($id_content);

        $data['kategoris'] = Category::all(); // Ambil semua kategori untuk dipilih


        return view('admin.berita.edit', $data);
    }

    public function update(Request $request, $id_content)
    {
        $content = Content::where('type', Content::TYPE_BERITA)->findOrFail($id_content);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'slug' => 'required|unique:contents,slug,' . $content->id_content,
            'is_active' => 'boolean',
        ]);

        $data['kategoris'] = Category::all(); // Ambil semua kategori untuk dipilih
        $data = $request->all();
        $content->update($data);

        session()->flash('message', 'Berita berhasil diperbarui.');
        return redirect()->route('admin.berita.index');
    }

    public function show($id_content)
    {
        // Ambil data berita dari model berdasarkan id_content
        $content = Content::find($id_content);

        // Jika data tidak ditemukan, redirect dengan pesan error
        if (!$content) {
            return redirect()->route('admin.berita.index')->with('error', 'Berita tidak ditemukan');
        }

        // Kirim variabel $id_content ke view
        $data = [];
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['menu'] = 'berita-show';
        $data['session_data'] = \App\Helpers\AppHelper::instance()->getSessionData();
        $data['content'] = Content::where('type', Content::TYPE_BERITA)->findOrFail($id_content);
        $data['id_content'] = $id_content;
        $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();

        $data['kategoris'] = Category::all(); // Ambil semua kategori untuk dipilih


        return view('admin.berita.show', $data);
    }

    public function destroy($id_content)
    {
        $content = Content::where('type', Content::TYPE_BERITA)->findOrFail($id_content);
        $content->delete();

        session()->flash('message', 'Berita berhasil dihapus.');
        return redirect()->route('admin.berita.index');
    }
}
