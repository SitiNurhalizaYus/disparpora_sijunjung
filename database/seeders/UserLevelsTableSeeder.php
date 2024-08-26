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
            ['name' => 'Admin', 'notes' => 'Administrator of the system', 'is_active' => true],
            ['name' => 'Editor', 'notes' => 'Content editor', 'is_active' => true],
            // Tambahkan 4 role lainnya jika diperlukan
        ]);
    }
}
