@extends('client.layouts.auth')

@section('content')
    <div class="wrapper">
        <div class="gradient">
            <div class="container">
                <img src="{{ asset('assets/images/error/500.png') }}" class="img-fluid mb-4 w-50" alt="">
                <h2 class="mb-0 mt-4 text-white">Oops! This Page is Not Found.</h2>
                <p class="mt-2 text-white">The requested page dose not exist.</p>
                <a class="btn bg-white text-primary d-inline-flex align-items-center" href="{{ url('/admin') }}">Back to Home</a>
            </div>
            <div class="box">
                <div class="c xl-circle">
                    <div class="c lg-circle">
                        <div class="c md-circle">
                            <div class="c sm-circle">
                                <div class="c xs-circle">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
