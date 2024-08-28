<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('categories')->insert([
            ['name' => 'Pemuda', 'slug' => 'pemuda', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Olahraga', 'slug' => 'olahraga', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pariwisata', 'slug' => 'pariwisata', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Penghargaan', 'slug' => 'penghargaan', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pelatihan', 'slug' => 'pelatihan', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Anugerah', 'slug' => 'anugerah', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
