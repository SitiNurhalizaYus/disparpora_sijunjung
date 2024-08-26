<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SlidersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Slider::factory()->create([
            'name' => 'Festival Pariwisata 2024',
            'description' => 'Sambut Festival Pariwisata 2024 dengan penuh semangat!',
            'image' => 'uploads/sliders/festival-pariwisata.jpg',
            'link' => 'http://festivalpariwisata.com',
            'notes' => 'Slider utama untuk mempromosikan Festival Pariwisata 2024.',
            'is_active' => true,
            'created_by' => 1, // Assuming the admin user has an ID of 1
        ]);

        Slider::factory()->create([
            'name' => 'Program Pemuda 2024',
            'description' => 'Dukung Program Pemuda untuk masa depan yang lebih baik!',
            'image' => 'uploads/sliders/program-pemuda.jpg',
            'link' => 'http://programpemuda.com',
            'notes' => 'Slider untuk mempromosikan Program Pemuda 2024.',
            'is_active' => true,
            'created_by' => 1,
        ]);

        Slider::factory()->create([
            'name' => 'Olahraga Bersama',
            'description' => 'Ikuti kegiatan olahraga bersama di berbagai tempat di Sijunjung.',
            'image' => 'uploads/sliders/olahraga-bersama.jpg',
            'link' => 'http://olahraga.com',
            'notes' => 'Slider untuk mempromosikan kegiatan olahraga.',
            'is_active' => true,
            'created_by' => 1,
        ]);

        Slider::factory()->create([
            'name' => 'Explore Sijunjung',
            'description' => 'Jelajahi keindahan alam dan budaya Sijunjung.',
            'image' => 'uploads/sliders/explore-sijunjung.jpg',
            'link' => 'http://exploresijunjung.com',
            'notes' => 'Slider untuk promosi pariwisata Sijunjung.',
            'is_active' => true,
            'created_by' => 1,
        ]);

        Slider::factory()->create([
            'name' => 'Lomba Fotografi',
            'description' => 'Ikuti lomba fotografi dan menangkan hadiah menarik.',
            'image' => 'uploads/sliders/lomba-fotografi.jpg',
            'link' => 'http://lombafotografi.com',
            'notes' => 'Slider untuk promosi lomba fotografi.',
            'is_active' => true,
            'created_by' => 1,
        ]);

        Slider::factory()->create([
            'name' => 'Pameran Kebudayaan',
            'description' => 'Saksikan pameran kebudayaan dan kerajinan tangan di Sijunjung.',
            'image' => 'uploads/sliders/pameran-kebudayaan.jpg',
            'link' => 'http://pamerankebudayaan.com',
            'notes' => 'Slider untuk mempromosikan pameran kebudayaan.',
            'is_active' => true,
            'created_by' => 1,
        ]);
    }
}
