<?php

namespace App\Http\Controllers\Admin;

use App\Models\Content;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BeritaController extends Controller
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

    public function show($id_content)
    {
        $data = [];
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['menu'] = 'berita-show';
        $data['session_data'] = \App\Helpers\AppHelper::instance()->getSessionData();
        $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();
        $data['id_content'] = $id_content;

        $content = Content::findOrFail($id_content);

        $category = Category::find($content->category_id);

        $data['content'] = $content;
        $data['name_category'] = $category ? $category->name : 'Kategori tidak ditemukan';

        return view('admin.berita.show', $data);
    }

    public function create()
    {
        $data = [];
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['menu'] = 'berita-create';
        $data['session_data'] = \App\Helpers\AppHelper::instance()->getSessionData();
        $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();
      
        $categories = Category::all()->unique('name');
        $data['categories'] = $categories;

        return view('admin.berita.create', $data);
    }

    public function edit($id_content)
    {
        $data = [];
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['menu'] = 'berita-edit';
        $data['session_data'] = \App\Helpers\AppHelper::instance()->getSessionData();
        $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();
        $data['id_content'] = $id_content;

        $content = Content::findOrFail($id_content);
        $categories = Category::all()->unique('name');
        
        $data['content'] = $content;
        $data['categories'] = $categories;

        return view('admin.berita.edit', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'slug' => 'required|unique:contents,slug',
            'category_id' => 'required|exists:categories,id_category',
            'is_active' => 'boolean',
        ]);

        // Membuat slug yang unik
        $slug = $this->generateUniqueSlug($request->input('title'));

        $data = $request->all();
        $data = $request->$slug;
        $data['type'] = 'berita';

        Content::create($data);

        return view('admin.berita.create', $data);
        // session()->flash('message', 'Berita berhasil ditambahkan.');
        // return redirect()->to(url('/admin/berita'))->with('success', 'Data berhasil disimpan!');

    }

    public function update(Request $request, $id_content)
    {
        $content = Content::findOrFail($id_content);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'slug' => 'required|unique:contents,slug,' . $content->id_content,
            'category_id' => 'required|exists:categories,id_category',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $content->update($data);

        session()->flash('message', 'Berita berhasil diperbarui.');
        return redirect()->to(url('/admin/berita'))->with('success', 'Data berhasil disimpan!');

    }

    public function destroy($id_content)
    {
        $content = Content::findOrFail($id_content);
        $content->delete();

        session()->flash('message', 'Berita berhasil dihapus.');
        return redirect()->to(url('/admin/berita'))->with('success', 'Data berhasil disimpan!');

    }

    private function generateUniqueSlug($title) {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;
    
        while (Content::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }
    
        return $slug;
    }
    
}
