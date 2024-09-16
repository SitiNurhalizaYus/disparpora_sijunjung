@extends('client.layouts.app')

@section('content')
    <div class="container-fluid position-relative p-0">
        <!-- Header Section -->
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

        <!-- Breadcrumb Section -->
        <div class="container-fluid bg-light py-3">
            <div class="px-5">
                <a href="{{ url('/beranda') }}" class="text-green">Beranda</a>
                <i class="bi bi-arrow-right-short text-green px-2"></i>
                <span class="text-green" id="breadcrumb-title">Profil</span>
            </div>
        </div>

        <!-- Blog Detail Section -->
        <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="container py-5">
                <div class="row g-5">
                    <!-- Blog Content Start -->
                    <div class="col-lg-8">
                        <div class="text-dark row g-5 mb-5" id="blog-detail">
                            <!-- Konten detail akan dimuat di sini menggunakan AJAX -->
                        </div>

                        <!-- Bagikan Postingan Start -->
                        <div class="share-buttons mb-5 mt-3 wow zoomIn" data-wow-delay="0.3s">
                            <p class="fw-bold">Share on : <br></p>
                            <div class="d-flex">
                                <button class="share-btn facebook mx-2"
                                    onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(window.location.href), '_blank')">
                                    <i class="bi bi-facebook"></i>
                                </button>
                                <button class="share-btn twitter mx-2"
                                    onclick="window.open('https://twitter.com/intent/tweet?url=' + encodeURIComponent(window.location.href) + '&text=' + encodeURIComponent(document.title), '_blank')">
                                    <i class="bi bi-twitter"></i>
                                </button>
                                <button class="share-btn linkedin mx-2"
                                    onclick="window.open('https://www.linkedin.com/shareArticle?mini=true&url=' + encodeURIComponent(window.location.href), '_blank')">
                                    <i class="bi bi-linkedin"></i>
                                </button>
                                <button class="share-btn whatsapp mx-2"
                                    onclick="window.open('https://wa.me/?text=' + encodeURIComponent('Check this out! ' + window.location.href), '_blank')">
                                    <i class="bi bi-whatsapp"></i>
                                </button>
                                <button class="share-btn email mx-2"
                                    onclick="window.location.href='mailto:?subject=' + encodeURIComponent(document.title) + '&body=' + encodeURIComponent('Check this out! ' + window.location.href)">
                                    <i class="bi bi-envelope"></i>
                                </button>

                            </div>
                        </div>
                        <!-- Bagikan Postingan End -->
                    </div>
                    <!-- Blog Content End -->

                    <!-- Sidebar Start -->
                    <div class="col-lg-4">

                        <!-- Recent Post Start -->
                        <div class="mb-5 wow slideInUp" data-wow-delay="0.1s">
                            <div class="section-title section-title-sm position-relative pb-3 mb-4">
                                <h3 class="mb-0">Recent Posts</h3>
                            </div>
                            <div id="recent-post-list">
                                <!-- Recent posts akan dimuat di sini menggunakan AJAX -->
                            </div>
                        </div>
                        <!-- Recent Post End -->


                    </div>
                    <!-- Sidebar End -->
                </div>
            </div>
        </div>
        <!-- Blog End -->
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            const baseUrl = "{{ url('/') }}";
            // Fungsi untuk memuat detail konten dengan AJAX
            function loadContentDetail(slug) {
                $.ajax({
                    url: "{{ url('/api/content') }}/" + slug,
                    method: "GET",
                    success: function(response) {
                        const content = response.data;
                        
                        // Menggabungkan base URL dengan path gambar
                        const imagePath = `${baseUrl}/uploads/${content.image.split('/').pop()}`;
    
                        const detailHtml = `
                        <h1 class="mb-3">${content.title}</h1>
                        <img class="img-fluid w-100 rounded mb-3" src="${imagePath}" alt="${content.title}">
                            <p>${content.content}</p>
                        `;
                        $('#blog-detail').html(detailHtml);
                        $('#breadcrumb-title').text(content.title);

                        // Setelah detail dimuat, muat recent posts tanpa konten ini
                        loadRecentPosts(slug);
                    },
                    error: function(xhr) {
                        $('#blog-detail').html(
                            '<p class="text-center">Gagal memuat detail profil. Silakan coba lagi nanti.</p>'
                        );
                    }
                });
            }

            // Fungsi untuk memuat recent posts dengan AJAX
            function loadRecentPosts(slug) {
                $.ajax({
                    url: "{{ url('/api/content') }}",
                    method: "GET",
                    data: {
                        recent: true,
                        type: 'berita',
                        per_page: 6, // Membatasi jumlah recent posts
                        exclude_slug: slug // Kirim slug yang akan dikecualikan
                    },
                    success: function(response) {
                        let recentPostList = '';
                        $.each(response.data, function(index, post) {
                            recentPostList += `
                            <div class="d-flex rounded overflow-hidden mb-3">
                                <img class="img-fluid" src="${post.image}" style="width: 100px; height: 100px; object-fit: cover;" alt="${post.title}">
                                <a href="{{ url('/berita') }}/${post.slug}" class="h5 fw-semi-bold d-flex align-items-center bg-light px-3 mb-0">${post.title}</a>
                                </div>
                                `;
                        });
                        $('#recent-post-list').html(recentPostList);
                    },
                    error: function(xhr) {
                        $('#recent-post-list').html(
                            '<p class="text-center">Gagal memuat postingan terbaru. Silakan coba lagi nanti.</p>'
                        );
                    }
                });
            }

            // Muat detail konten berdasarkan slug dari URL
            const slug = window.location.pathname.split('/').pop();
            loadContentDetail(slug);
        });
    </script>
@endsection
