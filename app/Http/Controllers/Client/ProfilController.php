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
        // Mapping slug ke metode dan view
        $slugMethodViewMapping = [
            'struktur-organisasi-dinas' => [
                'method' => 'getStrukturOrganisasi',
                'view' => 'client.profil.struktur'
            ],
            'visi-misi' => [
                'method' => 'getVisi',
                'view' => 'client.profil.visimisi'
            ],
            'tujuan-strategis' => [
                'method' => 'getTujuan',
                'view' => 'client.profil.tujuan'
            ],
            'sasaran-strategis' => [
                'method' => 'getSasaran',
                'view' => 'client.profil.sasaran'
            ],
        ];

        // Periksa apakah slug ada dalam mapping
        if (!array_key_exists($slug, $slugMethodViewMapping)) {
            abort(404, 'Konten tidak ditemukan');
        }

        // Panggil metode yang sesuai berdasarkan slug
        $method = $slugMethodViewMapping[$slug]['method'];
        $view = $slugMethodViewMapping[$slug]['view'];
        $konten = $this->$method();

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

    private function getStrukturOrganisasi()
    {
        $konten = \App\Helpers\AppHelper::instance()->requestApiGet('api/konten/struktur-organisasi-dinas');

        if (!$konten) {
            abort(404, 'Konten tidak ditemukan');
        }

        return $konten;
    }

    private function getVisi()
    {
        $konten = \App\Helpers\AppHelper::instance()->requestApiGet('api/konten/visi-misi');

        if (!$konten) {
            abort(404, 'Konten tidak ditemukan');
        }

        return $konten;
    }

    private function getTujuan()
    {
        $konten = \App\Helpers\AppHelper::instance()->requestApiGet('api/konten/tujuan-strategis');

        if (!$konten) {
            abort(404, 'Konten tidak ditemukan');
        }

        return $konten;
    }

    private function getSasaran()
    {
        $konten = \App\Helpers\AppHelper::instance()->requestApiGet('api/konten/sasaran-strategis');

        if (!$konten) {
            abort(404, 'Konten tidak ditemukan');
        }

        return $konten;
    }
}
