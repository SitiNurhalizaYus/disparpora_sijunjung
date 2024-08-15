<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Konten;
use Illuminate\Support\Str;



class KontenSeeder extends Seeder
{
    public function run()
    {
        //profil
        Konten::create([
            'title' => 'Struktur Organisasi Dinas Pariwisata Pemuda dan Olahraga',
            'slug' => Str::slug('Struktur Organisasi Dinas Pariwisata Pemuda dan Olahraga'),
            'description_short' => 'Adapun Struktur Organisasi Dinas Pariwisata Pemuda Dan Olahraga (Parpora)
Kabupaten Sijunjung.
',
            'description_long' => ' ',
            'type' => 'profil',
            'kategori_id' => 1, 
            'photo' => 'uploads/xxx/noimage.jpg',
            'is_active' => 1,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
        ]);

        Konten::create([
            'title' => 'Visi dan Misi Dinas Pariwisata Pemuda dan Olahraga',
            'slug' => Str::slug('Struktur Organisasi'),
            'description_short' => 'Visi Dinas Pariwisata Pemuda dan Olahraga adalah “Menjadikan Sijunjung sebagai Daerah Tujuan Wisata yang didukung oleh Adat dan Seni Budaya Daerah..',
            'description_long' => 'Visi Dinas Pariwisata Pemuda dan Olahraga adalah “Menjadikan Sijunjung sebagai Daerah Tujuan Wisata yang didukung oleh Adat dan Seni Budaya Daerah Dengan
pengembangan Kreatifitas Pemuda dan Olahraga”. Misi Dinas Pariwisata Pemuda dan Olahraga adalah sebagai berikut :
1. Mewujudkan perekonomian masyarakat yang kuat dan sejahtera
2. Mewujudkan kualitas sumber daya manusia yang kuat, cerdas dan berakhlak mulia
3. Mewujudkan infrastruktur yang berkualitas dan merata
4. Mewujudkan pemerintahan yang bekerja dan melayani
5. Mengoptimalkan pengelolaan sumber daya alam yang berwawasan lingkungan
6. Melakukan revitalisasi adat dan budaya berlandaskan “adat basandi syara’, syara’ basandi kitabullah.
Perencanaan strategis Dinas Pariwisata Pemuda dan Olahraga Kabupaten Sijunjung diperlukan untuk merencanakan kegiatan, pengelolaan keberhasilan program yang bersifat
fleksibel berorientasi kedepan untuk pelayanan prima kepada masyarakat dan instansi terkait.
Hubungan Visi & Misi Pariwisata Pemuda dan Olahraga dengan dokumen perencanaan lainnya adalah:
1. Penyusunan Visi dan Misi Pariwisata Pemuda dan Olahraga ini berpedoman pada Rencana Pembangunan Jangka Menengah Daerah (RPJMD) tahun 2016-2021.
2. Visi dan Misi Pariwisata Pemuda dan Olahraga ini ditindaklanjuti lagi ke dalam penyusunan Renstra Dinas Pariwisata dan Olahraga tahun 2016-2021.
3. Rencana Strategis (Renstra) OPD Dinas Pariwisata Pemuda dan Olahraga disusun sesuai dengan tugas pokok dan fungsi OPD serta berpedoman kepada Rencana Pembangunan
Jangka Menengah Daerah (RPJMD) dan Peraturan Menteri Dalam Negeri No.13 Tahun 2006.
4. Rencana Strategis OPD Dinas Pariwisata Pemuda dan Olahraga lebih lanjut menjadi pedoman dalam penyusunan Rencana Kerja (Renja) OPD Dinas Pariwisata Pemuda dan
Olahraga.
5. Rencana Kerja OPD (Renja) SKPD Dinas Pariwisata Pemuda dan Olahraga menjadi salah satu pedoman dan penyusunan program dan kegiatan dalam Rencana Anggaran
Pendapatan dan Belanja Daerah (RAPBD) dan Anggaran Pendapatan dan Belanja Daerah (APBD).',
            'type' => 'profil',
            'kategori_id' => 1,
            'photo' => 'uploads/xxx/noimage.jpg',
            'is_active' => 1,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
        ]);


        Konten::create([
            'title' => 'Tujuan Strategis JANGKA MENENGAH DINAS PARIWISATA PEMUDA DAN OLAHRAGA',
            'slug' => Str::slug('Tujuan Strategis JANGKA MENENGAH DINAS PARIWISATA PEMUDA DAN OLAHRAGA'),
            'description_short' => 'Tujuan merupakan penjabaran atau implementasi dari pernyataan Misi yang akan dicapai untuk dihasilkan dalam jangka waktu 1 (satu) sampai 5 (lima) tahun',
            'description_long' => 'TUJUAN
Tujuan merupakan penjabaran atau implementasi dari pernyataan Misi yang akan dicapai untuk dihasilkan dalam jangka waktu 1 (satu) sampai 5 (lima) tahun. Dengan
diformulasikannya tujuan strategis ini maka Dinas Pariwisata Pemuda dan Olahraga Kabupaten Sijunjung dapat secara tepat mengetahui apa yang harus dilaksanakan oleh organisasi
dalam memenuhi Visi Misinya untuk kurun waktu ke depan, dengan mempertimbangkan sumber daya dan kemampuan yang dimiliki. Sejalan dengan itu, agar dapat terukurnya
keberhasilan organisasi di dalam mencapai tujuan strategis yang diterapkan akan memiliki indikator kerja (Performance Indicator).
Sesuai dengan Misi yang telah ditetapkan di atas, Dinas Pariwisata Pemuda dan Olahraga diharapkan mampu mencapai tujuan sebagai berikut :
a. Meningkatkan pembangunan, pengembangan dan promosi pariwisata.
b. Meningkatkan Sumber Daya Manusia yang cerdas, kompetitif dan berkarakter.',
            'type' => 'profil',
            'kategori_id' => 1,
            'photo' => 'uploads/xxx/noimage.jpg',
            'is_active' => 1,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
        ]);

        Konten::create([
            'title' => 'Sasaran Strategis JANGKA MENENGAH DINAS PARIWISATA PEMUDA DAN OLAHRAGA',
            'slug' => Str::slug('Sasaran Strategis JANGKA MENENGAH DINAS PARIWISATA PEMUDA DAN OLAHRAGA'),
            'description_short' => 'Sasaran strategis Dinas Pariwisata Pemuda dan Olahraga Kabupaten Sijunjung merupakan bagian integral dalam proses perencanaan strategis',
            'description_long' => 'Sasaran strategis Dinas Pariwisata Pemuda dan Olahraga Kabupaten Sijunjung merupakan bagian integral dalam proses perencanaan strategis Dinas dan merupakan dasar yang
kuat untuk mengendalikan dan memantau pencapaian kinerja Dinas Parpora serta lebih menjamin suksesnya pelaksanaan rencana jangka menengah dan rencana jangka panjang yang
sifatnya menyeluruh yang berarti menyangkut keseluruhan satuan kerja di lingkungan Dinas Parpora.
Sasaran-sasaran yang ditetapkan sepenuhnya mendukung pencapaian tujuan yang terkait, yaitu:
1. Terwujudnya standar pelayanan kepada masyarakat
2. Tersedianya sarana dan prasarana pendukung kegiatan Kepariwisataan, Pemuda dan Olahraga
3. Meningkatnya Pendapatan Asli Daerah dari sektor pariwisata
4. Terselenggaranya pengembangan nilai-nilai budaya dalam kehidupan bermasyarakat
5. Terkelolanya nilai-nilai kekayaan bangsa
6. Tercapainya pemasyarakatan olahraga di kalangan masyarakat dan lingkungan pemerintah
7. Terselenggaranya pengembangan potensi keolahragaan di Kabupaten Sijunjung
8. Meningkatnya partisipasi dan peran aktif pemuda di berbagai bidang pembangunan .
9. Terciptanya kebebasan dalam berkreasi/ berkesenian.
10. Terinventarisirnya seni lokal dan terdokumentasinya wisata budaya daerah.
11. Meningkatnya frekwensi kegiatan pembinaan olahraga
12. Meningkatnya jumlah atlit berprestasi',
            'type' => 'profil',
            'kategori_id' => 1,
            'photo' => 'uploads/xxx/noimage.jpg',
            'is_active' => 1,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
        ]);

        Konten::create([
            'title' => 'STRATEGI DAN KEBIJAKAN DINAS PARIWISATA PEMUDA OLAHRAGA',
            'slug' => Str::slug('STRATEGI DAN KEBIJAKAN DINAS PARIWISATA PEMUDA OLAHRAGA'),
            'description_short' => 'Strategi pembangunan daerah Kabupaten Sijunjung dalam urusan wajib Pariwisata, urusan wajib Pemuda dan Olahraga..',
            'description_long' => 'Strategi pembangunan daerah Kabupaten Sijunjung dalam urusan wajib Pariwisata, urusan wajib Pemuda dan Olahraga disusun untuk melaksanakan berbagai misi guna
mewujudkan visi Dinas Parpora Kabupaten Sijunjung tahun 2016-2021. Strategi pembangunan tersebut disusun dengan mempertimbangkan kondisi daerah yang strategis karena
berada pada lintasan Sumatera yang alamnya penuh dengan objek wisata alam yang potensial untuk dikembangkan di masa yang akan datang, yang diharapkan dapat menunjang
revitalisasi adat seni anak nagari dan peningkatan kualitas pemuda dan pembinaan serta pemasyarakatan olahraga.
Strategi ini juga mampertimbangkan pengalaman pembangunan di masa lalu dan berbagai kemungkinan perkembangan pembangunan masa depan. Secara umum, Strategi
pengembangan Pariwisata Pemuda dan Olahraga mencakup beberapa hal sebagai berikut:
a. Melaksanakan prinsip-prinsip organisasi pemerintahan yang baik (good government) dalam perencanaan, pengorganisasian, pengawasan program/kegiatan. Prinsip-prinsip
tersebut dilaksanakan melalui 3 (tiga) pilar yang memiliki saling ketergantungan satu sama lainnya. Pilar-pilar tersebut adalah:
1. Pilar Pemerintah
Pemerintah diharapkan bisa menjadi fasilitator, regulator, penyedia kebutuhan barang-barang publik dan sebagai stimulator dalam peningkatan pengembangan seni dan
budaya anak nagari serta peningkatan kualitas pemuda dan pembinaan serta pemasyarakatan olahraga di Kabupaten Sijunjung untuk membangun manajemen pemerintahan
yang profesional dengan menerapkan prinsip-prinsip reinventing government dalam manajemennya.
2. Pilar Swasta
 Pihak swasta dalam hal ini para pengusaha/ investor diharapkan mampu mengambil peran sebagai motor penggerak pembangunan melalui sumber daya yang mereka miliki.
Peran swasta diharapkan akan mampu mengacu pertumbuhan ekonomi daerah melalui investasi yang ditanamkan terutama pada bidang pariwisata alam dan Seni
3. Pilar Masyarakat
 Masyarakat sebagai pilar terbesar dalam prinsip Good Government diharapkan mampu menjadi kekuatan pembangunan terbesar terutama melalui pemberdayaan masyarakat
nagari.
b. Memberdayakan kekuatan Tungku Tigo Sajarangan dan Tali Tigo Sapilin dalam Akselerasi Pembangunan Nagari.
c. Melaksanakan Outward Looking Strategy dalam pembangunan ekonomi daerah dengan langkah-langkah:
1. Mengembangkan komoditi/produk pariwisata yang berorientasi pasar.
2. Memanfaatkan Kerja Sama Antar Daerah (KSAD) dan ekonomi regional
3. Mengangkat daya tarik investasi daerah melalui deregulasi/ debirokrasi dan penyiapan sarana dan prasarana penunjang program/ kegiatan yang berkaitan dengan
Pariwisata Pemuda dan Olahraga.',
            'type' => 'profil',
            'kategori_id' => 1,
            'photo' => 'uploads/xxx/noimage.jpg',
            'is_active' => 1,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
        ]);
        
        //berita
        Konten::create([
            'title' => 'Yuk ikuti dan saksikan Pemilihan Uda Uni Duta Wisata Kabupaten Sijunjung Tahun 2024',
            'slug' => Str::slug('Yuk ikuti dan saksikan Pemilihan Uda Uni Duta Wisata Kabupaten Sijunjung Tahun 2024'),
            'description_short' => 'Uda Uni Duta Wisata Kabupaten Sijunjung 2024',
            'description_long' => ' ',
            'type' => 'berita',
            'kategori_id' => 2, //olahraga
            'photo' => 'uploads/xxx/noimage.jpg',
            'is_active' => 1,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
        ]);

        Konten::create([
            'title' => 'Pelatihan dan Sertfikasi Kompetensi Pemandu Geowisata Kabupaten Sijunjung',
            'slug' => Str::slug('Pelatihan dan Sertfikasi Kompetensi Pemandu Geowisata Kabupaten Sijunjung'),
            'description_short' => 'Pada tanggal 15 dan 16 Juli 2024 dilangsungkan Pelatihan dan Sertifikasi Kompetensi Pemandu Geowisata Kabupaten Sijunjung',
            'description_long' => ' Pada tanggal 15 dan 16 Juli 2024 dilangsungkan Pelatihan dan Sertifikasi Kompetensi Pemandu Geowisata Kabupaten Sijunjung yang bertempat dihotel Bukik Gadang. Pelatihan dan sertifikasi diberikan oleh LSP Pramindo sebanyak 14 orang peserta.

Acara dibuka oleh Kepala Dinas Parpora Afrineldi didampingi Kabid Pengembangan destinasi Pariwisata Wilda Ardes. Pada sambutannya Kadis parpora berharap kegiatan ini dapat melahirkan pemandu Geowisata yang profesional di Kabupaten Sijunjung, Setelah acara pembukaan peserta mendapatkan materi pelatihan terlebih dahulu, sebelum pada hari kedua dilaksanakan uji kompetensi peserta untuk mendapatkan sertifikasi pemandu Geowisata.

Pemateri dari LSP Pramindo Heryadi Rachmat dan Supriatna Amiputra, materi yang diberikan berupa menyusun rencana perjalanan Geowisata, menyiapkan perangkat perjalanan, pemahaman tentang informasi Geowisata, melakukan pemanduan di daya tarik Geowisata, memimpin perjalanan Geowisata, melakukan interpretasi dalam pemanduan Geowisata.

Acara ditutup dengan sesi diskusi dan penyampaian kesan pesan peserta terkait kegiatan dan foto bersama.',
            'type' => 'berita',
            'kategori_id' => 2, //olahraga
            'photo' => 'uploads/xxx/noimage.jpg',
            'is_active' => 1,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
        ]);

        Konten::create([
            'title' => 'Mari Ikuti dan Saksikan Festival Randai Kreasi Tingkat Umum dan Pelajar se-Kabupaten Sijunjung',
            'slug' => Str::slug('Mari Ikuti dan Saksikan Festival Randai Kreasi Tingkat Umum dan Pelajar se-Kabupaten Sijunjung'),
            'description_short' => 'Dinas Pariwisata Pemuda dan olahraga Kabupaten Sijunjung kembali mengadakan Festival Randai kreasi tingkat umum dan pelajar',
            'description_long' => 'Dinas Pariwisata Pemuda dan olahraga Kabupaten Sijunjung kembali mengadakan Festival Randai kreasi tingkat umum dan pelajar. kegiatan ini di adakan pada bulan agustus tanggal 8 s/d 11 2024 yang bertempat di Pujasera depan RTH Muaro Sijunjung dan untuk pendaftaran dimulai tanggal 1 Juli s/d 5 Agustus 2024 yang . yuk ikuti dan saksikan kegiatan ini. link pendaftaran https://tinyurl.com/RandaiKreasi2024',
            'type' => 'berita',
            'kategori_id' => 2, // olahraga
            'photo' => 'uploads/xxx/noimage.jpg',
            'is_active' => 1,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
        ]);
        
        Konten::create([
            'title' => 'Dinas Parpora Sijunjung Melaksanakan Pelatihan Eko Wisata',
            'slug' => Str::slug('Dinas Parpora Sijunjung Melaksanakan Pelatihan Eko Wisata'),
            'description_short' => 'Bupati Sijunjung membuka acara pelatihan ekowisata yang di hadiri Kepala Dinas Pariwisata Pemuda dan Olahraga Afrineldi, SH. pelatihan ini dilaksanakan di Hotel Bukik Gadang Muaro Sijunjung',
            'description_long' => 'Bupati Sijunjung membuka acara pelatihan ekowisata yang di hadiri Kepala Dinas Pariwisata Pemuda dan Olahraga Afrineldi, SH. pelatihan ini dilaksanakan di Hotel Bukik Gadang Muaro Sijunjung pada hari Senin tanggal 24 Juni 2024.

Ekowisata merupakan wisata berbasis alam, Kabupaten Sijunjung memiliki potensi alam yang sangat beragam, ada Kawasan geopark, Hutan lindung, sungai, danau, dan goa, papar Kadis Parpora Afrineldi saat menyampaikan sambutan pada pelatihan ini

Dengan pengelolaan alam yang baik akan menjadi manfaat membuka lapangan pekerjaan sehingga akan meningkatkan ekonomi masyarakat Ranah Lansek Manih. Maka dengan adanya pelatihan pemandu ekowisata ini diharapkan para pemandu ekowisata dapat melindungi dan memanfaatkan alam dengan baik. Kiita memiliki program pengembangan Kawasan geopark ranah minang silokek yang selalu melakukan pembenahan dan persiapan untuk menuju UGG(unesco Global Geopark). Kabupaten Sijunjung melalui Dinas Pariwisata Pemuda dan Olahraga menggelar pelatihan pemandu Ekowisata guna meningkatkan kompetensi para pemandu wisata memenuhi Standar Kompetensi Kerja Nasional Indonesia (SKKNI) bidang kepemanduan Ekowisata jelas Afrineldi.

Ketua Pelaksana Wilda Ardes selaku Kabid Bidang PDP (Pengembangan Destinasi Pariwisata) menyampaikan tujuan Pelatihan Pemandu Ekowisata adalah untuk meningkatkan pengetahuan, motivasi, dan kompetensi Pengelola objek wisata dan Geosite agar dapat memenuhi standar kompetensi kerja nasional Indonesia (SKKNI) bidang kepemanduan, Peserta Berasal dari kelompok sadar wisata, pengelola objek wisata dan Masyarakat yang tinggal di Geosite Geopark Ranah Minang Silokek dengan jumlah peserta 30 orang.

Pelatihan Ekowisata ini mengusung tema Wisata Berkembang, Geopark Mendunia, Lingkungan Terjaga Masyarakat Sejahtera”, berlangsung selama 3 (tiga) hari dari tanggal 24 s/d 26 Juni 2024',
            'type' => 'berita',
            'kategori_id' => 2, //olahraga
            'photo' => 'uploads/xxx/noimage.jpg',
            'is_active' => 1,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
        ]);
        
        Konten::create([
            'title' => 'Disparpora Sijunjung Melaksanakan Pelatihan Pemandu Geowisata',
            'slug' => Str::slug('Disparpora Sijunjung Melaksanakan Pelatihan Pemandu Geowisata'),
            'description_short' => 'Pelatihan Pemandu Geowisata diikuti Sebanyak 30 yang dilaksanakan di Hotel Bukit Gadang Muaro Sijunjung selama 3 hari, pada hari Senin sampai Rabu, 13 s/d 15 Mei 2024',
            'description_long' => 'Pelatihan Pemandu Geowisata diikuti Sebanyak 30 yang dilaksanakan di Hotel Bukit Gadang Muaro Sijunjung selama 3 hari, pada hari Senin sampai Rabu, 13 s/d 15 Mei 2024

Pelatihan yang dibuka Bupati Sijunjung, Benny Dwifa Yuswir diwakili oleh Kepala Dinas Pariwsata Pemuda dan Olahraga Afrineldi, SH pada Senin 13 Mei 2024 dan turut dihadiri oleh Sekretaris Dinas Parpora, Desmawati, SE,.M.Si serta Pejabat Fungsional Analis Kebijakan Ahli Muda Dinas Parpora, Sparta, SE, M.Si

Dalam sambutannya, Kadis Parpora Afrineldi mengatakan bahwa dalam pengembangan geopark ranah minang silokek dibutuhkan pemandu geowisata sebagai pusat informasi bagi para pengunjung.

“Peningkatan sumber daya manusia pengelola objek wisata harus selalu kita lakukan, sehingga terdapat pemerataan kemampuan bagi seluruh anggota pokdarwis, pengelola objek wisata harus bisa mengikuti pelatihan, dan memiliki kompetensi sesuai dengan bidangnya masing – masing,”ujarnya

Ia menambahkan bahwa pada saat ini kegiatan wisata alam menjadi objek wisata yang banyak diminati, sehingga menjadi peluang dalam membangun kepariwisataan di Indonesia bahkan di Kabupaten Sijunjung yang memiliki tempat-tempat wisata yang masih alami.

“Pemerintah Daerah sangat mendukung terhadap kegiatan peningkatan sumber daya manusia, diantaranya memberikan pelatihan untuk pokdarwis – pokdarwis yang ada di Kabupaten Sijunjung seperti saat ini,”lanjutnya

Sementara itu, Kabid Pengembangan Destinasi Pariwisata Dinas Parpora. Wilda Ardes, ST, MT selaku panitia pelaksana mengatakan bahwa Pelatihan Pemandu Geowisata ini bertujuan untuk meningkatkan pengetahuan, motivasi, dan kompetensi Pengelola objek wisata agar dapat memenuhi standar kompetensi kerja nasional Indonesia (SKKNI) bidang kepemanduan Peserta pelatihan ini lanjut berasal dari kelompok sadar wisata (POKDARWIS) dan pengelola objek wisata dan Masyarakat yang tinggal di Geosite Geopark Ranah Minang Silokek.',
            'type' => 'berita',
            'kategori_id' => 2, //Geopark Ranah Minang Silokek
            'photo' => 'uploads/xxx/noimage.jpg',
            'is_active' => 1,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
        ]);
        
        Konten::create([
            'title' => 'Peringatan Hari Bumi Internasional',
            'slug' => Str::slug('Peringatan Hari Bumi Internasional'),
            'description_short' => 'Tanggal 22 April yang biasa diperingati setiap tahunnya sebagai hari bumi internasional, sebanyak 22 Organisasi / Lembaga/Komunitas se Kabupaten Sijunjung',
            'description_long' => 'Tanggal 22 April yang biasa diperingati setiap tahunnya sebagai hari bumi internasional, sebanyak 22 Organisasi / Lembaga/Komunitas se Kabupaten Sijunjung (Dinas Parpora, Dinas Perkim LH, BP. Geopark, KKI WARSI, IMAS  Batusangkar, IMAS Bukittinggi, Literasi Kita, PDAM, MASATA, RAI, Pokdarwis, SAPMA, GYF, Sijunjung Muda Berkarya, Duta Genre, Sispala, Forsilamsi, Bank Sampah, Guru Penggerak, English Education Vilage Taratak Baru, Duta Budaya dan K_Laskita), melakukan peringatan dengan beberapa kegiatan selama 2 hari  ( 27 dan 28 April 2024 ). Kegiatan diawali tanggal 27 April dengan aksi penanaman pohon sebanyak 500 batang di areal SMPN 45 Sijunjung dan sekitarnya, selanjutnya di Pusat Informasi Geopark Ranah Minang Silokek melakukan pengenalan geopark, sharing session, lomba daur ulang sampah plastik tingkat SD dan SLTP, pengenalan ekoprint dan cara daur ulang sampah plastik selanjutnya tanggal 28 April dilakukan aksi pungut sampah plastik di Perkampungan Adat Sijunjung.

Afrineldi SH selaku Kepala Dinas Disparpora juga melakukan penanaman pohon di Sekitar area SMPN 45 Sijunjung yang didampingi oleh Kabid Pemasaran Pariwisata Rahmad Azandi Fajar, S.STP dan beberapa orang Kasi.

Momen peringatan hari bumi ini dilaksanakan dalam upaya membangun kebersamaan antar komunitas, meningkatkan kepedulian terhadap lingkungan terutama sampah plastik baik untuk pelajar maupun komunitas,

Sebagai penanggung jawab kegiatan mengucapkan terimakasih kepada para relawan dan komunitas yang telah berpartisipasi mensukseskan kegiatan tersebut

Dan kepada para pihak yang telah memberikan sumbangan baik tenaga maupun pembiayaan kami mengucapkan terimakasih semoga kegiatan ini bermanfaat baik untuk konservasi maupun edukasi dalam upaya menjaga bumi khususnya di Kabupaten Sijunjung',
            'type' => 'berita',
            'kategori_id' => 2, //olahraga
            'photo' => 'uploads/xxx/noimage.jpg',
            'is_active' => 1,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
        ]);
        
        Konten::create([
            'title' => 'Festival Lansek Manih Kembali digelar',
            'slug' => Str::slug('Festival Lansek Manih Kembali digelar'),
            'description_short' => 'Festival Lansek Manih (FLM) adalah kalender tahunan Pemerintah Daerah Kabupaten Sijunjung',
            'description_long' => 'Festival Lansek Manih (FLM) adalah kalender tahunan Pemerintah Daerah Kabupaten Sijunjung, yang biasanya dilaksanakan bersamaan dengan peringatan Hari Jadi Kabupaten (HJK) Sijunjung yang jatuh pada bulan Februari setiap tahunnya.

Berhubung dengan agenda nasional, Pemilu serentak yang berdekatan waktunya dengan peringatan HJK Sijunjung, maka FLM tahun 2024 dilaksanakan di Bulan April ini, dengan mengangkat tema ” Culture Diversity and Geoproduct UMKM/EKRAF Geopark Ranah Minang Silokek Menyambut Urang Rantau Pulang ka Kampuang”

Benny Dwifa Yuswir pada sambutannya, Kamis,18 April 2024 di Ruang Terbuka Hijau Logas Muaro Sijunjung, mengucapkan Terimakasih kepada Forkopimda yang lengkap hadir pada acara itu, termasuk para pejabat daerah tetangga seperti Tanah Datar dan Sawahlunto.

“Kunci dari kita bisa berbuat maksimal untuk daerah adalah dengan adanya kekompakan, ini terbukti dengan meningkatnya IPM Sijunjung menjadi peringkat 12 Provinsi Sumbar, ini tidak lepas dari peran dan sinergi kita semua” kata Bupati Sijunjung Benny Dwifa Yuswir',
            'type' => 'berita',
            'kategori_id' => 2, //kegiatan
            'photo' => 'uploads/xxx/noimage.jpg',
            'is_active' => 1,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
        ]);
        
        Konten::create([
            'title' => 'Diparpora Kembali Melaksanakan Pelatihan Pemandu Keselamatan Wisata Tirta',
            'slug' => Str::slug('Diparpora Kembali Melaksanakan Pelatihan Pemandu Keselamatan Wisata Tirta'),
            'description_short' => '1 s/d 3 Desember disparpora kembali melaksanakan Pelatihan Pemandu Keselamatan Wisata Tirta yang bertempat di Nyalo Beach Cotage Kawasan Mandeh',
            'description_long' => '1 s/d 3 Desember disparpora kembali melaksanakan Pelatihan Pemandu Keselamatan Wisata Tirta yang bertempat di Nyalo Beach Cotage Kawasan Mandeh, kegiatan ini diikuti oleh Pokdarwis dan pengelola Desa Wisata sebanyak 40 orang. kegiatan ini dibuka secara langsung oleh Kepala dinas Pariwisata Pemuda dan Olah Raga Kabupaten Sijunjung Afrineldi, SH.',
            'type' => 'berita',
            'kategori_id' => 2, //olahraga
            'photo' => 'uploads/xxx/noimage.jpg',
            'is_active' => 1,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
        ]);
        
        Konten::create([
            'title' => 'Sijunjung Menjadi Tuan Rumah Rakornas Geopark Indonesia Tahun 2023',
            'slug' => Str::slug('Sijunjung Menjadi Tuan Rumah Rakornas Geopark Indonesia Tahun 2023'),
            'description_short' => 'Kawasan Geopark Ranah Minang Silokek, Kabupaten Sijunjung, Sumatera Barat dipercaya sebagai tempat penyelenggaraan Rapat Koordinasi Nasional (Rakornas) Geopark Indonesia tahun 2023',
            'description_long' => 'Kawasan Geopark Ranah Minang Silokek, Kabupaten Sijunjung, Sumatera Barat dipercaya sebagai tempat penyelenggaraan Rapat Koordinasi Nasional (Rakornas) Geopark Indonesia tahun 2023 dan Perencanaan Program Kerja tahun 2024 Komisi Perencanaan Komite Nasional Geopark Indonesia.

Seremonial Pembukaan acara Rakornas tersebut digelar di Gedung Pancasila Muaro, Senin (20/11/23).

Hadir kesempatan itu, Wakil Bupati Sijunjung, Iraddatillah, Wakil Ketua DPRD Kabupaten Sijunjung, Unsur Forkopimda Kabupaten Sijunjung, Ketua Pengadilan Negeri Muaro, Ketua Pengadilan Agama Sijunjung serta undangan lainnya.

Dalam sambutannya, Bupati Sijunjung Benny Dwifa Yuswir mengucapkan terimakasih atas kepercayaan dan kesempatan dengan ditunjuknya Geopark Ranah Minang Silokek sebagai tempat penggelaran acara berskala nasional ini.

“Terimakasih yang sebesar-besarnya kepada pihak Bappenas dan panitia penyelenggara Rakornas yang telah menunjuk Kawasan Geopark Ranah Minang Silokek. Dengan adanya acara berskala nasional ini tentu Kabupaten Sijunjung lebih dikenal ditingkat nasional maupun internasional, sehingga bisa ditetapkan sebagai warisan dunia atau Unesco Global Geopark (UGGp),” ujarnya.',
            'type' => 'berita',
            'kategori_id' => 2, //Geopark Ranah Minang Silokek
            'photo' => 'uploads/xxx/noimage.jpg',
            'is_active' => 1,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
        ]);
        
        Konten::create([
            'title' => 'Sijunjung Kembali Raih Penghargaan API Award Tahun 2023',
            'slug' => Str::slug('Sijunjung Kembali Raih Penghargaan API Award Tahun 2023'),
            'description_short' => 'Malam Puncak Anugerah Pesona Indonesia Tahun ini dilaksanakan di Kota Ambon yang bertempat di Gedung Presisi Manise Polda Maluku pada tanggal 1 November 2023.',
            'description_long' => 'Malam Puncak Anugerah Pesona Indonesia Tahun ini dilaksanakan di Kota Ambon yang bertempat di Gedung Presisi Manise Polda Maluku pada tanggal 1 November 2023.

Ajang ini diikuti oleh bebagai Kabupaten Kota yang ada di Indonesia, Alhamdulillah Sijunjung kembali raih Juara II Kategori Festival Pariwisata pada Tahun ini.

“Kepada para pemenang berbagai kategori, saya mengucapkan selamat dan terus menjadi yang terbaik dalam meningkatkan kualitas dan daya saing pariwisata,” kata Gubernur Maluku Murad Ismail, di Ambon, Rabu malam.

Provinsi Maluku berhasil meraih juara umum pada malam puncak acara Anugerah Pesona Indonesia (API) ke-8 2023, dengan mendapatkan 10 kategori penghargaan dari 18 kategori.',
            'type' => 'berita',
            'kategori_id' => 2, //anugerah
            'photo' => 'uploads/xxx/noimage.jpg',
            'is_active' => 1,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
        ]);
        
        Konten::create([
            'title' => 'Pemuda Pelopor Utusan Kabupaten Sijunjung Berhasil Meraih Juara 1 Pada Ajang Pemuda Pelopor Tingkat Nasional',
            'slug' => Str::slug('Pemuda Pelopor Utusan Kabupaten Sijunjung Berhasil Meraih Juara 1 Pada Ajang Pemuda Pelopor Tingkat Nasional'),
            'description_short' => 'Govinda Yuli Effendi, Pemuda Pelopor utusan Kabupaten Sijunjung berhasil mendapatkan Juara 1 pada Pemuda Pelopor Tingkat Nasional yang diadakan di Jakarta.',
            'description_long' => 'Govinda Yuli Effendi, Pemuda Pelopor utusan Kabupaten Sijunjung berhasil mendapatkan Juara 1 pada Pemuda Pelopor Tingkat Nasional yang diadakan di Jakarta. Govinda masuk dalam kategori Bidang Sumber Daya Alam, Lingkungan dan Pariwisata. Kadis Parpora Kabupaten Sijunjung Afrineldi, SH menuturkan, rasa haru dan bangga kami yang tak terhingga, kerja keras dalam membina para pemuda pelopor di Kabupateb Sijunjung tidak lah sia-sia. “Kepada Pemda Sijunjung dibawah kepemimpinan Bupati, Wakil Bupati dan semua stakekholder yang  turut membantu kesuksesan ini, tentu kita aturkan terima kasih ,” ujar  Afrineldi.

Dengan terpilihnya Govinda menjadi juara Nasional maka sudah 3 kali pemuda pelopor Kabupaten Sijunjung dalam kurun waktu 5 tahun terakhir menjadi juara tingkat nasional, hal ini membuktikan bahwa pemuda- pemuda Kabupaten Sijunjung adalah pemuda- pemuda yang potensial dan hebat.',
            'type' => 'berita',
            'kategori_id' => 2, //anugerah
            'photo' => 'uploads/xxx/noimage.jpg',
            'is_active' => 1,
            'created_by' => 1,
            'updated_by' => 1, 
            'created_at' => now(),
        ]);
        
        Konten::create([
            'title' => 'Disparpora Sijunjung Menggelar Pelatihan Inovasi dan Higienitas Sajian Kuliner di Destinasi Wisata',
            'slug' => Str::slug('Disparpora Sijunjung Menggelar Pelatihan Inovasi dan Higienitas Sajian Kuliner di Destinasi Wisata'),
            'description_short' => 'Disparpora Sijunjung sukses melakukan pelatihan Inovasi dan Higienitas sajian kuliner di destinasi wisata diikuti oleh 40 Peserta yang terdiri dari pelaku ekraf',
            'description_long' => 'Disparpora Sijunjung sukses melakukan pelatihan Inovasi dan Higienitas sajian kuliner di destinasi wisata diikuti oleh 40 Peserta yang terdiri dari pelaku ekraf, pengelola homestay,penginapan dan hotel pada 12 sampai dengan 14 Oktober 2023 di Bukittinggi. Pelatihan dibuka oleh Ketua Dekranasda Kab. Sijunjung Ny. Riri Benny Dwifa, dihadri juga oleh Kepala Dinas Pariwisata Pemuda dan Olahraga, Afrineldi, S.H.  Dalam pelatihan ini dihadirkan narasumber yang kompeten dibidangnya. Peserta dibekali ilmu mengenai Kreativitas dan Inovasi dalam penyajian kuliner, standar dan higienitas sajian kuliner di Indonesia dan Dunia,serta ekosistem kuliner di Indonesia. Tidak hanya itu, peserta juga diajak mengunjungi salah satu restoran di Bukittinggi oleh salah satu narasumber untuk melihat bagaimana inovasi dan kreasi dalam menyajikan kuliner yang menarik. Peserta juga dibekali dengan praktek lapangan di BLK Muaro yaitu membuat kuliner dan dessert didampingi oleh tutor professional. Pelatihan ini diharapkan memberikan dampak terhadap perkembangan pariwisata di Kabupaten Sijunjung. Ilmu yang telah dibekali kepada para peserta dapat dimanfaatkan di sektor pariwisata yang dikelolanya.',
            'type' => 'berita',
            'kategori_id' => 2, //kegitan
            'photo' => 'uploads/xxx/noimage.jpg',
            'is_active' => 1,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
        ]);
        
        // Konten::create([
        //     'title' => 'Yuk ikuti dan saksikan Pemilihan Uda Uni Duta Wisata Kabupaten Sijunjung Tahun 2024',
        //     'slug' => Str::slug('Yuk ikuti dan saksikan Pemilihan Uda Uni Duta Wisata Kabupaten Sijunjung Tahun 2024'),
        //     'description_short' => 'Uda Uni Duta Wisata Kabupaten Sijunjung 2024',
        //     'description_long' => ' ',
        //     'type' => 'berita',
        //     'kategori_id' => 2, //anugerah
        //     'photo' => 'uploads/xxx/noimage.jpg',
        //     'is_active' => 1,
        //     'created_by' => 1,
        //     'updated_by' => 1,
        //     'created_at' => now(),
        // ]);
    }
}
