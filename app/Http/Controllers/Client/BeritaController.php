<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Helpers;

class BeritaController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $data = [];
        $data['og'] = [];
        $data['og']['url'] = url('/').'/berita';
        $data['og']['title'] = 'Berita';
        $data['og']['description'] = 'Daftar Berita';
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['contents'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/content');
        
        // Tidak memuat konten di sini, karena konten akan diambil melalui AJAX
        return view('client.berita.index', $data);
    }

    public function detail($id_content)
    {
        $data = [];
        $data['berita'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/content/'.$id_content.'?type=berita');
        $data['og'] = [];
        $data['og']['url'] = url('/').'/berita/'.$data['berita']['slug'];
        $data['og']['title'] = $data['berita']['title'];
        $data['og']['description'] = $data['berita']['description_short'];
        $data['og']['image'] = $data['berita']['image'];
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['contents'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/content');
        
        return view('client.berita.detail', $data);
    }
}
