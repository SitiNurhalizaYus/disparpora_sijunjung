<?php

namespace Database\Seeders;

use App\Models\Poster;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SlidersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Poster::factory()->create([
            'name' => 'Festival Pariwisata 2024',
            'image' => 'uploads/sliders/festival-pariwisata.jpg',
            'link' => 'http://festivalpariwisata.com',
            'notes' => 'Poster utama untuk mempromosikan Festival Pariwisata 2024.',
            'is_active' => true,
            'created_by' => 1, // Assuming the admin user has an ID of 1
        ]);

        Poster::factory()->create([
            'name' => 'Program Pemuda 2024',
            'image' => 'uploads/sliders/program-pemuda.jpg',
            'link' => 'http://programpemuda.com',
            'notes' => 'Poster untuk mempromosikan Program Pemuda 2024.',
            'is_active' => true,
            'created_by' => 1,
        ]);

        Poster::factory()->create([
            'name' => 'Olahraga Bersama',
            'image' => 'uploads/sliders/olahraga-bersama.jpg',
            'link' => 'http://olahraga.com',
            'notes' => 'Poster untuk mempromosikan kegiatan olahraga.',
            'is_active' => true,
            'created_by' => 1,
        ]);

        Poster::factory()->create([
            'name' => 'Explore Sijunjung',
            'image' => 'uploads/sliders/explore-sijunjung.jpg',
            'link' => 'http://exploresijunjung.com',
            'notes' => 'Poster untuk promosi pariwisata Sijunjung.',
            'is_active' => true,
            'created_by' => 1,
        ]);

        Poster::factory()->create([
            'name' => 'Lomba Fotografi',
            'image' => 'uploads/sliders/lomba-fotografi.jpg',
            'link' => 'http://lombafotografi.com',
            'notes' => 'Poster untuk promosi lomba fotografi.',
            'is_active' => true,
            'created_by' => 1,
        ]);

        Poster::factory()->create([
            'name' => 'Pameran Kebudayaan',
            'image' => 'uploads/sliders/pameran-kebudayaan.jpg',
            'link' => 'http://pamerankebudayaan.com',
            'notes' => 'Poster untuk mempromosikan pameran kebudayaan.',
            'is_active' => true,
            'created_by' => 1,
        ]);
    }
}
