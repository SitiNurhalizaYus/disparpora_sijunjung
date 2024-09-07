<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Helpers;

class StatistikController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        // Ambil data statistik dari API menggunakan helper
        $data = [];
        
        // Data Open Graph untuk SEO dan sharing
        $data['og'] = [];
        $data['og']['url'] = url('/').'/statistik';
        $data['og']['title'] = 'Statistik Informasi Publik';
        $data['og']['description'] = 'Menampilkan statistik halaman yang paling sering dikunjungi.';
        $data['og']['image'] = asset('path/to/default/statistics-image.jpg'); // Sesuaikan dengan gambar default atau yang relevan
        
        // Mengambil setting umum dari API (jika ada setting yang diperlukan untuk layout)
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['statistik'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/statistik');

        // Menampilkan statistik dan meta ke dalam view
        return view('client.statistik.index', $data);
    }
}
