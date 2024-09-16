@extends('client.layouts.app')

@section('content')
    <div class="container-fluid position-relative p-0">
        <!-- Header with logo and name -->
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
                        <!-- Sort Order Dropdown -->
                        <div class="d-flex justify-content-end mb-3">
                            <select id="sort-order" class="form-select w-auto">
                                <option value="event_date:desc">Terbaru</option>
                                <option value="event_date:asc">Terlama</option>
                            </select>
                        </div>

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
            function loadAgenda(page = 1, sort = 'event_date:desc') {
                $.ajax({
                    url: "{{ url('/api/agenda') }}", // URL endpoint API agenda
                    method: "GET",
                    data: {
                        page: page,
                        per_page: perPage,
                        sort: sort // Tambahkan parameter sorting berdasarkan pilihan pengguna
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

            // Inisialisasi halaman pertama dengan sorting berdasarkan tanggal terbaru (desc)
            loadAgenda(1, 'event_date:desc');

            // Event listener untuk pagination
            $(document).on('click', '.page-link', function() {
                const page = $(this).data('page');
                const sort = $('#sort-order').val();
                loadAgenda(page, sort);
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

            // Event listener untuk mengubah urutan berdasarkan pilihan pengguna
            $('#sort-order').change(function() {
                const sort = $(this).val();
                loadAgenda(1, sort); // Panggil ulang loadAgenda dengan urutan baru
            });
        });
    </script>
@endsection
