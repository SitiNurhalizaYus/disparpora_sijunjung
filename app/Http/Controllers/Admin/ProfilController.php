<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Content;

class ProfilController extends Controller
{
    public function __construct() {}

    public function index()
    {
        $has_session = \App\Helpers\AppHelper::instance()->checkSession();

        if ($has_session) {
            $data = [];
            $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
            $data['menu'] = 'profil-list';
            $data['session_data'] = \App\Helpers\AppHelper::instance()->getSessionData();
            $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();

            // Mengambil data dari API
            $response = Http::withToken($data['session_token'])->get(url('/api/content?type=profil'));

            if ($response->successful()) {
                $data['contents'] = $response->json()['data']; // Data profil dari API
            } else {
                $data['contents'] = [];
                session()->flash('message', 'Gagal mengambil data.');
            }

            return view('admin.profil.index', $data);
        } else {
            session()->flash('message', 'Session expired.');
            return redirect()->route('admin.login');
        }
    }

    // Show untuk menampilkan detail data profil dari API
    public function show($id)
    {
        $data = [];
        $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();

        $response = Http::withToken($data['session_token'])->get(url("/api/content/{$id}"));

        if ($response->successful()) {
            $data['content'] = $response->json()['data'];
            return view('admin.profil.show', $data);
        } else {
            session()->flash('error', 'Data tidak ditemukan.');
            return redirect()->route('admin.profil.index');
        }
    }

    // Create untuk menampilkan form tambah data profil
    public function create()
    {
        $data = [];
        $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();
        return view('admin.profil.create', $data);
    }

    // Store untuk menambahkan data baru ke API
    public function store(Request $request)
    {
        $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();

        $response = Http::withToken($data['session_token'])->post(url('/api/content'), [
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'type' => 'profil',
            'description_short' => $request->input('description_short'),
            'image' => $request->input('image'),
            'is_active' => $request->input('is_active'),
        ]);

        if ($response->successful()) {
            session()->flash('success', 'Data berhasil ditambahkan');
            return redirect()->route('admin.profil.index');
        } else {
            session()->flash('error', 'Gagal menambahkan data.');
            return redirect()->route('admin.profil.create');
        }
    }

    // Edit untuk menampilkan form edit data profil
    public function edit($id)
    {
        $data = [];
        $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();

        $response = Http::withToken($data['session_token'])->get(url("/api/content/{$id}"));

        if ($response->successful()) {
            $data['content'] = $response->json()['data'];
            return view('admin.profil.edit', $data);
        } else {
            session()->flash('error', 'Data tidak ditemukan.');
            return redirect()->route('admin.profil.index');
        }
    }

    // Update untuk menyimpan perubahan data profil ke API
    public function update(Request $request, $id)
    {
        $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();

        $response = Http::withToken($data['session_token'])->put(url("/api/content/{$id}"), [
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'type' => 'profil',
            'description_short' => $request->input('description_short'),
            'image' => $request->input('image'),
            'is_active' => $request->input('is_active'),
        ]);

        if ($response->successful()) {
            session()->flash('success', 'Data berhasil diperbarui');
            return redirect()->route('admin.profil.index');
        } else {
            session()->flash('error', 'Gagal memperbarui data.');
            return redirect()->route('admin.profil.edit', $id);
        }
    }
}
