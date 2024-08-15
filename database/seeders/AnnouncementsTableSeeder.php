<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AnnouncementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('announcements')->insert([
            [
                'title' => 'Pengumuman Festival Pariwisata',
                'content' => 'Festival pariwisata akan diadakan bulan depan oleh Dinas Pariwisata dan Olahraga.',
                'is_active' => true,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Tambahkan 5 pengumuman lainnya
        ]);
    }
}
