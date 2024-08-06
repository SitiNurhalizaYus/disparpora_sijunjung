<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Tag;
use App\Models\User;
use App\Models\Event;
use App\Models\Konten;
use App\Models\Survei;
use App\Models\Kategori;
use App\Models\TagKonten;
use App\Models\UmpanBalik;
use Illuminate\Support\Str;
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
            'role_id' => 1,
            'name' => 'admin',
            'gender' => 'male',
            // 'reg_date' => '20-03-2024',
            'email' => 'admin@email.com',
            'password' => 'admin',
            'address' => 'padang',
            'phone_number' => '08xxxx',
			'photo' => 'uploads/xxx/noimage.jpg',
            'created_by'=> 1,
            'updated_by'=> 1,
        ]);

        User::factory()->create([
            'role_id' => 2,
            'name' => 'user',
            'gender' => 'male',            
            // 'reg_date' => '20-03-2024',
            'email' => 'user@email.com',
            'password' => 'user',
            'address' => 'padang',
            'phone_number' => '08xxxx',
			'photo' => 'uploads/xxx/noimage.jpg',
            'created_by'=> 1,
            'updated_by'=> 1,
        ]);

        User::factory(10)->create();

        Kategori::create([
            'name' => 'Profil',
            'deskripsi' => 'Konten terkait profil dinas',
        ]);
        
        Kategori::create([
            'name' => 'Publikasi',
            'deskripsi' => 'Konten terkait publikasi',
        ]);

        Kategori::create([
            'name' => 'Acara/Kegiatan',
            'deskripsi' => 'Konten terkait kegiatan',
        ]);

        Kategori::create([
            'name' => 'Anugerah',
            'deskripsi' => 'Konten terkait anugerah',
        ]);

        Kategori::create([
            'name' => 'Culturediversity',
            'deskripsi' => 'Konten terkait culturediversity',
        ]);


        Kategori::create([
            'name' => 'Geodiversity',
            'deskripsi' => 'Konten terkait geodiversity',
        ]);

        Kategori::create([
            'name' => 'Geopark Ranah Minang Silokek',
            'deskripsi' => 'Konten terkait geopark',
        ]);

        Kategori::create([
            'name' => 'Pemuda',
            'deskripsi' => 'Konten terkait pemuda',
        ]);

        Kategori::create([
            'name' => 'Olahraga',
            'deskripsi' => 'Konten terkait olahraga',
        ]);
        
        Kategori::create([
            'name' => 'Pelatihan',
            'deskripsi' => 'Konten terkait pelatihan',
        ]);

        Kategori::create([
            'name' => 'Penghargaan',
            'deskripsi' => 'Konten terkait penghargaan',
        ]);

        Kategori::create([
            'name' => 'Wisata',
            'deskripsi' => 'Konten terkait wisata',
        ]);

        Kategori::create([
            'name' => 'Restoran',
            'deskripsi' => 'Konten terkait restoran',
        ]);

        Kategori::create([
            'name' => 'Penginapan',
            'deskripsi' => 'Konten terkait penginapan',
        ]);
        

        Konten::create([
            'judul' => 'Struktur Organisasi Dinas',
            'slug' => Str::slug('Struktur Organisasi Dinas'),
            'description_short' => 'Short description for sample post 1.',
            'description_long' => 'Long description for sample post 1. Detailed information goes here.',
            'gambar' => 'uploads/xxx/noimage.jpg',
            'kategori_id' => 1,
            'is_active' => 1,
            'created_by' => 1, // Sesuaikan dengan ID pengguna yang valid
            'updated_by'=> 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Konten::create([
            'judul' => 'Visi dan Misi',
            'slug' => Str::slug('Visi Misi'),
            'description_short' => 'Short description for sample post 2.',
            'description_long' => 'Long description for sample post 2. Detailed information goes here.',
            'gambar' => 'uploads/xxx/noimage.jpg',
            'kategori_id' => 1,
            'is_active' => 1,
            'created_by' => 1, // Sesuaikan dengan ID pengguna yang valid
            'updated_by'=> 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        Konten::create([
            'judul' => 'Tujuan Strategis',
            'slug' => Str::slug('Tujuan Strategis'),
            'description_short' => 'Short description for sample post 2.',
            'description_long' => 'Long description for sample post 2. Detailed information goes here.',
            'gambar' => 'uploads/xxx/noimage.jpg',
            'kategori_id' => 1,
            'is_active' => 1,
            'created_by' => 1, // Sesuaikan dengan ID pengguna yang valid
            'updated_by'=> 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Konten::create([
            'judul' => 'Informasi Terkait',
            'slug' => Str::slug('Informasi Terkait'),
            'description_short' => 'Short description for sample post 2.',
            'description_long' => 'Long description for sample post 2. Detailed information goes here.',
            'gambar' => 'uploads/xxx/noimage.jpg',
            'kategori_id' => 2,
            'is_active' => 1,
            'created_by' => 1, // Sesuaikan dengan ID pengguna yang valid
            'updated_by'=> 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Konten::create([
            'judul' => 'Sasaran Strategis',
            'slug' => Str::slug('Sasaran Strategis'),
            'description_short' => 'Short description for sample post 2.',
            'description_long' => 'Long description for sample post 2. Detailed information goes here.',
            'gambar' => 'uploads/xxx/noimage.jpg',
            'kategori_id' => 1,
            'is_active' => 1,
            'created_by' => 1, // Sesuaikan dengan ID pengguna yang valid
            'updated_by'=> 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Konten::factory(10)->create();
        Tag::factory(5)->create();
        TagKonten::factory(5)->create();
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
            'admin_id' => 1,
        ]);

        Event::factory(10)->create();

        \App\Models\Role::factory()->create(['id' => 1, 'name' => 'Admin (Pemerintah)', 'created_by' => '1', 'updated_by' => '1']);
        \App\Models\Role::factory()->create(['id' => 2, 'name' => 'Masyarakat Umum', 'created_by' => '1', 'updated_by' => '1']);
       
        \App\Models\Setting::factory()->create(['id' => 1, 'is_active'=> true, 'type' => 'text', 'key' => 'name', 'value' => 'DISPARPORA Sijunjung']);
        \App\Models\Setting::factory()->create(['id' => 2, 'is_active'=> true, 'type' => 'text', 'key' => 'copyright', 'value' => 'Copyright @2024 Dinas Pariwisata Pemuda dan Olahraga Kabupaten Sijunjung']);
        \App\Models\Setting::factory()->create(['id' => 3, 'is_active'=> true, 'type' => 'longtext', 'key' => 'footer-about', 'value' => 'Lorem Ipsum']);
        \App\Models\Setting::factory()->create(['id' => 4, 'is_active'=> true, 'type' => 'text', 'key' => 'address', 'value' => 'Jl. Pasar Inpres, Muaro,
                        Kecamaten Sijunjung, Kabupaten Sijunjung, Sumatera Barat 27562']);
        \App\Models\Setting::factory()->create(['id' => 5, 'is_active'=> true, 'type' => 'text', 'key' => 'phone', 'value' => '0751-xxxx']);
        \App\Models\Setting::factory()->create(['id' => 6, 'is_active'=> true, 'type' => 'text', 'key' => 'email', 'value' => 'parporadinas@gmail.com']);
        \App\Models\Setting::factory()->create(['id' => 7, 'is_active'=> true, 'type' => 'text', 'key' => 'socmed-twitter', 'value' => 'http://google.com']);
        \App\Models\Setting::factory()->create(['id' => 8, 'is_active'=> true, 'type' => 'text', 'key' => 'socmed-instagram', 'value' => 'http://google.com']);
        \App\Models\Setting::factory()->create(['id' => 9, 'is_active'=> true, 'type' => 'text', 'key' => 'socmed-linkedin', 'value' => 'http://google.com']);
        \App\Models\Setting::factory()->create(['id' => 10, 'is_active'=> true, 'type' => 'text', 'key' => 'socmed-facebook', 'value' => 'http://google.com']);
        \App\Models\Setting::factory()->create(['id' => 11, 'is_active'=> true, 'type' => 'wysiwyg', 'key' => 'faq-description', 'value' => 'Lorem Ipsum']);
        \App\Models\Setting::factory()->create(['id' => 12, 'is_active'=> true, 'type' => 'longtext', 'key' => 'contact-map', 'value' => 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d123505.75790910245!2d121.05573800000002!3d14.681181!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397ba0942ef7375%3A0x4a9a32d9fe083d40!2sQuezon%20City%2C%20Metro%20Manila%2C%20Philippines!5e0!3m2!1sen!2sus!4v1676356596840!5m2!1sen!2sus']);
        \App\Models\Setting::factory()->create(['id' => 13, 'is_active'=> true, 'type' => 'wysiwyg', 'key' => 'about-content', 'value' => '<h1>HTML Ipsum Presents</h1>']);
        \App\Models\Setting::factory()->create(['id' => 14, 'is_active'=> true, 'type' => 'longtext', 'key' => 'logo-geopark', 'value' => 'uploads/xxx/logo-geopark.ico']);
        \App\Models\Setting::factory()->create(['id' => 15, 'is_active'=> true, 'type' => 'longtext', 'key' => 'logo-parpora', 'value' => 'uploads/xxx/logo-parpora.ico']);
        \App\Models\Setting::factory()->create(['id' => 16, 'is_active'=> true, 'type' => 'text', 'key' => 'name-short', 'value' => 'DISPARPORA']);
        \App\Models\Setting::factory()->create(['id' => 17, 'is_active'=> true, 'type' => 'text', 'key' => 'name-long', 'value' => 'Dinas Pariwisata Pemuda dan Olahraga']);
    }
}
