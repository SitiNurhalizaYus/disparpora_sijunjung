<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Tag;
use App\Models\User;
use App\Models\Event;
use App\Models\Konten;
use App\Models\Survei;
use App\Models\Setting;
use App\Models\Kategori;
use App\Models\TagKonten;
use App\Models\UserLevel;
use App\Models\UmpanBalik;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'level_id' => 1,
            'nik' => '1234567890',
            'name' => 'admin',
            'email' => 'admin@email.com',
            'password' => 'admin',
            'address' => 'padang',
            'phone_number' => '08xxxx',
			'photo' => 'uploads/xxx/noimage.jpg',
        ]);

        User::factory()->create([
            'level_id' => 2,
            'nik' => '1234567890',
            'name' => 'user',
            'email' => 'user@email.com',
            'password' => 'user',
            'address' => 'padang',
            'phone_number' => '08xxxx',
			'photo' => 'uploads/xxx/noimage.jpg',
        ]);

        User::factory(10)->create();

        Kategori::create([
            'nama_kategori' => 'Budaya',
            'deskripsi' => 'Konten terkait budaya',
        ]);

        Kategori::create([
            'nama_kategori' => 'Wisata',
            'deskripsi' => 'Konten terkait wisata',
        ]);

        Konten::factory(10)->create();
        Tag::factory(10)->create();
        TagKonten::factory(20)->create();
        UmpanBalik::factory(10)->create();

        Survei::create([
            'pertanyaan' => 'Bagaimana pendapat Anda tentang layanan kami?',
            'pilihan_1' => 'Sangat Baik',
            'pilihan_2' => 'Baik',
            'pilihan_3' => 'Cukup',
            'pilihan_4' => 'Buruk',
            'total_pilihan_1' => 0,
            'total_pilihan_2' => 0,
            'total_pilihan_3' => 0,
            'total_pilihan_4' => 0,
        ]);

        Event::create([
            'nama_acara' => 'Festival Sijunjung',
            'tanggal_acara' => '2024-08-15',
            'deskripsi' => 'Event tahunan di Sijunjung',
            'gambar' => 'img/event.jpg',
            'link_event' => 'http://sijunjungtour.com/festival',
            'id_admin' => 1,
        ]);

        Event::factory(10)->create();

        \App\Models\UserLevel::factory()->create(['id' => 1, 'role' => 'Admin (Pemerintah)', 'created_by' => '1', 'updated_by' => '1']);
        \App\Models\UserLevel::factory()->create(['id' => 2, 'role' => 'Masyarakat Umum', 'created_by' => '1', 'updated_by' => '1']);
       
        \App\Models\Setting::factory()->create(['id' => 1, 'is_active'=> true, 'type' => 'text', 'key' => 'name', 'value' => 'DISPARPORA Sijunjung']);
        \App\Models\Setting::factory()->create(['id' => 2, 'is_active'=> true, 'type' => 'text', 'key' => 'copyright', 'value' => 'Copyright @2024 Dinas Pariwisata dan Olahraga Kabupaten Sijunjung']);
        \App\Models\Setting::factory()->create(['id' => 3, 'is_active'=> true, 'type' => 'longtext', 'key' => 'footer-about', 'value' => 'Lorem Ipsum']);
        \App\Models\Setting::factory()->create(['id' => 4, 'is_active'=> true, 'type' => 'text', 'key' => 'address', 'value' => 'Sijunjung']);
        \App\Models\Setting::factory()->create(['id' => 5, 'is_active'=> true, 'type' => 'text', 'key' => 'phone', 'value' => '085']);
        \App\Models\Setting::factory()->create(['id' => 6, 'is_active'=> true, 'type' => 'text', 'key' => 'email', 'value' => 'disparpora@email.com']);
        \App\Models\Setting::factory()->create(['id' => 7, 'is_active'=> true, 'type' => 'text', 'key' => 'socmed-twitter', 'value' => 'http://google.com']);
        \App\Models\Setting::factory()->create(['id' => 8, 'is_active'=> true, 'type' => 'text', 'key' => 'socmed-instagram', 'value' => 'http://google.com']);
        \App\Models\Setting::factory()->create(['id' => 9, 'is_active'=> true, 'type' => 'text', 'key' => 'socmed-linkedin', 'value' => 'http://google.com']);
        \App\Models\Setting::factory()->create(['id' => 10, 'is_active'=> true, 'type' => 'text', 'key' => 'socmed-facebook', 'value' => 'http://google.com']);
        \App\Models\Setting::factory()->create(['id' => 11, 'is_active'=> true, 'type' => 'wysiwyg', 'key' => 'faq-description', 'value' => 'Lorem Ipsum']);
        \App\Models\Setting::factory()->create(['id' => 12, 'is_active'=> true, 'type' => 'longtext', 'key' => 'contact-map', 'value' => 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d123505.75790910245!2d121.05573800000002!3d14.681181!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397ba0942ef7375%3A0x4a9a32d9fe083d40!2sQuezon%20City%2C%20Metro%20Manila%2C%20Philippines!5e0!3m2!1sen!2sus!4v1676356596840!5m2!1sen!2sus']);
        \App\Models\Setting::factory()->create(['id' => 13, 'is_active'=> true, 'type' => 'wysiwyg', 'key' => 'about-content', 'value' => '<h1>HTML Ipsum Presents</h1>']);
        \App\Models\Setting::factory()->create(['id' => 14, 'is_active'=> true, 'type' => 'longtext', 'key' => 'logo-geopark', 'value' => 'uploads/xxx/Logo-Geopark.ico']);
        \App\Models\Setting::factory()->create(['id' => 15, 'is_active'=> true, 'type' => 'text', 'key' => 'name-short', 'value' => 'DISPARPORA']);
        \App\Models\Setting::factory()->create(['id' => 16, 'is_active'=> true, 'type' => 'longtext', 'key' => 'seo-description', 'value' => 'Citiasia adalah']);
        \App\Models\Setting::factory()->create(['id' => 17, 'is_active'=> true, 'type' => 'longtext', 'key' => 'seo-keywords', 'value' => 'city, asia, smart city, blueprint']);
        \App\Models\Setting::factory()->create(['id' => 18, 'is_active'=> true, 'type' => 'longtext', 'key' => 'seo-author', 'value' => 'Citiasia']);
        \App\Models\Setting::factory()->create(['id' => 19, 'is_active'=> true, 'type' => 'longtext', 'key' => 'seo-keyphrases', 'value' => '']);
        \App\Models\Setting::factory()->create(['id' => 20, 'is_active'=> true, 'type' => 'longtext', 'key' => 'seo-mytopic', 'value' => 'smartcity']);
        \App\Models\Setting::factory()->create(['id' => 21, 'is_active'=> true, 'type' => 'longtext', 'key' => 'seo-classification', 'value' => 'public']);
        \App\Models\Setting::factory()->create(['id' => 22, 'is_active'=> true, 'type' => 'longtext', 'key' => 'seo-robots', 'value' => '']);
    }
}
