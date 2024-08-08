<?php 
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PublikasiController extends Controller
{
    public function __construct()
    {
    }

    // Method untuk menampilkan daftar publikasi
    public function index()
    {
        $kategoriId = '2'; // Menggunakan kategori_id = 2 untuk publikasi
        $kontens = \App\Helpers\AppHelper::instance()->requestApiGet("api/konten?kategori_id={$kategoriId}");
 
        // Mengatur data yang akan dikirim ke view
        $data = [];
        $data['konten'] = $kontens;
        $data['og'] = [];
        $data['og']['url'] = url('/') . '/publikasi/' . $kontens['kategori'];
        $data['og']['title'] = $kontens['judul'];
        $data['og']['description'] = $kontens['description_short'];
        $data['og']['image'] = $kontens['gambar'];
        $data['kontens'] = $kontens;
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['kategoris'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/kategori');
        $data['tags'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/tag');
        $data['tag_kontens'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/tag_konten');

        return view('client.publikasi.index', $data);
    }

    // Method untuk menampilkan detail publikasi berdasarkan slug
    public function detail($slug)
    {
        $kategoriId = 2; // Menggunakan kategori_id = 2 untuk publikasi
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

        // Mengatur data yang akan dikirim ke view
        $data = [];
        $data['konten'] = $konten;
        $data['og'] = [];
        $data['og']['url'] = url('/') . '/publikasi/' . $konten['slug'];
        $data['og']['title'] = $konten['judul'];
        $data['og']['description'] = $konten['description_short'];
        $data['og']['image'] = $konten['gambar'];
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['kategoris'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/kategori');
        $data['tags'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/tag');
        $data['tag_kontens'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/tag_konten');

        return view('client.publikasi.detail', $data);
    }
}
