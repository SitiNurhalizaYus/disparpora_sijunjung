<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ArsipsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('arsips')->insert([
            ['tahun' => 2024, 'bulan' => 7, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['tahun' => 2024, 'bulan' => 8, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            // Tambahkan 4 arsip lainnya dengan data terkait
        ]);
    }
}
