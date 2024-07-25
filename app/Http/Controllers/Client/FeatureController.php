<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $data = [];
        $data['og'] = [];
        $data['og']['url'] = url('/').'/feature';
        $data['og']['title'] = 'Feature';
        $data['og']['description'] = 'Feature';
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['pages'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/page');
        $data['features'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/feature');
        return view('client.feature.index', $data);
    }
}
