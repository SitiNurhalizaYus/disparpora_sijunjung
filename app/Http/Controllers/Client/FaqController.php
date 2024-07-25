<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $data = [];
        $data['og'] = [];
        $data['og']['url'] = url('/').'/faq';
        $data['og']['title'] = 'Faq';
        $data['og']['description'] = 'Faq';
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['pages'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/page');
        $data['faqs'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/faq');
        return view('client.faq.index', $data);
    }
}
