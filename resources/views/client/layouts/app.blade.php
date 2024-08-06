<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{ $og['title'] . ' - ' . $setting['name'] }}</title>

    <!-- logo-parpora -->
    <link rel="shortcut icon" href="{{ asset('/' . str_replace('/xxx/', '/100/', $setting['logo-parpora'])) }}">
    <link rel="apple-touch-icon" href="{{ asset('/' . str_replace('/xxx/', '/100/', $setting['logo-parpora'])) }}">
    <link rel="apple-touch-icon" sizes="72x72"
        href="{{ asset('/' . str_replace('/xxx/', '/100/', $setting['logo-parpora'])) }}">
    <link rel="apple-touch-icon" sizes="114x114"
        href="{{ asset('/' . str_replace('/xxx/', '/100/', $setting['logo-parpora'])) }}">

    <!-- social media shared -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $og['url'] }}">
    <meta property="og:title" content="{{ $og['title'] }}">
    <meta property="og:description" content="{{ $og['description'] }}">
    @if (isset($og['image']))
        <meta property="og:image" content="{{ asset('/' . $og['image']) }}">
    @else
        <meta property="og:image" content="{{ asset('/' . str_replace('/xxx/', '/300/', $setting['logo-parpora'])) }}">
    @endif

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Rubik:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('landingpage/assets/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('landingpage/assets/lib/animate/animate.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('landingpage/assets/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('landingpage/assets/css/style.css') }}" rel="stylesheet">
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner"></div>
    </div>
    <!-- Spinner End -->


    <!-- Topbar Start -->
    <div class="container-fluid bg-dark px-5 d-none d-lg-block">
        <div class="row gx-0">
            <div class="col-lg-8 text-center text-lg-start mb-2 mb-lg-0">
                <div class="d-inline-flex align-items-center" style="height: 50px;">
                    <small class="me-3 text-light"><i
                            class="fa fa-map-marker-alt me-2"></i>{{ $setting['address'] }}</small>
                    <small class="me-3 text-light"><i class="fa fa-phone-alt me-2"></i>{{ $setting['phone'] }}</small>
                    <small class="text-light"><i class="fa fa-envelope-open me-2"></i>{{ $setting['email'] }}</small>
                </div>
            </div>
            <div class="col-lg-4 text-center text-lg-end">
                <div class="d-inline-flex align-items-center" style="height: 50px;">
                    <a class="btn btn-sm btn-outline-light btn-sm-square rounded-circle me-2" href=""><i
                            class="fab fa-twitter fw-normal"></i></a>
                    <a class="btn btn-sm btn-outline-light btn-sm-square rounded-circle me-2" href=""><i
                            class="fab fa-facebook-f fw-normal"></i></a>
                    <a class="btn btn-sm btn-outline-light btn-sm-square rounded-circle me-2" href=""><i
                            class="fab fa-instagram fw-normal"></i></a>
                    <a class="btn btn-sm btn-outline-light btn-sm-square rounded-circle" href=""><i
                            class="fab fa-youtube fw-normal"></i></a>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <div class="container-fluid position-relative p-0">
        <nav class="navbar navbar-expand-lg navbar-dark px-5 py-3 py-lg-0">
            <a href="/beranda" class="navbar-brand p-0">
                <h2 class="m-0">
                    <img src="{{ asset('/' . str_replace('/xxx/', '/300/', $setting['logo-geopark'])) }}">
                    {{ $setting['name-short'] }}
                </h2>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav mx-auto py-0">
                    <a href="{{ url('/beranda') }}"
                        class="nav-item nav-link {{ Request::is('beranda') ? 'active' : '' }} me-3">Beranda</a>
                    <div class="nav-item dropdown me-3">
                        <a href="#" class="nav-link dropdown-toggle"
                            data-bs-toggle="dropdown">Profil</a>
                        <div class="dropdown-menu m-0">
                            <a href="{{ route('profil', ['slug' => 'struktur-organisasi-dinas']) }}" class="dropdown-item">Struktur
                                Organisasi Dinas</a>
                            <a href="{{ route('profil', ['slug' => 'visi-misi']) }}" class="dropdown-item">Visi dan Misi</a>
                            <a href="{{ route('profil', ['slug' => 'tujuan-strategis']) }}" class="dropdown-item">Tujuan Strategis</a>
                            <a href="{{ route('profil', ['slug' => 'sasaran-strategis']) }}" class="dropdown-item">Sasaran
                                Strategis</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown me-3">
                        <a href="{{ url('/publikasi') }}" class="nav-link dropdown-toggle"
                            data-bs-toggle="dropdown">Publikasi</a>
                        <div class="dropdown-menu m-0">
                            <a href="{{ url('/publikasi/informasi') }}"" class="dropdown-item">Informasi</a>
                            <a href="{{ url('/publikasi/produkhukum') }}" class="dropdown-item">Produk Hukum</a>
                            <a href="{{ url('/publikasi/keuangan') }}" class="dropdown-item">Laporan Keuangan</a>
                            <a href="{{ url('/publikasi/kinerja') }}" class="dropdown-item">Laporan Kinerja Instansi
                                Pemerintah</a>
                            <a href="{{ url('/publikasi/renja') }}" class="dropdown-item">Dokumen Renja DISPARPORA
                                Sijunjung</a>
                            <a href="{{ url('/publikasi/renstra') }}" class="dropdown-item">Dokumen Renstra
                                DISPARPORA Sijunjung</a>
                            <a href="{{ url('/publikasi/pengadaan') }}" class="dropdown-item">Pengadaan Barang dan
                                Jasa</a>
                            <a href="{{ url('/publikasi/aset') }}" class="dropdown-item">Aset Dan Persediaan
                                DISPARPORA</a>
                            <a href="{{ url('/publikasi/prosedur') }}" class="dropdown-item">Prosedur Tanggap Darurat
                                DISPARPORA</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown me-3">
                        <a href="{{ url('/ppid') }}" class="nav-link dropdown-toggle"
                            data-bs-toggle="dropdown">PPID</a>
                        <div class="dropdown-menu m-0">
                            <a href="{{ url('/ppid/laporan') }}" class="dropdown-item">Laporan Layanan Informasi
                                Publik</a>
                            <a href="{{ url('/ppid/statistik') }}" class="dropdown-item">Statistik Informasi
                                Publik</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown me-3">
                        <a href="{{ url('/lokawisata') }}" class="nav-link dropdown-toggle"
                            data-bs-toggle="dropdown">Lokawisata</a>
                        <div class="dropdown-menu m-0">
                            <a href="{{ url('/lokawisata/alam') }}" class="dropdown-item">Wisata Alam</a>
                            <a href="{{ url('/lokawisata/buatan') }}" class="dropdown-item">Wisata Buatan</a>
                        </div>
                    </div>

                    <a href="{{ url('/event') }}" class="nav-item nav-link me-3">Event</a>
                    <a href="{{ url('/hubungikami') }}" class="nav-item nav-link me-3">Hubungi Kami</a>
                    <button type="button" class="btn text-secondary ms-3" data-bs-toggle="modal"
                        data-bs-target="#searchModal">
                        <i class="fa fa-search"></i>
                    </button>
                    <a href="{{ url('/akun') }}" class="btn btn-primary py-2 px-4 ms-3"><i
                            class="bi bi-person-fill"></i>
                        Akun</a>
                </div>
            </div>
        </nav>
    </div>
    <!-- Navbar End -->


    @yield('content')


    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light mt-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="row gx-5">
                <div class="col-lg-4 col-md-6 footer-about">
                    <div
                        class="d-flex flex-column align-items-center justify-content-center text-center h-100 bg-primary p-4">
                        <a href="index.html" class="navbar-brand">
                            <h1 class="m-0 text-white"><img
                                    src="{{ asset('/' . str_replace('/xxx/', '/300/', $setting['logo-geopark'])) }}">
                                Disparpora</h1>
                        </a>
                        <p class="mt-3 mb-4">{{ $setting['address'] }}</p>
                        <form action="">
                            <div class="input-group">
                                <input type="text" class="form-control border-white p-3" placeholder="Your Email">
                                <button class="btn btn-dark">Sign Up</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-8 col-md-6">
                    <div class="row gx-5">
                        <div class="col-lg-4 col-md-12 pt-5 mb-5">
                            <div class="section-title section-title-sm position-relative pb-3 mb-4">
                                <h3 class="text-light mb-0">Get In Touch</h3>
                            </div>
                            <div class="d-flex mb-2">
                                <i class="bi bi-geo-alt text-primary me-2"></i>
                                <p class="mb-0">maps..</p>
                            </div>
                            <div class="d-flex mb-2">
                                <i class="bi bi-envelope-open text-primary me-2"></i>
                                <p class="mb-0">{{ $setting['email'] }}</p>
                            </div>
                            <div class="d-flex mb-2">
                                <i class="bi bi-telephone text-primary me-2"></i>
                                <p class="mb-0">{{ $setting['phone'] }}</p>
                            </div>
                            <div class="d-flex mt-4">
                                <a class="btn btn-primary btn-square me-2" href="#"><i
                                        class="fab fa-twitter fw-normal"></i></a>
                                <a class="btn btn-primary btn-square me-2" href="#"><i
                                        class="fab fa-facebook-f fw-normal"></i></a>
                                <a class="btn btn-primary btn-square me-2" href="#"><i
                                        class="fab fa-linkedin-in fw-normal"></i></a>
                                <a class="btn btn-primary btn-square" href="#"><i
                                        class="fab fa-instagram fw-normal"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 pt-0 pt-lg-5 mb-5">
                            <div class="section-title section-title-sm position-relative pb-3 mb-4">
                                <h3 class="text-light mb-0">Quick Links</h3>
                            </div>
                            <div class="link-animated d-flex flex-column justify-content-start">
                                <a class="text-light mb-2" href="{{ url('/beranda') }}"><i
                                        class="bi bi-arrow-right text-primary me-2"></i>Beranda</a>
                                <a class="text-light mb-2" href="{{ url('/profildinas') }}"><i
                                        class="bi bi-arrow-right text-primary me-2"></i>Profil</a>
                                <a class="text-light mb-2" href="{{ url('/service') }}"><i
                                        class="bi bi-arrow-right text-primary me-2"></i>Our Services</a>
                                <a class="text-light mb-2" href="#"><i
                                        class="bi bi-arrow-right text-primary me-2"></i>Meet The Team</a>
                                <a class="text-light mb-2" href="#"><i
                                        class="bi bi-arrow-right text-primary me-2"></i>Latest Blog</a>
                                <a class="text-light" href="#"><i
                                        class="bi bi-arrow-right text-primary me-2"></i>Contact Us</a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 pt-0 pt-lg-5 mb-5">
                            <div class="section-title section-title-sm position-relative pb-3 mb-4">
                                <h3 class="text-light mb-0">Popular Links</h3>
                            </div>
                            <div class="link-animated d-flex flex-column justify-content-start">
                                <a class="text-light mb-2" href="/beranda"><i
                                        class="bi bi-arrow-right text-primary me-2"></i>Beranda</a>
                                <a class="text-light mb-2" href="/profildinas"><i
                                        class="bi bi-arrow-right text-primary me-2"></i>Profil</a>
                                <a class="text-light mb-2" href="#"><i
                                        class="bi bi-arrow-right text-primary me-2"></i>Our Services</a>
                                <a class="text-light mb-2" href="#"><i
                                        class="bi bi-arrow-right text-primary me-2"></i>Meet The Team</a>
                                <a class="text-light mb-2" href="#"><i
                                        class="bi bi-arrow-right text-primary me-2"></i>Latest Blog</a>
                                <a class="text-light" href="#"><i
                                        class="bi bi-arrow-right text-primary me-2"></i>Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid text-white" style="background: #000f0b;">
        <div class="container text-center">
            <div class="row justify-content-end">
                <div class="col-lg-8 col-md-6">
                    <div class="d-flex align-items-center justify-content-center" style="height: 75px;">
                        <p class="mb-0">copyright &copy; 2024 - <a class="text-white border-bottom"
                                href="#">{{ $setting['name-long'] }}</a>.

                            <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                            <a class="text-white border-bottom" href="https://htmlcodex.com"></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded back-to-top"><i
            class="bi bi-arrow-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('landingpage/assets/lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('landingpage/assets/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('landingpage/assets/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('landingpage/assets/lib/counterup/counterup.min.js') }}"></script>
    <script src="{{ asset('landingpage/assets/lib/owlcarousel/owl.carousel.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('landingpage/assets/js/main.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mendapatkan elemen dropdown-toggle untuk sub-menu
            var dropdownToggles = document.querySelectorAll('.dropdown-item.dropdown-toggle');

            // Menambahkan event listener untuk hover dan click pada setiap dropdown-toggle
            dropdownToggles.forEach(function(toggle) {
                var submenu = toggle.nextElementSibling;

                // Event listener untuk hover
                toggle.addEventListener('mouseenter', function() {
                    submenu.classList.add('show');
                });

                // Event listener untuk hover keluar
                toggle.addEventListener('mouseleave', function() {
                    submenu.classList.remove('show');
                });

                // Event listener untuk klik
                toggle.addEventListener('click', function(event) {
                    event.preventDefault();
                    event.stopPropagation(); // Mencegah event bubbling

                    var isOpen = submenu.classList.contains('show');

                    // Tutup semua sub-menu terlebih dahulu
                    document.querySelectorAll('.dropdown-menu .dropdown-menu.show').forEach(
                        function(openMenu) {
                            openMenu.classList.remove('show');
                        });

                    // Toggle sub-menu saat ini
                    if (!isOpen) {
                        submenu.classList.add('show');
                    }
                });

                // Event listener untuk hover keluar dari submenu
                submenu.addEventListener('mouseleave', function() {
                    submenu.classList.remove('show');
                });

                submenu.addEventListener('mouseenter', function() {
                    submenu.classList.add('show');
                });
            });

            // Menambahkan event listener untuk klik di luar dropdown
            document.addEventListener('click', function(event) {
                if (!event.target.closest('.dropdown-menu')) {
                    document.querySelectorAll('.dropdown-menu .dropdown-menu.show').forEach(function(
                        openMenu) {
                        openMenu.classList.remove('show');
                    });
                }
            });
        });
    </script>
</body>

</html>
