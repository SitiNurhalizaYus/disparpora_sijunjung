<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Visimisiontroller extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $data = [];
        $data['og'] = [];
        $data['og']['url'] = url('/').'/visimisi';
        $data['og']['title'] = 'Visimisi';
        $data['og']['description'] = 'visimisi';
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['pages'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/page');
        $data['pages'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/kategori');
        $data['pages'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/konten');
        return view('client.visimisi.index', $data);
    }
}
