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
        $data['og']['url'] = url('/').'/lokawisata';
        $data['og']['title'] = 'Lokawista';
        $data['og']['description'] = 'Lokawisata';
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['pages'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/page');
        $data['info_tempats'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/lokawisata');
        return view('client.lokawisata.index', $data);
   
    }

    public function detail($id)
    {
        $data = [];
        $data['info_tempat'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/lokawisata/'.$id);
        // dd($data['info_tempat']);
        $data['og'] = [];
        $data['og']['url'] = url('/').'/lokawisata/'.$data['info_tempat']['slug'];
        $data['og']['title'] = $data['info_tempat']['name'];
        $data['og']['description'] = 'Lokawisata';
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['info_tempats'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/lokawisata');
        return view('client.lokawisata.detail', $data);
    }
}
