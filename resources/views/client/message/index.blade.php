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
                </div>
            </div>
        </div>
    </div>

    <!-- Message Start -->
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-7">
                    <div class="d-flex align-items-start">
                        <img src="{{ asset('assets/images/chat.png') }}" alt="Contact Illustration" class="img-fluid me-3" style="width: 100px; height: 100px;">
                        <div>
                            <h1 class="mb-4">Kirim pertanyaan, saran, atau masukan anda kepada kami</h1>
                            <p>Dinas Pariwisata Pemuda Dan Olahraga Kabupaten Sijunjung</p>
                        </div>
                    </div>

                    <!-- Alert if verification required -->
                    <div id="verificationAlert" class="alert alert-warning text-center w-100 mb-4 d-none">
                        <h5>Email belum diverifikasi</h5>
                        <p>Silakan cek email Anda untuk melakukan verifikasi.</p>
                        <button class="btn btn-primary" id="resendVerification">Kirim Ulang Email Verifikasi</button>
                    </div>
                </div>

                <!-- Form Section -->
                <div class="col-lg-5">
                    <div class="bg-primary rounded-lg h-100 d-flex align-items-center p-5 wow zoomIn"
                        data-wow-delay="0.9s" id="form-section">

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
                                    <input type="file" id="file" name="file" class="form-control bg-light border-0 rounded short-input">
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-dark w-100 py-3 rounded" type="submit">Kirim Pesan</button>
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
<script>
    $(document).ready(function() {
        $('#contactForm').on('submit', function(event) {
            event.preventDefault();

            // Buat FormData dari form untuk menangani pengiriman file juga
            let formData = new FormData(this);

            // Kirim data ke server untuk menyimpan user dan memverifikasi email
            $.ajax({
                url: "{{ url('/api/user/create-or-verify') }}", // Endpoint untuk membuat user dan mengirim email verifikasi
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status === 'verification_required') {
                        // Tampilkan pesan verifikasi jika diperlukan
                        $('#verificationAlert').removeClass('d-none');
                        $('#formAlert').removeClass('alert-danger').addClass('alert-info').text(response.message).removeClass('d-none');
                    } else {
                        // Jika email sudah diverifikasi, kirim pesan ke tabel message
                        $('#formAlert').removeClass('alert-danger').addClass('alert-success').text(response.message).removeClass('d-none');
                        $('#contactForm')[0].reset(); // Reset form setelah berhasil mengirim
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = '';

                        // Tampilkan pesan error
                        for (let key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                errorMessage += errors[key][0] + '\n';
                            }
                        }
                        $('#formAlert').removeClass('d-none alert-success').addClass('alert-danger').text(errorMessage);
                    } else {
                        $('#formAlert').removeClass('d-none alert-success').addClass('alert-danger').text('Gagal memproses permintaan.');
                    }
                }
            });
        });

        // Resend verification email
        $('#resendVerification').on('click', function() {
            $.post("{{ route('verification.resend') }}", {_token: '{{ csrf_token() }}'}, function(response) {
                alert(response.message);
            });
        });
    });
</script>
@endsection
