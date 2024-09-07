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
                <span class="text-green">Statistik Informasi Publik</span>
            </div>
        </div>

        {{-- statistik halaman --}}
        <div class="container-fluid py-5">
            <div class="container">
                <h2 class="text-center mb-4">Statistik Informasi Publik</h2>

                <!-- Pilihan untuk melihat statistik berdasarkan Total Kunjungan atau Kunjungan Bulanan -->
                <div class="row mb-4 left-content-center">
                    <div class="col-md-4 d-flex align-items-center">
                        <label for="statistikOption" class="form-label fw-normal me-2">Lihat Berdasarkan:</label>
                        <select id="statistikOption" class="form-select form-select-sm w-auto">
                            <option value="total">Total Kunjungan per Halaman</option>
                            <option value="monthly">Kunjungan Bulanan</option>
                        </select>
                    </div>
                </div>

                <!-- Grafik -->
                <div class="row">
                    <div class="col-md-12">
                        <h3 id="chartTitle" class="text-left">Total Kunjungan per Halaman</h3>
                        <canvas id="statistikChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Library Chart.js dan jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            const ctx = document.getElementById('statistikChart').getContext('2d');
            let chart;

            // Fungsi untuk memuat data total kunjungan
            function loadTotalKunjungan() {
                $('#chartTitle').text('Total Kunjungan per Halaman');
                $.ajax({
                    url: "{{ url('/api/statistik') }}",  // Ganti dengan URL API yang sesuai
                    method: "GET",
                    success: function(response) {
                        const data = response.data;
                        let labels = [];
                        let totals = [];

                        $.each(data, function(index, page) {
                            if (page.path !== '/') {  // Filter untuk tidak menampilkan '/'
                                labels.push(page.path);
                                totals.push(page.total);
                            }
                        });

                        // Update chart data
                        if (chart) chart.destroy();  // Hapus chart lama
                        chart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Total Kunjungan',
                                    data: totals,
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("Error: " + error);
                    }
                });
            }

            // Fungsi untuk memuat data kunjungan bulanan
            function loadKunjunganBulanan() {
                $('#chartTitle').text('Jumlah Kunjungan Bulanan');
                $.ajax({
                    url: "{{ url('/api/statistik-bulanan') }}",  // Ganti dengan URL API statistik bulanan
                    method: "GET",
                    success: function(response) {
                        const data = response.data;
                        let labels = [];
                        let totals = [];

                        $.each(data, function(index, month) {
                            labels.push(month.month);
                            totals.push(month.total);
                        });

                        // Update chart data
                        if (chart) chart.destroy();  // Hapus chart lama
                        chart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Kunjungan Bulanan',
                                    data: totals,
                                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                                    borderColor: 'rgba(153, 102, 255, 1)',
                                    borderWidth: 1,
                                    fill: true
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("Error: " + error);
                    }
                });
            }

            // Inisialisasi dengan Total Kunjungan
            loadTotalKunjungan();

            // Event listener untuk dropdown pilihan statistik
            $('#statistikOption').change(function() {
                const selectedOption = $(this).val();
                if (selectedOption === 'total') {
                    loadTotalKunjungan();
                } else if (selectedOption === 'monthly') {
                    loadKunjunganBulanan();
                }
            });
        });
    </script>
@endsection
