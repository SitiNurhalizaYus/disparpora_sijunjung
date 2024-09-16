@extends('client.layouts.app')

@section('content')
    <div class="container-fluid position-relative p-0">
        <!-- Header dengan logo dan nama -->
        <div class="container-fluid bg-primary py-5 bg-header">
            <div class="row py-5">
                <div class="col-12 pt-lg-5 mt-lg-5 text-center">
                    <img src="{{ asset('/' . str_replace('/xxx/', '/100/', $setting['logo-parpora'])) }}" alt="Logo" class="logo">
                    <div class="logo-text">
                        <h3 class="text-light">{{ $setting['name-long'] }}</h3>
                        <p>Kabupaten Sijunjung</p>

                        <!-- Notifikasi Upload -->
                        <div id="uploadNotification" class="alert alert-info d-none">
                            File berhasil diunggah. Terima kasih, silahkan lanjutkan mengisi form dan kirim pesan.
                        </div>

                        <!-- Error Upload -->
                        <div id="uploadError" class="alert alert-danger d-none">
                            Gagal mengunggah gambar. Silakan coba lagi.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Message Start -->
        <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="container py-5">
                <div class="row g-5">
                    <!-- Bagian Kiri: Informasi dan Alert -->
                    <div class="col-lg-7">
                        <div class="d-flex align-items-start">
                            <img src="{{ asset('assets/images/chat.png') }}" alt="Contact Illustration" class="img-fluid me-3" style="width: 100px; height: 100px;">
                            <div>
                                <h1 class="mb-4">Kirim pertanyaan, saran, atau masukan anda kepada kami</h1>
                                <p>Dinas Pariwisata Pemuda Dan Olahraga Kabupaten Sijunjung</p>

                                <!-- Tampilkan pesan sukses setelah verifikasi -->
                                @if (session('status'))
                                    <div id="successAlert" class="alert alert-success text-center w-100 mb-4">
                                        <h5>{{ session('status') }}</h5>
                                    </div>
                                @endif

                                <!-- Loading saat menunggu verifikasi -->
                                <div id="loadingSpinner" class="text-center w-100 mb-4 d-none">
                                    <p>Sedang memproses pesan...</p>
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Section -->
                    <div class="col-lg-5">
                        <div class="bg-primary rounded-lg h-100 d-flex align-items-center p-5 wow zoomIn" data-wow-delay="0.9s" id="form-section">

                            <form id="contactForm" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-xl-12">
                                        <label for="name" class="text-white">Nama Anda</label>
                                        <input type="text" id="name" name="name" class="form-control bg-light border-0 rounded" placeholder="Nama Anda" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="email" class="text-white">Email Anda</label>
                                        <input type="email" id="email" name="email" class="form-control bg-light border-0 rounded" placeholder="Email Anda" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="subject" class="text-white">Subjek</label>
                                        <input type="text" id="subject" name="subject" class="form-control bg-light border-0 rounded" placeholder="Subjek" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="message" class="text-white">Pesan</label>
                                        <textarea id="message" name="message" class="form-control bg-light border-0 rounded" rows="3" placeholder="Pesan" required></textarea>
                                    </div>
                                    <div class="col-12">
                                        <label for="file" class="text-white">Unggah File (Opsional)</label>
                                        <input type="file" id="file" name="file" class="form-control bg-light border-0 rounded short-input" accept="image/jpeg,image/png,image/jpg">
                                        <input type="hidden" id="file_path" name="file_path" value="noimage.jpg" placeholder="file_path">
                                        <br>
                                        <img src="{{ asset('/uploads/noimage.jpg') }}" id="image-preview" name="image-preview" width="300px" style="border-radius: 2%;">
                                        <p class="text-danger" style="display: none; font-size: 0.75rem;" id="invalid-picture">
                                            Silakan unggah gambar.</p>
                                    </div>
                
                                    <div class="col-12">
                                        <button id="submitMessage" class="btn btn-dark w-100 py-3 rounded" type="button">Kirim Pesan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="formAlert" class="alert mt-4 d-none"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Message End -->
    </div>

    <!-- jQuery and AJAX script for form handling -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            let uploadedFilePath = ''; // Variable untuk menyimpan path file sementara

            // Handle file upload
            $('#file').on('change', function() {
                var file = $(this).prop('files')[0];
                if (!file || !file.type.match('image.*')) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "File yang diunggah bukan gambar yang valid. Silakan unggah file dalam format JPG, JPEG, atau PNG.",
                        confirmButtonColor: '#3A57E8',
                    });
                    $(this).val('');
                    $('#image-preview').attr('src', '{{ asset('/uploads/noimage.jpg') }}');
                } else {
                    $('#invalid-picture').hide();

                    var oFReader = new FileReader();
                    oFReader.readAsDataURL(file);
                    oFReader.onload = function(oFREvent) {
                        $('#image-preview').attr('src', oFREvent.target.result);
                    };

                    var formdata = new FormData();
                    formdata.append("file", file);

                    // Tampilkan loading
                    Swal.fire({
                        title: 'Mengunggah...',
                        html: 'Tunggu sebentar, gambar sedang diunggah',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $.ajax({
                        url: '/api/upload', // Endpoint untuk mengunggah gambar
                        type: "POST",
                        data: formdata,
                        processData: false,
                        contentType: false,
                        success: function(result) {
                            Swal.close(); // Tutup dialog loading
                            if (result['success'] == true) {
                                // Simpan path file sementara ke dalam variabel
                                uploadedFilePath = result['data']['url'].replace('/xxx/', '/500/');
                                Swal.fire({
                                    icon: "success",
                                    title: "Berhasil",
                                    text: "Gambar berhasil diunggah. Tekan tombol Simpan untuk menyimpan semua data.",
                                    confirmButtonColor: '#3A57E8',
                                });
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: "Oops...",
                                    text: "Gagal mengunggah gambar.",
                                    confirmButtonColor: '#3A57E8',
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.close(); // Tutup dialog loading
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Terjadi kesalahan saat mengunggah gambar.",
                                confirmButtonColor: '#3A57E8',
                            });
                            $('#file').val('');
                            $('#image-preview').attr('src', '{{ asset('/uploads/noimage.jpg') }}');
                        }
                    });
                }
            });

            // Handle form submission with confirmation
            $('#submitMessage').on('click', function() {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Pastikan Anda sudah memeriksa semua data. Tidak ada perubahan lagi?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3A57E8',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, kirim sekarang!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let formData = new FormData($('#contactForm')[0]);

                        // Sertakan path gambar yang telah diunggah
                        if (uploadedFilePath !== '') {
                            formData.set('file_path', uploadedFilePath);
                        } else {
                            formData.set('file_path', 'noimage.jpg'); // Atur gambar default jika tidak ada
                        }

                        // Tampilkan loading spinner saat memproses
                        $('#loadingSpinner').removeClass('d-none');

                        $.ajax({
                            url: "{{ route('message.store') }}", // URL untuk mengirim pesan
                            method: "POST",
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                $('#loadingSpinner').addClass('d-none');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Pesan Anda telah dikirim. Terima kasih atas masukannya.',
                                    confirmButtonColor: '#3A57E8',
                                });
                                $('#contactForm')[0].reset(); // Reset form setelah berhasil mengirim
                                $('#image-preview').attr('src', '{{ asset('/uploads/noimage.jpg') }}');
                                $('#uploadNotification').addClass('d-none'); // Sembunyikan notifikasi upload
                            },
                            error: function(xhr) {
                                $('#loadingSpinner').addClass('d-none');
                                Swal.fire({
                                    icon: "error",
                                    title: "Oops...",
                                    text: "Terjadi kesalahan, silahkan periksa dan lengkapi form.",
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
