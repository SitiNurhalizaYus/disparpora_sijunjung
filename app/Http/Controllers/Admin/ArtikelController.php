<?php

namespace App\Http\Controllers\Admin;

use App\Models\Content;
use App\Models\Category;
use App\Models\Arsip;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArtikelController extends Controller
{
    public function __construct() {

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
            $data['contents'] = Content::where('type', Content::TYPE_BERITA)->paginate(10); // Hanya mengambil konten dengan tipe 'artikel'
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

        $data['categories'] = Category::all(); // Ambil semua kategori untuk dipilih
        $data['arsips'] = Arsip::all(); // Ambil arsip untuk dipilih (opsional)

        return view('admin.artikel.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'slug' => 'required|unique:contents,slug',
            'category_id' => 'required|exists:categories,id_category',
            'arsip_id' => 'nullable|exists:arsips,id', // Opsional, jika arsip ada
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['type'] = 'artikel'; // Mengatur tipe sebagai artikel
        $data['created_by'] = auth()->id(); // Set user yang membuat artikel

        Content::create($data);

        session()->flash('message', 'Berita berhasil ditambahkan.');
        return redirect()->route('admin.artikel.index');
    }

    public function edit($id_content)
    {
        $data = [];
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['menu'] = 'artikel-edit';
        $data['session_data'] = \App\Helpers\AppHelper::instance()->getSessionData();
        $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();
        $data['content'] = Content::where('type', Content::TYPE_BERITA)->findOrFail($id_content);

        $data['categories'] = Category::all(); // Ambil semua kategori untuk dipilih
        $data['arsips'] = Arsip::all(); // Ambil arsip untuk dipilih (opsional)

        return view('admin.artikel.edit', $data);
    }

    public function update(Request $request, $id_content)
    {
        $content = Content::where('type', Content::TYPE_BERITA)->findOrFail($id_content);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'slug' => 'required|unique:contents,slug,' . $content->id_content,
            'category_id' => 'required|exists:categories,id_category',
            'arsip_id' => 'nullable|exists:arsips,id', // Opsional, jika arsip ada
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['updated_by'] = auth()->id(); // Set user yang mengupdate artikel

        $content->update($data);

        session()->flash('message', 'Berita berhasil diperbarui.');
        return redirect()->route('admin.artikel.index');
    }

    public function show($id_content)
    {
        // Ambil data artikel dari model berdasarkan id_content
        $content = Content::where('type', Content::TYPE_BERITA)->findOrFail($id_content);

        $data = [];
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['menu'] = 'artikel-show';
        $data['session_data'] = \App\Helpers\AppHelper::instance()->getSessionData();
        $data['content'] = $content;
        $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();

        return view('admin.artikel.show', $data);
    }

    public function destroy($id_content)
    {
        $content = Content::where('type', Content::TYPE_BERITA)->findOrFail($id_content);
        $content->delete();

        session()->flash('message', 'Berita berhasil dihapus.');
        return redirect()->route('admin.artikel.index');
    }
}
