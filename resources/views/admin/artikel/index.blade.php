@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid content-inner mt-n5 py-0" style="margin-top: 100px !important;">
        <div class="card-header mb-2 px-3">
            <div class="flex-wrap d-flex justify-content-between align-items-center">
                <div>
                    <div class="header-title">
                        <h2 class="card-title">Artikel</h2>
                        <p>List data artikel</p>
                    </div>
                </div>
                <div>
                    <a href="{{ url('/admin/artikels/create') }}" class="btn btn-md btn-primary">Tambah Data +</a>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="card mb-4 p-4 shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-3" style="color: #017454;"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                        height="16" fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16" style="color: #017454;">
                        <path
                            d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2z" />
                    </svg> Filter</h5>
                <button id="reset-filters" class="btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                        class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2z" />
                        <path
                            d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466" />
                    </svg>
                </button>
            </div>

            <div class="row g-4">
                <div class="col-md-3">
                    <!-- Filter Kategori -->
                    <label for="filter-category" class="form-label">Kategori</label>
                    <select id="filter-category" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id_category }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <!-- Filter Tahun -->
                    <label for="filter-year" class="form-label">Tahun</label>
                    <select id="filter-year" class="form-select">
                        <option value="">Pilih Tahun</option>
                        @php
                            $currentYear = date('Y');
                        @endphp
                        @for ($year = $currentYear; $year >= $currentYear - 10; $year--)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-3">
                    <!-- Filter Bulan -->
                    <label for="filter-month" class="form-label">Bulan</label>
                    <select id="filter-month" class="form-select" disabled>
                        <option value="">Pilih Bulan</option>
                        @for ($m = 1; $m <= 12; ++$m)
                            <option value="{{ $m }}">{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-3" @if ($session_data['user_level_name'] === 'Kontributor') style="display: none;" @endif>
                    <!-- Filter Penulis -->
                    <label for="filter-author" class="form-label">Penulis</label>
                    <select id="filter-author" class="form-select">
                        <option value="">Semua Penulis</option>
                        @foreach ($authors as $author)
                            <option value="{{ $author->id_user }}">{{ $author->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <br>
                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped" data-toggle="data-table">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Judul</th>
                                        <th class="text-center">Kategori</th>
                                        <th class="text-center">Gambar</th>
                                        <th class="text-center">Penulis</th>
                                        <th class="text-center">Dibuat</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Keterangan</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Inisialisasi DataTable
            var table = $('#datatable').DataTable({
                order: [
                    [0, 'asc']
                ],
                lengthMenu: [
                    [5, 15, 25, 100, -1],
                    [5, 15, 25, 100, 'Semua']
                ],
                pageLength: 5,
                processing: true,
                searching: true,
                paging: true,
                serverSide: true,
                autoWidth: true,
                scrollX: true,
                responsive: true,
                ajax: function(data, callback, settings) {
                    var sort_col_id = data.order[0].column;
                    var sort_col_order = data.order[0].dir;
                    var sort_col_name = data.columns[data.order[0].column].data;
                    var category = $('#filter-category').val(); // Ambil kategori yang dipilih
                    var month = $('#filter-month').val(); // Ambil bulan yang dipilih
                    var year = $('#filter-year').val(); // Ambil tahun yang dipilih
                    var author = $('#filter-author').val(); // Ambil penulis yang dipilih

                    $.ajaxSetup({
                        headers: {
                            'Authorization': "Bearer {{ $session_token }}"
                        }
                    });

                    $.get('{{ url('/api/content') }}', {
                                per_page: data.length,
                                page: (data.start / data.length) + 1,
                                sort: sort_col_name + ':' + sort_col_order,
                                type: 'artikel', // Tipe konten artikel
                                category_id: category, // Kirim kategori yang dipilih
                                month: month, // Kirim bulan yang dipilih
                                year: year, // Kirim tahun yang dipilih
                                author_id: author // Kirim penulis yang dipilih
                            },
                            function(json) {
                                callback({
                                    recordsTotal: json.metadata.total_data,
                                    recordsFiltered: json.metadata.total_data,
                                    data: json.data
                                });
                            })
                        .fail(function() {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Terjadi kesalahan saat memuat data.",
                                confirmButtonColor: '#3A57E8',
                            });
                        });
                },
                columns: [{
                        data: null, // Nomor urut
                        className: 'text-center',
                        orderable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart +
                                1; // Menghasilkan nomor urut
                        }
                    },
                    {
                        data: 'title',
                        render: function(data) {
                            return '<span style="white-space: normal;">' + data + '</span>';
                        }
                    },
                    // {
                    //     data: 'content',
                    //     render: function(data) {
                    //         if (data && data.length > 50) {
                    //             return '<span style="white-space: normal;">' + data.substring(0,
                    //                 50) + '...</span>';
                    //         } else if (data) {
                    //             return '<span style="white-space: normal;">' + data + '</span>';
                    //         } else {
                    //             return '<span>Tidak ada konten</span>';
                    //         }
                    //     }
                    // },
                    {
                        data: 'category.name', // Menampilkan nama kategori
                        className: 'text-center',
                        render: function(data) {
                            return data ? data : '<span>Tidak ada kategori</span>';
                        }
                    },
                    {
                        data: 'image',
                        className: 'text-center',
                        render: function(data, type, row, meta) {
                            if (data && data !== null) { // Pastikan data tidak null
                                var imagePath = "{{ asset('/') }}" + data.replace('/xxx/',
                                    '/500/');
                                return '<img src="' + imagePath +
                                    '" style="max-width:100px; max-height:100px;">';
                            } else {
                                return '<span>No Image</span>'; // Tampilkan pesan jika tidak ada gambar
                            }
                        }
                    },
                    {
                        data: 'created_by',
                        className: 'text-center',
                        render: function(data) {
                            return data ? data : '<span>Unknown</span>';
                        }
                    },
                    {
                        data: 'created_at',
                        className: 'text-center',
                        render: function(data) {
                            return '<span style="white-space: normal;">' + convertStringToDate(
                                data) + '</span>';
                        }
                    },
                    {
                        data: 'is_active',
                        className: 'text-center',
                        render: function(data) {
                            return data == '1' ? '<span class="badge bg-success">Aktif</span>' :
                                '<span class="badge bg-danger">Tidak Aktif</span>';
                        }
                    },
                    {
                        data: 'note',
                        className: 'text-center',
                        render: function(data) {
                            if (data === 'Draft') {
                                return '<span class="badge bg-gray">Draft</span>';
                            } else if (data === 'Menunggu Persetujuan') {
                                return '<span class="badge bg-info">Menunggu Persetujuan</span>';
                            } else if (data === 'Ditolak') {
                                return '<span class="badge bg-danger">Ditolak</span>'; 
                            } else if (data === 'Lakukan Perbaikan') {
                                return '<span class="badge bg-warning">Lakukan Perbaikan</span>';
                            } else if (data === 'Diposting/Disetujui') {
                                return '<span class="badge bg-success">Diposting/Disetujui</span>';
                            } else if (data === 'Diposting/Disetujui Dengan Perubahan') {
                                return '<span class="badge bg-success">Diposting/Disetujui<br>Dengan Perubahan</span>';
                            } else {
                                return '<span class="badge bg-light">Belum ada keterangan</span>';
                            }
                        }
                    },
                    {
                        render: function(data, type, row, meta) {
                            var btn_detail = `
                        <a href="{{ url('/admin/artikels/`+row.id_content+`') }}" class="btn btn-sm btn-icon btn-info flex-end" data-bs-toggle="tooltip" aria-label="Detail" data-bs-original-title="Detail">
                            <span class="btn-inner">
                                <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="11.7669" cy="11.7666" r="8.98856" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></circle>
                                    <path d="M18.0186 18.4851L21.5426 22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </span>
                        </a>`;

                            // Cek apakah pengguna adalah kontributor dan status is_active = 1
                            if ({{ $session_data['user_level_id'] }} == 3 && row.is_active == 1) {
                                // Jika kontributor dan konten sudah aktif, disable edit dan delete
                                var btn_edit = `
                        <a href="javascript:void(0);" class="btn btn-sm btn-icon btn-warning flex-end disabled" data-bs-toggle="tooltip" aria-label="Edit" data-bs-original-title="Edit">
                            <span class="btn-inner">
                                <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.4925 2.78906H7.75349C4.67849 2.78906 2.75049 4.96606 2.75049 8.04806V16.3621C2.75049 19.4441 4.66949 21.6211 7.75349 21.6211H16.5775C19.6625 21.6211 21.5815 19.4441 21.5815 16.3621V12.3341" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.82812 10.921L16.3011 3.44799C17.2321 2.51799 18.7411 2.51799 19.6721 3.44799L20.8891 4.66499C21.8201 5.59599 21.8201 7.10599 20.8891 8.03599L13.3801 15.545C12.9731 15.952 12.4211 16.181 11.8451 16.181H8.09912L8.19312 12.401C8.20712 11.845 8.43412 11.315 8.82812 10.921Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M15.1655 4.60254L19.7315 9.16854" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </span>
                        </a>`;

                                var btn_delete = `
                        <button class="btn btn-sm btn-icon btn-danger flex-end disabled" data-bs-toggle="tooltip" aria-label="Delete" data-bs-original-title="Delete">
                            <span class="btn-inner">
                                <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
                                    <path d="M19.3248 9.46826C19.3248 9.46826 18.7818 16.2033 18.4668 19.0403C18.3168 20.3953 17.4798 21.1893 16.1088 21.2143C13.4998 21.2613 10.8878 21.2643 8.27979 21.2093C6.96079 21.1823 6.13779 20.3783 5.99079 19.0473C5.67379 16.1853 5.13379 9.46826 5.13379 9.46826" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M20.708 6.23975H3.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M17.4406 6.23973C16.6556 6.23973 15.9796 5.68473 15.8256 4.91573L15.5826 3.69973C15.4326 3.13873 14.9246 2.75073 14.3456 2.75073H10.1126C9.53358 2.75073 9.02558 3.13873 8.87558 3.69973L8.63258 4.91573C8.47858 5.68473 7.80258 6.23973 7.01758 6.23973" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </span>
                        </button>`;
                            } else {
                                var btn_edit = `
                        <a href="{{ url('/admin/artikels/`+row.id_content+`/edit') }}" class="btn btn-sm btn-icon btn-warning flex-end" data-bs-toggle="tooltip" aria-label="Edit" data-bs-original-title="Edit">
                            <span class="btn-inner">
                                <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.4925 2.78906H7.75349C4.67849 2.78906 2.75049 4.96606 2.75049 8.04806V16.3621C2.75049 19.4441 4.66949 21.6211 7.75349 21.6211H16.5775C19.6625 21.6211 21.5815 19.4441 21.5815 16.3621V12.3341" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.82812 10.921L16.3011 3.44799C17.2321 2.51799 18.7411 2.51799 19.6721 3.44799L20.8891 4.66499C21.8201 5.59599 21.8201 7.10599 20.8891 8.03599L13.3801 15.545C12.9731 15.952 12.4211 16.181 11.8451 16.181H8.09912L8.19312 12.401C8.20712 11.845 8.43412 11.315 8.82812 10.921Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M15.1655 4.60254L19.7315 9.16854" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            </span>
                        </a>`;

                                var btn_delete = `
                        <button onclick="removeData(` + row.id_content + `)" class="btn btn-sm btn-icon btn-danger flex-end" data-bs-toggle="tooltip" aria-label="Delete" data-bs-original-title="Delete">
                            <span class="btn-inner">
                                <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
                                    <path d="M19.3248 9.46826C19.3248 9.46826 18.7818 16.2033 18.4668 19.0403C18.3168 20.3953 17.4798 21.1893 16.1088 21.2143C13.4998 21.2613 10.8878 21.2643 8.27979 21.2093C6.96079 21.1823 6.13779 20.3783 5.99079 19.0473C5.67379 16.1853 5.13379 9.46826 5.13379 9.46826" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M20.708 6.23975H3.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M17.4406 6.23973C16.6556 6.23973 15.9796 5.68473 15.8256 4.91573L15.5826 3.69973C15.4326 3.13873 14.9246 2.75073 14.3456 2.75073H10.1126C9.53358 2.75073 9.02558 3.13873 8.87558 3.69973L8.63258 4.91573C8.47858 5.68473 7.80258 6.23973 7.01758 6.23973" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </span>
                        </button>`;
                            }

                            return '<div style="display: flex;">' + btn_detail + '&nbsp;' +
                                btn_edit +
                                '&nbsp;' + btn_delete + '</div>';
                        }
                    }

                ],
                language: {
                    "sEmptyTable": "Tidak ada data yang tersedia pada tabel ini",
                    "sProcessing": "Sedang memproses...",
                    "sLengthMenu": "Tampilkan _MENU_ data",
                    "sZeroRecords": "Tidak ditemukan data yang sesuai",
                    "sInfo": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    "sInfoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
                    "sInfoFiltered": "(disaring dari _MAX_ total data)",
                    "sInfoPostFix": "",
                    "sSearch": "Cari:",
                    "sUrl": "",
                    "sLoadingRecords": "Sedang memuat...",
                    "oPaginate": {
                        "sFirst": "Pertama",
                        "sPrevious": "Sebelumnya",
                        "sNext": "Berikutnya",
                        "sLast": "Terakhir"
                    },
                    "oAria": {
                        "sSortAscending": ": aktifkan untuk mengurutkan kolom secara ascending",
                        "sSortDescending": ": aktifkan untuk mengurutkan kolom secara descending"
                    }
                },
                columnDefs: [{
                        targets: [0],
                        width: "5%"
                    },
                    {
                        targets: [1],
                        width: "20%"
                    },
                    {
                        targets: [2],
                        width: "25%"
                    },
                    {
                        targets: [3],
                        width: "15%"
                    },
                    {
                        targets: [4],
                        width: "10%"
                    },
                    {
                        targets: [5],
                        width: "10%"
                    },
                    {
                        targets: [6],
                        width: "10%"
                    },
                    {
                        targets: [7],
                        width: "10%"
                    },
                    {
                        targets: [8],
                        width: "10%",
                        orderable: false
                    }
                ]
            });

            // Ketika filter berubah, reload data tabel
            $('#filter-category, #filter-month, #filter-year, #filter-author').on('change', function() {
                table.ajax.reload();
            });

            // Mengaktifkan atau menonaktifkan filter bulan tergantung pada apakah tahun dipilih
            $('#filter-year').on('change', function() {
                if ($(this).val()) {
                    $('#filter-month').prop('disabled', false);
                } else {
                    $('#filter-month').val('').prop('disabled', true); // Reset bulan saat tahun direset
                }
            });

            // Tombol reset untuk menghapus filter
            $('#reset-filters').on('click', function() {
                var level_name = '{{ $session_data['user_level_name'] }}';

                // Reset semua filter, kecuali untuk kontributor (level_name = "Kontributor")
                $('#filter-year').val(''); // Reset tahun
                $('#filter-month').val('').prop('disabled', true); // Reset bulan dan nonaktifkan

                if (level_name !== 'Kontributor') {
                    $('#filter-author').val('');
                }

                $('#filter-category').val('');
                table.ajax.reload(); // Reload data tabel setelah reset
            });

            // Jika user adalah kontributor, set filter penulis otomatis dan nonaktifkan
            if ('{{ $session_data['user_level_name'] }}' === 'Kontributor') {
                var author_id = '{{ $session_data['user_id'] }}';
                $('#filter-author').val(author_id).trigger('change');
                $('#filter-author').prop('disabled', true);
            }
        });

        function removeData(id_content) {
            Swal.fire({
                title: "Kamu yakin ingin menghapus?",
                showDenyButton: true,
                confirmButtonText: "Yes",
                denyButtonText: "No",
                confirmButtonColor: '#1AA053',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            'Authorization': "Bearer {{ $session_token }}"
                        }
                    });
                    $.ajax({
                        url: '{{ url('/api/content') }}/' + id_content + '?type=artikel',
                        type: "DELETE",
                        success: function(result) {
                            if (result.success) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Success",
                                    text: result.message,
                                    confirmButtonColor: '#3A57E8',
                                }).then(() => {
                                    $('#datatable').DataTable().ajax.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: "Oops...",
                                    text: result.message,
                                    confirmButtonColor: '#3A57E8',
                                });
                            }
                        }
                    });
                }
            });
        }
    </script>
@endsection
