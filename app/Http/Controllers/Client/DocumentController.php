<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $data = [];
        $data['og'] = [];
        $data['og']['url'] = url('/').'/document';
        $data['og']['title'] = 'Document';
        $data['og']['description'] = 'Document';
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['pages'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/page');
        $data['documents'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/document');
        return view('client.document.index', $data);
    }
}
