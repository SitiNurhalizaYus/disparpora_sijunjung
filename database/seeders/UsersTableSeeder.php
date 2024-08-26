<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'level_id' => 1,
                'username' => 'admin',
                'password' => Hash::make('admin'),
                'name' => 'Admin Dinas',
                'email' => 'admin@dinas.com',
                'picture' => 'uploads/xxx/profile.jpg',  
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'level_id' => 2,
                'username' => 'editor',
                'password' => Hash::make('editor'),
                'name' => 'Editor 1',
                'email' => 'editor1@dinas.com',
                'picture' => 'uploads/xxx/profile.jpg',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Tambahkan 4 pengguna lainnya dengan data serupa
        ]);
    }
}
