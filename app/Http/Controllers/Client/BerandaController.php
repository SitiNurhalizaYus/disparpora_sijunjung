<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Helpers;

class BerandaController extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {
        $data = [];
        $data['og'] = [];
        $data['og']['url'] = url('/').'/beranda';
        $data['og']['title'] = 'Beranda';
        $data['og']['description'] = 'beranda';
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting(); 
        $data['kontens'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/konten');
        $data['sliders'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/slider');
        $data['big_numbers'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/big_number');
        $data['teams'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/team');
        $data['partners'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/partner');
        $data['testimonies'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/testimony');
        return view('client.beranda.index', $data);
    }
}
