@extends('client.layouts.app')

@section('content')
    <!--Carousel Start -->
    <div class="container-fluid position-relative p-0">
        <div id="header-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="w-100" src="{{ asset('landingpage/assets/img/carousel-1.jpeg') }}" alt="Image">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3" style="max-width: 900px;">
                            <h5 class="text-white text-uppercase mb-3 animated slideInDown">Explore Sijunjung</h5>
                            <h1 class="display-1 text-white mb-md-4 animated zoomIn">Discover the Beauty of Sijunjung</h1>
                            <a href="{{ url('/lokawisata') }}"
                                class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Lihat Destinasi</a>
                            <a href="{{ url('/message') }}"
                                class="btn btn-outline-light py-md-3 px-md-5 animated slideInRight">Hubungi Kami</a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="w-100" src="{{ asset('landingpage/assets/img/carousel-2.jpeg') }}" alt="Image">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3" style="max-width: 900px;">
                            <h5 class="text-white text-uppercase mb-3 animated slideInDown">Sports in Sijunjung</h5>
                            <h1 class="display-1 text-white mb-md-4 animated zoomIn">Enhancing Youth and Sports</h1>
                            <a href="{{ url('/artikel') }}"
                                class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Explore Sports</a>
                            <a href="{{ url('/message') }}"
                                class="btn btn-outline-light py-md-3 px-md-5 animated slideInRight">Hubungi Kami</a>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <!--Carousel End -->

    <!-- Full Screen Search Start -->
    <div class="modal fade" id="searchModal" tabindex="-1">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content" style="background: rgba(10, 50, 29, 0.59);">
                <div class="modal-header border-0">
                    <button type="button" class="btn bg-white btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex align-items-center justify-content-center">
                    <div class="input-group" style="max-width: 600px;">
                        <input type="text" class="form-control bg-white border-green p-3"
                            placeholder="Type search keyword">
                        <button class="btn btn-primary px-4"><i class="bi bi-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Full Screen Search End -->

    <!-- Facts Start -->
    {{-- <div class="container-fluid facts py-5 pt-lg-0">
        <div class="container py-5 pt-lg-0">
            <div class="row gx-0">
                <div class="col-lg-4 wow zoomIn" data-wow-delay="0.1s">
                    <div class="bg-primary shadow d-flex align-items-center justify-content-center p-4"
                        style="height: 150px;">
                        <div class="bg-white d-flex align-items-center justify-content-center rounded mb-2"
                            style="width: 60px; height: 60px;">
                            <i class="fa fa-users text-primary"></i>
                        </div>
                        <div class="ps-4">
                            <h5 class="text-white mb-0">Happy Clients</h5>
                            <h1 class="text-white mb-0" data-toggle="counter-up">12345</h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 wow zoomIn" data-wow-delay="0.3s">
                    <div class="bg-light shadow d-flex align-items-center justify-content-center p-4"
                        style="height: 150px;">
                        <div class="bg-primary d-flex align-items-center justify-content-center rounded mb-2"
                            style="width: 60px; height: 60px;">
                            <i class="fa fa-check text-white"></i>
                        </div>
                        <div class="ps-4">
                            <h5 class="text-primary mb-0">Projects Done</h5>
                            <h1 class="mb-0" data-toggle="counter-up">12345</h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 wow zoomIn" data-wow-delay="0.6s">
                    <div class="bg-primary shadow d-flex align-items-center justify-content-center p-4"
                        style="height: 150px;">
                        <div class="bg-white d-flex align-items-center justify-content-center rounded mb-2"
                            style="width: 60px; height: 60px;">
                            <i class="fa fa-award text-primary"></i>
                        </div>
                        <div class="ps-4">
                            <h5 class="text-white mb-0">Win Awards</h5>
                            <h1 class="text-white mb-0" data-toggle="counter-up">12345</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- Facts Start -->

    <!-- About Start -->
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-7">
                    <div class="section-title position-relative pb-3 mb-4">
                        {{-- <h5 class="fw-bold text-primary text-uppercase">About Us</h5> --}}
                        <h1 class="mb-0">Membangun Pariwisata dan Olahraga di Sijunjung</h1>
                    </div>
                    <p class="mb-4">Dinas Pariwisata Pemuda dan Olahraga Sijunjung berkomitmen untuk mengembangkan
                        potensi
                        pariwisata dan olahraga melalui berbagai program dan kegiatan yang inovatif dan berkelanjutan. Kami
                        mengundang Anda untuk menjelajahi keindahan alam dan budaya serta mendukung peningkatan prestasi
                        olahraga di Sijunjung.</p>
                    <div class="row g-0 mb-3">
                        <div class="col-sm-6 wow zoomIn" data-wow-delay="0.2s">
                            <h5 class="mb-3"><i class="fa fa-check text-primary me-3"></i>Wisata Alam</h5>
                            <h5 class="mb-3"><i class="fa fa-check text-primary me-3"></i>Budaya dan Adat Istiadat</h5>
                        </div>
                        <div class="col-sm-6 wow zoomIn" data-wow-delay="0.4s">
                            <h5 class="mb-3"><i class="fa fa-check text-primary me-3"></i>Fasilitas Olahraga</h5>
                            <h5 class="mb-3"><i class="fa fa-check text-primary me-3"></i>Kegiatan Pemuda</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5" style="min-height: 500px;">
                    <div class="position-relative h-100">
                        <img class="position-absolute w-100 h-100 rounded wow zoomIn" data-wow-delay="0.9s"
                            src="{{ asset('landingpage/assets/img/kepala-dinas.jpg') }}" style="object-fit: cover;">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

    <!-- Berita Start -->
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="section-title text-center position-relative pb-3 mb-5 mx-auto" style="max-width: 600px;">
                <h5 class="fw-bold text-primary text-uppercase">Berita Terbaru</h5>
                <h1 class="mb-0">Baca Artikel dan Berita Terbaru Kami</h1>
            </div>
            <div class="row g-5" id="berita-container">
                <!-- Konten berita akan dimuat melalui AJAX di sini -->
            </div>
            <div class="text-center mt-5">
                <a href="{{ route('client.berita.index') }}" class="btn btn-primary">Load More</a>
            </div>
        </div>
    </div>
    <!-- Berita End -->


    <!-- Testimonial Start -->
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="section-title text-center position-relative pb-3 mb-4 mx-auto" style="max-width: 600px;">
                <h5 class="fw-bold text-primary text-uppercase">Lokawisata</h5>
                <h1 class="mb-0">Spot Unggulan Wisata</h1>
            </div>
            <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.6s">
                <div class="testimonial-item bg-light my-4">
                    <div class="d-flex align-items-center border-bottom pt-5 pb-4 px-5">
                        <img class="img-fluid rounded"
                            src="{{ asset('uploads/500/WhatsApp Image 2024-09-19 at 10.43.44.jpeg') }}"
                            style="width: 60px; height: 60px;">
                        <div class="ps-4">
                            <h4 class="text-primary mb-1">Ngalau Basurek</h4>
                            <small class="text-uppercase">Goa/ngalau</small>
                        </div>
                    </div>
                    <div class="pt-4 pb-5 px-5">
                        Ngalau/Goa Basurek merupakan goa pada batuan karst/gamping yang unsur utamanya mengandung karbonat
                        CaCo3.
                    </div>
                </div>
                <div class="testimonial-item bg-light my-4">
                    <div class="d-flex align-items-center border-bottom pt-5 pb-4 px-5">
                        <img class="img-fluid rounded"
                            src="{{ asset('uploads/500/WhatsApp Image 2024-09-19 at 10.43.44.jpeg') }}"
                            style="width: 60px; height: 60px;">
                        <div class="ps-4">
                            <h4 class="text-primary mb-1">Air Terjun Lubuk Kinari</h4>
                            <small class="text-uppercase">AIR TERJUN</small>
                        </div>
                    </div>
                    <div class="pt-4 pb-5 px-5">
                        Air terjun ini terkenal karena keindahan alamnya dan suasana yang sejuk, dengan air yang jernih
                        mengalir dari ketinggian tebing ke kolam alami di bawahnya.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->

    <!-- Service Start -->
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="section-title text-center position-relative pb-3 mb-5 mx-auto" style="max-width: 600px;">
                <h5 class="fw-bold text-primary text-uppercase">Layanan Kami</h5>
                <h1 class="mb-0">Solusi Pariwisata dan Olahraga untuk Masyarakat</h1>
            </div>
            <div class="row g-5">
                <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.3s">
                    <div
                        class="service-item bg-light rounded d-flex flex-column align-items-center justify-content-center text-center">
                        <div class="service-icon">
                            <i class="fa fa-map-marked-alt text-white"></i>
                        </div>
                        <h4 class="mb-3">Pengembangan Destinasi Wisata</h4>
                        <p class="m-0">Kami menyediakan informasi lengkap tentang destinasi wisata yang ada di Kabupaten
                            Sijunjung.</p>
                        <a class="btn btn-lg btn-primary rounded" href="{{ url('/destinations') }}">
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.6s">
                    <div
                        class="service-item bg-light rounded d-flex flex-column align-items-center justify-content-center text-center">
                        <div class="service-icon">
                            <i class="fa fa-running text-white"></i>
                        </div>
                        <h4 class="mb-3">Fasilitas Olahraga</h4>
                        <p class="m-0">Fasilitas olahraga untuk mendukung kegiatan olahraga di Kabupaten Sijunjung.</p>
                        <a class="btn btn-lg btn-primary rounded" href="{{ url('/sports') }}">
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.9s">
                    <div
                        class="service-item bg-light rounded d-flex flex-column align-items-center justify-content-center text-center">
                        <div class="service-icon">
                            <i class="fa fa-users text-white"></i>
                        </div>
                        <h4 class="mb-3">Kegiatan Pemuda</h4>
                        <p class="m-0">Program dan kegiatan untuk mendukung pengembangan pemuda di Kabupaten Sijunjung.
                        </p>
                        <a class="btn btn-lg btn-primary rounded" href="{{ url('/youth-activities') }}">
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Service End -->

    <!-- AJAX Script -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            function loadBeritaTerbaru() {
                $.ajax({
                    url: "{{ url('/api/content') }}", // Endpoint API untuk berita
                    method: "GET",
                    data: {
                        type: 'berita',
                        per_page: 6
                    },
                    success: function(response) {
                        console.log(response); // Log respons API
                        if (response.success) {
                            let beritaContainer = $('#berita-container');
                            let beritaHtml = '';
    
                            $.each(response.data, function(index, berita) {
                                const formattedDate = new Date(berita.created_at).toLocaleDateString('id-ID', {
                                    year: 'numeric',
                                    month: 'long',
                                    day: 'numeric'
                                });
    
                                beritaHtml += `
                                    <div class="col-lg-4 wow slideInUp" data-wow-delay="0.3s">
                                        <div class="blog-item bg-light rounded overflow-hidden">
                                            <div class="blog-img position-relative overflow-hidden">
                                                <img class="img-fluid" src="${berita.image}" alt="${berita.title}">
                                                <a class="position-absolute top-0 start-0 bg-primary text-white rounded-end mt-5 py-2 px-4" href="/berita/${berita.slug}">
                                                    ${berita.category ? berita.category.name : 'Kategori'}
                                                </a>
                                            </div>
                                            <div class="p-4">
                                                <div class="d-flex mb-3">
                                                    <small class="me-3"><i class="far fa-user text-primary me-2"></i>${berita.created_by ?? 'Unknown Author'}</small>
                                                    <small><i class="far fa-calendar-alt text-primary me-2"></i>${formattedDate}</small>
                                                </div>
                                                <h4 class="mb-3">${berita.title}</h4>
                                                <p>${berita.description_short}</p>
                                                <a class="text-uppercase" href="/berita/${berita.slug}">Read More <i class="bi bi-arrow-right"></i></a>
                                            </div>
                                        </div>
                                    </div>`;
                            });
    
                            beritaContainer.html(beritaHtml);
                        } else {
                            $('#berita-container').html('<p class="text-center">Tidak ada berita yang ditemukan.</p>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText); // Log error response
                        $('#berita-container').html('<p class="text-center">Gagal memuat berita. Silakan coba lagi nanti.</p>');
                    }
                });
            }
    
            loadBeritaTerbaru();
        });
    </script>
    

    <!-- Vendor Start -->
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-5 mb-5">
            <div class="bg-white">
                <div class="owl-carousel vendor-carousel">
                    <img src="{{ asset('landingpage/assets/img/mitra-1.png') }}" alt="">
                    <img src="{{ asset('landingpage/assets/img/mitra-2.png') }}" alt="">
                    <img src="{{ asset('landingpage/assets/img/mitra-3.png') }}" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- Vendor End -->
@endsection
