<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Helpers;

class ProfilController extends Controller
{

    public function __construct()
    {
    }

    public function detail($slug)
{
    $kategoriId = 1; // Menggunakan kategori_id = 1
    $kontens = \App\Helpers\AppHelper::instance()->requestApiGet("api/konten?kategori_id={$kategoriId}");

    // Cari konten yang sesuai dengan slug yang diberikan
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

    // Filter out the current content from the list and limit to 5 items
    $kontensKategori = collect($kontens)->filter(function ($item) use ($slug) {
        return $item['slug'] !== $slug;
    })->take(5);

    // Mengatur data yang akan dikirim ke view
    $data = [];
    $data['konten'] = $konten;
    $data['kontensKategori'] = $kontensKategori; // Konten dengan kategori_id = 1, kecuali konten yang sedang ditampilkan, dibatasi 5 entri
    $data['og'] = [];
    $data['og']['url'] = url('/') . '/profil/' . $konten['slug'];
    $data['og']['title'] = $konten['judul'];
    $data['og']['description'] = $konten['description_short'];
    $data['og']['image'] = $konten['gambar'];
    $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
    $data['kategoris'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/kategori');
    $data['labels'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/label');

    return view('client.konten.detail', $data);
}
}
