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

        <!-- Breadcrumbs -->
        <div class="container-fluid bg-primary py-3 bg-light">
            <div class="text-star px-5">
                <a href="{{ url('/beranda') }}" class="text-green">Beranda</a>
                <i class="bi bi-arrow-right-short text-green px-2"></i>
                <span class="text-green">Hubungi Kami</span>
            </div>
        </div>

        <!-- Message Start -->
        <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="container py-5">
                <div class="row g-5">
                    <div class="col-lg-7">
                        <div class="d-flex align-items-start">
                            <!-- Image Before the Title and Description -->
                            <img src="{{ asset('assets/images/chat.png') }}" alt="Contact Illustration" class="img-fluid me-3" style="width: 100px; height: 100px;">
                            <!-- Title and Description -->
                            <div>
                                <h1 class="mb-4">Kirim pertanyaan, saran, atau masukan anda kepada kami</h1>
                                <p>Dinas Pariwisata Pemuda Dan Olahraga Kabupaten Sijunjung</p>
                                <a href="#" class="text-primary">Lihat Publikasi Kiriman</a>
                            </div>
                        </div>
                    </div>

                    <!-- Form Section -->
                    <div class="col-lg-5">
                        <div class="bg-primary rounded-lg h-100 d-flex align-items-center p-5 wow zoomIn" data-wow-delay="0.9s">
                            <form id="contactForm" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-xl-12">
                                        <input type="text" id="name" name="name" class="form-control bg-light border-0 rounded" placeholder="Nama Anda" required>
                                    </div>
                                    <div class="col-12">
                                        <input type="email" id="email" name="email" class="form-control bg-light border-0 rounded" placeholder="Email Anda" required>
                                    </div>
                                    <div class="col-12">
                                        <input type="text" id="subject" name="subject" class="form-control bg-light border-0 rounded" placeholder="Subjek" required>
                                    </div>
                                    <div class="col-12">
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

                        <!-- Alert for Success/Error Messages -->
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
            // Handle form submission
            $('#contactForm').on('submit', function(event) {
                event.preventDefault(); // Prevent form default submission
                let formData = new FormData(this);

                // Clear previous alerts
                $('#formAlert').removeClass('alert-success alert-danger').addClass('d-none').text('');

                // AJAX request to send the form and email verification link
                $.ajax({
                    url: "{{ url('/message/send') }}", // Send form data and trigger email verification
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Inform user that verification email has been sent
                        $('#formAlert').removeClass('d-none alert-danger').addClass('alert-success').text('Pesan berhasil dikirim. Silakan verifikasi email Anda dari link yang telah dikirimkan ke email Anda.');
                    },
                    error: function(xhr) {
                        $('#formAlert').removeClass('d-none alert-success').addClass('alert-danger').text('Gagal mengirim pesan. Silakan coba lagi.');
                    }
                });
            });
        });
    </script>

    <!-- Custom CSS for consistent form input height and appearance -->
    <style>
        .short-input {
            height: 40px !important; /* Shorter input for file upload */
        }

        .rounded-lg {
            border-radius: 20px; /* More rounded edges for the entire form container */
        }

        .form-control {
            height: 55px; /* Ensuring consistent height for all form inputs */
        }

        textarea.form-control {
            height: auto !important; /* Let the textarea adjust based on content */
        }

        small.text-white {
            display: block;
            margin-top: 5px;
        }

        #sendVerificationCode {
            display: block;
            height: 55px; /* Ensuring the button height matches input fields */
        }
    </style>
@endsection
