<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VirtualTourController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $data = [];
        $data['og'] = [];
        $data['og']['url'] = url('/').'/virtual_tour';
        $data['og']['title'] = 'Virtual-Tours';
        $data['og']['description'] = 'Virtual-Tours';
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['pages'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/page');
        $data['virtual_tours'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/virtual_tour');
        return view('client.virtual_tour.index', $data);
   
    }

    public function detail($id)
{
    $data = [];

    // Ambil data dari API
    $response = \App\Helpers\AppHelper::instance()->requestApiGet('api/virtual_tour/'.$id);

    // Periksa apakah respons sukses dan data tersedia
    if (isset($response['success']) && $response['success'] && isset($response['data'][0])) {
        $virtualTour = $response['data'][0]; // Akses elemen pertama dalam array 'data'
        
        $data['virtual_tour'] = $virtualTour;
        
        // Siapkan data untuk og meta
        $data['og'] = [];
        $data['og']['url'] = url('/').'/virtual_tour/'.$virtualTour['slug'];
        $data['og']['title'] = $virtualTour['name'];
        $data['og']['description'] = 'Virtual_tours';
        
        $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
        $data['virtual_tours'] = \App\Helpers\AppHelper::instance()->requestApiGet('api/virtual_tour');

        return view('client.virtual_tour.detail', $data);
    } else {
        // Jika data tidak ditemukan, arahkan kembali atau tampilkan pesan error
        return redirect()->back()->withErrors('Data virtual tour tidak ditemukan!');
    }
}

}
