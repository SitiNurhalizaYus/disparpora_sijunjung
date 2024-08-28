@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid content-inner mt-n5 py-0" style="margin-top: 100px !important;">
        <div class="card-header mb-2 px-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="header-title">
                    <h3 class="card-title">
                        <!-- Tombol Back -->
                        <a href="{{ url('/admin/agenda/') }}" class="text-decoration-none text-dark">
                            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor"
                                class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                                <path fill="black" fill-rule="evenodd"
                                    d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z" />
                            </svg>
                            Agenda/Detail
                        </a>
                    </h3>
                </div>
                <div>
                    <a href="#" id="edit-button" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <button id="delete-button" class="btn btn-danger btn-sm">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4 id="title"></h4>
                        <p><strong>Tanggal Acara:</strong> <span id="event_date"></span></p>
                        <p><strong>Penyelenggara:</strong> <span id="organizer"></span></p>
                        <p><strong>Konten:</strong> <div id="content"></div></p>

                        <div class="mt-4">
                            <h5>File yang diunggah:</h5>
                            <div id="file-preview"></div>
                        </div>

                        <p class="mt-4"><strong>Status:</strong> 
                            <span id="status"></span>
                        </p>

                        <p><strong>Dibuat pada:</strong> <span id="created_at"></span></p>
                        <p><strong>Diperbarui pada:</strong> <span id="updated_at"></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Ambil data agenda menggunakan AJAX
            const agendaId = {{ $id }}; // Asumsikan $id dikirim dari controller atau route parameter

            $.ajax({
                url: '/api/agenda/' + agendaId,
                type: "GET",
                dataType: "json",
                success: function(result) {
                    if (result['success']) {
                        // Isi data form dengan data yang diterima dari API
                        $('#title').text(result['data']['title']);
                        $('#event_date').text(result['data']['event_date']);
                        $('#organizer').text(result['data']['organizer']);
                        $('#content').html(result['data']['content']);

                        // Tampilkan preview file jika file_path tersedia
                        if (result['data']['file_path']) {
                            const fileType = result['data']['file_path'].split('.').pop().toLowerCase();
                            const fileUrl = `{{ asset('uploads') }}/${result['data']['file_path']}`;

                            if (['jpg', 'jpeg', 'png', 'gif'].includes(fileType)) {
                                $('#file-preview').html(`<img src="${fileUrl}" alt="Gambar Agenda" class="img-fluid">`);
                            } else if (fileType === 'pdf') {
                                $('#file-preview').html(`
                                    <a href="${fileUrl}" target="_blank" class="btn btn-primary">Lihat Dokumen PDF</a>
                                    <iframe src="${fileUrl}" width="100%" height="600px"></iframe>
                                `);
                            } else {
                                $('#file-preview').text("File tidak dikenali.");
                            }
                        } else {
                            $('#file-preview').text("Tidak ada file yang diunggah.");
                        }

                        // Status Aktif
                        if (result['data']['is_active']) {
                            $('#status').html('<span class="badge bg-success">Aktif</span>');
                        } else {
                            $('#status').html('<span class="badge bg-danger">Tidak Aktif</span>');
                        }

                        // Tanggal Buat dan Update
                        $('#created_at').text(result['data']['created_at']);
                        $('#updated_at').text(result['data']['updated_at']);

                        // Set edit button URL
                        $('#edit-button').attr('href', '/admin/agenda/' + agendaId + '/edit');
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: result['message'],
                            confirmButtonColor: '#3A57E8',
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Gagal mengambil data agenda.",
                        confirmButtonColor: '#3A57E8',
                    });
                }
            });

            // Fungsi untuk menghapus data
            $('#delete-button').click(function() {
                Swal.fire({
                    title: "Apakah Anda yakin ingin menghapus?",
                    showDenyButton: true,
                    confirmButtonText: "Ya",
                    denyButtonText: "Tidak",
                    confirmButtonColor: '#1AA053',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/api/agenda/' + agendaId,
                            type: "DELETE",
                            success: function(result) {
                                if (result['success']) {
                                    Swal.fire({
                                        icon: "success",
                                        title: "Berhasil dihapus",
                                        text: result['message'],
                                        confirmButtonColor: '#3A57E8',
                                    }).then(() => {
                                        window.location.replace("{{ url('/admin/agenda') }}");
                                    });
                                } else {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Oops...",
                                        text: result['message'],
                                        confirmButtonColor: '#3A57E8',
                                    });
                                }
                            },
                            error: function() {
                                Swal.fire({
                                    icon: "error",
                                    title: "Oops...",
                                    text: "Terjadi kesalahan saat menghapus data.",
                                    confirmButtonColor: '#3A57E8',
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
