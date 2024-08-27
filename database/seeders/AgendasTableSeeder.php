<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AgendasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('agendas')->insert([
            [
                'title' => 'Rapat Koordinasi Festival Pariwisata',
                'content' => 'Rapat ini bertujuan untuk koordinasi antara panitia dan peserta.',
                'event_date' => Carbon::create('2024', '12', '15'),
                'organizer' => 'Dinas Pariwisata dan Olahraga',
                'file_path' => 'path/to/file.pdf',
                'is_active' => true,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Tambahkan 5 agenda lainnya
        ]);
    }
}
