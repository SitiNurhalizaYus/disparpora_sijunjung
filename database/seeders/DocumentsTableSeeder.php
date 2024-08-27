<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DocumentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('documents')->insert([
            [
                'title' => 'Restra',
                'file_path' => 'path/to/nodocument.pdf',
                'description' => 'Dokumentasi Rencana Strategis Dinas Pariwisata Pemuda dan Olahraga Tahun 2021-2026',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'RTP',
                'file_path' => 'path/to/nodocument.pdf',
                'description' => 'Dokumen Penetapan Konteks Risiko Strategis OPD 2023',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Rencana Aksi PARPORA',
                'file_path' => 'path/to/nodocument.pdf',
                'description' => 'Dokumen Matriks Aksi Tindak Lanjut Terhadap Laporan Hasil Evaluasi SAKIP 2022',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'RATL LHE PARPORA',
                'file_path' => 'path/to/nodocument.pdf',
                'description' => 'Dokumen Matriks Aksi Tindak Lanjut Terhadap Laporan Hasil Evaluasi SAKIP 2022',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Definisi Operasional',
                'file_path' => 'path/to/nodocument.pdf',
                'description' => 'Dokumen Definisi Operasional Kinerja 2023',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Casceding PARPORA',
                'file_path' => 'path/to/nodocument.pdf',
                'description' => 'Dokumen yang berisi sasaran RPJMD misi 2, tujuan OPD, dan sasaran strategis PD',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'SK Pedoman Pengukuran Kinerja',
                'file_path' => 'path/to/nodocument.pdf',
                'description' => 'Dokumen pedoman pengukuran dan pengumpulan data kinerja di lingkungan dinas pariwisata pemuda dan olahraga kabupaten sijunjung',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Prestasi olahraga TH 2022',
                'file_path' => 'path/to/nodocument.pdf',
                'description' => 'Dokumen indikator kinerja kunci Outcome 8 urusan kepemudaan dan olahraga tentang peningkatan prestasi olahraga',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'LKJIP Tahun 2023',
                'file_path' => 'path/to/nodocument.pdf',
                'description' => 'Dokumen laporan kinerja instansi pemerintah',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Salinan Perda 2021-2016',
                'file_path' => 'path/to/nodocument.pdf',
                'description' => 'Dokumen rencana pembangunan jangka menengah daerah tahun 2021-2026',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Tambahkan 5 dokumen lainnya
        ]);
    }
}
