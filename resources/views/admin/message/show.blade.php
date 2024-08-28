@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid content-inner mt-n5 py-0" style="margin-top: 100px !important;">
        <div class="card-header mb-3 px-3">
            <div class="flex-wrap d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="card-title">
                        <!-- Tombol Back -->
                        <a href="{{ url('/admin/message/') }}" style="text-decoration: none; color: inherit;">
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
                <p><strong> Waktu Kirim :</strong> <span id="created_at"></span></p>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-primary text-white"><strong> Balas Pesan</strong></div>
            <div class="card-body text-dark">
                <form id="replyForm">
                    @csrf
                    <div class="form-group">
                        <label for="reply">Balasan</label>
                        <textarea name="reply" id="reply" class="form-control" rows="5" placeholder="Tulis balasan..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-success mt-3">Kirim Balasan</button>
                </form>
            </div>
        </div>

    </div>

    <script>
        $(document).ready(function() {
            // Konfigurasi AJAX Setup dengan token
            $.ajaxSetup({
                headers: {
                    'Authorization': "Bearer {{ $session_token }}"
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
                        $('#created_at').text(convertStringToDate(result.data.created_at));
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

            // Kirim balasan pesan menggunakan AJAX
            $('#replyForm').submit(function(e) {
                e.preventDefault();

                var replyData = {
                    reply: $('#reply').val()
                };

                $.ajax({
                    url: '/api/message/{{ $id }}/reply', // Pastikan URL ini sesuai dengan rute di API
                    type: 'POST',
                    data: JSON.stringify(replyData),
                    contentType: 'application/json',
                    success: function(result) {
                        if (result.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Balasan Terkirim',
                                text: result.message,
                                confirmButtonColor: '#3A57E8',
                            }).then(() => {
                                $('#reply').val(''); // Kosongkan form setelah berhasil mengirim balasan
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: result.message,
                                confirmButtonColor: '#3A57E8',
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Gagal mengirim balasan.',
                            confirmButtonColor: '#3A57E8',
                        });
                    }
                });
            });

            // Fungsi untuk menghapus data
            function removeData(id) {
                Swal.fire({
                    title: "Kamu yakin ingin menghapus?",
                    showDenyButton: true,
                    confirmButtonText: "Yes",
                    denyButtonText: "No",
                    confirmButtonColor: '#1AA053',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Request untuk menghapus data message
                        $.ajax({
                            url: '/api/message/' + id,
                            type: "DELETE",
                            success: function(result) {
                                if (result.success) {
                                    Swal.fire({
                                        icon: "success",
                                        title: "Deleted",
                                        text: result.message,
                                        confirmButtonColor: '#3A57E8',
                                    }).then(() => {
                                        window.location.replace(
                                            "{{ url('/admin/message') }}");
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
