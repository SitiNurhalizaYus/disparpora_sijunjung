<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DocumentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('documents')->insert([
            [
                'title' => 'Dokumen Festival Pariwisata',
                'file_path' => 'path/to/document1.pdf',
                'description' => 'Dokumen panduan untuk peserta festival pariwisata.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Tambahkan 5 dokumen lainnya
        ]);
    }
}
