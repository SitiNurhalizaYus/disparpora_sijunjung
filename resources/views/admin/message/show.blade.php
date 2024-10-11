@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid content-inner mt-n5 py-0" style="margin-top: 100px !important;">
        <div class="card-header mb-3 px-3">
            <div class="flex-wrap d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="card-title">
                        <!-- Tombol Back -->
                        <a href="{{ url('/admin/messages/') }}" style="text-decoration: none; color: inherit;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor"
                                class="bi bi-arrow-left-short" viewBox="0 0 16 16" style="text-decoration: none;">
                                <path fill="black"
                                    fill-rule="evenodd"d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5" />
                            </svg>
                            Pesan/Detail
                        </a>
                    </h3>
                </div>
            </div>
        </div>

        <div class="card mb-3" style="box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);">
            <div class="card-header bg-secondary text-white"><strong> Informasi Detail</strong></div>
            <div class="card-body text-dark">
                <p><strong> Pengirim :</strong> <span id="name"></span></p>
                <p><strong> Email :</strong> <span id="email"></span></p>
                <p><strong> Subjek :</strong> <span id="subject"></span></p>
                <p><strong> Pesan :</strong> <span id="message"></span></p>
                <p><strong> File :</strong><br><span id="file-content"></span></p>
                <p><strong> Waktu Kirim :</strong> <span id="created_at"></span></p>
            </div>
        </div>

        <!-- Bagian Balasan (Reply) -->
        <div class="card">
            <div class="card-header bg-primary text-white"><strong> Balas Pesan</strong></div>
            <div class="card-body text-dark">
                <div id="reply-section">
                    <!-- Balasan sudah ada, maka tampilkan -->
                </div>

                <!-- Jika status is_active 0, tampilkan form balasan -->
                <form id="replyForm" style="display:none;">
                    @csrf
                    <div class="form-group">
                        <label for="reply">Balasan</label>
                        <textarea name="reply" id="reply" class="form-control" rows="5" placeholder="Tulis balasan..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-success mt-3">Kirim Balasan</button>
                </form>

                <!-- Loader -->
                <div id="loading" class="text-center" style="display:none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Mengirim...</span>
                    </div>
                    <p>Mengirim balasan, mohon tunggu...</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            let token = "{{ $session_token }}";

            $.ajaxSetup({
                headers: {
                    'Authorization': "Bearer " + token,
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Panggil data pesan melalui AJAX
            $.ajax({
                url: '/api/message/{{ $id }}',
                type: "GET",
                dataType: "json",
                success: function(result) {
                    if (result.success) {
                        // Isi data ke elemen HTML
                        $('#name').text(result.data.name);
                        $('#email').text(result.data.email);
                        $('#subject').text(result.data.subject);
                        $('#message').text(result.data.message);
                        // Cek apakah ada file yang diunggah dan tampilkan sesuai format file
                        if (result.data.file_path) {
                            let filePath = "{{ url('/') }}/" + result.data.file_path.replace(
                                '/xxx/', '/300/');
                            if (filePath.match(/\.(jpeg|jpg|gif|png)$/)) {
                                $('#file-content').html(
                                    `<img src="${filePath}" alt="File Belum DiUpload" style="max-width: 100%; height: auto;">`
                                    );
                            } else {
                                $('#file-content').html(
                                    `<a href="${filePath}" target="_blank">Download File</a>`);
                            }
                        }
                        $('#created_at').text(convertStringToDate(result.data.created_at));

                        // Cek status is_active, jika 1 tampilkan balasan
                        if (result.data.is_active == 1) {
                            $('#reply-section').html(`
                                <p><strong>Balasan :</strong></p>
                                <p>${result.data.reply}</p>
                            `);
                        } else {
                            // Jika status belum aktif, tampilkan form balasan
                            $('#replyForm').show();
                        }
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: result.message,
                            confirmButtonColor: '#3A57E8',
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Gagal mengambil data pesan.",
                        confirmButtonColor: '#3A57E8',
                    });
                }
            });

            // Kirim balasan pesan menggunakan AJAX dengan loader dan konfirmasi
            $('#replyForm').submit(function(e) {
                e.preventDefault();

                var replyData = {
                    reply: $('#reply').val()
                };

                if (replyData.reply.trim() === '') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Balasan kosong',
                        text: 'Mohon masukkan balasan sebelum mengirim.',
                        confirmButtonColor: '#3A57E8',
                    });
                    return;
                }

                // Konfirmasi sebelum mengirim balasan
                Swal.fire({
                    title: 'Kirim balasan?',
                    text: "Anda tidak akan bisa mengubah setelah balasan dikirim!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, kirim!',
                    cancelButtonText: 'Tidak, batalkan',
                    confirmButtonColor: '#1AA053',
                    cancelButtonColor: '#d33'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Tampilkan loader dan sembunyikan form
                        $('#replyForm').hide();
                        $('#loading').show();

                        $.ajax({
                            url: '/api/message/{{ $id }}/reply',
                            type: 'POST',
                            data: JSON.stringify(replyData),
                            contentType: 'application/json',
                            success: function(result) {
                                $('#loading').hide(); // Sembunyikan loader

                                if (result.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Balasan Terkirim',
                                        text: result.message,
                                        confirmButtonColor: '#3A57E8',
                                    }).then(() => {
                                        $('#reply').val(
                                        ''); // Kosongkan form setelah berhasil mengirim balasan
                                        $('#replyForm')
                                    .hide(); // Sembunyikan form balasan
                                        $('#reply-section').html(`
                                            <p><strong>Balasan :</strong></p>
                                            <p>${replyData.reply}</p>
                                        `);
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: result.message,
                                        confirmButtonColor: '#3A57E8',
                                    });
                                    $('#replyForm')
                                .show(); // Tampilkan kembali form balasan jika gagal
                                }
                            },
                            error: function(xhr) {
                                $('#loading').hide(); // Sembunyikan loader

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Gagal mengirim balasan.',
                                    confirmButtonColor: '#3A57E8',
                                });
                                $('#replyForm')
                            .show(); // Tampilkan kembali form balasan jika gagal
                            }
                        });
                    }
                });
            });

            // Fungsi untuk mengonversi tanggal ke format yang lebih mudah dibaca
            function convertStringToDate(dateString) {
                const options = {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                };
                return new Date(dateString).toLocaleDateString('id-ID', options);
            }
        });
    </script>
@endsection
