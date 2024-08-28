<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HubungikamiController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $data = [];
        $data['og'] = [];
        $data['og']['url'] = url('/').'/message';
        $data['og']['title'] = 'Message';
        $data['og']['description'] = 'Message';
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['pages'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/page');
        $data['result'] = [];
        return view('client.message.index', $data);
    }

    public function submit(Request $request)
    {
        $payload = $request->all();
        $data['og'] = [];
        $data['og']['url'] = url('/').'/message';
        $data['og']['title'] = 'Message';
        $data['og']['description'] = 'Message';
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['pages'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/page');
        $data['result'] = \App\Helpers\AppHelper::instance()->requestApiPost('/api/message', $payload);
        return view('client.message.index', $data);
    }
}
