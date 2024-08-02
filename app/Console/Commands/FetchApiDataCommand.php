<?php

namespace App\Console\Commands;

use App\Models\Agent;
use App\Models\Kategori;
use App\Models\InfoTempat;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchApiDataCommand extends Command
{
    // Mendefinisikan signature dari command yang akan dijalankan di terminal
    protected $signature = 'fetch:apidata';
    
    // Deskripsi singkat tentang fungsi command ini
    protected $description = 'Fetch data from API and store in database';

    public function __construct()
    {
        // Memanggil konstruktor parent
        parent::__construct();
    }

    // Method utama yang dijalankan ketika command dipanggil
    public function handle()
    {
        // Memanggil method untuk mengambil data agent
        $this->fetchAgents();
        
        // Memanggil method untuk mengambil data tempat
        $this->fetchInfoTempats();
    }

    // Method untuk mengambil data dari API dan menyimpan data agent ke dalam database
    private function fetchAgents()
    {
        // Mengambil data dari endpoint API untuk agent
        $response = Http::get('http://localhost:8080/api/agents');
        
        // Mengonversi respons JSON menjadi array PHP
        $agents = $response->json();

        // Mengiterasi setiap data agent yang diterima
        foreach ($agents as $agent) {
            // Menyimpan atau memperbarui data agent berdasarkan email
            Agent::updateOrCreate(
                ['email' => $agent['email']], // Kondisi pencarian untuk update
                [
                    'nama' => $agent['nama'],
                    'alamat' => $agent['alamat'],
                    'telepon' => $agent['telepon'],
                    'website' => $agent['website']
                ]
            );
        }
    }

    // Method untuk mengambil data dari API dan menyimpan data tempat ke dalam database
    private function fetchInfoTempats()
    {
        // Mengambil data dari endpoint API untuk tempat
        $response = Http::get('http://localhost:8080/api/info_tempats');
        
        // Mengonversi respons JSON menjadi array PHP
        $infoTempats = $response->json();

        // Mengiterasi setiap data tempat yang diterima
        foreach ($infoTempats as $tempat) {
            // Menyimpan atau mendapatkan kategori dari database
            $kategori = Kategori::firstOrCreate(
                ['nama_kategori' => $tempat['kategori']], // Kondisi pencarian untuk kategori
                ['deskripsi' => ''] // Data default jika kategori baru dibuat
            );

            // Menyimpan atau memperbarui data tempat berdasarkan nama
            InfoTempat::updateOrCreate(
                ['nama' => $tempat['nama']], // Kondisi pencarian untuk update
                [
                    'id_agen' => $tempat['id_agen'],
                    'id_kategori' => $kategori->id, // Menyimpan ID kategori
                    'deskripsi' => $tempat['deskripsi'],
                    'fasilitas' => $tempat['fasilitas'],
                    'jam_operasional' => $tempat['jam_operasional'],
                    'harga_tiket' => $tempat['harga_tiket'],
                    'gambar' => $tempat['gambar']
                ]
            );
        }
    }
}
