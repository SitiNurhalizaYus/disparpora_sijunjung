@extends('client.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-5">
                    <div class="card-header">Verifikasi Email Berhasil</div>

                    <div class="card-body">
                        <div class="alert alert-success text-center">
                            <h5>Email Anda telah berhasil diverifikasi!</h5>
                            <p>Anda sekarang dapat mengirimkan pesan Anda.</p>
                        </div>

                        <div class="text-center">
                            <a href="{{ url('/hubungi-kami') }}" class="btn btn-primary">Kirim Pesan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
