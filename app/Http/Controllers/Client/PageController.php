<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function __construct()
    {
    }

    public function detail($id)
    {
        $data = [];
        $data['page'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/page/'.$id);
        $data['og'] = [];
        $data['og']['url'] = url('/').'/page/'.$data['page']['slug'];
        $data['og']['title'] = $data['page']['name'];
        $data['og']['description'] = $data['page']['description_short'];
        $data['og']['image'] = $data['page']['image'];
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['pages'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/page');
        return view('client.page.detail', $data);
    }
}
