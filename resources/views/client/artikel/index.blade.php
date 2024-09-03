@extends('client.layouts.app')

@section('content')
    <div class="container-fluid position-relative p-0">
        <!-- Header dengan logo dan nama -->
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

        <!-- Breadcrumbs -->
        <div class="container-fluid bg-primary py-3 bg-light">
            <div class="text-star px-5">
                <a href="{{ url('/beranda') }}" class="text-green">Beranda</a>
                <i class="bi bi-arrow-right-short text-green px-2"></i>
                <a href="{{ route('client.artikel.index') }}" class="text-green">Artikel</a>
            </div>
        </div>

        <!-- Blog Start -->
        <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="container py-5">
                <div class="row g-5">
                    <!-- Blog list Start -->
                    <div class="col-lg-8">
                        <!-- Category Title -->
                        <div id="category-title" class="mb-4" style="display: none;">
                            <h2 class="text-center text-primary" id="selected-category-title"></h2>
                        </div>
                        ` <!-- Archive Title -->
                        <div id="archive-title" class="mb-4" style="display: none;">
                            <h2 class="text-center text-primary" id="selected-archive-title"></h2>
                        </div>
                        <div class="row g-5" id="content-list">
                            <!-- Konten akan dimuat di sini menggunakan AJAX -->
                        </div>
                        <div id="pagination" class="d-flex justify-content-center mt-4">
                            <!-- Pagination akan dimuat di sini -->
                        </div>
                    </div>
                    <!-- Blog list End -->

                    <!-- Sidebar Start -->
                    <div class="col-lg-4">
                        <!-- Search Form Start -->
                        <div class="mb-5 wow slideInUp" data-wow-delay="0.1s">
                            <div class="input-group">
                                <input type="text" id="search-input" class="form-control p-3" placeholder="Keyword">
                                <button class="btn btn-primary px-4" id="search-button"><i
                                        class="bi bi-search"></i></button>
                            </div>
                        </div>
                        <!-- Search Form End -->

                        <!-- Category Start -->
                        <div class="mb-5 wow slideInUp" data-wow-delay="0.1s">
                            <div class="section-title section-title-sm position-relative pb-3 mb-4">
                                <h3 class="mb-0">Categories</h3>
                            </div>
                            <div class="link-animated d-flex flex-column justify-content-start" id="category-list">
                                <!-- Kategori akan dimuat di sini menggunakan AJAX -->
                            </div>
                        </div>
                        <!-- Category End -->

                        <!-- Archives Start -->
                        <div class="mb-5 wow slideInUp" data-wow-delay="0.1s">
                            <div class="section-title section-title-sm position-relative pb-3 mb-4">
                                <h3 class="mb-0">Archives</h3>
                            </div>
                            <div class="d-flex flex-wrap m-n1" id="archive-list">
                                <!-- Arsip akan dimuat di sini menggunakan AJAX -->
                            </div>
                        </div>
                        <!-- Archives End -->
                    </div>
                    <!-- Sidebar End -->
                </div>
            </div>
        </div>
        <!-- Blog End -->

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                let currentPage = 1;
                let perPage = 4;
                let categoryId = null;
                let searchQuery = '';
                let month = null;
                let year = null;

                // Fungsi untuk memuat konten artikel dengan AJAX
                function loadContent(page = 1, append = false) {
                    let data = {
                        page: page,
                        per_page: perPage,
                        type: 'artikel'
                    };

                    if (searchQuery) {
                        data.search = searchQuery;
                    }

                    if (categoryId) {
                        data.category_id = categoryId;
                    } else if (month && year) {
                        data.month = month;
                        data.year = year;
                    }

                    $.ajax({
                        url: "{{ url('/api/content') }}",
                        method: "GET",
                        data: data,
                        success: function(response) {
                            let contentList = '';
                            if (response.data.length > 0) {
                                $.each(response.data, function(index, content) {
                                    const formattedDate = new Date(content.created_at)
                                        .toLocaleDateString('id-ID', {
                                            year: 'numeric',
                                            month: 'long',
                                            day: 'numeric'
                                        });
                                    contentList += `
                                <div class="col-md-6 wow slideInUp" data-wow-delay="0.1s">
                                    <div class="blog-item bg-light rounded overflow-hidden">
                                        <div class="blog-img position-relative overflow-hidden">
                                            <img class="img-fluid" src="${content.image}" alt="${content.title}">
                                        </div>
                                        <div class="p-4">
                                            <div class="d-flex mb-3">
                                                <small><i class="far fa-calendar-alt text-primary me-2"></i>${formattedDate}</small>
                                            </div>
                                            <h4 class="mb-3">${content.title}</h4>
                                            <p>${content.description_short}</p>
                                            <a class="text-uppercase" href="{{ url('/artikel') }}/${content.slug}">Read More <i class="bi bi-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            `;
                                });
                            } else {
                                if (!append) {
                                    contentList =
                                        '<p class="text-center">Tidak ada artikel yang ditemukan.</p>';
                                }
                            }

                            if (append) {
                                $('#content-list').append(contentList);
                            } else {
                                $('#content-list').html(contentList);
                            }

                            // Tampilkan pagination
                            let paginationHtml = '';
                            const totalPages = response.metadata.total_page;

                            if (totalPages > 1) {
                                paginationHtml += `
                            <nav aria-label="...">
                                <ul class="pagination">
                        `;

                                // Tombol Previous
                                if (currentPage > 1) {
                                    paginationHtml += `
                                <li class="page-item">
                                    <a class="page-link" href="#" data-page="${currentPage - 1}" tabindex="-1">Previous</a>
                                </li>
                            `;
                                } else {
                                    paginationHtml += `
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                                </li>
                            `;
                                }

                                // Tombol Halaman
                                for (let i = 1; i <= totalPages; i++) {
                                    paginationHtml += `
                                <li class="page-item ${currentPage === i ? 'active' : ''}">
                                    <a class="page-link" href="#" data-page="${i}">${i}</a>
                                </li>
                            `;
                                }

                                // Tombol Next
                                if (currentPage < totalPages) {
                                    paginationHtml += `
                                <li class="page-item">
                                    <a class="page-link" href="#" data-page="${currentPage + 1}">Next</a>
                                </li>
                            `;
                                } else {
                                    paginationHtml += `
                                <li class="page-item disabled">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            `;
                                }

                                paginationHtml += `
                                </ul>
                            </nav>
                        `;
                            }

                            $('#pagination').html(paginationHtml);
                        },
                        error: function(xhr) {
                            $('#content-list').html(
                                '<p class="text-center">Gagal memuat artikel. Silakan coba lagi nanti.</p>'
                            );
                        }
                    });
                }

                // Fungsi untuk memuat kategori dengan AJAX
                function loadCategories() {
                    $.ajax({
                        url: "{{ url('/api/category') }}",
                        method: "GET",
                        success: function(response) {
                            let categoryList = '';
                            $.each(response.data, function(index, category) {
                                categoryList += `
                            <a href="#" class="h5 fw-semi-bold bg-light rounded py-2 px-3 mb-2" data-category-id="${category.id_category}" data-category-name="${category.name}">
                                <i class="bi bi-arrow-right me-2"></i>${category.name}
                            </a>
                        `;
                            });
                            $('#category-list').html(categoryList);
                        }
                    });
                }

                // Fungsi untuk memuat arsip dengan AJAX
                function loadArchives() {
                    $.ajax({
                        url: "{{ url('/api/arsip') }}",
                        method: "GET",
                        success: function(response) {
                            let archiveList = '';
                            $.each(response.data, function(index, archive) {
                                archiveList += `
                            <a href="#" class="btn btn-light m-1" data-month="${archive.month}" data-year="${archive.year}">
                                ${archive.month_name} ${archive.year}
                            </a>
                        `;
                            });
                            $('#archive-list').html(archiveList);
                        }
                    });
                }

                // Memuat data artikel pertama kali
                loadContent(currentPage);

                // Memuat kategori dan arsip
                loadCategories();
                loadArchives();

                // Event untuk pencarian
                $('#search-button').on('click', function() {
                    searchQuery = $('#search-input').val();
                    currentPage = 1;
                    categoryId = null;
                    month = null;
                    year = null;
                    loadContent(currentPage);

                    // Sembunyikan judul kategori jika melakukan pencarian
                    $('#category-title').hide();
                    $('#archive-title').hide();
                });

                // Event untuk filter kategori
                $('#category-list').on('click', 'a', function(e) {
                    e.preventDefault();
                    categoryId = $(this).data('category-id');
                    const categoryName = $(this).data('category-name');
                    currentPage = 1;
                    month = null;
                    year = null;
                    loadContent(currentPage);

                    // Sorot kategori yang dipilih
                    $('#category-list a').removeClass('active');
                    $(this).addClass('active');

                    // Tampilkan judul kategori yang dipilih
                    $('#selected-category-title').text(`Category: ${categoryName}`);
                    $('#category-title').show();

                    // Sembunyikan judul arsip
                    $('#archive-title').hide();
                });

                // Event untuk filter arsip
                $('#archive-list').on('click', 'a', function(e) {
                    e.preventDefault();
                    month = $(this).data('month');
                    year = $(this).data('year');
                    currentPage = 1;
                    categoryId = null;
                    loadContent(currentPage);

                    // Sorot arsip yang dipilih
                    $('#archive-list a').removeClass('active');
                    $(this).addClass('active');

                    // Tampilkan judul arsip yang dipilih
                    const monthName = $(this).text();
                    $('#selected-archive-title').text(`Archive: ${monthName}`);
                    $('#archive-title').show();

                    // Sembunyikan judul kategori jika arsip dipilih
                    $('#category-title').hide();
                });


                // Event untuk pagination
                $('#pagination').on('click', '.page-link', function(e) {
                    e.preventDefault();
                    currentPage = $(this).data('page');
                    loadContent(currentPage);
                });
            });
        </script>
    @endsection
