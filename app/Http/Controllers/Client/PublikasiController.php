<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PublikasiController extends Controller
{
    public function __construct()
    {
        // Optional: middleware or other initializations
    }

    public function publikasi($slug)
    {
        // Mapping slug ke view
        $slugMethodViewMapping = [
            'struktur-organisasi-dinas' => 'client.publikasi.informasi',
            'visi-misi' => 'client.publikasi.produkhukum',
            'tujuan-strategis' => 'client.publikasi.keuangan',
            'sasaran-strategis' => 'client.publikasi.kinerja',
            'sasaran-strategis' => 'client.publikasi.renja',
            'sasaran-strategis' => 'client.publikasi.renstra',
            'sasaran-strategis' => 'client.publikasi.pengadaan',
            'sasaran-strategis' => 'client.publikasi.aset',
            'sasaran-strategis' => 'client.publikasi.prosedur',
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
                'url' => url('/publikasi/' . $konten['slug']),
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
