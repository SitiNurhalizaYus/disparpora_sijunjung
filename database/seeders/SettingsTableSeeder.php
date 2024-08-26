<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Setting::factory()->create([
            'key' => 'name',
            'value' => 'DISPARPORA Sijunjung',
            'type' => 'text',
            'notes' => 'Nama instansi Dinas Pariwisata Pemuda dan Olahraga',
            'is_active' => true,
            'created_by' => 1, 
            'updated_by' => 1, 
        ]);

        Setting::factory()->create([
            'key' => 'copyright',
            'value' => 'Copyright @2024 Dinas Pariwisata Pemuda dan Olahraga Kabupaten Sijunjung',
            'type' => 'text',
            'notes' => 'Informasi hak cipta untuk tahun 2024',
            'is_active' => true,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        Setting::factory()->create([
            'key' => 'footer-about',
            'value' => 'Lorem Ipsum',
            'type' => 'text',
            'notes' => 'Deskripsi singkat untuk footer situs',
            'is_active' => true,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        Setting::factory()->create([
            'key' => 'address',
            'value' => 'Jl. Pasar Inpres, Muaro, Kecamatan Sijunjung, Kabupaten Sijunjung, Sumatera Barat 27562',
            'type' => 'text',
            'notes' => 'Alamat kantor utama',
            'is_active' => true,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        Setting::factory()->create([
            'key' => 'phone',
            'value' => '0751-xxxx',
            'type' => 'text',
            'notes' => 'Nomor telepon utama kantor',
            'is_active' => true,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        Setting::factory()->create([
            'key' => 'email',
            'value' => 'parporadinas@gmail.com',
            'type' => 'text',
            'notes' => 'Email utama untuk kontak',
            'is_active' => true,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        Setting::factory()->create([
            'key' => 'socmed-twitter',
            'value' => 'http://twitter.com/dinaspariwisata',
            'type' => 'text',
            'notes' => 'URL Twitter resmi',
            'is_active' => true,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        Setting::factory()->create([
            'key' => 'socmed-instagram',
            'value' => 'http://instagram.com/dinaspariwisata',
            'type' => 'text',
            'notes' => 'URL Instagram resmi',
            'is_active' => true,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        Setting::factory()->create([
            'key' => 'socmed-facebook',
            'value' => 'http://facebook.com/dinaspariwisata',
            'type' => 'text',
            'notes' => 'URL Facebook resmi',
            'is_active' => true,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        Setting::factory()->create([
            'key' => 'faq-description',
            'value' => 'Lorem Ipsum',
            'type' => 'wysiwyg',
            'notes' => 'Deskripsi FAQ',
            'is_active' => true,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        Setting::factory()->create([
            'key' => 'contact-map',
            'value' => 'https://www.google.com/maps/embed?pb=...',
            'type' => 'longtext',
            'notes' => 'Embed code untuk peta lokasi kantor',
            'is_active' => true,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        Setting::factory()->create([
            'key' => 'about-content',
            'value' => '<h1>HTML Ipsum Presents</h1>',
            'type' => 'wysiwyg',
            'notes' => 'Konten "Tentang Kami"',
            'is_active' => true,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        Setting::factory()->create([
            'key' => 'logo-geopark',
            'value' => 'uploads/xxx/logo-geopark.ico',
            'type' => 'longtext',
            'notes' => 'Path untuk logo Geopark',
            'is_active' => true,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        Setting::factory()->create([
            'key' => 'logo-parpora',
            'value' => 'uploads/xxx/logo-parpora.ico',
            'type' => 'longtext',
            'notes' => 'Path untuk logo Parpora',
            'is_active' => true,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        Setting::factory()->create([
            'key' => 'name-short',
            'value' => 'DISPARPORA',
            'type' => 'text',
            'notes' => 'Nama singkat instansi',
            'is_active' => true,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        Setting::factory()->create([
            'key' => 'name-long',
            'value' => 'Dinas Pariwisata Pemuda dan Olahraga',
            'type' => 'text',
            'notes' => 'Nama panjang instansi',
            'is_active' => true,
            'created_by' => 1,
            'updated_by' => 1,
        ]);
    }
}
