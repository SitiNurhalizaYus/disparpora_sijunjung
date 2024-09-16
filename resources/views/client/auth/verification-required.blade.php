@extends('client.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-5">
                    <div class="card-header">Email Belum Diverifikasi</div>

                    <div class="card-body">
                        <div class="alert alert-warning text-center">
                            <h5>Email Anda belum diverifikasi!</h5>
                            <p>Silakan cek email Anda dan klik tautan verifikasi.</p>
                        </div>

                        <div class="text-center">
                            <form method="POST" action="{{ route('verification.resend') }}">
                                @csrf
                                <button type="submit" class="btn btn-primary">Kirim Ulang Email Verifikasi</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
