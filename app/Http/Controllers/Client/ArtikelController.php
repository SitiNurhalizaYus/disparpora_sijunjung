<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Helpers;

class ArtikelController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $data = [];
        $data['og'] = [];
        $data['og']['url'] = url('/').'/artikel';
        $data['og']['title'] = 'Artikel';
        $data['og']['description'] = 'Daftar Artikel';
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['contents'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/content');
        
        // Tidak memuat konten di sini, karena konten akan diambil melalui AJAX
        return view('client.artikel.index', $data);
    }

    public function detail($id_content)
    {
        $data = [];
        $data['artikel'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/content/'.$id_content.'?type=artikel');
        $data['og'] = [];
        $data['og']['url'] = url('/').'/artikel/'.$data['artikel']['slug'];
        $data['og']['title'] = $data['artikel']['title'];
        $data['og']['description'] = $data['artikel']['description_short'];
        $data['og']['image'] = $data['artikel']['image'];
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['contents'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/content');
        
        return view('client.artikel.detail', $data);
    }
}
