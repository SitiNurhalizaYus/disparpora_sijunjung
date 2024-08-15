<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Arsip;

class ArsipSeeder extends Seeder
{
    public function run()
    {
        Arsip::create([
            'year' => 2024,
            'month' => 8,
            'konten_id' => 1,
            'is_active' => 1,
        ]);

        Arsip::create([
            'year' => 2024,
            'month' => 8,
            'konten_id' => 2,
            'is_active' => 1,
        ]);
    }
}
