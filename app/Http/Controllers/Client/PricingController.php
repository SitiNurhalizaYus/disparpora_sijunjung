<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PricingController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $data = [];
        $data['og'] = [];
        $data['og']['url'] = url('/').'/pricing';
        $data['og']['title'] = 'Pricing';
        $data['og']['description'] = 'Pricing';
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['pages'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/page');
        $data['pricings'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/pricing');
        return view('client.pricing.index', $data);
    }
}
