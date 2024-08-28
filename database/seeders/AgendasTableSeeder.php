<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AgendasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('agendas')->insert([
            [
                'title' => 'Yuk Saksikan “Silokek Culture Diversity Festival”',
                'content' => 'Rangkaian Kegiatan Silokek Culture Diversity Festival Tanggal 21 s/d 23 Agustus 2024 di depan Gor Sibinuang Muaro:
                1. Pawai Budaya “marak dulang makan bajamba”
                2. Pameran UMKM Jajanan Tradisional
                3. Pojok Kopi
                4. Talk Show Budaya
                5. Festival Randai Kreasi Tingkat umum dan pelajar
                6. Permainan Anak Nagari
                7. Pameran Geopark',
                'event_date' => '2024-08-16',
                'organizer' => 'Dinas Pariwisata dan Olahraga',
                'file_path' => 'path/to/no-image.jpg',
                'is_active' => true,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Yuk ikuti dan saksikan Pemilihan Uda Uni Duta Wisata Kabupaten Sijunjung Tahun 2024',
                'content' => 'https://dutawisatasijunjung.id/ (Link Pendaftaran)',
                'event_date' => '2024-07-18',
                'organizer' => 'Dinas Pariwisata dan Olahraga',
                'file_path' => 'path/to/noimage.jpg',
                'is_active' => true,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Mari Ikuti dan Saksikan Festival Randai Kreasi Tingkat Umum dan Pelajar se-Kabupaten Sijunjung',
                'content' => 'Dinas Pariwisata Pemuda dan olahraga Kabupaten Sijunjung kembali mengadakan Festival Randai kreasi tingkat umum dan pelajar. kegiatan ini di adakan pada bulan agustus tanggal 8 s/d 11 2024 yang bertempat di Pujasera depan RTH Muaro Sijunjung dan untuk pendaftaran dimulai tanggal 1 Juli s/d 5 Agustus 2024 yang . yuk ikuti dan saksikan kegiatan ini. link pendaftaran https://tinyurl.com/RandaiKreasi2024',
                'event_date' => '2024-07-4',
                'organizer' => 'Dinas Pariwisata dan Olahraga',
                'file_path' => 'path/to/noimage.jpg',
                'is_active' => true,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Pelatihan dan Sertfikasi Kompetensi Pemandu Geowisata Kabupaten Sijunjung',
                'content' => 'Pada tanggal 15 dan 16 Juli 2024 dilangsungkan Pelatihan dan Sertifikasi Kompetensi Pemandu Geowisata Kabupaten Sijunjung yang bertempat dihotel Bukik Gadang. Pelatihan dan sertifikasi diberikan oleh LSP Pramindo sebanyak 14 orang peserta.

                Acara dibuka oleh Kepala Dinas Parpora Afrineldi didampingi Kabid Pengembangan destinasi Pariwisata Wilda Ardes. Pada sambutannya Kadis parpora berharap kegiatan ini dapat melahirkan pemandu Geowisata yang profesional di Kabupaten Sijunjung, Setelah acara pembukaan peserta mendapatkan materi pelatihan terlebih dahulu, sebelum pada hari kedua dilaksanakan uji kompetensi peserta untuk mendapatkan sertifikasi pemandu Geowisata.

                Pemateri dari LSP Pramindo Heryadi Rachmat dan Supriatna Amiputra, materi yang diberikan berupa menyusun rencana perjalanan Geowisata, menyiapkan perangkat perjalanan, pemahaman tentang informasi Geowisata, melakukan pemanduan di daya tarik Geowisata, memimpin perjalanan Geowisata, melakukan interpretasi dalam pemanduan Geowisata.

                Acara ditutup dengan sesi diskusi dan penyampaian kesan pesan peserta terkait kegiatan dan foto bersama.',
                'event_date' => '2024-07-18',
                'organizer' => 'Dinas Pariwisata dan Olahraga',
                'file_path' => 'path/to/noimage.jpg',
                'is_active' => true,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Dinas Parpora Sijunjung Melaksanakan Pelatihan Eko Wisata',
                'content' => 'Bupati Sijunjung membuka acara pelatihan ekowisata yang di hadiri Kepala Dinas Pariwisata Pemuda dan Olahraga Afrineldi, SH. pelatihan ini dilaksanakan di Hotel Bukik Gadang Muaro Sijunjung pada hari Senin tanggal 24 Juni 2024.

                Ekowisata merupakan wisata berbasis alam, Kabupaten Sijunjung memiliki potensi alam yang sangat beragam, ada Kawasan geopark, Hutan lindung, sungai, danau, dan goa, papar Kadis Parpora Afrineldi saat menyampaikan sambutan pada pelatihan ini

                Dengan pengelolaan alam yang baik akan menjadi manfaat membuka lapangan pekerjaan sehingga akan meningkatkan ekonomi masyarakat Ranah Lansek Manih. Maka dengan adanya pelatihan pemandu ekowisata ini diharapkan para pemandu ekowisata dapat melindungi dan memanfaatkan alam dengan baik. Kiita memiliki program pengembangan Kawasan geopark ranah minang silokek yang selalu melakukan pembenahan dan persiapan untuk menuju UGG(unesco Global Geopark). Kabupaten Sijunjung melalui Dinas Pariwisata Pemuda dan Olahraga menggelar pelatihan pemandu Ekowisata guna meningkatkan kompetensi para pemandu wisata memenuhi Standar Kompetensi Kerja Nasional Indonesia (SKKNI) bidang kepemanduan Ekowisata jelas Afrineldi.

                Ketua Pelaksana Wilda Ardes selaku Kabid Bidang PDP (Pengembangan Destinasi Pariwisata) menyampaikan tujuan Pelatihan Pemandu Ekowisata adalah untuk meningkatkan pengetahuan, motivasi, dan kompetensi Pengelola objek wisata dan Geosite agar dapat memenuhi standar kompetensi kerja nasional Indonesia (SKKNI) bidang kepemanduan, Peserta Berasal dari kelompok sadar wisata, pengelola objek wisata dan Masyarakat yang tinggal di Geosite Geopark Ranah Minang Silokek dengan jumlah peserta 30 orang.

                Pelatihan Ekowisata ini mengusung tema Wisata Berkembang, Geopark Mendunia, Lingkungan Terjaga Masyarakat Sejahtera”, berlangsung selama 3 (tiga) hari dari tanggal 24 s/d 26 Juni 2024',
                'event_date' => '2024-06-25',
                'organizer' => 'Dinas Pariwisata dan Olahraga',
                'file_path' => 'path/to/noimage.jpg',
                'is_active' => true,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Dinas Parpora Sijunjung Melaksanakan Pelatihan Eko Wisata',
                'content' => 'Bupati Sijunjung membuka acara pelatihan ekowisata yang di hadiri Kepala Dinas Pariwisata Pemuda dan Olahraga Afrineldi, SH. pelatihan ini dilaksanakan di Hotel Bukik Gadang Muaro Sijunjung pada hari Senin tanggal 24 Juni 2024.

                Ekowisata merupakan wisata berbasis alam, Kabupaten Sijunjung memiliki potensi alam yang sangat beragam, ada Kawasan geopark, Hutan lindung, sungai, danau, dan goa, papar Kadis Parpora Afrineldi saat menyampaikan sambutan pada pelatihan ini

                Dengan pengelolaan alam yang baik akan menjadi manfaat membuka lapangan pekerjaan sehingga akan meningkatkan ekonomi masyarakat Ranah Lansek Manih. Maka dengan adanya pelatihan pemandu ekowisata ini diharapkan para pemandu ekowisata dapat melindungi dan memanfaatkan alam dengan baik. Kiita memiliki program pengembangan Kawasan geopark ranah minang silokek yang selalu melakukan pembenahan dan persiapan untuk menuju UGG(unesco Global Geopark). Kabupaten Sijunjung melalui Dinas Pariwisata Pemuda dan Olahraga menggelar pelatihan pemandu Ekowisata guna meningkatkan kompetensi para pemandu wisata memenuhi Standar Kompetensi Kerja Nasional Indonesia (SKKNI) bidang kepemanduan Ekowisata jelas Afrineldi.

                Ketua Pelaksana Wilda Ardes selaku Kabid Bidang PDP (Pengembangan Destinasi Pariwisata) menyampaikan tujuan Pelatihan Pemandu Ekowisata adalah untuk meningkatkan pengetahuan, motivasi, dan kompetensi Pengelola objek wisata dan Geosite agar dapat memenuhi standar kompetensi kerja nasional Indonesia (SKKNI) bidang kepemanduan, Peserta Berasal dari kelompok sadar wisata, pengelola objek wisata dan Masyarakat yang tinggal di Geosite Geopark Ranah Minang Silokek dengan jumlah peserta 30 orang.

                Pelatihan Ekowisata ini mengusung tema Wisata Berkembang, Geopark Mendunia, Lingkungan Terjaga Masyarakat Sejahtera”, berlangsung selama 3 (tiga) hari dari tanggal 24 s/d 26 Juni 2024',
                'event_date' => '2024-06-25',
                'organizer' => 'Dinas Pariwisata dan Olahraga',
                'file_path' => 'path/to/noimage.jpg',
                'is_active' => true,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Disparpora Sijunjung Melaksanakan Pelatihan Pemandu Geowisata',
                'content' => 'Pelatihan Pemandu Geowisata diikuti Sebanyak 30 yang dilaksanakan di Hotel Bukit Gadang Muaro Sijunjung selama 3 hari, pada hari Senin sampai Rabu, 13 s/d 15 Mei 2024

                Pelatihan yang dibuka Bupati Sijunjung, Benny Dwifa Yuswir diwakili oleh Kepala Dinas Pariwsata Pemuda dan Olahraga Afrineldi, SH pada Senin 13 Mei 2024 dan turut dihadiri oleh Sekretaris Dinas Parpora, Desmawati, SE,.M.Si serta Pejabat Fungsional Analis Kebijakan Ahli Muda Dinas Parpora, Sparta, SE, M.Si

                Dalam sambutannya, Kadis Parpora Afrineldi mengatakan bahwa dalam pengembangan geopark ranah minang silokek dibutuhkan pemandu geowisata sebagai pusat informasi bagi para pengunjung.

                “Peningkatan sumber daya manusia pengelola objek wisata harus selalu kita lakukan, sehingga terdapat pemerataan kemampuan bagi seluruh anggota pokdarwis, pengelola objek wisata harus bisa mengikuti pelatihan, dan memiliki kompetensi sesuai dengan bidangnya masing – masing,”ujarnya

                Ia menambahkan bahwa pada saat ini kegiatan wisata alam menjadi objek wisata yang banyak diminati, sehingga menjadi peluang dalam membangun kepariwisataan di Indonesia bahkan di Kabupaten Sijunjung yang memiliki tempat-tempat wisata yang masih alami.

                “Pemerintah Daerah sangat mendukung terhadap kegiatan peningkatan sumber daya manusia, diantaranya memberikan pelatihan untuk pokdarwis - pokdarwis yang ada di Kabupaten Sijunjung seperti saat ini,”lanjutnya

                Sementara itu, Kabid Pengembangan Destinasi Pariwisata Dinas Parpora. Wilda Ardes, ST, MT selaku panitia pelaksana mengatakan bahwa Pelatihan Pemandu Geowisata ini bertujuan untuk meningkatkan pengetahuan, motivasi, dan kompetensi Pengelola objek wisata agar dapat memenuhi standar kompetensi kerja nasional Indonesia (SKKNI) bidang kepemanduan Peserta pelatihan ini lanjut berasal dari kelompok sadar wisata (POKDARWIS) dan pengelola objek wisata dan Masyarakat yang tinggal di Geosite Geopark Ranah Minang Silokek.',
                'event_date' => '2024-05-21',
                'organizer' => 'Dinas Pariwisata dan Olahraga',
                'file_path' => 'path/to/noimage.jpg',
                'is_active' => true,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Peringatan Hari Bumi Internasional',
                'content' => 'Tanggal 22 April yang biasa diperingati setiap tahunnya sebagai hari bumi internasional, sebanyak 22 Organisasi / Lembaga/Komunitas se Kabupaten Sijunjung (Dinas Parpora, Dinas Perkim LH, BP. Geopark, KKI WARSI, IMAS  Batusangkar, IMAS Bukittinggi, Literasi Kita, PDAM, MASATA, RAI, Pokdarwis, SAPMA, GYF, Sijunjung Muda Berkarya, Duta Genre, Sispala, Forsilamsi, Bank Sampah, Guru Penggerak, English Education Vilage Taratak Baru, Duta Budaya dan K_Laskita), melakukan peringatan dengan beberapa kegiatan selama 2 hari  ( 27 dan 28 April 2024 ).Kegiatan diawali tanggal 27 April dengan aksi penanaman pohon sebanyak 500 batang di areal SMPN 45 Sijunjung dan sekitarnya, selanjutnya di Pusat Informasi Geopark Ranah Minang Silokek melakukan pengenalan geopark, sharing session, lomba daur ulang sampah plastik tingkat SD dan SLTP, pengenalan ekoprint dan cara daur ulang sampah plastik selanjutnya tanggal 28 April dilakukan aksi pungut sampah plastik di Perkampungan Adat Sijunjung.

                Afrineldi SH selaku Kepala Dinas Disparpora juga melakukan penanaman pohon di Sekitar area SMPN 45 Sijunjung yang didampingi oleh Kabid Pemasaran Pariwisata Rahmad Azandi Fajar, S.STP dan beberapa orang Kasi.

                Momen peringatan hari bumi ini dilaksanakan dalam upaya membangun kebersamaan antar komunitas, meningkatkan kepedulian terhadap lingkungan terutama sampah plastik baik untuk pelajar maupun komunitas,

                Sebagai penanggung jawab kegiatan mengucapkan terimakasih kepada para relawan dan komunitas yang telah berpartisipasi mensukseskan kegiatan tersebut

                Dan kepada para pihak yang telah memberikan sumbangan baik tenaga maupun pembiayaan kami mengucapkan terimakasih semoga kegiatan ini bermanfaat baik untuk konservasi maupun edukasi dalam upaya menjaga bumi khususnya di Kabupaten Sijunjung',
                'event_date' => '2024-05-29',
                'organizer' => 'Dinas Pariwisata dan Olahraga',
                'file_path' => 'path/to/noimage.jpg',
                'is_active' => true,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Tambahkan 5 agenda lainnya
        ]);
    }
}
