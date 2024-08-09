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
                <a href="{{ route('informasi.index', ['kategori_id' => 2]) }}" class="text-green">Informasi</a>
                <i class="bi bi-arrow-right-short text-green px-2"></i>
                <a href="{{ route('informasi.detail', ['slug' => $konten['slug']]) }}"
                    class="text-green">{{ $konten['judul'] }}</a>
            </div>
        </div>

        <!-- Blog Detail Section -->
        <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="container py-5">
                <div class="row g-5">
                    <!-- Blog Content Start -->
                    <div class="col-lg-8">
                        <div class="mb-5">
                            <img class="img-fluid w-100 rounded mb-5"
                                src="{{ asset('/' . str_replace('/xxx/', '/500/', $konten['gambar'])) }}"
                                alt="{{ $konten['judul'] }}">
                            <h1 class="mb-4">{{ $konten['judul'] }}</h1>
                            <p>{!! $konten['description_long'] !!}</p>
                        </div>

                        <!-- Comment List Start -->
                        <div class="mb-5">
                            <div class="section-title section-title-sm position-relative pb-3 mb-4">
                                <h3 class="mb-0">{{ count($konten['comments']) }} Comments</h3>
                            </div>

                            @foreach ($konten['comments'] as $comment)
                                <div class="d-flex mb-4">
                                    <img src="{{ asset('img/user.jpg') }}" class="img-fluid rounded"
                                        style="width: 45px; height: 45px;">
                                    <div class="ps-3">
                                        <h6><a href="#">{{ $comment['user']['name'] }}</a>
                                            <small><i>{{ \Carbon\Carbon::parse($comment['created_at'])->format('d M Y') }}</i></small>
                                        </h6>
                                        <p>{{ $comment['content'] }}</p>
                                        <button class="btn btn-sm btn-light">Reply</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!-- Comment List End -->

                        <!-- Comment Form Start -->
                        <div class="bg-light rounded p-5">
                            <div class="section-title section-title-sm position-relative pb-3 mb-4">
                                <h3 class="mb-0">Leave A Comment</h3>
                            </div>
                            <form action="{{ route('comments.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="konten_id" value="{{ $konten['id'] }}">
                                <div class="row g-3">
                                    <div class="col-12 col-sm-6">
                                        <input type="text" class="form-control bg-white border-0" placeholder="Your Name"
                                            name="name" style="height: 55px;" required>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <input type="email" class="form-control bg-white border-0"
                                            placeholder="Your Email" name="email" style="height: 55px;" required>
                                    </div>
                                    <div class="col-12">
                                        <textarea class="form-control bg-white border-0" rows="5" placeholder="Comment" name="content" required></textarea>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-primary w-100 py-3" type="submit">Leave Your
                                            Comment</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- Comment Form End -->
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

                        <!-- Category Start -->
                        {{-- <div class="mb-5 wow slideInUp" data-wow-delay="0.1s">
                            <div class="section-title section-title-sm position-relative pb-3 mb-4">
                                <h3 class="mb-0">Categories</h3>
                            </div>
                            <div class="link-animated d-flex flex-column justify-content-start">
                                @foreach ($categories as $category)
                                    <a class="h5 fw-semi-bold bg-light rounded py-2 px-3 mb-2"
                                        href="{{ route('category.show', $category['slug']) }}">
                                        <i class="bi bi-arrow-right me-2"></i>{{ $category['name'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div> --}}
                        <!-- Category End -->

                        <!-- Recent Posts Start -->
                        {{-- <div class="mb-5 wow slideInUp" data-wow-delay="0.1s">
                            <div class="section-title section-title-sm position-relative pb-3 mb-4">
                                <h3 class="mb-0">Recent Posts</h3>
                            </div>
                            @foreach ($recentPosts as $recentPost)
                                <div class="d-flex rounded overflow-hidden mb-3">
                                    <img class="img-fluid" src="{{ asset('storage/' . $recentPost['gambar']) }}"
                                        style="width: 100px; height: 100px; object-fit: cover;"
                                        alt="{{ $recentPost['judul'] }}">
                                    <a href="{{ route('publikasi.detail', ['slug' => $recentPost['slug']]) }}"
                                        class="h5 fw-semi-bold d-flex align-items-center bg-light px-3 mb-0">{{ Str::limit($recentPost['judul'], 50) }}
                                    </a>
                                </div>
                            @endforeach
                        </div> --}}
                        <!-- Recent Posts End -->

                        <!-- Label Start -->
                        <div class="mb-5 wow slideInUp" data-wow-delay="0.1s">
                            <div class="section-title section-title-sm position-relative pb-3 mb-4">
                                <h3 class="mb-0">Label</h3>
                            </div>
                            <div class="d-flex flex-wrap m-n1">
                                @foreach ($labels as $label)
                                    <a href="{{ route('labels.show', $label['slug']) }}"
                                        class="btn btn-light m-1">{{ $label['name'] }}</a>
                                @endforeach
                            </div>
                        </div>
                        <!-- Label End -->
                    </div>
                    <!-- Sidebar End -->
                </div>
            </div>
        </div>

        <!-- Blog End -->
    </div>
@endsection
