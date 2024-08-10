<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InformasiController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $kategoriId = 2;
        $data = [];
        try {
            $kontens = \App\Helpers\AppHelper::instance()->requestApiGet("api/konten?kategori_id={$kategoriId}");
            $data['kontens'] = $kontens;
            $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
            $data['labels'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/label');
        } catch (\Exception $e) {
            // Log error or handle exception
            $data['kontens'] = [];
            $data['setting'] = [];
            $data['labels'] = [];
        }

        $data['og'] = [
            'url' => url('/') . '/informasi',
            'title' => 'Informasi',
            'description' => 'Informasi'
        ];

        return view('client.informasi.index', $data);
    }

    public function detail($slug)
    {
        $kategoriId = 2;

        try {
            $kontens = \App\Helpers\AppHelper::instance()->requestApiGet("api/konten?kategori_id={$kategoriId}");
        } catch (\Exception $e) {
            // Log error or handle exception
            abort(404, 'Konten tidak ditemukan');
        }

        $konten = collect($kontens)->firstWhere('slug', $slug);

        if (!$konten) {
            abort(404, 'Konten tidak ditemukan');
        }

        try {
            $comments = \App\Helpers\AppHelper::instance()->requestApiGet("api/comment?konten_id={$konten['id']}");
            $arsips = \App\Helpers\AppHelper::instance()->requestApiGet('api/arsip');
            $setting = \App\Helpers\AppHelper::instance()->requestApiSetting();
            $labels = \App\Helpers\AppHelper::instance()->requestApiGet('api/label');
        } catch (\Exception $e) {
            $comments = [];
            $arsips = [];
            $setting = [];
            $labels = [];
        }

        $kontensKategori = collect($kontens)->filter(function ($item) use ($slug) {
            return isset($item['slug']) && $item['slug'] !== $slug;
        })->take(5);

        $data = [
            'konten' => $konten,
            'kontensKategori' => $kontensKategori,
            'konten_comments' => $comments,
            'og' => [
                'url' => url('/') . '/informasi/' . $konten['slug'],
                'title' => $konten['judul'],
                'description' => $konten['description_short'],
                'image' => $konten['gambar'],
            ],
            'setting' => $setting,
            'labels' => $labels,
            'arsips' => $arsips,
        ];

        return view('client.informasi.detail', $data);
    }
}
