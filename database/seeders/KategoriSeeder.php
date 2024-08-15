<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Kategori;
use Illuminate\Support\Str;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        Kategori::create([
            'name' => 'Anugerah',
            'slug' => Str::slug('Anugerah'),
            'is_active' => 1,
        ]);
        
        Kategori::create([
            'name' => 'Kegiatan',
            'slug' => Str::slug('Kegiatan'),
            'is_active' => 1,
        ]);

        Kategori::create([
            'name' => 'Olahraga',
            'slug' => Str::slug('Olahraga'),
            'is_active' => 1,
        ]);

        Kategori::create([
            'name' => 'Pariwisata',
            'slug' => Str::slug('Pariwisata'),
            'is_active' => 1,
        ]);
        
        Kategori::create([
            'name' => 'Pelatihan',
            'slug' => Str::slug('Pelatihan'),
            'is_active' => 1,
        ]);

        Kategori::create([
            'name' => 'Pemuda',
            'slug' => Str::slug('Pemuda'),
            'is_active' => 1,
        ]);
        
        Kategori::create([
            'name' => 'Penghargaan',
            'slug' => Str::slug('Penghargaan'),
            'is_active' => 1,
        ]);
    }
}
