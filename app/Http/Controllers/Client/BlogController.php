<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $data = [];
        $data['og'] = [];
        $data['og']['url'] = url('/').'/blog';
        $data['og']['title'] = 'Blog';
        $data['og']['description'] = 'Blog';
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['pages'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/page');
        return view('client.blog.index', $data);
    }

    public function detail($id)
    {
        $data = [];
        $data['blog'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/blog/'.$id);
        $data['og'] = [];
        $data['og']['url'] = url('/').'/blog/detail/'.$data['blog']['slug'];
        $data['og']['title'] = $data['blog']['name'];
        $data['og']['description'] = $data['blog']['description_short'];
        $data['og']['image'] = $data['blog']['image'];
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['pages'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/page');
        return view('client.blog.detail', $data);
    }
}
