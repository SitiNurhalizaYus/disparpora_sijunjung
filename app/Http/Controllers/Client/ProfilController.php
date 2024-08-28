<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\AppHelper;

class ProfilController extends Controller
{
    public function detail($slug)
    {
        $type = 'profil'; // Menggunakan type 'profil'
        $kontens = collect(AppHelper::instance()->requestApiGet("api/content?type={$type}"));

        // Cari konten yang sesuai dengan slug yang diberikan
        $konten = $kontens->firstWhere('slug', $slug);

        // Jika konten tidak ditemukan, tampilkan halaman 404
        if (!$konten) {
            abort(404, 'Konten tidak ditemukan');
        }

        // Filter konten untuk kategori yang sama, kecuali konten saat ini
        $kontensKategori = $kontens->filter(function ($item) use ($slug) {
            return $item['slug'] !== $slug;
        })->take(5);

        // Mengatur data yang akan dikirim ke view
        $data = [
            'konten' => $konten,
            'kontensKategori' => $kontensKategori,
            'og' => [
                'url' => url('/profil/' . $konten['slug']),
                'title' => $konten['title'],
                'description' => $konten['description_short'],
                'image' => $konten['image'],
            ],
            'setting' => AppHelper::instance()->requestApiSetting(),
        ];

        return view('client.konten.detail', $data);
    }
}
