<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
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
                'announcement_date' => Carbon::now()->subDays(2),  // Example announcement from 2 days ago
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'title' => 'Pengumuman Festival Pariwisata',
                'content' => 'Festival pariwisata akan diadakan bulan depan oleh Dinas Pariwisata dan Olahraga.',
                'is_active' => true,
                'created_by' => 1,
                'announcement_date' => Carbon::now()->subWeeks(1),  // Example announcement from last week
                'created_at' => now(),
                'updated_at' => now(),
            ],

            
            // Tambahkan 5 pengumuman lainnya
        ]);
    }
}
