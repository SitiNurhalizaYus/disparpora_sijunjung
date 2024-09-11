@extends('client.layouts.app')

@section('content')
    <div class="container-fluid position-relative p-0">
        <div class="container-fluid bg-primary py-5 bg-header">
            <div class="row py-5">
                <div class="col-12 pt-lg-5 mt-lg-5 text-center">
                    <img src="{{ asset('/' . str_replace('/xxx/', '/100/', $setting['logo-parpora'])) }}" alt="Logo"
                        class="logo">
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
                <span class="text-green">Lokawisata</span>
            </div>
        </div>

        <!-- Event Cards Container -->
        <div id="event-cards-container" class="event-cards"></div>

        <!-- Spinner for loading -->
        <div id="loading-spinner" class="text-center my-5" style="display:none;">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <!-- Load More Button -->
        <div id="load-more-container" class="text-center my-5" style="display:none;">
            <button id="load-more-btn" class="btn btn-primary">Load More</button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        var currentPage = 1;  // Halaman pertama
        var perPage = 8;  // Jumlah data per halaman
        var lastPage = false; // Indikator apakah sudah mencapai halaman terakhir

        // Fungsi untuk memuat data Lokawisata menggunakan AJAX
        function loadLokawisata(page = 1) {
            // Tampilkan spinner
            $('#loading-spinner').show();
            $('#load-more-container').hide();

            // Lakukan request AJAX ke API Lokawisata dengan parameter halaman dan jumlah data per halaman
            $.ajax({
                url: `/api/lokawisata?page=${page}&per_page=${perPage}`,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    var eventCards = '';
                    
                    // Periksa apakah data tersedia
                    if (response.data && response.data.length > 0) {
                        response.data.forEach(function(item) {
                            eventCards += `
                                <div class="event-card">
                                    <div class="event-image">
                                        <img src="${item.image}" alt="${item.name}">
                                    </div>
                                    <div class="event-details">
                                        <h3 class="event-title">${item.name}</h3>
                                        <a href="{{ url('/lokawisata') }}/${item.slug}" class="event-link">Detail</a>
                                    </div>
                                </div>
                            `;
                        });

                        // Tambahkan data baru ke container
                        $('#event-cards-container').append(eventCards);

                        // Cek apakah sudah halaman terakhir
                        if (response.data.length < perPage) {
                            lastPage = true;
                        }
                    } else {
                        // Jika tidak ada data, sembunyikan tombol Load More
                        lastPage = true;
                    }

                    // Sembunyikan spinner
                    $('#loading-spinner').hide();

                    // Tampilkan tombol Load More jika belum mencapai halaman terakhir
                    if (!lastPage) {
                        $('#load-more-container').show();
                    }
                },
                error: function(xhr, status, error) {
                    // Sembunyikan spinner dan tampilkan pesan error
                    $('#loading-spinner').hide();
                    $('#event-cards-container').html('<p>Error loading data</p>');
                }
            });
        }

        // Panggil fungsi loadLokawisata saat halaman dimuat
        $(document).ready(function() {
            loadLokawisata();

            // Ketika tombol Load More diklik
            $('#load-more-btn').on('click', function() {
                currentPage++; // Tambah halaman
                loadLokawisata(currentPage); // Muat data baru
            });
        });
    </script>
@endsection
