<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
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
                'slug' => Str::slug('Pembukaan Festival Pariwisata', '-'),
                'content' => 'Pembukaan festival pariwisata oleh Dinas Pariwisata dan Olahraga.',
                'description_short' => 'Pembukaan festival pariwisata.',
                'type' => 'berita',
                'category_id' => 1,
                // 'arsip_id' => 1,
                'is_active' => true,
                'created_by' => 1,                
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'title' => 'Pembukaan Festival Pariwisata2',
                'slug' => Str::slug('Pembukaan Festival Pariwisata2', '-'),
                'content' => 'Pembukaan festival pariwisata oleh Dinas Pariwisata dan Olahraga.',
                'description_short' => 'Pembukaan festival pariwisata.',
                'type' => 'profil',
                'category_id' => 1,
                // 'arsip_id' => 1,
                'is_active' => true,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Pembukaan Festival Pariwisata3',
                'slug' => Str::slug('Pembukaan Festival Pariwisata3', '-'),
                'content' => 'Pembukaan festival pariwisata oleh Dinas Pariwisata dan Olahraga.',
                'description_short' => 'Pembukaan festival pariwisata.',
                'type' => 'artikel',
                'category_id' => 1,
                // 'arsip_id' => 1,
                'is_active' => true,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Tambahkan 5 konten lainnya dengan data terkait dinas
        ]);
    }
}
