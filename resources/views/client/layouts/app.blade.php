<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{ $og['title'] . ' - ' . $setting['name'] }}</title>

    <!-- logo-parpora -->
    <link rel="shortcut icon" href="{{ asset(str_replace('/xxx/', '/100/', $setting['logo-parpora'])) }}">
    <link rel="apple-touch-icon" href="{{ asset(str_replace('/xxx/', '/100/', $setting['logo-parpora'])) }}">
    <link rel="apple-touch-icon" sizes="72x72"
        href="{{ asset(str_replace('/xxx/', '/100/', $setting['logo-parpora'])) }}">
    <link rel="apple-touch-icon" sizes="114x114"
        href="{{ asset(str_replace('/xxx/', '/100/', $setting['logo-parpora'])) }}">

    <!-- social media shared -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $og['url'] }}">
    <meta property="og:title" content="{{ $og['title'] }}">
    <meta property="og:description" content="{{ $og['description'] }}">
    @if (isset($og['image']))
        <meta property="og:image" content="{{ asset($og['image']) }}">
    @else
        <meta property="og:image" content="{{ asset(str_replace('/xxx/', '/300/', $setting['logo-parpora'])) }}">
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

    <!-- CSS for sticky footer -->
    <style>
        html,
        body {
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        .content-wrapper {
            flex: 1;
        }

        .footer {
            margin-top: auto;
        }
    </style>

</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner"></div>
    </div>
    <!-- Spinner End -->

    <div class="content-wrapper">
        <!-- Topbar Start -->
        <div class="container-fluid bg-dark px-5 d-none d-lg-block">
            <div class="row gx-0">
                <div class="col-lg-8 text-center text-lg-start mb-2 mb-lg-0">
                    <div class="d-inline-flex align-items-center" style="height: 50px;">
                        <small class="me-3 text-light"><i
                                class="fa fa-map-marker-alt me-2"></i>{{ $setting['address'] }}</small>
                        <small class="me-3 text-light"><i
                                class="fa fa-phone-alt me-2"></i>{{ $setting['phone'] }}</small>
                        <small class="text-light"><i
                                class="fa fa-envelope-open me-2"></i>{{ $setting['email'] }}</small>
                    </div>
                </div>
                <div class="col-lg-4 text-center text-lg-end">
                    <div class="d-inline-flex align-items-center" style="height: 50px;">
                        <a class="btn btn-sm btn-outline-light btn-sm-square rounded-circle me-2" href="#"><i
                                class="bi bi-twitter"></i></i></a>
                        <a class="btn btn-sm btn-outline-light btn-sm-square rounded-circle me-2" href="#"><i
                                class="fab fa-facebook-f fw-normal"></i></a>
                        <a class="btn btn-sm btn-outline-light btn-sm-square rounded-circle me-2" href="#"><i
                                class="fab fa-instagram fw-normal"></i></a>
                        <a class="btn btn-sm btn-outline-light btn-sm-square rounded-circle me-2" href="#"><i
                                class="fab fa-youtube fw-normal"></i></a>
                        <!-- Icon Pengaturan untuk login admin-->
                        <a class="btn btn-md rounded-circle" href="{{ url('/admin/login') }}"><i
                                class="bi bi-gear"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Topbar End -->

        <!-- Navbar Start -->
        <div class="container-fluid position-relative p-0">
            <nav class="navbar navbar-expand-lg navbar-dark px-5 py-3 py-lg-0">
                <a href="{{ url('/beranda') }}" class="navbar-brand p-0">
                    <h2 class="m-0">
                        <img src="{{ asset(str_replace('/xxx/', '/300/', $setting['logo-geopark'])) }}">
                        {{ $setting['name-short'] }}
                    </h2>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav mx-auto py-0">
                        <a href="{{ url('/beranda') }}"
                            class="nav-item nav-link {{ Request::is('beranda') ? 'active' : '' }} me-3">Beranda</a>
                        <div class="nav-item dropdown me-3">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Profil</a>
                            <div class="dropdown-menu m-0">
                                <a href="{{ route('client.profil.detail', ['slug' => 'struktur-organisasi-dinas-pariwisata']) }}"
                                    class="dropdown-item">Struktur Organisasi Dinas</a>
                                <a href="{{ route('client.profil.detail', ['slug' => 'visi-misi-dinas-pariwisata']) }}"
                                    class="dropdown-item">Visi dan Misi</a>
                                <a href="{{ route('client.profil.detail', ['slug' => 'tujuan-strategis-dinas-pariwisata']) }}"
                                    class="dropdown-item">Tujuan Strategis</a>
                                <a href="{{ route('client.profil.detail', ['slug' => 'sasaran-dinas-pariwisata-sijunjung']) }}"
                                    class="dropdown-item">Sasaran Strategis</a>
                            </div>

                        </div>
                        <div class="nav-item dropdown me-3">
                            <a href="#" class="nav-link dropdown-toggle"
                                data-bs-toggle="dropdown">Publikasi</a>
                            <div class="dropdown-menu m-0">
                                <a href="{{ route('client.berita.index') }}" class="dropdown-item">Berita</a>
                                <a href="{{ route('client.artikel.index') }}" class="dropdown-item">Artikel</a>
                                <a href="{{ route('client.document.index') }}" class="dropdown-item">Dokumen
                                    Publik</a>
                                <a href="{{ route('client.agenda.index') }}" class="dropdown-item">Agenda</a>

                                <a href="{{ route('client.statistik') }}" class="dropdown-item">Statistik Informasi
                                    Publik</a>

                            </div>
                        </div>
                        {{-- <div class="nav-item dropdown me-3">
                            <a href="{{ url('/ppid') }}" class="nav-link dropdown-toggle"
                                data-bs-toggle="dropdown">PPID</a>
                            <div class="dropdown-menu m-0">
                                <a href="{{ route('client.statistik') }}" class="dropdown-item">Statistik Informasi
                                    Publik</a>
                            </div>
                        </div> --}}
                        <div class="nav-item dropdown me-3">
                            <a href="{{ route('client.lokawisata.index') }}" class="nav-link">Lokawisata</a>
                        </div>
                        <button type="button" class="btn text-secondary ms-3" data-bs-toggle="modal"
                            data-bs-target="#searchModal">
                            <i class="fa fa-search"></i>
                        </button>
                        <a href="{{ route('client.message.index') }}" class="btn btn-primary py-2 px-4 ms-3">Hubungi
                            Kami</a>
                    </div>
                </div>
            </nav>
        </div>
        <!-- Navbar End -->

        <!-- Content -->
        @yield('content')
    </div>

    <!-- Footer Start -->
    <div class="footer container-fluid bg-dark text-light py-5">
        <div class="container">
            <div class="row">
                <!-- Logo and Address Section -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <h1 class="text-white mb-3">
                        <img src="{{ asset(str_replace('/xxx/', '/300/', $setting['logo-geopark'])) }}"
                            alt="Logo" class="me-2" style="width: 40px;">
                        Disparpora
                    </h1>
                    <p>{{ $setting['address'] }}</p>
                    <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-envelope-fill" viewBox="0 0 16 16">
                            <path
                                d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414zM0 4.697v7.104l5.803-3.558zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586zm3.436-.586L16 11.801V4.697z" />
                        </svg> <a href="mailto:{{ $setting['email'] }}"
                            class="text-light">{{ $setting['email'] }}</a></p>
                    <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-telephone-fill" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z" />
                        </svg> <a href="tel:{{ $setting['phone'] }}" class="text-light">{{ $setting['phone'] }}</a>
                    </p>
                </div>

                <!-- Quick Links Section -->
                <div class="link-animated d-flex flex-column col-lg-3 col-md-6 mb-4">
                    <h3 class="text-light mb-3">Quick Links</h3>
                    <ul class="list-unstyled ms-3">
                        <li><a class="text-light" href="{{ url('/beranda') }}">• Beranda</a></li>
                        <li><a class="text-light" href="{{ url('/profildinas') }}">• Profil</a></li>
                        <li><a class="text-light" href="{{ route('client.artikel.index') }}">• Artikel</a></li>
                        <li><a class="text-light" href="{{ route('client.message.index') }}">• Contact Us</a></li>
                    </ul>
                </div>

                <!-- Map and Social Media Section -->
                <div class="col-lg-6 col-md-12">
                    <h3 class="text-light mb-3">Our Location</h3>
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4172.845819895561!2d100.93594582345908!3d-0.6634303272020157!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e2b2101459e56cf%3A0x812aecc4641eabad!2sDinas%20Pariwisata%2C%20Pemuda%2C%20Dan%20Olahraga%20Kabupaten%20Sijunjung!5e0!3m2!1sid!2sid!4v1724945132927!5m2!1sid!2sid"
                        width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                    <div class="d-flex mt-3">
                        <a class="btn btn-primary btn-square me-2" href="{{ $setting['socmed-facebook'] }}"><i
                                class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-primary btn-square me-2" href="{{ $setting['socmed-twitter'] }}"><i
                                class="fab fa-twitter"></i></a>
                        <a class="btn btn-primary btn-square me-2" href="{{ $setting['socmed-instagram'] }}"><i
                                class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col text-center">
                    <p class="mb-0">© 2024 {{ $setting['name-long'] }}. All Rights Reserved.</p>
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
