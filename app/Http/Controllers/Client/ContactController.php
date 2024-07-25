<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $data = [];
        $data['og'] = [];
        $data['og']['url'] = url('/').'/contact';
        $data['og']['title'] = 'Contact';
        $data['og']['description'] = 'Contact';
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['pages'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/page');
        $data['result'] = [];
        return view('client.contact.index', $data);
    }

    public function submit(Request $request)
    {
        $payload = $request->all();
        $data['og'] = [];
        $data['og']['url'] = url('/').'/contact';
        $data['og']['title'] = 'Contact';
        $data['og']['description'] = 'Contact';
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['pages'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/page');
        $data['result'] = \App\Helpers\AppHelper::instance()->requestApiPost('/api/review', $payload);
        return view('client.contact.index', $data);
    }
}
