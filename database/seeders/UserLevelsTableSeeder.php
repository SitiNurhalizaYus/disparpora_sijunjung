<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserLevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('user_levels')->insert([
            ['name' => 'Admin', 'notes' => 'Hak akses penuh.', 'is_active' => true],
            ['name' => 'Editor', 'notes' => 'Akses penuh untuk mengelola konten.', 'is_active' => true],
            ['name' => 'Kontributor', 'notes' => 'Akses untuk membuat konten tetapi tidak memiliki hak untuk menerbitkan (konten menunggu persetujuan editor).', 'is_active' => true],
        ]);
    }
}
