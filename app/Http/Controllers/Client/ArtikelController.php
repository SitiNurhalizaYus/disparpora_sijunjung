<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type', 'artikel');

        // Memanggil API untuk mendapatkan data konten berdasarkan tipe artikel
        $contents = collect(\App\Helpers\AppHelper::instance()->requestApiGet("api/content"))
            ->filter(function ($item) use ($type) {
                return $item['type'] === $type;
            });
        // dd($contents);

            // Jika data tidak ditemukan, mungkin ada masalah dengan API atau pemanggilannya
        if ($contents->isEmpty()) {
            abort(404, 'Tidak ada konten artikel yang ditemukan.');
        }

        // Mengambil recent posts dari API
        $recentPosts = collect(\App\Helpers\AppHelper::instance()->requestApiGet("api/content?limit=5"))
            ->filter(function ($item) use ($type) {
                return $item['type'] === $type;
            });
        // Mengambil kategori untuk sidebar dari API
        $categories = collect(\App\Helpers\AppHelper::instance()->requestApiGet("api/category"));

        $setting = \App\Helpers\AppHelper::instance()->requestApiSetting();

        $data = [
            'contents' => $contents,
            'recentPosts' => $recentPosts,
            'categories' => $categories,
            'setting' => $setting,
            'og' => [
                'url' => url('/content'),
                'title' => 'Artikel',
                'description' => 'Artikel Terbaru'
            ]
        ];

        return view('client.artikel.index', $data);
    }

    public function detail($id_content, Request $request)
    {
        $type = $request->get('type', 'artikel');

        // Tetap menggunakan endpoint API 'content'
        $content = collect(\App\Helpers\AppHelper::instance()->requestApiGet("api/content/{$id_content}?type={$type}"))->first();

        if (!$content) {
            abort(404, 'Artikel tidak ditemukan');
        }

        $recentPosts = collect(\App\Helpers\AppHelper::instance()->requestApiGet("api/content?type={$type}&limit=5"));
        $categories = collect(\App\Helpers\AppHelper::instance()->requestApiGet("api/category"));

        $data = [
            'content' => $content,
            'recentPosts' => $recentPosts,
            'categories' => $categories,
            'og' => [
                'url' => url("/artikel/{$id_content}"),
                'title' => $content['title'],
                'description' => $content['description_short'],
                'image' => $content['image'],
            ],
            'setting' => \App\Helpers\AppHelper::instance()->requestApiSetting()
        ];

        return view('client.artikel.detail', $data);
    }
}
