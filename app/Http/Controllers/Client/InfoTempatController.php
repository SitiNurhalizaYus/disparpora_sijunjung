<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InfoTempatController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $data = [];
        $data['og'] = [];
        $data['og']['url'] = url('/').'/infotempat';
        $data['og']['title'] = 'InfoTempat';
        $data['og']['description'] = 'infotempat';
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['pages'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/page');
        $data['info_tempats'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/lokawisata');
        return view('client.lokawisata.index', $data);
            // Tambahkan ini untuk debug
   
    }

    public function detail($id)
    {
        $data = [];
        $data['info_tempats'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/lokawisata/'.$id);
        $data['og'] = [];
        $data['og']['url'] = url('/').'/lokawisata/detail/'.$data['info_tempats']['slug'];
        $data['og']['title'] = $data['info_tempats']['name'];
        $data['og']['description'] = 'infotempat';
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['pages'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/page');
        return view('client.lokawisata.detail', $data);
    }
}
