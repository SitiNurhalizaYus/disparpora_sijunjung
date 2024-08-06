<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function __construct()
    {
        // Optional: middleware or other initializations
    }

    public function profil($slug)
    {
        // Mapping slug ke view
        $slugMethodViewMapping = [
            'struktur-organisasi-dinas' => 'client.profil.struktur',
            'visi-misi' => 'client.profil.visimisi',
            'tujuan-strategis' => 'client.profil.tujuan',
            'sasaran-strategis' => 'client.profil.sasaran',
        ];

        // Periksa apakah slug ada dalam mapping
        if (!array_key_exists($slug, $slugMethodViewMapping)) {
            abort(404, 'Konten tidak ditemukan');
        }

        // Ambil konten berdasarkan slug
        $konten = $this->getContenBySlug($slug);

        if (!$konten) {
            abort(404, 'Konten tidak ditemukan');
        }

        // Tentukan view berdasarkan slug
        $view = $slugMethodViewMapping[$slug];

        // Mengatur data yang akan dikirim ke view
        $data = [
            'konten' => $konten,
            'og' => [
                'url' => url('/profil/' . $konten['slug']),
                'title' => $konten['judul'],
                'description' => $konten['description_short'],
                'image' => $konten['gambar']
            ]
        ];
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();        
        $data['kategoris'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/kategori');
        $data['tags'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/tag');
        $data['tag_kontens'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/tag_konten');

        // Mengembalikan view yang sesuai dengan data yang sudah disiapkan
        return view($view, $data);
    }

    private function getContenBySlug($slug)
    {
        // Mengambil konten berdasarkan slug
        $response = \App\Helpers\AppHelper::instance()->requestApiGet("api/konten/{$slug}");

        if (!$response) {
            abort(404, 'Konten tidak ditemukan');
        }

        return $response;
    }
}
