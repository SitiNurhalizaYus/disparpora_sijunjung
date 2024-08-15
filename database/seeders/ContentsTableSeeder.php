<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ContentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('contents')->insert([
            [
                'title' => 'Pembukaan Festival Pariwisata',
                'slug' => 'pembukaan-festival-pariwisata',
                'content' => 'Pembukaan festival pariwisata oleh Dinas Pariwisata dan Olahraga.',
                'description_short' => 'Pembukaan festival pariwisata.',
                'type' => 'berita',
                'category_id' => 1,
                'arsip_id' => 1,
                'is_active' => true,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Tambahkan 5 konten lainnya dengan data terkait dinas
        ]);
    }
}
