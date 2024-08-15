<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['name' => 'Admin', 'description' => 'Administrator of the system', 'is_active' => true],
            ['name' => 'Editor', 'description' => 'Content editor', 'is_active' => true],
            // Tambahkan 4 role lainnya jika diperlukan
        ]);
    }
}
