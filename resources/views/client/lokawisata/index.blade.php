@extends('client.layouts.app')

@section('content')
<style>
.event-cards {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 20px;
    margin-top: 50px;
    padding: 20px;
}

.event-card {
    background: #fff;
    border: 1px solid #e1e1e1;
    border-radius: 5px;
    width: 100%;
    max-width: 300px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    text-align: center;
}

.event-image img {
    width: 100%;
    height: auto;
    border-bottom: 1px solid #e1e1e1;
}

.event-details {
    padding: 15px;
}

.event-title {
    font-size: 18px;
    color: #333;
    margin-bottom: 15px;
}

.event-link {
    color: #007bff;
    text-decoration: none;
    font-weight: bold;
    font-size: 14px;
}

.event-link:hover {
    text-decoration: underline;
}
</style>

<div class="container-fluid position-relative p-0">
    <div class="container-fluid bg-primary py-5 bg-header">
        <div class="row py-5">
            <div class="col-12 pt-lg-5 mt-lg-5 text-center">
                <img src="{{ asset('/' . str_replace('/xxx/', '/100/', $setting['logo-parpora'])) }}" alt="Logo"
                    class="logo">
                <div class="logo-text">
                    <h3 class="text-light">{{ $setting['name-long'] }}</h3>
                    <p>Kabupaten Sijunjung</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid bg-primary py-3 bg-light">
        <div class="text-star px-5">
            <a href="{{ url('/beranda') }}" class="text-green">Beranda</a>
            <i class="bi bi-arrow-right-short text-green px-2"></i>
            <span class="text-green">Lokawisata</span>
        </div>
    </div>

    <div class="event-cards">
        @foreach($infotempats as $infotempat)
            <div class="event-card">
                <div class="event-image">
                    <img src="{{ $infotempat['images'] }}" alt="{{ $infotempat['name'] }}">
                </div>
                <div class="event-details">
                    <h3 class="event-title">{{ $infotempat['name'] }}</h3>
                    <a href="{{ url('/lokawisata/detail/' . $infotempat['id']) }}" class="event-link">Detail</a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
