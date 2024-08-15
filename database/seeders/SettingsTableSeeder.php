<?php

namespace Database\Seeders;

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
        DB::table('settings')->insert([
            [
                'key' => 'site_name',
                'value' => 'Dinas Pariwisata dan Olahraga',
                'notes' => 'Nama situs utama',
                'is_active' => true,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'site_email',
                'value' => 'info@dinas.com',
                'notes' => 'Email utama untuk kontak',
                'is_active' => true,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'phone_number',
                'value' => '+62 123 4567 890',
                'notes' => 'Nomor telepon utama',
                'is_active' => true,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'address',
                'value' => 'Jl. Pariwisata No. 1, Sijunjung',
                'notes' => 'Alamat kantor utama',
                'is_active' => true,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'facebook_url',
                'value' => 'https://facebook.com/dinaspariwisata',
                'notes' => 'URL halaman Facebook resmi',
                'is_active' => true,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'instagram_url',
                'value' => 'https://instagram.com/dinaspariwisata',
                'notes' => 'URL halaman Instagram resmi',
                'is_active' => true,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
