<?php

namespace Database\Seeders;

use App\Models\Agent;
use App\Models\InfoTempat;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class InfoTempatTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        InfoTempat::create([
            'name' => 'Air Terjun Palukahan',
            'slug' => 'air-terjun-palukahan',
            'description' => 'Air Terjun Palukahan adalah salah satu destinasi wisata alam yang berada di Kabupaten Sijunjung, Sumatera Barat. Terletak di kawasan yang dikelilingi oleh hutan lebat, air terjun ini menawarkan pemandangan yang indah dan suasana yang sejuk. Palukahan merupakan air terjun yang belum banyak diketahui wisatawan, sehingga tempat ini masih sangat alami dan jarang dikunjungi, menjadikannya lokasi yang ideal untuk mereka yang mencari ketenangan dan keindahan alam yang belum terjamah.
            Air terjun ini memiliki ketinggian yang cukup signifikan, dengan aliran air yang jernih dan segar yang jatuh dari ketinggian tebing ke kolam alami di bawahnya. Kolam tersebut biasanya digunakan oleh pengunjung untuk berenang atau sekadar bermain air. Selain keindahan air terjunnya, kawasan sekitar Palukahan juga menyajikan pemandangan hutan tropis yang asri, dengan flora dan fauna yang beragam. Untuk mencapai Air Terjun Palukahan, pengunjung biasanya harus melakukan perjalanan dengan berjalan kaki melewati jalur yang menantang, tetapi sepadan dengan pemandangan yang ditawarkan. Meskipun aksesnya mungkin tidak mudah, keindahan dan keasrian tempat ini menjadikan Air Terjun Palukahan sebagai salah satu destinasi yang patut dikunjungi bagi pencinta alam.',
            'facilities' => 'Parkir, Jalur Trekking, Rest Area',
            'operating_hours' => '08:00 - 17:00',
            'ticket_price' => 'free',
            'image' => 'noimage.jpg',
            'is_active' => true,
        ]);

        InfoTempat::create([
            'name' => 'Air Terjun Lubuk Kinari',
            'slug' => 'air-terjun-lubuk-kinari',
            'description' => 'Air Terjun Lubuk Kinari adalah salah satu destinasi wisata alam yang terletak di Kabupaten Sijunjung, Sumatera Barat. Air terjun ini terkenal karena keindahan alamnya dan suasana yang sejuk, dengan air yang jernih mengalir dari ketinggian tebing ke kolam alami di bawahnya. Dikelilingi oleh hutan tropis yang lebat, Lubuk Kinari menawarkan pemandangan yang memukau dan ketenangan yang sulit ditemukan di tempat lain.

            Lubuk Kinari tidak hanya menawarkan air terjun yang indah, tetapi juga lingkungan sekitarnya yang asri dan alami. Hutan di sekitar air terjun kaya akan flora dan fauna, membuatnya menjadi tempat yang menarik bagi para pencinta alam dan fotografer. Jalur menuju air terjun biasanya melibatkan trekking melalui hutan yang menambah sensasi petualangan bagi pengunjung.

            Air Terjun Lubuk Kinari memiliki beberapa tingkatan, di mana air mengalir dari satu tingkatan ke tingkatan lainnya, menciptakan serangkaian kolam alami yang dapat digunakan untuk berenang atau sekadar bermain air. Airnya yang jernih dan sejuk sangat menyegarkan, terutama setelah perjalanan melalui hutan.

            Untuk mencapai air terjun ini, pengunjung harus menempuh perjalanan yang cukup menantang, baik dengan kendaraan maupun berjalan kaki. Meskipun aksesnya tidak mudah, keindahan dan keasrian alam yang ditawarkan oleh Lubuk Kinari menjadikannya salah satu destinasi wisata yang patut dikunjungi di Sumatera Barat. Karena masih belum terlalu dikenal dan dikunjungi oleh banyak wisatawan, Lubuk Kinari tetap mempertahankan kealamian dan keindahannya yang masih sangat terjaga.',
            'facilities' => 'Parkir, Jalur Trekking, Rest Area',
            'operating_hours' => '08:00 - 17:00',
            'ticket_price' => 'free',
            'image' => 'noimage.jpg',
            'is_active' => true,
        ]);

        InfoTempat::create([
            'name' => 'Air Terjun Lubuk Lundang',
            'slug' => 'air-terjun-lubuk-lundang',
            'description' => 'Air Terjun Lubuk Lundang adalah salah satu destinasi wisata alam yang terletak di Kabupaten Sijunjung, Sumatera Barat. Air terjun ini dikenal dengan keindahan dan keasrian alamnya, yang menawarkan pengalaman alam yang memukau bagi para pengunjung. Terletak di kawasan yang masih sangat alami, Lubuk Lundang memberikan suasana yang tenang dan damai, jauh dari keramaian kota.

            Air Terjun Lubuk Lundang memiliki ketinggian yang cukup signifikan, dengan air yang jatuh dari tebing dan mengalir ke kolam alami di bawahnya. Airnya jernih dan segar, cocok untuk berenang atau sekadar bermain air di kolam yang terbentuk secara alami. Selain itu, lingkungan sekitar air terjun ini dikelilingi oleh hutan tropis yang lebat, menambah kesan alami dan sejuk bagi para pengunjung.

            Jalur menuju Air Terjun Lubuk Lundang biasanya melibatkan trekking yang cukup menantang, melewati hutan dan jalan setapak yang terjal. Meski perjalanan menuju air terjun ini membutuhkan usaha ekstra, pemandangan yang ditawarkan di sepanjang jalan dan keindahan air terjun yang menanti di ujung perjalanan membuat semuanya sepadan.

            Karena lokasinya yang relatif terpencil dan belum terlalu banyak dieksplorasi oleh wisatawan, fasilitas di sekitar air terjun ini masih minim. Pengunjung disarankan untuk mempersiapkan segala keperluan dengan baik sebelum berangkat, termasuk membawa makanan, minuman, dan perlengkapan pribadi lainnya. Mengunjungi Air Terjun Lubuk Lundang akan memberikan pengalaman yang mendalam dalam menikmati keindahan alam Sumatera Barat yang masih murni dan belum banyak terjamah.',
            'operating_hours' => '08:00 - 17:00',
            'ticket_price' => 'free',
            'image' => 'noimage.jpg',
            'is_active' => true,
        ]);

        InfoTempat::create([
            'name' => 'Gunuang Tampalo Bukik Panjamuan',
            'slug' => 'gunuang-tampalo-bukik-panjamuan',
            'description' => 'Gunuang Tampalo, juga dikenal sebagai Bukik Panjamuan, adalah salah satu destinasi wisata alam di Kabupaten Sijunjung, Sumatera Barat, yang menawarkan panorama pegunungan dan perbukitan yang memukau. Tempat ini menjadi daya tarik bagi para penggemar alam dan pendaki karena keindahan alamnya serta pemandangan yang dapat dinikmati dari puncaknya.',
            'facilities' => 'Parkir, Jalur Trekking, Rest Area',
            'operating_hours' => '08:00 - 17:00',
            'ticket_price' => 'free',
            'image' => 'noimage.jpg',
            'is_active' => true,
        ]);

        InfoTempat::create([
            'name' => 'Puncak Bukik Sangkiang',
            'slug' => 'puncak-bukik-sangkiang',
            'description' => 'Puncak Bukik Sangkiang adalah salah satu destinasi wisata alam yang menonjol di Kabupaten Sijunjung, Sumatera Barat. Bukik Sangkiang menawarkan pemandangan alam yang memukau dari ketinggian, di mana pengunjung dapat menikmati panorama pegunungan, perbukitan, dan hamparan hijau yang membentang luas. Tempat ini menjadi tujuan favorit bagi mereka yang mencari ketenangan dan keindahan alam serta bagi para pendaki yang menyukai tantangan.

            Bukik Sangkiang dikenal karena puncaknya yang menawarkan pemandangan spektakuler, terutama saat matahari terbit atau terbenam. Dari puncaknya, pengunjung dapat melihat lanskap yang luas, termasuk hamparan sawah, hutan, dan desa-desa kecil di kejauhan. Saat cuaca cerah, pemandangan ini tampak sangat jelas dan menakjubkan, menjadikannya lokasi yang sempurna untuk fotografi alam.

            Untuk mencapai Puncak Bukik Sangkiang, pengunjung harus melakukan pendakian melalui jalur yang telah tersedia. Pendakian ini memerlukan stamina yang cukup karena medan yang menanjak, tetapi tidak terlalu sulit bagi pendaki pemula. Jalur menuju puncak dikelilingi oleh pemandangan alam yang indah, dengan udara yang segar dan sejuk, memberikan pengalaman mendaki yang menyenangkan.

            Di puncak, biasanya terdapat area yang cukup luas bagi pengunjung untuk beristirahat dan menikmati pemandangan. Sebagian pendaki bahkan memilih untuk berkemah di puncak, menikmati suasana malam di tengah alam yang tenang. Meski fasilitas di Puncak Bukik Sangkiang masih terbatas, tempat ini tetap menarik bagi para penggemar alam dan pendakian.

            Secara keseluruhan, Puncak Bukik Sangkiang adalah destinasi yang menawarkan keindahan alam yang luar biasa dan pengalaman mendaki yang memuaskan. Tempat ini cocok bagi mereka yang ingin menjauh sejenak dari kesibukan sehari-hari dan menikmati kedamaian serta keindahan alam Sumatera Barat.',
            'facilities' => 'Parkir, Jalur Trekking, Rest Area',
            'operating_hours' => '08:00 - 17:00',
            'ticket_price' => 'free',
            'image' => 'noimage.jpg',
            'is_active' => true,
        ]);

        InfoTempat::create([
            'name' => 'Bukik Kunik',
            'slug' => 'bukik-kunik',
            'description' => 'Bukik Kunik adalah salah satu destinasi wisata alam yang terletak di Kabupaten Sijunjung, Sumatera Barat. Tempat ini terkenal dengan pemandangan alamnya yang indah, yang mencakup perbukitan hijau, lembah-lembah yang subur, dan udara yang sejuk. Bukik Kunik menjadi tujuan yang menarik bagi wisatawan yang mencari kedamaian di tengah alam yang masih alami dan belum banyak tersentuh oleh perkembangan modern.',
            'facilities' => 'Parkir, Jalur Trekking, Rest Area',
            'operating_hours' => '08:00 - 17:00',
            'ticket_price' => 'free',
            'image' => 'noimage.jpg',
            'is_active' => true,
        ]);
    }
}
