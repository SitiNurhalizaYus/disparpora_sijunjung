@extends('client.layouts.app')

@section('content')
    <div class="container-fluid position-relative p-0">
        <!-- Header Section -->
        <div class="container-fluid bg-primary py-5 bg-header">
            <div class="row py-5">
                <div class="col-12 pt-lg-5 mt-lg-5 text-center">
                    <img src="{{ asset('/' . str_replace('/xxx/', '/100/', $setting['logo-parpora'])) }}" alt="Logo"
                        class="logo mb-4">
                    <div class="logo-text">
                        <h3 class="text-light">{{ $setting['name-long'] }}</h3>
                        <p>Kabupaten Sijunjung</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid bg-primary py-3 bg-light">
            <div class="text-star px-5">
                <a href="{{ url('/beranda') }}" class="text-green">Beranda</a>
                <i class="bi bi-arrow-right-short text-green px-2"></i>
                <a href="{{ route('client.lokawisata.index') }}" class="text-green">Lokawisata</a>
                <i class="bi bi-arrow-right-short text-green px-2"></i>
                <span class="text-green" id="breadcrumb-title">Detail</span>
            </div>
        </div>

        <!-- Detail Container -->
        <div class="container mt-5">
            <div class="row">
                <!-- Gambar dan Petunjuk Arah -->
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <img id="lokawisata-image" src="" alt="" class="card-img-top">
                        <div class="card-body text-center">
                            <h1 id="lokawisata-name" class="card-title"></h1>
                            <!-- Tampilkan tombol hanya jika link tidak null -->
                            <a id="lokawisata-link" href="#" class="btn btn-primary mt-3" style="display:none;">
                                <i class="bi bi-geo-alt-fill"></i> Petunjuk Arah
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Deskripsi, Fasilitas, Jam Operasional, Harga Tiket -->
                <div class="col-md-6">
                    <div class="detail-section mb-4">
                        <h2>Deskripsi</h2>
                        <p id="lokawisata-description"></p>
                    </div>

                    <div class="detail-section mb-4">
                        <h2>Fasilitas</h2>
                        <ul id="lokawisata-facilities"></ul>
                    </div>

                    <div class="detail-section mb-4">
                        <h2>Jam Operasional</h2>
                        <p id="lokawisata-operating-hours"></p>
                    </div>

                    <div class="detail-section mb-4">
                        <h2>Harga Tiket</h2>
                        <p id="lokawisata-ticket-price"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Fungsi untuk memformat angka menjadi format Rupiah
        function formatRupiah(angka) {
            var number_string = angka.toString().replace(/[^,\d]/g, ''),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            return 'Rp. ' + rupiah;
        }

        // Fungsi untuk memuat detail konten berdasarkan slug dari URL
        function loadContentDetail(slug) {
            $.ajax({
                url: '/api/lokawisata/' + slug, // API endpoint untuk mengambil detail berdasarkan slug
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        const lokawisata = response.data;

                        // Isi data pada elemen HTML
                        $('#lokawisata-image').attr('src', lokawisata.image);
                        $('#lokawisata-name').text(lokawisata.name);
                        $('#breadcrumb-title').text(lokawisata.name);
                        $('#lokawisata-description').html(lokawisata.description);
                        $('#lokawisata-operating-hours').text(lokawisata.operating_hours);

                        // Format fasilitas menjadi list
                        const facilities = lokawisata.facilities.split(',');
                        let facilitiesHtml = '';
                        facilities.forEach(function(facility) {
                            facilitiesHtml += '<li>' + facility.trim() + '</li>';
                        });
                        $('#lokawisata-facilities').html(facilitiesHtml);

                        // Format harga tiket ke format Rupiah
                        $('#lokawisata-ticket-price').text(formatRupiah(lokawisata.ticket_price));

                        // Tampilkan tombol petunjuk arah jika link tidak null
                        if (lokawisata.link) {
                            $('#lokawisata-link').attr('href', lokawisata.link).show();
                        } else {
                            $('#lokawisata-link').hide();
                        }
                    } else {
                        console.error('Gagal mengambil data');
                    }
                },
                error: function() {
                    console.error('Terjadi kesalahan dalam mengambil data');
                }
            });
        }

        // Saat dokumen sudah siap, jalankan fungsi ini
        $(document).ready(function() {
            const slug = window.location.pathname.split('/').pop();
            loadContentDetail(slug); // Panggil fungsi untuk memuat data detail berdasarkan slug
        });
    </script>
@endsection
