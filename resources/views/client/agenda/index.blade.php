@extends('client.layouts.app')

@section('content')
<div class="container-fluid position-relative p-0">
    <!-- Header with logo and name -->
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
            <span class="text-green">Pengumuman</span>
        </div>
    </div>

    <!-- Blog Start -->
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    @if(!empty($agendas))
                        <div class="timeline">
                            @foreach ($agendas as $agenda)
                                <div class="timeline-item wow slideInUp" data-wow-delay="0.1s">
                                    <div class="timeline-date">
                                        <span class="day">{{ \Carbon\Carbon::parse($agenda['event_date'])->format('d') }}</span>
                                        <span class="month">{{ \Carbon\Carbon::parse($agenda['event_date'])->format('M') }}</span>
                                    </div>
                                    <div class="timeline-content bg-light rounded p-4">
                                        <span class="badge bg-danger text-white mb-2">Pengumuman</span>
                                        <h4 class="mb-3">{{ $agenda['title'] }}</h4>
                                        <p>{{ \Illuminate\Support\Str::limit($agenda['content'], 100) }}</p>
                                        
                                        @if (!empty($agenda['file_path']))
                                            <a href="#" 
                                               class="text-primary ms-2 download-file" 
                                               data-file="{{ $agenda['file_path'] }}">
                                               LIHAT
                                            </a>
                                        @else
                                            <p class="text-muted">Tidak ada file yang tersedia</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>Tidak ada pengumuman saat ini.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Blog End -->

    <style>
        .timeline {
            position: relative;
            padding: 1rem 0;
            margin-top: 1rem;
        }

        .timeline::before {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            width: 2px;
            background-color: #e9ecef;
            left: 40px;
            margin-left: -1px;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 3rem;
            display: flex;
            align-items: center;
        }

        .timeline-date {
            position: absolute;
            left: 0;
            width: 80px;
            text-align: center;
            font-size: 18px;
            line-height: 1.2;
        }

        .timeline-date .day {
            font-size: 2.5rem;
            font-weight: bold;
            color: #dc3545;
        }

        .timeline-date .month {
            font-size: 1rem;
            color: #6c757d;
            text-transform: uppercase;
        }

        .timeline-content {
            margin-left: 100px;
            padding: 1rem;
            background-color: #ffffff;
            border-radius: 0.25rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgb(58 59 69 / 15%);
        }

        .timeline-content h4 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #343a40;
        }

        .timeline-content p {
            margin-bottom: 0;
            color: #6c757d;
        }

        .timeline-content .badge {
            font-size: 0.75rem;
            padding: 0.35rem 0.65rem;
        }

        .timeline-content a {
            font-weight: bold;
            color: #dc3545;
            text-decoration: none;
        }

        .timeline-content a:hover {
            text-decoration: underline;
        }
    </style>
@endsection

@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.download-file').on('click', function(e) {
            e.preventDefault();
            var filePath = $(this).data('file');
            var url = '{{ url("/storage") }}/' + encodeURIComponent(filePath);

            // Membuat elemen <a> secara dinamis untuk memulai unduhan
            var link = document.createElement('a');
            link.href = url;
            link.download = filePath; // Menyertakan nama file di sini
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });
    });
</script>
@endsection
