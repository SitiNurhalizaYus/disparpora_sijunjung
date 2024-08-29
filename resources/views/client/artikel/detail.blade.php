@extends('client.layouts.app')

@section('content')
    <!-- Font Awesome untuk ikon sosial media -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Styling untuk tombol berbagi sosial media -->
    <style>
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            color: white;
            text-align: center;
            font-size: 14px;
        }

        .btn i {
            margin: 0;
        }

        .btn-sm {
            width: 36px;
            height: 36px;
        }

        .btn-facebook {
            background-color: #3b5998;
            /* Facebook */
        }

        .btn-twitter {
            background-color: #1DA1F2;
            /* Twitter */
        }

        .btn-whatsapp {
            background-color: #25D366;
            /* WhatsApp */
        }

        .btn-linkedin {
            background-color: #0077b5;
            /* LinkedIn */
        }
    </style>

    <div class="container-fluid position-relative p-0">
        <!-- Header Section -->
        <div class="container-fluid bg-primary py-5 bg-header">
            <div class="row py-5">
                <div class="col-12 pt-lg-5 mt-lg-5 text-center">
                    <img src="{{ asset('/' . str_replace('/xxx/', '/100/', $setting['logo-parpora'])) }}" alt="Logo" class="logo">
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
                <a href="{{ route('artikel.index') }}" class="text-green">Artikel</a>
                <i class="bi bi-arrow-right-short text-green px-2"></i>
                <span class="text-green" id="breadcrumb-title">Detail</span>
            </div>
        </div>

        <!-- Blog Detail Section -->
        <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="container py-5">
                <div class="row g-5">
                    <!-- Blog Content Start -->
                    <div class="col-lg-8">
                        <div class="mb-5" id="blog-detail">
                            <!-- Konten detail akan dimuat di sini menggunakan AJAX -->
                        </div>

                        <!-- Share Section Start -->
                        <div class="container-fluid py-3">
                            <h5 class="mb-4">Share on:</h5>
                            <div class="d-flex justify-content-start">
                                <a href="#" id="share-facebook" class="btn btn-facebook btn-sm me-2" target="_blank">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#" id="share-twitter" class="btn btn-twitter btn-sm me-2" target="_blank">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#" id="share-whatsapp" class="btn btn-whatsapp btn-sm me-2" target="_blank">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                                <a href="#" id="share-linkedin" class="btn btn-linkedin btn-sm me-2" target="_blank">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            </div>
                        </div>
                        <!-- Share Section End -->
                    </div>
                    <!-- Blog Content End -->

                    <!-- Sidebar Start -->
                    <div class="col-lg-4">
                        <!-- Search Form Start -->
                        <div class="mb-5 wow slideInUp" data-wow-delay="0.1s">
                            <div class="input-group">
                                <input type="text" class="form-control p-3" placeholder="Keyword">
                                <button class="btn btn-primary px-4"><i class="bi bi-search"></i></button>
                            </div>
                        </div>
                        <!-- Search Form End -->

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
@endsection

<!-- Script untuk memuat konten detail dan recent posts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Fungsi untuk memuat detail konten dengan AJAX
        function loadContentDetail(slug) {
            $.ajax({
                url: "{{ url('/api/content') }}/" + slug,
                method: "GET",
                success: function(response) {
                    const content = response.data;
                    const formattedDate = new Date(content.created_at)
                        .toLocaleDateString('id-ID', {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        });

                    const detailHtml = `
                        <img class="img-fluid w-100 rounded mb-5" src="${content.image}" alt="${content.title}">
                        <h1 class="mb-4">${content.title}</h1>
                        <p>${content.content}</p>
                    `;

                    $('#blog-detail').html(detailHtml);
                    $('#breadcrumb-title').text(content.title);
                },
                error: function(xhr) {
                    $('#blog-detail').html(
                        '<p class="text-center">Gagal memuat detail artikel. Silakan coba lagi nanti.</p>'
                    );
                }
            });
        }

        // Fungsi untuk memuat recent posts dengan AJAX
        function loadRecentPosts() {
            $.ajax({
                url: "{{ url('/api/content') }}",
                method: "GET",
                data: {
                    recent: true,
                    type: 'artikel',
                    per_page: 5 // Membatasi jumlah recent posts
                },
                success: function(response) {
                    let recentPostList = '';
                    $.each(response.data, function(index, post) {
                        recentPostList += `
                            <div class="d-flex rounded overflow-hidden mb-3">
                                <img class="img-fluid" src="${post.image}" style="width: 100px; height: 100px; object-fit: cover;" alt="${post.title}">
                                <a href="{{ url('/artikel') }}/${post.slug}" class="h5 fw-semi-bold d-flex align-items-center bg-light px-3 mb-0">${post.title}</a>
                            </div>
                        `;
                    });
                    $('#recent-post-list').html(recentPostList);
                }
            });
        }

        // Muat detail konten berdasarkan slug dari URL
        const slug = window.location.pathname.split('/').pop();
        loadContentDetail(slug);

        // Muat recent posts
        loadRecentPosts();
    });
</script>

<!-- Script untuk mengatur URL berbagi di sosial media -->
<script>
    $(document).ready(function() {
        // Mendapatkan URL halaman saat ini
        const url = window.location.href;
        const title = document.title;

        // Atur URL berbagi untuk setiap tombol sosial media
        $('#share-facebook').attr('href', `https://www.facebook.com/sharer/sharer.php?u=${url}`);
        $('#share-twitter').attr('href', `https://twitter.com/intent/tweet?url=${url}&text=${title}`);
        $('#share-whatsapp').attr('href', `https://api.whatsapp.com/send?text=${title} ${url}`);
        $('#share-linkedin').attr('href', `https://www.linkedin.com/sharing/share-offsite/?url=${url}`);
    });
</script>
