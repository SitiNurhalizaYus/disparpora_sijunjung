<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Helpers;

class HomeController extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {
        $data = [];
        $data['og'] = [];
        $data['og']['url'] = url('/').'/home';
        $data['og']['title'] = 'Home';
        $data['og']['description'] = 'Home';
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting(); 
        $data['pages'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/page');
        $data['sliders'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/slider');
        $data['big_numbers'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/big_number');
        $data['teams'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/team');
        $data['partners'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/partner');
        $data['testimonies'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/testimony');
        return view('client.home.index', $data);
    }
}
