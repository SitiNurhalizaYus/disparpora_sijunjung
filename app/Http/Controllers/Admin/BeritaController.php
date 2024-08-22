<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

            // Mengambil data berita dari API
            $response = Http::withToken($data['session_token'])->get(url('/api/content?type=berita'));

            if ($response->successful()) {
                $data['contents'] = $response->json()['data']; // Data berita dari API
            } else {
                $data['contents'] = [];
                session()->flash('message', 'Gagal mengambil data.');
            }

            return view('admin.berita.index', $data);
        } else {
            session()->flash('message', 'Session expired.');
            return redirect()->route('admin.login');
        }
    }

    public function show($id)
    {
        $data = [];
        $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();

        $response = Http::withToken($data['session_token'])->get(url("/api/content/{$id}"));

        if ($response->successful()) {
            $data['content'] = $response->json()['data'];
            return view('admin.berita.show', $data);
        } else {
            session()->flash('error', 'Data tidak ditemukan.');
            return redirect()->route('admin.berita.index');
        }
    }

    public function create()
    {
        $data = [];
        $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();
        return view('admin.berita.create', $data);
    }

    public function store(Request $request)
    {
        $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();

        $response = Http::withToken($data['session_token'])->post(url('/api/content'), [
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'type' => 'berita',
            'description_short' => $request->input('description_short'),
            'image' => $request->input('image'),
            'category_id' => $request->input('category_id'),
            'arsip_id' => $request->input('arsip_id'),
            'is_active' => $request->input('is_active'),
        ]);

        if ($response->successful()) {
            session()->flash('success', 'Data berhasil ditambahkan');
            return redirect()->route('admin.berita.index');
        } else {
            session()->flash('error', 'Gagal menambahkan data.');
            return redirect()->route('admin.berita.create');
        }
    }

    public function edit($id)
    {
        $data = [];
        $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();

        $response = Http::withToken($data['session_token'])->get(url("/api/content/{$id}"));

        if ($response->successful()) {
            $data['content'] = $response->json()['data'];
            return view('admin.berita.edit', $data);
        } else {
            session()->flash('error', 'Data tidak ditemukan.');
            return redirect()->route('admin.berita.index');
        }
    }

    public function update(Request $request, $id)
    {
        $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();

        $response = Http::withToken($data['session_token'])->put(url("/api/content/{$id}"), [
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'type' => 'berita',
            'description_short' => $request->input('description_short'),
            'image' => $request->input('image'),
            'category_id' => $request->input('category_id'),
            'arsip_id' => $request->input('arsip_id'),
            'is_active' => $request->input('is_active'),
        ]);

        if ($response->successful()) {
            session()->flash('success', 'Data berhasil diperbarui');
            return redirect()->route('admin.berita.index');
        } else {
            session()->flash('error', 'Gagal memperbarui data.');
            return redirect()->route('admin.berita.edit', $id);
        }
    }


    // Tambahkan metode lainnya seperti create, show, edit yang juga akan memanggil API dengan type=berita
}
