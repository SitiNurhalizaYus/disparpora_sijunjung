<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Helpers;

class ProfilController extends Controller
{
    public function __construct()
    {
    }

    public function detail($id_content)
    {
        $data = [];
        $data['profil'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/content/'.$id_content.'?type=profil');
        $data['og'] = [];
        $data['og']['url'] = url('/').'/profil/'.$data['profil']['slug'];
        $data['og']['title'] = $data['profil']['title'];
        $data['og']['description'] = $data['profil']['description_short'];
        $data['og']['image'] = $data['profil']['image'];
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['contents'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/content');
        
        return view('client.profil.detail', $data);
    }
}
