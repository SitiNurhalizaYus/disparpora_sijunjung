<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    public function run()
    {
        DB::table('events')->insert([
            [
                'event_name' => 'Festival Budaya Sijunjung',
                'organizer' => 'Dinas Pariwisata Kabupaten Sijunjung', // Tambahkan penyelenggara
                'event_date' => Carbon::create('2024', '09', '12'),
                'description' => 'Festival budaya tahunan yang menampilkan berbagai kebudayaan dan seni dari Kabupaten Sijunjung.',
                'image' => 'festival-budaya-sijunjung.jpg',
                'event_link' => 'https://pariwisata-sijunjung.go.id/festival-budaya-sijunjung',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'event_name' => 'Lomba Lari Marathon Sijunjung',
                'organizer' => 'Dinas Pemuda dan Olahraga Kabupaten Sijunjung', // Tambahkan penyelenggara
                'event_date' => Carbon::create('2024', '11', '03'),
                'description' => 'Lomba lari marathon tahunan yang diadakan di Sijunjung untuk meningkatkan minat olahraga masyarakat.',
                'image' => 'marathon-sijunjung.jpg',
                'event_link' => 'https://pariwisata-sijunjung.go.id/lomba-lari-marathon',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'event_name' => 'Pameran Wisata Sijunjung',
                'organizer' => 'Dinas Pariwisata Kabupaten Sijunjung', // Tambahkan penyelenggara
                'event_date' => Carbon::create('2024', '12', '15'),
                'description' => 'Pameran yang menampilkan berbagai destinasi wisata unggulan di Kabupaten Sijunjung.',
                'image' => 'pameran-wisata.jpg',
                'event_link' => 'https://pariwisata-sijunjung.go.id/pameran-wisata',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}  
