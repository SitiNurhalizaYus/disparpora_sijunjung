@extends('admin.layouts.app')

@section('content')
<div class="container">
    <!-- Header -->
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">
                    <h2>Survey Kontributor 2024</h2>
                </div>

                <div class="card-body">
                    <!-- Deskripsi Survey -->
                    <p class="text-center">
                        <strong>Selamat datang</strong> dihalaman survey kontributor!<br>Mohon luangkan waktu Anda untuk mengisi survey di bawah ini. 
                        Survey Anda sangat berharga bagi kami.
                    </p>
                    <!-- Tampilkan form survey menggunakan iframe full page -->
                    <iframe 
                        src="https://docs.google.com/forms/d/e/1FAIpQLSdSi12p8SnfzRq5JxKwd2_Nx8_KhRyCCJixDpnEYzBR1ZrX6Q/viewform?pli=1" 
                        width="100%" 
                        height="1000" 
                        frameborder="0" 
                        marginheight="0" 
                        marginwidth="0"
                        style="border: 0;">
                        Loading…
                    </iframe>
                </div>
            </div>
        </div>
    </div>

    <!-- Survey Form Section -->
    <div class="row justify-content-center mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
