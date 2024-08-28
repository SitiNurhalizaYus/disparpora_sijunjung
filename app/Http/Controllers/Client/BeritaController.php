<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type', 'berita');

        // Memanggil API untuk mendapatkan data konten berdasarkan tipe berita
        $contents = collect(\App\Helpers\AppHelper::instance()->requestApiGet("api/content"))
            ->filter(function ($item) use ($type) {
                return $item['type'] === $type;
            });
        // dd($contents);

            // Jika data tidak ditemukan, mungkin ada masalah dengan API atau pemanggilannya
        if ($contents->isEmpty()) {
            abort(404, 'Tidak ada konten berita yang ditemukan.');
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
                'title' => 'Berita',
                'description' => 'Berita Terbaru'
            ]
        ];

        return view('client.berita.index', $data);
    }



    public function detail($id_berita, Request $request)
    {
        $type = $request->get('type', 'berita');

        // Tetap menggunakan endpoint API 'content'
        $content = collect(\App\Helpers\AppHelper::instance()->requestApiGet("api/content/{$id_berita}?type={$type}"))->first();

        if (!$content) {
            abort(404, 'Berita tidak ditemukan');
        }

        $recentPosts = collect(\App\Helpers\AppHelper::instance()->requestApiGet("api/content?type={$type}&limit=5"));
        $categories = collect(\App\Helpers\AppHelper::instance()->requestApiGet("api/categories"));

        $data = [
            'content' => $content,
            'recentPosts' => $recentPosts,
            'categories' => $categories,
            'og' => [
                'url' => url("/berita/{$id_berita}"),
                'title' => $content['title'],
                'description' => $content['description_short'],
                'image' => $content['image'],
            ],
            'setting' => \App\Helpers\AppHelper::instance()->requestApiSetting()
        ];

        return view('client.berita.detail', $data);
    }

    public function detailWithCategory($id_berita, Request $request)
    {
        $type = $request->get('type', 'berita');
        $category_id = $request->get('category_id', null);

        // Tetap menggunakan endpoint API 'content'
        $content = collect(\App\Helpers\AppHelper::instance()->requestApiGet("api/content/{$id_berita}?type={$type}&category_id={$category_id}"))->first();

        if (!$content) {
            abort(404, 'Berita tidak ditemukan');
        }

        $recentPosts = collect(\App\Helpers\AppHelper::instance()->requestApiGet("api/content?type={$type}&category_id={$category_id}&limit=5"));
        $categories = collect(\App\Helpers\AppHelper::instance()->requestApiGet("api/categories"));

        $data = [
            'content' => $content,
            'recentPosts' => $recentPosts,
            'categories' => $categories,
            'og' => [
                'url' => url("/berita/{$id_berita}?category_id={$category_id}"),
                'title' => $content['title'],
                'description' => $content['description_short'],
                'image' => $content['image'],
            ],
            'setting' => \App\Helpers\AppHelper::instance()->requestApiSetting()
        ];

        return view('client.berita.index', $data);
    }
}
