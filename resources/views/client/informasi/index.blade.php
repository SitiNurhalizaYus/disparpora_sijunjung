@extends('client.layouts.app')

@section('content')
    <div class="container-fluid position-relative p-0">
        <div class="container-fluid bg-primary py-5 bg-header">
            <div class="row py-5">
                <div class="col-12 pt-lg-5 mt-lg-5 text-center">
                    <div class="logo-text">
                        <h1 class="text-light">Informasi</h1>
                        <p>
                            Informasi terbaru dari DISPARPORA, termasuk berita, pengumuman, dan update penting lainnya. <br>Dapatkan informasi terkini dengan mengikuti publikasi kami secara berkala.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid bg-primary py-3 bg-light">
            <div class="text-star px-5">
                <a href="{{ url('/beranda') }}" class="text-green">Beranda</a>
                <i class="bi bi-arrow-right-short text-green px-2"></i>
                <span class="text-green">Informasi</span>
            </div>
        </div>

        <!-- Full Screen Search Start -->
        <div class="modal fade" id="searchModal" tabindex="-1">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content" style="background: rgba(10, 50, 29, 0.59);">
                    <div class="modal-header border-0">
                        <button type="button" class="btn bg-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex align-items-center justify-content-center">
                        <div class="input-group" style="max-width: 600px;">
                            <input type="text" class="form-control bg-white border-green p-3" placeholder="Ketik keyword apa yang anda cari..">
                            <button class="btn btn-primary px-4"><i class="bi bi-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Full Screen Search End -->

        <!-- Blog Start -->
        <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="container py-5">
                <div class="row g-5">
                    <!-- Blog list Start -->
                    <div class="col-lg-8">
                        <div class="row g-5">
                            @foreach($kontens as $konten)
                                <div class="col-md-6 wow slideInUp" data-wow-delay="0.1s">
                                    <div class="blog-item bg-light rounded overflow-hidden">
                                        <div class="blog-img position-relative overflow-hidden">
                                            <img class="img-fluid" src="{{ asset('/' . str_replace('/xxx/', '/500/', $konten['gambar'])) }}" alt="">
                                            {{-- <a class="position-absolute top-0 start-0 bg-primary text-white rounded-end mt-5 py-2 px-4" href="{{ route('kategori.show', $konten['kategori']['slug']) }}">{{ $konten['kategori']['name'] }}</a> --}}
                                        </div>
                                        <div class="p-4">
                                            <div class="d-flex mb-3">
                                                <small class="me-3"><i class="far fa-user text-primary me-2"></i>{{ $konten['created_by'] }}</small>
                                                <small><i class="far fa-calendar-alt text-primary me-2"></i>{{ \Carbon\Carbon::parse($konten['created_at'])->format('d M, Y') }}</small>
                                            </div>
                                            <h4 class="mb-3">{{ $konten['judul'] }}</h4>
                                            <p>{{ \Illuminate\Support\Str::limit($konten['description_short'], 100) }}</p>
                                            <a class="text-uppercase" href="{{ route('informasi.detail', $konten['slug']) }}">Read More <i class="bi bi-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- Blog list End -->

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

                        <!-- Category Start -->
                        {{-- <div class="mb-5 wow slideInUp" data-wow-delay="0.1s">
                            <div class="section-title section-title-sm position-relative pb-3 mb-4">
                                <h3 class="mb-0">Categories</h3>
                            </div>
                            <div class="link-animated d-flex flex-column justify-content-start">
                                @foreach($kategoris as $kategori)
                                    <a class="h5 fw-semi-bold bg-light rounded py-2 px-3 mb-2" href="{{ route('kategori.show', $kategori['slug']) }}"><i class="bi bi-arrow-right me-2"></i>{{ $kategori['name'] }}</a>
                                @endforeach
                            </div>
                        </div> --}}
                        <!-- Category End -->

                        <!-- Recent Post Start -->
                        {{-- <div class="mb-5 wow slideInUp" data-wow-delay="0.1s">
                            <div class="section-title section-title-sm position-relative pb-3 mb-4">
                                <h3 class="mb-0">Recent Post</h3>
                            </div>
                            @foreach($recentPosts as $post)
                                <div class="d-flex rounded overflow-hidden mb-3">
                                    <img class="img-fluid" src="{{ asset('storage/' . $post['gambar']) }}" style="width: 100px; height: 100px; object-fit: cover;" alt="">
                                    <a href="{{ route('informasi.detail', $post['slug']) }}" class="h5 fw-semi-bold d-flex align-items-center bg-light px-3 mb-0">{{ $post['judul'] }}</a>
                                </div>
                            @endforeach
                        </div> --}}
                        <!-- Recent Post End -->

                        <!-- Tags Start -->
                        <div class="mb-5 wow slideInUp" data-wow-delay="0.1s">
                            <div class="section-title section-title-sm position-relative pb-3 mb-4">
                                <h3 class="mb-0">Tag Cloud</h3>
                            </div>
                            <div class="d-flex flex-wrap m-n1">
                                @foreach($tags as $tag)
                                    <a href="{{ route('tag.show', $tag['slug']) }}" class="btn btn-light m-1">{{ $tag['nama'] }}</a>
                                @endforeach
                            </div>
                        </div>
                        <!-- Tags End -->

                        <!-- Plain Text Start -->
                        <div class="wow slideInUp" data-wow-delay="0.1s">
                            <div class="section-title section-title-sm position-relative pb-3 mb-4">
                                <h3 class="mb-0">Plain Text</h3>
                            </div>
                            <div class="bg-light text-center" style="padding: 30px;">
                                <p>Vero sea et accusam justo dolor accusam lorem consetetur, dolores sit amet sit dolor clita kasd justo, diam accusam no sea ut tempor magna takimata, amet sit et diam dolor ipsum amet diam</p>
                                <a href="" class="btn btn-primary py-2 px-4">Read More</a>
                            </div>
                        </div>
                        <!-- Plain Text End -->
                    </div>
                    <!-- Sidebar End -->
                </div>
            </div>
        </div>
        <!-- Blog End -->
@endsection
