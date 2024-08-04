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
                <a href="href={{ url('/beranda') }}" class="text-green">Beranda</a>
                <i class="bi bi-arrow-right-short text-green px-2"></i>
                <a href="{{ url('/client/profil/struktur') }}" class="text-green">Struktur Organisasi Dinas</a>
            </div>
        </div>

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
                                placeholder="Ketik keyword apa yang anda cari..">
                            <button class="btn btn-primary px-4"><i class="bi bi-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Full Screen Search End -->

        <!-- Visi misi Start -->
        <div class="container-fluid py-3 wow fadeInUp" data-wow-delay="0.1s">
            <div class="container py-5">
                <div class="row g-5">
                    <div class="col-lg-8">
                        <!-- Detail Start -->
                        <div class="section-title position-relative pb-3 mb-5">
                            <h5 class="fw-bold text-primary text-uppercase">Profil</h5>
                            <h1 class="mb-0">{{ $konten['judul'] }}</h1>
                        </div>
                        <div class="mb-2">
                            <img class="position-relative w-100 h-100 rounded wow zoomIn" data-wow-delay="0.9s"
                            src="{{ asset('/' . str_replace('/xxx/', '/500/', $konten['gambar'])) }}" style="object-fit: cover;">
                        </div>
                        <p class="mb-4">
                            {!! $konten['description_long'] !!}
                        </p>
                        <!-- Detail End -->

                        <!-- Bagikan Postingan Start -->
                        <div class="share-buttons mb-4 mt-3 wow zoomIn" data-wow-delay="0.3s">
                            <p class="fw-bold">Share on : <br></p>
                            <div class="d-flex">
                                <button class="share-btn facebook mx-2"
                                    onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=https://example.com', '_blank')">
                                    <i class="bi bi-facebook"></i>
                                </button>
                                <button class="share-btn twitter mx-2"
                                    onclick="window.open('https://twitter.com/intent/tweet?url=https://example.com&text=Check this out!', '_blank')">
                                    <i class="bi bi-twitter"></i>
                                </button>
                                <button class="share-btn linkedin mx-2"
                                    onclick="window.open('https://www.linkedin.com/shareArticle?mini=true&url=https://example.com', '_blank')">
                                    <i class="bi bi-linkedin"></i>
                                </button>
                                <button class="share-btn whatsapp mx-2"
                                    onclick="window.open('https://wa.me/?text=Check this out! https://example.com', '_blank')">
                                    <i class="bi bi-whatsapp"></i>
                                </button>
                                <button class="share-btn email mx-2"
                                    onclick="window.location.href='mailto:?subject=Interesting Article&body=Check this out! https://example.com'">
                                    <i class="bi bi-envelope"></i>
                                </button>
                            </div>
                        </div>
                        <!-- Bagikan Postingan End -->

                        <a href="quote.html" class="btn btn-primary py-3 px-5 mt-3 wow zoomIn" data-wow-delay="0.9s">Request
                            A Quote</a>
                    </div>

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
                                <h3 class="mb-0">Recent Post</h3>
                            </div>
                            <div class="d-flex rounded overflow-hidden mb-3">
                                <img class="img-fluid" src="img/blog-1.jpg"
                                    style="width: 100px; height: 100px; object-fit: cover;" alt="">
                                <a href="" class="h5 fw-semi-bold d-flex align-items-center bg-light px-3 mb-0">Lorem
                                    ipsum dolor sit amet adipis elit</a>
                            </div>
                            <!-- Add more posts if needed -->
                        </div>
                        <!-- Recent Post End -->

                        <!-- Plain Text Start -->
                        <div class="wow slideInUp" data-wow-delay="0.1s">
                            <div class="section-title section-title-sm position-relative pb-3 mb-4">
                                <h3 class="mb-0">Plain Text</h3>
                            </div>
                            <div class="bg-light text-center" style="padding: 30px;">
                                <p>Vero sea et accusam justo dolor accusam lorem consetetur, dolores sit amet sit dolor
                                    clita kasd justo, diam accusam no sea ut tempor magna takimata, amet sit et diam dolor
                                    ipsum amet diam</p>
                                <a href="" class="btn btn-primary py-2 px-4">Read More</a>
                            </div>
                        </div>
                        <!-- Plain Text End -->
                    </div>
                    <!-- Side Bar End -->
                </div>
            </div>
        </div>
        <!-- Visi misi End -->
    @endsection
