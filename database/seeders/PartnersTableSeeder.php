<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PartnersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('partners')->insert([
            [
                'name' => 'PT Wisata Nusantara',
                'image' => 'path/to/image.jpg',
                'link' => 'http://wisatanusantara.com',
                'notes' => 'Mitra resmi Dinas Pariwisata dan Olahraga.',
                'is_active' => true,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Tambahkan 5 mitra lainnya
        ]);
    }
}
