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
            ['tahun' => 2023, 'bulan' => 1, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['tahun' => 2023, 'bulan' => 2, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            // Tambahkan 4 arsip lainnya dengan data terkait
        ]);
    }
}
