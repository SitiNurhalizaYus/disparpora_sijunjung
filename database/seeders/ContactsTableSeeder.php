<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ContactsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('contacts')->insert([
            [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'subject' => 'Pertanyaan tentang Festival',
                'message' => 'Kapan festival dimulai?',
                'file_path' => 'path/to/file.pdf',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Tambahkan 5 kontak lainnya
        ]);
    }
}
