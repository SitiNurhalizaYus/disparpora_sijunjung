<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GalleriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('galleries')->insert([
            [
                'title' => 'Galeri Pembukaan Festival Pariwisata',
                'type' => 'gambar',
                'file_path' => 'upload/300/image1.jpg',
                'is_active' => true,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Tambahkan 5 galeri lainnya
        ]);
    }
}
