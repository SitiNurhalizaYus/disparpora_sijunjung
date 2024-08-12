<?php

namespace App\Http\Controllers\Client;

use App\Models\Konten;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BeritaController extends Controller
{
    public function index()
    {
        $kategoriId = 2;
        
        // Mengambil konten berdasarkan kategori
        $kontens = collect(\App\Helpers\AppHelper::instance()->requestApiGet("api/konten?kategori_id={$kategoriId}"));

        // Mengambil recent posts, yaitu konten terbaru yang tidak ada dalam $kontens
        $recentPosts = Konten::where('kategori_id', $kategoriId)
                            ->whereNotIn('id', $kontens->pluck('id'))
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();
        
        // Mengambil setting, label, dan data lainnya
        $data = [
            'kontens' => $kontens,
            'recentPosts' => $recentPosts,
            'setting' => \App\Helpers\AppHelper::instance()->requestApiSetting(),
            'labels' => \App\Helpers\AppHelper::instance()->requestApiGet('api/label'),
            'og' => [
                'url' => url('/berita'),
                'title' => 'Berita',
                'description' => 'Berita'
            ]
        ];
        
        // Mengembalikan view index dengan data
        return view('client.berita.index', $data);
    }
    
    public function detail($slug)
    {
        $kategoriId = 2;
        
        // Mengambil semua konten berdasarkan kategori
        $kontens = collect(\App\Helpers\AppHelper::instance()->requestApiGet("api/konten?kategori_id={$kategoriId}"));
        
        // Menemukan konten berdasarkan slug
        $konten = $kontens->firstWhere('slug', $slug);
        
        if (!$konten) {
            abort(404, 'Konten tidak ditemukan');
        }

        // Mengambil recent posts yang tidak termasuk dalam konten yang ditemukan
        $recentPosts = Konten::where('kategori_id', $kategoriId)
                            ->whereNotIn('id', $kontens->pluck('id'))
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();

        // Mengambil komentar, arsip, dan label
        $comments = \App\Helpers\AppHelper::instance()->requestApiGet("api/comment?konten_id={$konten['id']}");
        $arsips = \App\Helpers\AppHelper::instance()->requestApiGet('api/arsip');
        $setting = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $labels = \App\Helpers\AppHelper::instance()->requestApiGet('api/label');

        // Mengambil konten terkait dalam kategori yang sama
        $kontensKategori = $kontens->filter(function ($item) use ($slug) {
            return isset($item['slug']) && $item['slug'] !== $slug;
        })->take(5);

        $data = [
            'konten' => $konten,
            'kontensKategori' => $kontensKategori,
            'recentPosts' => $recentPosts,
            'konten_comments' => $comments,
            'og' => [
                'url' => url('/berita/' . $konten['slug']),
                'title' => $konten['judul'],
                'description' => $konten['description_short'],
                'image' => $konten['gambar'],
            ],
            'setting' => $setting,
            'labels' => $labels,
            'arsips' => $arsips,
        ];

        // Mengembalikan view detail dengan data
        return view('client.berita.detail', $data);
    }

    public function showByLabel($labelId)
    {
        $kategoriId = 2; // Hanya mengambil kategori dengan ID 2

        // Mengambil konten berdasarkan kategori dan label
        $kontens = collect(\App\Helpers\AppHelper::instance()->requestApiGet("api/konten?kategori_id={$kategoriId}&label_id={$labelId}"));
dd($kontens);
        // Mengambil recent posts yang tidak termasuk dalam konten yang ditemukan
        $recentPosts = Konten::where('kategori_id', $kategoriId)
                            ->whereNotIn('id', $kontens->pluck('id'))
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();

        // Menemukan label berdasarkan ID
        $label = collect(\App\Helpers\AppHelper::instance()->requestApiGet('api/label'))->firstWhere('id', $labelId);

        if (!$label) {
            abort(404, 'Label tidak ditemukan');
        }

        $data = [
            'kontens' => $kontens,
            'recentPosts' => $recentPosts,
            'label' => $label,
            'setting' => \App\Helpers\AppHelper::instance()->requestApiSetting(),
            'labels' => \App\Helpers\AppHelper::instance()->requestApiGet('api/label'),
            'og' => [
                'url' => url('/berita/label/' . $kategoriId .$labelId),
                'title' => 'Berita: ' . $label['name'],
                'description' => 'Berita berdasarkan label: ' . $label['name']
            ]
        ];

        // Mengembalikan view berdasarkan label dengan data
        return view('client.berita.bylabel', $data);
    }

}
