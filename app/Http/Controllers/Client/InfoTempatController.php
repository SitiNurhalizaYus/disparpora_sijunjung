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
        $data['infotempats'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/infotempat');
        return view('client.lokawisata.index', $data);
    }

    public function detail($id)
    {
        $data = [];
        $data['infotempats'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/infotempat/'.$id);
        $data['og'] = [];
        $data['og']['url'] = url('/').'/lokawisata/detail/'.$data['infotempats']['slug'];
        $data['og']['title'] = $data['interships']['name'];
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['pages'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/page');
        return view('client.internship.detail', $data);
    }
}
