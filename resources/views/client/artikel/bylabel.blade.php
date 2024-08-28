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
                <a href="{{ url('/beranda') }}" class="text-green">Beranda</a>
                <i class="bi bi-arrow-right-short text-green px-2"></i>
                <span class="text-green">Kategori {{ $label['name'] }}</span>
            </div>
        </div>

        <!-- Blog Start -->
        <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="container py-5">
                <div class="row g-5">
                    <!-- Blog list Start -->
                    <div class="col-lg-8">
                        <div class="row g-5">
                            <h1 class="mb-4">{{ $label['name'] }}</h1>
                            @forelse($kontens as $konten)
                                <div class="col-md-6 wow slideInUp" data-wow-delay="0.1s">
                                    <div class="blog-item bg-light rounded overflow-hidden">
                                        <div class="blog-img position-relative overflow-hidden">
                                            <img class="img-fluid"
                                                src="{{ asset('/' . str_replace('/xxx/', '/300/', $konten['gambar'])) }}"
                                                alt="">
                                        </div>
                                        <div class="p-4">
                                            <div class="d-flex mb-3">
                                                <small><i
                                                        class="far fa-calendar-alt text-primary me-2"></i>{{ \Carbon\Carbon::parse($konten['created_at'])->format('d M, Y') }}</small>
                                            </div>
                                            <h4 class="mb-3">{{ $konten['judul'] }}</h4>
                                            <p>{{ \Illuminate\Support\Str::limit($konten['description_short'], 100) }}</p>
                                            <a class="text-uppercase"
                                                href="{{ route('berita.detail', $konten['slug']) }}">Read More <i
                                                    class="bi bi-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p>No content available for this label.</p>
                            @endforelse
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
                        <div class="mb-5 wow slideInUp" data-wow-delay="0.1s">
                            <div class="section-title section-title-sm position-relative pb-3 mb-4">
                                <h3 class="mb-0">Categories</h3>
                            </div>
                            <div class="link-animated d-flex flex-column justify-content-start">
                                @foreach ($labels as $label)
                                    <a href="{{ route('berita.label', ['kategoriId' => $label['kategori_id'], 'labelId' => $label['id']]) }}"
                                        class="h5 fw-semi-bold bg-light rounded py-2 px-3 mb-2">
                                        <i class="bi bi-arrow-right me-2"></i>{{ $label['name'] }}</a>
                                @endforeach
                            </div>
                        </div>
                        <!-- Category End -->

                        <!-- Recent Post Start -->
                        <div class="mb-5 wow slideInUp" data-wow-delay="0.1s">
                            <div class="section-title section-title-sm position-relative pb-3 mb-4">
                                <h3 class="mb-0">Recent Post</h3>
                            </div>
                            @foreach ($recentPosts as $post)
                                <div class="d-flex rounded overflow-hidden mb-3">
                                    <img class="img-fluid" src="{{ asset('storage/' . $post['gambar']) }}"
                                        style="width: 100px; height: 100px; object-fit: cover;" alt="">
                                    <a href="{{ route('berita.detail', $post['slug']) }}"
                                        class="h5 fw-semi-bold d-flex align-items-center bg-light px-3 mb-0">{{ $post['judul'] }}</a>
                                </div>
                            @endforeach
                        </div>
                        <!-- Recent Post End -->

                        {{-- <!-- Tags Start -->
                        <div class="mb-5 wow slideInUp" data-wow-delay="0.1s">
                            <div class="section-title section-title-sm position-relative pb-3 mb-4">
                                <h3 class="mb-0">Label</h3>
                            </div>
                            <div class="d-flex flex-wrap m-n1">
                                @foreach ($labels as $label)
                                    <a href="{{ route('berita.label', $label['slug']) }}" class="btn btn-light m-1">{{ $label['name'] }}</a>
                                @endforeach
                            </div>
                        </div>
                        <!-- Tags End --> --}}

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
                    <!-- Sidebar End -->
                </div>
            </div>
        </div>
        <!-- Blog End -->
    @endsection
