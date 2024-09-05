@extends('client.layouts.app')

{{-- @section('content')
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
                <span class="text-green">Agenda</span>
            </div>
        </div>

        <!-- Agenda Start -->
        <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="container py-5">
                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        @if (!empty($agendas))
                            <div class="timeline">
                                @foreach ($agendas as $agenda)
                                    <div class="timeline-item wow slideInUp" data-wow-delay="0.1s">
                                        <div class="timeline-date">
                                            <span class="day">{{ \Carbon\Carbon::parse($agenda['event_date'])->format('d') }}</span>
                                            <span class="month">{{ \Carbon\Carbon::parse($agenda['event_date'])->format('M') }}</span>
                                        </div>
                                        <div class="timeline-content bg-light rounded p-4">
                                            <span class="badge bg-danger text-white mb-2">Agenda</span>
                                            <h4 class="mb-3">{{ $agenda['title'] }}</h4>
                                            <p>{{ \Illuminate\Support\Str::limit($agenda['content'], 100) }}</p>

                                            @if (!empty($agenda['file_path']))
                                                <a href="#" class="text-primary ms-2 download-file"
                                                    data-file="{{ $agenda['file_path'] }}">
                                                    LIHAT
                                                </a>
                                            @else
                                                <p class="text-muted">Tidak ada file yang tersedia</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p>Tidak ada agenda saat ini.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Agenda End -->

    <style>
        /* Timeline wrapper */
        .timeline {
            position: relative;
            padding: 1rem 0;
            margin-top: 1rem;
        }

        /* Vertical line in the timeline */
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

        /* Each timeline item */
        .timeline-item {
            position: relative;
            margin-bottom: 3rem;
            display: flex;
            align-items: center;
        }

        /* Date block for agenda */
        .timeline-date {
            position: absolute;
            left: 0;
            width: 80px;
            text-align: center;
            font-size: 14px;
            line-height: 1.2;
            background-color: #fff;
            padding: 1rem;
            border: 1px solid #dc3545;
            border-radius: 6px; /* Membuat persegi dengan sedikit lengkung */
        }

        .timeline-date .day {
            font-size: 1.5rem;
            font-weight: bold;
            color: #dc3545;
        }

        .timeline-date .month {
            font-size: 1rem;
            color: #6c757d;
            text-transform: uppercase;
        }

        /* Content block for agenda */
        .timeline-content {
            margin-left: 120px; /* Spasi agar konten tidak menempel pada tanggal */
            padding: 1.5rem;
            background-color: #ffffff;
            border-radius: 8px; /* Lengkung untuk card */
            box-shadow: 0 0.15rem 1.75rem 0 rgb(58 59 69 / 15%);
            position: relative;
        }

        /* Title and content of the agenda */
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

        /* Vertical line connecting the items */
        .timeline-item::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 40px;
            height: 100%;
            width: 2px;
            background-color: #e9ecef;
            z-index: -1; /* Garis di belakang konten */
        }
    </style>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.download-file').on('click', function(e) {
                e.preventDefault();
                var filePath = $(this).data('file');
                var url = '{{ url('/storage') }}/' + encodeURIComponent(filePath);

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
@endsection --}}

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
                <span class="text-green">Agenda</span>
            </div>
        </div>

        <!-- Agenda Start -->
        <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="container py-5">
                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <div id="agenda-list">
                            <!-- Data agenda akan dimuat di sini melalui AJAX -->
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center" id="pagination">
                            <!-- Tombol pagination akan dimuat di sini -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Agenda End -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            const perPage = 5; // Set berapa agenda per halaman

            // Fungsi untuk memuat data agenda
            function loadAgenda(page = 1) {
                $.ajax({
                    url: "{{ url('/api/agenda') }}", // URL endpoint API agenda
                    method: "GET",
                    data: {
                        page: page,
                        per_page: perPage,
                    },
                    success: function(response) {
                        if (response.success) {
                            let agendaList = '';
                            response.data.forEach(agenda => {
                                agendaList += `
                                <div class="timeline-item wow slideInUp" data-wow-delay="0.1s">
                                    <div class="timeline-date">
                                        <span class="day">${new Date(agenda.event_date).getDate()}</span>
                                        <span class="month">${new Date(agenda.event_date).toLocaleString('id-ID', { month: 'short' }).toUpperCase()}</span>
                                    </div>
                                    <div class="timeline-content bg-light rounded p-4">
                                        <div class="d-flex justify-content-between">
                                            <!-- Content -->
                                            <div class="flex-grow-1">
                                                <span class="badge bg-danger text-white mb-2">Agenda</span>
                                                <h4 class="mb-3">${agenda.title}</h4>
                                                <p class="mb-0 text-muted">${agenda.content.substring(0, 100)}...</p>
                                            </div>

                                            <!-- "Lihat" Button -->
                                            <div class="ms-auto d-flex align-items-center">
                                                <span class="vertical-divider mx-3"></span>
                                                <a class="text-green fw-bold lihat-link" data-file="${agenda.file_path}">
                                                    Lihat
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                            });
                            $('#agenda-list').html(agendaList);

                            // Pagination
                            let pagination = '';
                            if (response.metadata.total_page > 1) {
                                pagination +=
                                    `<button class="page-link" data-page="${response.metadata.page - 1}" ${response.metadata.page === 1 ? 'disabled' : ''}>Previous</button>`;
                                for (let i = 1; i <= response.metadata.total_page; i++) {
                                    pagination +=
                                        `<button class="page-link ${i === response.metadata.page ? 'active' : ''}" data-page="${i}">${i}</button>`;
                                }
                                pagination +=
                                    `<button class="page-link" data-page="${response.metadata.page + 1}" ${response.metadata.page === response.metadata.total_page ? 'disabled' : ''}>Next</button>`;
                            }
                            $('#pagination').html(pagination);
                        } else {
                            $('#agenda-list').html('<p>Tidak ada agenda.</p>');
                        }
                    },
                    error: function() {
                        $('#agenda-list').html('<p>Gagal memuat data agenda.</p>');
                    }
                });
            }

            // Inisialisasi halaman pertama
            loadAgenda();

            // Event listener untuk pagination
            $(document).on('click', '.page-link', function() {
                const page = $(this).data('page');
                loadAgenda(page);
            });

            // Event listener untuk unduh file saat tombol "Lihat" diklik
            $(document).on('click', '.lihat-link', function(e) {
                e.preventDefault();
                const filePath = $(this).data('file');
                if (filePath) {
                    const url = '{{ url('/') }}' + '/' + (filePath);
                    window.open(url, '_blank');
                } else {
                    alert('File tidak tersedia.');
                }
            });
        });
    </script>
@endsection
