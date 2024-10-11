<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Welcome To {{ $setting['name'] }}</title>

    <!-- logo-geopark -->
    <link rel="shortcut icon" href="{{ asset('/' . str_replace('/xxx/', '/100/', $setting['logo-geopark'])) }}">

    <!-- Library / Plugin Css Build -->
    <link rel="stylesheet" href="{{ asset('assets/css/core/libs.min.css') }}">

    <!-- Aos Animation Css -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/aos/dist/aos.css') }}">

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

    <!-- Library Bundle Script -->
    <script src="{{ asset('assets/js/core/libs.min.js') }}"></script>

    <!-- Function Script -->
    <script src="{{ asset('assets/js/function.js') }}"></script>

    <!-- WYSIWYG Script -->
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>

</head>

<body class="  ">
    <!-- loader Start -->
    {{-- <div id="loading">
        <div class="loader simple-loader">
            <div class="loader-body">
            </div>
        </div>
    </div> --}}
    <div class="loader"></div>
    <!-- loader END -->

    <aside class="sidebar sidebar-default sidebar-base navs-rounded-all sidebar-dark">
        <div class="sidebar-header d-flex align-items-center justify-content-start">
            <a href="{{ url('/admin/dashboard') }}" class="navbar-brand">
                <!--Logo start-->
                <div class="logo-main">
                    <div class="logo-normal">
                        <img src="{{ asset('/' . str_replace('/xxx/', '/300/', $setting['logo-geopark'])) }}">
                    </div>
                    <div class="logo-mini">
                        <img src="{{ asset('/' . str_replace('/xxx/', '/100/', $setting['logo-geopark'])) }}">
                    </div>
                </div>
                <!--logo End-->

                <h4 class="logo-title">{{ $setting['name-short'] }}</h4>
            </a>
            <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
                <i class="icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.25 12.2744L19.25 12.2744" stroke="currentColor" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M10.2998 18.2988L4.2498 12.2748L10.2998 6.24976" stroke="currentColor"
                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </i>
            </div>
        </div>
        <div class="sidebar-body pt-0 data-scrollbar">
            <div class="sidebar-list">
                <!-- Sidebar Menu Start -->
                <ul class="navbar-nav iq-main-menu" id="sidebar-menu">
                    {{-- dashboard --}}
                    <li class="nav-item">
                        <a class="nav-link @if (str_contains($menu, 'dashboard')) {{ 'active' }} @endif"
                            aria-current="page" href="{{ url('/admin/dashboard') }}">
                            <i class="icon">
                                <svg class="icon-24" width="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M9.14373 20.7821V17.7152C9.14372 16.9381 9.77567 16.3067 10.5584 16.3018H13.4326C14.2189 16.3018 14.8563 16.9346 14.8563 17.7152V20.7732C14.8562 21.4473 15.404 21.9951 16.0829 22H18.0438C18.9596 22.0023 19.8388 21.6428 20.4872 21.0007C21.1356 20.3586 21.5 19.4868 21.5 18.5775V9.86585C21.5 9.13139 21.1721 8.43471 20.6046 7.9635L13.943 2.67427C12.7785 1.74912 11.1154 1.77901 9.98539 2.74538L3.46701 7.9635C2.87274 8.42082 2.51755 9.11956 2.5 9.86585V18.5686C2.5 20.4637 4.04738 22 5.95617 22H7.87229C8.19917 22.0023 8.51349 21.8751 8.74547 21.6464C8.97746 21.4178 9.10793 21.1067 9.10792 20.7821H9.14373Z"
                                        fill="currentColor"></path>
                                </svg>
                            </i>
                            <span class="item-name">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <hr class="hr-horizontal" style="background-color: white">
                    </li>

                    {{-- Kelola Konten --}}
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#kelola-konten-menu" role="button"
                            aria-expanded="false" aria-controls="kelola-konten-menu">
                            <i class="icon">
                                <svg class="icon-24" width="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.4"
                                        d="M16.0756 2H19.4616C20.8639 2 22.0001 3.14585 22.0001 4.55996V7.97452C22.0001 9.38864 20.8639 10.5345 19.4616 10.5345H16.0756C14.6734 10.5345 13.5371 9.38864 13.5371 7.97452V4.55996C13.5371 3.14585 14.6734 2 16.0756 2Z"
                                        fill="currentColor"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M4.53852 2H7.92449C9.32676 2 10.463 3.14585 10.463 4.55996V7.97452C10.463 9.38864 9.32676 10.5345 7.92449 10.5345H4.53852C3.13626 10.5345 2 9.38864 2 7.97452V4.55996C2 3.14585 3.13626 2 4.53852 2ZM4.53852 13.4655H7.92449C9.32676 13.4655 10.463 14.6114 10.463 16.0255V19.44C10.463 20.8532 9.32676 22 7.92449 22H4.53852C3.13626 22 2 20.8532 2 19.44V16.0255C2 14.6114 3.13626 13.4655 4.53852 13.4655ZM19.4615 13.4655H16.0755C14.6732 13.4655 13.537 14.6114 13.537 16.0255V19.44C13.537 20.8532 14.6732 22 16.0755 22H19.4615C20.8637 22 22 20.8532 22 19.44V16.0255C22 14.6114 20.8637 13.4655 19.4615 13.4655Z"
                                        fill="currentColor"></path>
                                </svg>
                            </i>
                            <span class="item-name">Kelola Konten</span>
                            <i class="right-icon">
                                <svg class="icon-18" xmlns="http://www.w3.org/2000/svg" width="18" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </i>
                        </a>
                        <ul class="sub-nav collapse @if (
                                // str_contains($menu, 'mitra') ||
                                str_contains($menu, 'profils') ||
                                str_contains($menu, 'beritas') ||
                                str_contains($menu, 'artikels') ||
                                str_contains($menu, 'category') ||
                                str_contains($menu, 'arsip')) show @endif"
                            id="kelola-konten-menu" data-bs-parent="#sidebar-menu">

                            {{-- <li class="nav-item">
                                <a class="nav-link @if (str_contains($menu, 'poster')) active @endif"
                                    aria-current="page" href="{{ url('/admin/posters') }}">
                                    <i class="icon">
                                        <svg class="icon-8" width="8" height="8" viewBox="0 0 8 8"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="4" cy="4" r="4" fill="currentColor" />
                                        </svg>
                                    </i>
                                    <span class="item-name">Poster</span>
                                </a>
                            </li> --}}
                            {{-- @if ($session_data['user_level_id'] == 1 || $session_data['user_level_id'] == 2)
                            <li class="nav-item">
                                <a class="nav-link @if (str_contains($menu, 'mitra')) active @endif"
                                    href="{{ url('/admin/mitras') }}">
                                    <i class="icon">
                                        <svg class="icon-8" width="8" height="8" viewBox="0 0 8 8"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="4" cy="4" r="4" fill="currentColor" />
                                        </svg>
                                    </i>
                                    <span class="item-name">Mitra</span>
                                </a>
                                <hr class="hr-horizontal" style="background-color: white">
                            </li>
                            @endif --}}

                            @if ($session_data['user_level_id'] == 1 || $session_data['user_level_id'] == 2)
                                <li class="nav-item">
                                    <a class="nav-link @if (str_contains($menu, 'profils')) active @endif"
                                        aria-current="page" href="{{ url('/admin/profils') }}">
                                        <i class="icon">
                                            <svg class="icon-8" width="8" height="8" viewBox="0 0 8 8"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="4" cy="4" r="4" fill="currentColor" />
                                            </svg>
                                        </i>
                                        <span class="item-name">Profil</span>
                                    </a>
                                </li>
                            @endif

                            <li class="nav-item">
                                <a class="nav-link @if (str_contains($menu, 'beritas')) active @endif"
                                    href="{{ url('/admin/beritas') }}">
                                    <i class="icon">
                                        <svg class="icon-8" width="8" height="8" viewBox="0 0 8 8"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="4" cy="4" r="4" fill="currentColor" />
                                        </svg>
                                    </i>
                                    <span class="item-name">Berita</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link @if (str_contains($menu, 'artikels')) active @endif"
                                    href="{{ url('/admin/artikels') }}">
                                    <i class="icon">
                                        <svg class="icon-8" width="8" height="8" viewBox="0 0 8 8"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="4" cy="4" r="4" fill="currentColor" />
                                        </svg>
                                    </i>
                                    <span class="item-name">Artikel</span>
                                </a>
                                <hr class="hr-horizontal" style="background-color: white">
                            </li>

                            <li class="nav-item">
                                <a class="nav-link @if (str_contains($menu, 'category')) active @endif"
                                    href="{{ url('/admin/categories') }}">
                                    <i class="icon">
                                        <svg class="icon-8" width="8" height="8" viewBox="0 0 8 8"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="4" cy="4" r="4" fill="currentColor" />
                                        </svg>
                                    </i>
                                    <span class="item-name">Kategori</span>
                                </a>
                                <hr class="hr-horizontal" style="background-color: white">
                            </li>

                            {{-- <li class="nav-item">
                                <a class="nav-link @if (str_contains($menu, 'arsip')) active @endif"
                                    href="{{ url('/admin/arsip') }}">
                                    <i class="icon">
                                        <svg class="icon-8" width="8" height="8" viewBox="0 0 8 8"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="4" cy="4" r="4" fill="currentColor" />
                                        </svg>
                                    </i>
                                    <span class="item-name">Arsip</span>
                                </a>
                            </li> --}}

                        </ul>
                    </li>

                    {{-- dokumen publik --}}
                    @if ($session_data['user_level_id'] == 1 || $session_data['user_level_id'] == 2)
                    <li class="nav-item">
                        <a class="nav-link @if (str_contains($menu, 'document')) {{ 'active' }} @endif"
                            aria-current="page" href="{{ url('/admin/documents') }}">
                            <i class="icon">
                                <svg class="icon-24" width="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.4"
                                        d="M18.8088 9.021C18.3573 9.021 17.7592 9.011 17.0146 9.011C15.1987 9.011 13.7055 7.508 13.7055 5.675V2.459C13.7055 2.206 13.5036 2 13.253 2H7.96363C5.49517 2 3.5 4.026 3.5 6.509V17.284C3.5 19.889 5.59022 22 8.16958 22H16.0463C18.5058 22 20.5 19.987 20.5 17.502V9.471C20.5 9.217 20.299 9.012 20.0475 9.013C19.6247 9.016 19.1177 9.021 18.8088 9.021Z"
                                        fill="currentColor"></path>
                                    <path opacity="0.4"
                                        d="M16.0842 2.56737C15.7852 2.25637 15.2632 2.47037 15.2632 2.90137V5.53837C15.2632 6.64437 16.1742 7.55437 17.2802 7.55437C17.9772 7.56237 18.9452 7.56437 19.7672 7.56237C20.1882 7.56137 20.4022 7.05837 20.1102 6.75437C19.0552 5.65737 17.1662 3.69137 16.0842 2.56737Z"
                                        fill="currentColor"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M8.97398 11.3877H12.359C12.77 11.3877 13.104 11.0547 13.104 10.6437C13.104 10.2327 12.77 9.89868 12.359 9.89868H8.97398C8.56298 9.89868 8.22998 10.2327 8.22998 10.6437C8.22998 11.0547 8.56298 11.3877 8.97398 11.3877ZM8.97408 16.3819H14.4181C14.8291 16.3819 15.1631 16.0489 15.1631 15.6379C15.1631 15.2269 14.8291 14.8929 14.4181 14.8929H8.97408C8.56308 14.8929 8.23008 15.2269 8.23008 15.6379C8.23008 16.0489 8.56308 16.3819 8.97408 16.3819Z"
                                        fill="currentColor"></path>
                                </svg>
                            </i>
                            <span class="item-name">Dokumen Publik</span>
                        </a>
                    </li>
                    @endif

                    {{-- galeri --}}
                    {{-- <li class="nav-item">
                        <a class="nav-link @if (str_contains($menu, 'galery')) {{ 'active' }} @endif"
                            aria-current="page" href="{{ url('/admin/galeries') }}">
                            <i class="icon">
                                <svg class="icon-24" width="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M21.9999 14.7024V16.0859C21.9999 16.3155 21.9899 16.5471 21.9699 16.7767C21.6893 19.9357 19.4949 22 16.3286 22H7.67126C6.06806 22 4.71535 21.4797 3.74341 20.5363C3.36265 20.1864 3.042 19.7753 2.7915 19.3041C3.12217 18.9021 3.49291 18.462 3.85363 18.0208C4.46485 17.289 5.05603 16.5661 5.42677 16.0959C5.97788 15.4142 7.43078 13.6196 9.44481 14.4617C9.85563 14.6322 10.2164 14.8728 10.547 15.0833C11.3586 15.6247 11.6993 15.7851 12.2705 15.4743C12.9017 15.1335 13.3125 14.4617 13.7434 13.76C13.9739 13.388 14.2043 13.0281 14.4548 12.6972C15.547 11.2736 17.2304 10.8926 18.6332 11.7348C19.3346 12.1559 19.9358 12.6872 20.4969 13.2276C20.6172 13.3479 20.7374 13.4592 20.8476 13.5695C20.9979 13.7198 21.4989 14.2211 21.9999 14.7024Z"
                                        fill="currentColor"></path>
                                    <path opacity="0.4"
                                        d="M16.3387 2H7.67134C4.27455 2 2 4.37607 2 7.91411V16.086C2 17.3181 2.28056 18.4119 2.79158 19.3042C3.12224 18.9022 3.49299 18.4621 3.85371 18.0199C4.46493 17.2891 5.05611 16.5662 5.42685 16.096C5.97796 15.4143 7.43086 13.6197 9.44489 14.4618C9.85571 14.6323 10.2164 14.8729 10.5471 15.0834C11.3587 15.6248 11.6994 15.7852 12.2705 15.4734C12.9018 15.1336 13.3126 14.4618 13.7435 13.759C13.9739 13.3881 14.2044 13.0282 14.4549 12.6973C15.5471 11.2737 17.2305 10.8927 18.6333 11.7349C19.3347 12.1559 19.9359 12.6873 20.497 13.2277C20.6172 13.348 20.7375 13.4593 20.8477 13.5696C20.998 13.7189 21.499 14.2202 22 14.7025V7.91411C22 4.37607 19.7255 2 16.3387 2Z"
                                        fill="currentColor"></path>
                                    <path
                                        d="M11.4543 8.79668C11.4543 10.2053 10.2809 11.3783 8.87313 11.3783C7.46632 11.3783 6.29297 10.2053 6.29297 8.79668C6.29297 7.38909 7.46632 6.21509 8.87313 6.21509C10.2809 6.21509 11.4543 7.38909 11.4543 8.79668Z"
                                        fill="currentColor"></path>
                                </svg>
                            </i>
                            <span class="item-name">Galeri</span>
                        </a>
                    </li> --}}

                    <li>
                        <hr class="hr-horizontal" style="background-color: white">
                    </li>

                    {{-- agenda --}}
                    @if ($session_data['user_level_id'] == 1 || $session_data['user_level_id'] == 2)
                    <li class="nav-item">
                        <a class="nav-link @if (str_contains($menu, 'agenda')) {{ 'active' }} @endif"
                            aria-current="page" href="{{ url('/admin/agendas') }}">
                            <i class="icon">
                                <svg class="icon-24" width="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.4"
                                        d="M16.6203 22H7.3797C4.68923 22 2.5 19.8311 2.5 17.1646V11.8354C2.5 9.16894 4.68923 7 7.3797 7H16.6203C19.3108 7 21.5 9.16894 21.5 11.8354V17.1646C21.5 19.8311 19.3108 22 16.6203 22Z"
                                        fill="currentColor"></path>
                                    <path
                                        d="M15.7551 10C15.344 10 15.0103 9.67634 15.0103 9.27754V6.35689C15.0103 4.75111 13.6635 3.44491 12.0089 3.44491C11.2472 3.44491 10.4477 3.7416 9.87861 4.28778C9.30854 4.83588 8.99272 5.56508 8.98974 6.34341V9.27754C8.98974 9.67634 8.65604 10 8.24487 10C7.8337 10 7.5 9.67634 7.5 9.27754V6.35689C7.50497 5.17303 7.97771 4.08067 8.82984 3.26285C9.68098 2.44311 10.7814 2.03179 12.0119 2C14.4849 2 16.5 3.95449 16.5 6.35689V9.27754C16.5 9.67634 16.1663 10 15.7551 10Z"
                                        fill="currentColor"></path>
                                </svg>
                            </i>
                            <span class="item-name">Agenda</span>
                        </a>
                    </li>
                    @endif

                    {{-- lokawista --}}
                    <li class="nav-item">
                        <a class="nav-link @if (str_contains($menu, 'lokawisata')) {{ 'active' }} @endif"
                            aria-current="page" href="{{ url('/admin/lokawisatas') }}">
                            <i class="icon">
                                <svg class="icon-24" width="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.4"
                                        d="M16.8843 5.11485H13.9413C13.2081 5.11969 12.512 4.79355 12.0474 4.22751L11.0782 2.88762C10.6214 2.31661 9.9253 1.98894 9.19321 2.00028H7.11261C3.37819 2.00028 2.00001 4.19201 2.00001 7.91884V11.9474C1.99536 12.3904 21.9956 12.3898 21.9969 11.9474V10.7761C22.0147 7.04924 20.6721 5.11485 16.8843 5.11485Z"
                                        fill="currentColor"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M20.8321 6.54353C21.1521 6.91761 21.3993 7.34793 21.5612 7.81243C21.8798 8.76711 22.0273 9.77037 21.9969 10.7761V16.0292C21.9956 16.4717 21.963 16.9135 21.8991 17.3513C21.7775 18.1241 21.5057 18.8656 21.0989 19.5342C20.9119 19.8571 20.6849 20.1553 20.4231 20.4215C19.2383 21.5089 17.665 22.0749 16.0574 21.9921H7.93061C6.32049 22.0743 4.74462 21.5086 3.55601 20.4215C3.2974 20.1547 3.07337 19.8566 2.88915 19.5342C2.48475 18.8661 2.21869 18.1238 2.1067 17.3513C2.03549 16.9142 1.99981 16.4721 2 16.0292V10.7761C1.99983 10.3374 2.02357 9.89902 2.07113 9.46288C2.08113 9.38636 2.09614 9.31109 2.11098 9.23659C2.13573 9.11241 2.16005 8.99038 2.16005 8.86836C2.25031 8.34204 2.41496 7.83116 2.64908 7.35101C3.34261 5.86916 4.76525 5.11492 7.09481 5.11492H16.8754C18.1802 5.01401 19.4753 5.4068 20.5032 6.21522C20.6215 6.3156 20.7316 6.4254 20.8321 6.54353ZM6.97033 15.5412H17.0355H17.0533C17.2741 15.5507 17.4896 15.4717 17.6517 15.3217C17.8137 15.1716 17.9088 14.963 17.9157 14.7425C17.9282 14.5487 17.8644 14.3577 17.7379 14.2101C17.5924 14.0118 17.3618 13.8935 17.1155 13.8907H6.97033C6.51365 13.8907 6.14343 14.2602 6.14343 14.7159C6.14343 15.1717 6.51365 15.5412 6.97033 15.5412Z"
                                        fill="currentColor"></path>
                                </svg>
                            </i>
                            <span class="item-name">Lokawisata</span>
                        </a>
                    </li>

                    {{-- virtual tour --}}
                    @if ($session_data['user_level_id'] == 1 || $session_data['user_level_id'] == 2)
                    <li class="nav-item">
                        <a class="nav-link @if (str_contains($menu, 'virtual_tour')) {{ 'active' }} @endif"
                            aria-current="page" href="{{ url('/admin/virtual_tours') }}">
                            <i class="icon">
                                <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                <path opacity="0.4" d="M22 12C22 17.523 17.523 22 12 22C6.477 22 2 17.523 2 12C2 6.478 6.477 2 12 2C17.523 2 22 6.478 22 12Z" fill="currentColor"></path>                                <path d="M15.8597 8.70505L14.2397 13.8251C14.1797 14.0351 14.0097 14.2051 13.7997 14.2661L8.69972 15.8651C8.35972 15.9761 8.02972 15.6451 8.13972 15.3051L9.73972 10.1751C9.79972 9.96505 9.96972 9.80505 10.1797 9.73505L15.2997 8.13505C15.6497 8.02505 15.9697 8.35505 15.8597 8.70505Z" fill="currentColor"></path>                                </svg>                            
                            </i>
                            <span class="item-name">Virtual Tour</span>
                        </a>
                    </li> 
                    @endif

                    @if ($session_data['user_level_id'] == 1 || $session_data['user_level_id'] == 2)
                        {{-- pesan --}}
                        <li class="nav-item">
                            <a class="nav-link @if (str_contains($menu, 'message')) {{ 'active' }} @endif"
                                aria-current="page" href="{{ url('/admin/messages') }}">
                                <i class="icon">
                                    <svg class="icon-24" width="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.4"
                                            d="M12.02 2C6.21 2 2 6.74 2 12C2 13.68 2.49 15.41 3.35 16.99C3.51 17.25 3.53 17.58 3.42 17.89L2.75 20.13C2.6 20.67 3.06 21.07 3.57 20.91L5.59 20.31C6.14 20.13 6.57 20.36 7.081 20.67C8.541 21.53 10.36 21.97 12 21.97C16.96 21.97 22 18.14 22 11.97C22 6.65 17.7 2 12.02 2Z"
                                            fill="currentColor"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M11.9807 13.2901C11.2707 13.2801 10.7007 12.7101 10.7007 12.0001C10.7007 11.3001 11.2807 10.7201 11.9807 10.7301C12.6907 10.7301 13.2607 11.3001 13.2607 12.0101C13.2607 12.7101 12.6907 13.2901 11.9807 13.2901ZM7.37033 13.2901C6.67033 13.2901 6.09033 12.7101 6.09033 12.0101C6.09033 11.3001 6.66033 10.7301 7.37033 10.7301C8.08033 10.7301 8.65033 11.3001 8.65033 12.0101C8.65033 12.7101 8.08033 13.2801 7.37033 13.2901ZM15.3105 12.0101C15.3105 12.7101 15.8805 13.2901 16.5905 13.2901C17.3005 13.2901 17.8705 12.7101 17.8705 12.0101C17.8705 11.3001 17.3005 10.7301 16.5905 10.7301C15.8805 10.7301 15.3105 11.3001 15.3105 12.0101Z"
                                            fill="currentColor"></path>
                                    </svg>
                                </i>
                                <span class="item-name">Pesan</span>
                            </a>
                        </li>
                    @endif

                    @if ($session_data['user_level_id'] == 1)
                        <li>
                            <hr class="hr-horizontal" style="background-color: white">
                        </li>
                        {{-- pengguna --}}
                        <li class="nav-item">
                            <a class="nav-link @if (str_contains($menu, 'user')) {{ 'active' }} @endif"
                                aria-current="page" href="{{ url('/admin/users') }}">
                                <i class="icon">
                                    <svg class="icon-24" width="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.4"
                                            d="M21.101 9.58786H19.8979V8.41162C19.8979 7.90945 19.4952 7.5 18.999 7.5C18.5038 7.5 18.1 7.90945 18.1 8.41162V9.58786H16.899C16.4027 9.58786 16 9.99731 16 10.4995C16 11.0016 16.4027 11.4111 16.899 11.4111H18.1V12.5884C18.1 13.0906 18.5038 13.5 18.999 13.5C19.4952 13.5 19.8979 13.0906 19.8979 12.5884V11.4111H21.101C21.5962 11.4111 22 11.0016 22 10.4995C22 9.99731 21.5962 9.58786 21.101 9.58786Z"
                                            fill="currentColor"></path>
                                        <path
                                            d="M9.5 15.0156C5.45422 15.0156 2 15.6625 2 18.2467C2 20.83 5.4332 21.5001 9.5 21.5001C13.5448 21.5001 17 20.8533 17 18.269C17 15.6848 13.5668 15.0156 9.5 15.0156Z"
                                            fill="currentColor"></path>
                                        <path opacity="0.4"
                                            d="M9.50023 12.5542C12.2548 12.5542 14.4629 10.3177 14.4629 7.52761C14.4629 4.73754 12.2548 2.5 9.50023 2.5C6.74566 2.5 4.5376 4.73754 4.5376 7.52761C4.5376 10.3177 6.74566 12.5542 9.50023 12.5542Z"
                                            fill="currentColor"></path>
                                    </svg>
                                </i>
                                <span class="item-name">Pengguna</span>
                            </a>
                        </li>
                    @endif

                    @if ($session_data['user_level_id'] == 1)
                        {{-- setting --}}
                        <li class="nav-item">
                            <a class="nav-link @if (str_contains($menu, 'setting')) {{ 'active' }} @endif"
                                aria-current="page" href="{{ url('/admin/settings') }}">
                                <i class="icon">
                                    <svg class="icon-24" width="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M12.0122 14.8299C10.4077 14.8299 9.10986 13.5799 9.10986 12.0099C9.10986 10.4399 10.4077 9.17993 12.0122 9.17993C13.6167 9.17993 14.8839 10.4399 14.8839 12.0099C14.8839 13.5799 13.6167 14.8299 12.0122 14.8299Z"
                                            fill="currentColor"></path>
                                        <path opacity="0.4"
                                            d="M21.2301 14.37C21.036 14.07 20.76 13.77 20.4023 13.58C20.1162 13.44 19.9322 13.21 19.7687 12.94C19.2475 12.08 19.5541 10.95 20.4228 10.44C21.4447 9.87 21.7718 8.6 21.179 7.61L20.4943 6.43C19.9118 5.44 18.6344 5.09 17.6226 5.67C16.7233 6.15 15.5685 5.83 15.0473 4.98C14.8838 4.7 14.7918 4.4 14.8122 4.1C14.8429 3.71 14.7203 3.34 14.5363 3.04C14.1582 2.42 13.4735 2 12.7172 2H11.2763C10.5302 2.02 9.84553 2.42 9.4674 3.04C9.27323 3.34 9.16081 3.71 9.18125 4.1C9.20169 4.4 9.10972 4.7 8.9462 4.98C8.425 5.83 7.27019 6.15 6.38109 5.67C5.35913 5.09 4.09191 5.44 3.49917 6.43L2.81446 7.61C2.23194 8.6 2.55897 9.87 3.57071 10.44C4.43937 10.95 4.74596 12.08 4.23498 12.94C4.06125 13.21 3.87729 13.44 3.59115 13.58C3.24368 13.77 2.93709 14.07 2.77358 14.37C2.39546 14.99 2.4159 15.77 2.79402 16.42L3.49917 17.62C3.87729 18.26 4.58245 18.66 5.31825 18.66C5.66572 18.66 6.0745 18.56 6.40153 18.36C6.65702 18.19 6.96361 18.13 7.30085 18.13C8.31259 18.13 9.16081 18.96 9.18125 19.95C9.18125 21.1 10.1215 22 11.3069 22H12.6968C13.872 22 14.8122 21.1 14.8122 19.95C14.8429 18.96 15.6911 18.13 16.7029 18.13C17.0299 18.13 17.3365 18.19 17.6022 18.36C17.9292 18.56 18.3278 18.66 18.6855 18.66C19.411 18.66 20.1162 18.26 20.4943 17.62L21.2097 16.42C21.5776 15.75 21.6083 14.99 21.2301 14.37Z"
                                            fill="currentColor"></path>
                                    </svg>
                                </i>
                                <span class="item-name">Pengaturan</span>
                            </a>
                        </li>
                    @endif

                    @if ($session_data['user_level_id'] == 3)
                        {{-- setting --}}
                        <li class="nav-item">
                            <a class="nav-link @if (str_contains($menu, 'survey')) {{ 'active' }} @endif"
                                aria-current="page" href="{{ url('/admin/survey') }}">
                                <i class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send-fill" viewBox="0 0 16 16">
                                        <path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471z"/>
                                      </svg>
                                </i>
                                <span class="item-name">Survey</span>
                            </a>
                        </li>
                    @endif

                </ul>

                <!-- Sidebar Menu End -->
            </div>
        </div>
        <div class="sidebar-footer"></div>
    </aside>
    <main class="main-content">
        <div class="position-relative iq-banner">
            <!--Nav Start-->
            <nav class="nav navbar navbar-expand-lg navbar-light iq-navbar navs-sticky menu-sticky">
                <div class="container-fluid navbar-inner">
                    <a href="{{ url('/admin/dashboard') }}" class="navbar-brand">
                        <!--Logo start-->
                        <div class="logo-main">
                            <div class="logo-normal">
                                <img src="{{ asset('/' . str_replace('/xxx/', '/300/', $setting['logo-geopark'])) }}">
                            </div>
                            <div class="logo-mini">
                                <img src="{{ asset('/' . str_replace('/xxx/', '/100/', $setting['logo-geopark'])) }}">
                            </div>
                        </div>
                        <!--logo End-->
                        <h4 class="logo-title">{{ $setting['name-short'] }}</h4>
                    </a>
                    <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
                        <i class="icon">
                            <svg width="20px" class="icon-20" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z" />
                            </svg>
                        </i>
                    </div>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon">
                            <span class="mt-2 navbar-toggler-bar bar1"></span>
                            <span class="navbar-toggler-bar bar2"></span>
                            <span class="navbar-toggler-bar bar3"></span>
                        </span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="mb-2 navbar-nav ms-auto align-items-center navbar-list mb-lg-0">
                            <li class="nav-item dropdown">
                                <a class="py-0 nav-link d-flex align-items-center" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <img id="user-picture" src="{{ asset('/' . str_replace('/xxx/', '/100/', $session_data['user_picture'])) . '?' . time() }}"
                                        class="theme-color-default-img img-fluid avatar avatar-50 avatar-rounded">
                                    <div class="caption ms-3 d-none d-md-block">
                                        <h6 class="mb-0 caption-title" id="user-name">{{ $session_data['user_name'] }}</h6>
                                        <p class="mb-0 caption-sub-title" id="user-level-name">{{ $session_data['user_level_name'] }}</p>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="{{ url('/admin/profile') }}">Profile</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="{{ url('/admin/auth/logout') }}">Logout</a></li>
                                </ul>
                            </li>
                        </ul>                        
                    </div>
                </div>
            </nav>
            <!--Nav End-->
        </div>


        @yield('content')


        <!-- Footer Section Start -->
        <footer class="footer">
            <div class="footer-body">
                <div class="right-panel">
                    {{ $setting['copyright'] }}
                </div>
            </div>
        </footer>
        <!-- Footer Section End -->
    </main>

    <!-- Validation -->
    <script src="{{ asset('assets/js/plugins/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/additional-methods.min.js') }}"></script>

    <!-- Alert -->
    <script src="{{ asset('assets/js/sweetalert2@11.js') }}"></script>

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

    <!-- Poster-tab Script -->
    <script src="{{ asset('assets/js/plugins/slider-tabs.js') }}"></script>

    <!-- Form Wizard Script -->
    <script src="{{ asset('assets/js/plugins/form-wizard.js') }}"></script>

    <!-- AOS Animation Plugin-->
    <script src="{{ asset('assets/vendor/aos/dist/aos.js') }}"></script>

    <!-- App Script -->
    <script src="{{ asset('assets/js/hope-ui.js') }}" defer></script>

</body>

</html>
