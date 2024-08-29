<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $data = [];
        $data['og'] = [
            'url' => url('/gallery'),
            'title' => 'Gallery',
            'description' => 'Gallery'
        ];

        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['pages'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/page');
        $data['galleries'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/gallery');

        if (empty($data['galleries']) || isset($data['galleries']['message'])) {
            return response()->json(['message' => 'No galleries found or API issue'], 404);
        }

        // If galleries data exists, continue to view
        return view('client.gallery.index', $data);
    }
}
