<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InformasiController extends Controller
{
    public function __construct()
    {
    }

    // Method untuk menampilkan daftar informasi
    public function index()
    {
        $kategoriId = 2;
        $kontens = \App\Helpers\AppHelper::instance()->requestApiGet("api/konten?kategori_id={$kategoriId}");
        // dd($kategoriId, $kontens);

        // Mengatur data yang akan dikirim ke view
        $data = [];
        $data['kontens'] = $kontens;
        $data['og'] = [];
        $data['og']['url'] = url('/').'/informasi';
        $data['og']['title'] = 'Informasi';
        $data['og']['description'] = 'Informasi';
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['kategoris'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/kategori');
        $data['tags'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/tag');
        $data['tag_kontens'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/tag_konten');

        return view('client.informasi.index', $data);
    }

    // Method untuk menampilkan detail informasi berdasarkan slug
    public function detail($slug)
    {
        $kategoriId = 2; // Menggunakan kategori_id = 2
        
        // Mengambil daftar konten
        $kontens = \App\Helpers\AppHelper::instance()->requestApiGet("api/konten?kategori_id={$kategoriId}");

        // Mencari konten yang sesuai dengan slug yang diberikan
        $konten = null;
        foreach ($kontens as $k) {
            if ($k['slug'] == $slug) {
                $konten = $k;
                break;
            }
        }

        // Jika konten tidak ditemukan, tampilkan halaman 404
        if (!$konten) {
            abort(404, 'Konten tidak ditemukan');
        }

        // Mengambil komentar untuk konten ini
        $comments = \App\Helpers\AppHelper::instance()->requestApiGet("api/comments?konten_id={$konten['id']}");

        // Filter konten dari kategori yang sama kecuali konten yang sedang ditampilkan dan batasi 5 entri
        $kontensKategori = collect($kontens)->filter(function ($item) use ($slug) {
            return $item['slug'] !== $slug;
        })->take(5);

        // Mengatur data yang akan dikirim ke view
        $data = [];
        $data['konten'] = $konten;
        $data['konten']['comments'] = $comments; // Menambahkan komentar ke data
        $data['kontensKategori'] = $kontensKategori; // Konten dengan kategori_id = 2, kecuali konten yang sedang ditampilkan, dibatasi 5 entri
        $data['og'] = [];
        $data['og']['url'] = url('/') . '/informasi/' . $konten['slug'];
        $data['og']['title'] = $konten['judul'];
        $data['og']['description'] = $konten['description_short'];
        $data['og']['image'] = $konten['gambar'];
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['kategoris'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/kategori');
        $data['tags'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/tag');
        $data['tag_kontens'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/tag_konten');

        return view('client.informasi.detail', $data);
    }

}
