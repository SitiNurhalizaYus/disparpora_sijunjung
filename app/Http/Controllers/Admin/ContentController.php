<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Content;

class ContentController extends Controller
{
    public function index()
    {
        $has_session = \App\Helpers\AppHelper::instance()->checkSession();

        if ($has_session) {
            $data = [];
            $data['profil'] = Content::where('type', 'profil')->get();
            $data['artikel'] = Content::with(['category', 'arsip'])->where('type', 'artikel')->get();
            $data['berita'] = Content::with(['category', 'arsip'])->where('type', 'berita')->get();
            $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
            $data['menu'] = 'content-list';
            $data['session_data'] = \App\Helpers\AppHelper::instance()->getSessionData();
            $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();
            return view('admin.content.index', $data);
        } else {
            session()->flash('message', 'Session expired.');
            return redirect()->route('admin.login');
        }
    }

    public function show($id)
    {
        $content = Content::with(['category', 'arsip'])->findOrFail($id);

        if ($content->type === 'profil') {
            $content->load([]);
        }

        $data = [];
        $data['content'] = $content;
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['menu'] = 'content-show';
        $data['session_data'] = \App\Helpers\AppHelper::instance()->getSessionData();
        $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();
        return view('admin.content.show', $data);
    }

    public function create()
    {
        $data = [];
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['menu'] = 'content-create';
        $data['session_data'] = \App\Helpers\AppHelper::instance()->getSessionData();
        $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();
        return view('admin.content.create', $data);
    }

    public function edit($id)
    {
        $content = Content::with(['category', 'arsip'])->findOrFail($id);

        if ($content->type === 'profil') {
            $content->load([]);
        }

        $data = [];
        $data['content'] = $content;
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['menu'] = 'content-edit';
        $data['session_data'] = \App\Helpers\AppHelper::instance()->getSessionData();
        $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();
        return view('admin.content.edit', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:contents',
            'content' => 'required',
            'type' => 'required|in:berita,artikel,profil',
            'is_active' => 'boolean',
        ]);

        $content = Content::create($request->all());

        return redirect()->route('admin.content.index')->with('success', 'Konten berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:contents,slug,' . $id,
            'content' => 'required',
            'type' => 'required|in:berita,artikel,profil',
            'is_active' => 'boolean',
        ]);

        $content = Content::findOrFail($id);
        $content->update($request->all());

        return redirect()->route('admin.content.index')->with('success', 'Konten berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $content = Content::findOrFail($id);
        $content->delete();

        return redirect()->route('admin.content.index')->with('success', 'Konten berhasil dihapus.');
    }
}
