<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('categories')->insert([
            ['name' => 'Berita', 'slug' => 'berita', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Artikel', 'slug' => 'artikel', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            // Tambahkan 4 kategori lainnya
        ]);
    }
}
