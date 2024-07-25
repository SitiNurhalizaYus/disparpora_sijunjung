<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr" class="landing-pages">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $og['title'] . ' - ' .$setting['name'] }}</title>

    <!-- logo-geopark -->
    <link rel="shortcut icon" href="{{ asset('/'.str_replace('/xxx/', '/100/', $setting['logo-geopark'])) }}">
    <link rel="apple-touch-icon" href="{{ asset('/'.str_replace('/xxx/', '/100/', $setting['logo-geopark'])) }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('/'.str_replace('/xxx/', '/100/', $setting['logo-geopark'])) }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('/'.str_replace('/xxx/', '/100/', $setting['logo-geopark'])) }}">

    <!-- SEO -->
    <meta name="description" content="{{ $setting['seo-description'] }}">
    <meta name="keywords" content="{{ $setting['seo-keywords'] }}">
    <meta name="author" content="{{ $setting['seo-author'] }}">
    <meta name="keyphrases" content="{{ $setting['seo-keyphrases'] }}">
    <meta name="mytopic" content="{{ $setting['seo-mytopic'] }}">
    <meta name="classification" content="{{ $setting['seo-classification'] }}">
    <meta name="robots" content="{{ $setting['seo-robots'] }}>">

    <!-- social media shared -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $og['url'] }}">
    <meta property="og:title" content="{{ $og['title'] }}">
    <meta property="og:description" content="{{ $og['description'] }}">
    @if(isset($og['image']))
        <meta property="og:image" content="{{ asset('/'.$og['image']) }}">
    @else
        <meta property="og:image" content="{{ asset('/'.str_replace('/xxx/', '/300/', $setting['logo-geopark'])) }}">
    @endif

    <!-- Library / Plugin Css Build -->
    <link rel="stylesheet" href="{{ asset('assets/css/core/libs.min.css') }}">

    <!-- Hope Ui Design System Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/hope-ui.min.css?v=4.0.0') }}">

    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.min.css?v=4.0.0') }}">

    <!-- Dark Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/dark.min.css') }}">

    <!-- Customizer Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/customizer.min.css') }}">

    <!-- RTL Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/rtl.min.css') }}">

    <!-- SwiperSlider css -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/swiperSlider/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('landing-pages/assets/css/landing-pages.min.css') }}">
</head>

<body class=" body-bg landing-pages">
    <span class="screen-darken"></span>
    <!-- loader-Start -->
    {{-- <div id="loading">
        <div class="loader simple-loader">
            <div class="loader-body"></div>
        </div>
    </div> --}}
    <div class="loader"></div>
    <!-- loader-END -->
    <!-- Wrapper-start -->
    <main class="main-content">

        <div class="position-relative">
            <!-- Nav-Start -->
            <nav class="nav navbar navbar-expand-xl navbar-light iq-navbar header-hover-menu">
                <div class="container-fluid navbar-inner">
                    <div class="d-flex align-items-center justify-content-between w-100 landing-header">
                        <a href="{{url('/home')}}" class="navbar-brand m-0 d-xl-flex d-none">
                            <!--Logo start-->
                            <img src="{{ asset('/'.str_replace("/xxx/", "/300/", $setting['logo-geopark'])) }}">
                            <!--logo End-->
                            <h5 class="logo-title">{{ $setting['name'] }}</h5>
                        </a>
                        <div class="d-flex align-items-center d-xl-none">
                            <button data-trigger="navbar_main" class="d-xl-none btn btn-primary rounded-pill p-1 pt-0"
                                type="button">
                                <svg width="20px" class="icon-20" viewbox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z"></path>
                                </svg>
                            </button>

                            <a href="{{url('/home')}}" class="navbar-brand ms-3  d-xl-none">
                                <!--Logo start-->
                                <img src="{{ asset('/'.str_replace("/xxx/", "/300/", $setting['logo-geopark'])) }}">
                                <!--logo End-->
                                <h5 class="logo-title">{{ $setting['name-short'] }}</h5>
                            </a>
                        </div>
                        <ul class="d-block d-xl-none list-unstyled m-0">
                            <li class="nav-item dropdown iq-responsive-menu ">
                                <div class="btn btn-sm bg-body" id="navbarDropdown-search-11" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <svg class="icon-20" width="20" viewbox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="11.7669" cy="11.7666" r="8.98856" stroke="currentColor"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></circle>
                                        <path d="M18.0186 18.4851L21.5426 22" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </div>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown-search-11"
                                    style="width: 18rem;">
                                    <li class="px-3 py-0">
                                        <div class="form-group input-group mb-0">
                                            <input type="text" class="form-control" placeholder="Search...">
                                            <span class="input-group-text">
                                                <svg class="icon-20" width="20" height="20" viewbox="0 0 24 24"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="11.7669" cy="11.7666" r="8.98856" stroke="currentColor"
                                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                    </circle>
                                                    <path d="M18.0186 18.4851L21.5426 22" stroke="currentColor"
                                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                    </path>
                                                </svg>
                                            </span>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>

                        <!-- Horizontal Menu Start -->
                        <nav id="navbar_main" class="mobile-offcanvas nav navbar navbar-expand-xl hover-nav horizontal-nav">
                            <div class="container-fluid p-lg-0">
                                <div class="offcanvas-header px-0">
                                    <a href="{{url('/home')}}" class="navbar-brand ms-3  d-xl-none">
                                        <!--Logo start-->
                                        <img src="{{ asset('/'.str_replace("/xxx/", "/300/", $setting['logo-geopark'])) }}">
                                        <!--logo End-->
                                        <h5 class="logo-title">{{ $setting['name'] }}</h5>
                                    </a>
                                    <button class="btn-close float-end px-3"></button>
                                </div>
                                <ul class="navbar-nav iq-nav-menu  list-unstyled" id="header-menu">
                                    <li class="nav-item">
                                        <a class="nav-link " href="{{url('/home')}}">Home
                                        </a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link menu-arrow justify-content-start" data-bs-toggle="collapse" href="#pageData" role="button" aria-expanded="false" aria-controls="pageData">
                                          <span class="item-name">Pages</span>
                                          <svg fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-18" width="18" height="18" viewBox="0 0 24 24"><path d="M19 8.5L12 15.5L5 8.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                        </a>
                                        <ul class="iq-header-sub-menu list-unstyled collapse" id="pageData">
                                            @foreach ($pages as $page)
                                                <li class="nav-item"><a class="nav-link" href="{{url('/page/'.$page['slug'])}}" style="font-size: medium;">{{ $page['name'] }}</a></li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link " href="{{url('/about')}}">About Us</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link " href="{{url('/feature')}}">Features</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link " href="{{url('/pricing')}}">Pricing</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link " href="{{url('/blog')}}">Blog</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link " href="{{url('/faq')}}">Faq</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link " href="{{url('/contact')}}">Contact Us</a>
                                    </li>
                                </ul>
                            </div>
                            <!-- container-fluid.// -->
                        </nav>
                        <!-- Sidebar Menu End -->
                    </div>
                </div>
            </nav>
            <!--Nav-End-->
        </div>

        @yield('content')

    </main>
    <!-- Wrapper-End -->
    <!-- Footer-start -->
    <footer>
        <div class="bg-secondary inner-box ">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <a href="{{url('/home')}}" class="navbar-brand  d-flex align-items-center">
                            <img src="{{ asset('/'.str_replace("/xxx/", "/300/", $setting['logo-geopark'])) }}">
                            <h4 class="logo-title ms-3 text-white">{{ $setting['name'] }}</h4>
                        </a>
                        <p class="text-white my-4">
                            {{ $setting['footer-about'] }}
                        </p>
                        <div class="d-flex align-items-center mb-4">
                            <svg width="24" height="24" viewbox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 6V22L8 18L16 22L23 18V2L16 6L8 2L1 6Z" stroke="white" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M16 6V22" stroke="white" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M8 2V18" stroke="white" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            <p class="ms-4 mb-0 text-white">{{ $setting['address'] }}</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <svg width="22" height="22" viewbox="0 0 22 22" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M21 15.9201V18.9201C21.0011 19.1986 20.9441 19.4743 20.8325 19.7294C20.7209 19.9846 20.5573 20.2137 20.3521 20.402C20.1468 20.5902 19.9046 20.7336 19.6407 20.8228C19.3769 20.912 19.0974 20.9452 18.82 20.9201C15.7428 20.5857 12.787 19.5342 10.19 17.8501C7.77382 16.3148 5.72533 14.2663 4.18999 11.8501C2.49997 9.2413 1.44824 6.27109 1.11999 3.1801C1.095 2.90356 1.12787 2.62486 1.21649 2.36172C1.30512 2.09859 1.44756 1.85679 1.63476 1.65172C1.82196 1.44665 2.0498 1.28281 2.30379 1.17062C2.55777 1.05843 2.83233 1.00036 3.10999 1.0001H6.10999C6.5953 0.995321 7.06579 1.16718 7.43376 1.48363C7.80173 1.80008 8.04207 2.23954 8.10999 2.7201C8.23662 3.68016 8.47144 4.62282 8.80999 5.5301C8.94454 5.88802 8.97366 6.27701 8.8939 6.65098C8.81415 7.02494 8.62886 7.36821 8.35999 7.6401L7.08999 8.9101C8.51355 11.4136 10.5864 13.4865 13.09 14.9101L14.36 13.6401C14.6319 13.3712 14.9751 13.1859 15.3491 13.1062C15.7231 13.0264 16.1121 13.0556 16.47 13.1901C17.3773 13.5286 18.3199 13.7635 19.28 13.8901C19.7658 13.9586 20.2094 14.2033 20.5265 14.5776C20.8437 14.9519 21.0122 15.4297 21 15.9201Z"
                                    stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <p class="ms-4 mb-0 text-white">{{ $setting['phone'] }}</p>
                        </div>
                    </div>
                    <div class="col-md-2 mt-md-0 mt-4">
                        <h5 class="mb-4 text-white">Links</h5>
                        <ul class="m-0 p-0 list-unstyled text-white">
                            <li class="mb-3"><a href="{{ url('/about') }}" style="color: lightgray;">About us</a></li>
                            <li class="mb-3"><a href="{{ url('/feature') }}" style="color: lightgray;">Features</a></li>
                            <li class="mb-3"><a href="{{ url('/pricing') }}" style="color: lightgray;">Pricing</a></li>
                            <li><a href="{{ url('/blog') }}" style="color: lightgray;">Blog</a></li>
                        </ul>
                    </div>
                    <div class="col-md-2 mt-md-0 mt-4">
                        <h5 class="mb-4 text-white">Help</h5>
                        <ul class="m-0 p-0 list-unstyled text-white">
                            <li class="mb-3"><a href="{{ url('/faq') }}" style="color: lightgray;">FAQ</a></li>
                            <li><a href="{{ url('/contact') }}" style="color: lightgray;">Contact Us</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4 mt-md-0 mt-4">
                        <h5 class="mb-4 text-white">Follow Us </h5>
                        <ul class="list-unstyled p-0 m-0 d-flex mt-4">
                            <li>
                                <a href="{{ $setting['socmed-facebook'] }}" target="_blank">
                                    <img src="{{ asset('assets/images/brands/08.png') }}" alt="fb" loading="lazy" class="rounded-pill">
                                </a>
                            </li>
                            <li class="ps-3">
                                <a href="{{ $setting['socmed-twitter'] }}" target="_blank">
                                    <img src="{{ asset('assets/images/brands/09.png') }}" alt="gm" loading="lazy" class="rounded-pill">
                                </a>
                            </li>
                            <li class="ps-3">
                                <a href="{{ $setting['socmed-instagram'] }}" target="_blank">
                                    <img src="{{ asset('assets/images/brands/10.png') }}" alt="im" loading="lazy" class="rounded-pill">
                                </a>
                            </li>
                            <li class="ps-3">
                                <a href="{{ $setting['socmed-linkedin'] }}" target="_blank">
                                    <img src="{{ asset('assets/images/brands/13.png') }}" alt="li" loading="lazy" class="rounded-pill">
                                </a>
                            </li>
                        </ul>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
        <div class="footer-bottom bg-secondary ">
            <div class="container border-top  py-4 border-primary">
                <div class="row">
                    <div class="col-md-12 text-center text-white">
                        <p class="mb-0">©
                            {{ $setting['copyright'] }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer-end -->
    <div id="back-to-top" style="display: none;">
        <a class="p-0 btn btn-primary btn-sm position-fixed top" id="top" href="#top">
            <svg class="icon-30" width="30" viewbox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M5 15.5L12 8.5L19 15.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round"></path>
            </svg>
        </a>
    </div>
    <a class="btn btn-fixed-end btn-primary btn-icon btn-landing" href="{{url('/admin')}}" style="width: 145px;">
        Admin
    </a>

    <!-- offcanvas start -->
    <!-- Library Bundle Script -->
    <script src="{{ asset('assets/js/core/libs.min.js') }}"></script>

    <!-- External Library Bundle Script -->
    <script src="{{ asset('assets/js/core/external.min.js') }}"></script>

    <!-- Widgetchart Script -->
    <script src="{{ asset('assets/js/charts/widgetcharts.js') }}"></script>

    <!-- mapchart Script -->
    <script src="{{ asset('assets/js/charts/vectore-chart.js') }}"></script>
    <script src="{{ asset('assets/js/charts/dashboard.js') }}"></script>

    <!-- fslightbox Script -->
    <script src="{{ asset('assets/js/plugins/fslightbox.js') }}"></script>

    <!-- Settings Script -->
    <script src="{{ asset('assets/js/plugins/setting.js') }}"></script>

    <!-- Slider-tab Script -->
    <script src="{{ asset('assets/js/plugins/slider-tabs.js') }}"></script>

    <!-- Form Wizard Script -->
    <script src="{{ asset('assets/js/plugins/form-wizard.js') }}"></script>

    <!-- AOS Animation Plugin-->

    <!-- App Script -->
    <script src="{{ asset('assets/js/hope-ui.js') }}" defer="defer"></script>

    <!-- SwiperSlider Script -->
    <script src="{{ asset('assets/vendor/swiperSlider/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('landing-pages/assets/js/app-landing.js') }}" defer="defer"></script>
</body>

</html>
