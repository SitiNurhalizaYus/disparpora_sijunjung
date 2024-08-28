@extends('client.layouts.app')

@section('content')
<style>
    .detail-container {
        max-width: 900px;
        margin: 50px auto;
        padding: 20px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .detail-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .detail-header img {
        max-width: 150px;
        border-radius: 10px;
    }

    .detail-header h1 {
        font-size: 28px;
        color: #333;
        margin: 0;
    }

    .detail-header .location-link {
        display: flex;
        align-items: center;
        color: #007bff;
        text-decoration: none;
        font-weight: bold;
        font-size: 16px;
    }

    .detail-header .location-link i {
        margin-right: 8px;
    }

    .detail-section {
        margin-bottom: 20px;
    }

    .detail-section h2 {
        font-size: 20px;
        color: #444;
        margin-bottom: 10px;
    }

    .detail-section p {
        font-size: 16px;
        color: #666;
        line-height: 1.6;
    }

    .detail-section ul {
        list-style-type: disc;
        margin-left: 20px;
    }

    .detail-section ul li {
        font-size: 16px;
        color: #666;
        line-height: 1.6;
    }
</style>
    <div class="container-fluid position-relative p-0">
        <!-- Header Section -->
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

        <div class="detail-container">
            <div class="detail-header">
                <h1>{{ $info_tempats['name'] }}</h1> 
                <img src="{{ asset('storage/' . $info_tempats['image']) }}" alt="{{ $info_tempats['name'] }}">
                <a href="{{ $info_tempats['link'] }}" class="location-link">
                    <i class="bi bi-geo-alt-fill"></i> Petunjuk Arah
                </a>
            </div>
        
            <div class="detail-section">
                <h2>Deskripsi</h2>
                <p>{{ $info_tempats['description'] }}</p>
            </div>
        
            <div class="detail-section">
                <h2>Fasilitas</h2>
                <ul>
                    @foreach(explode(',', $info_tempats['facilities']) as $facility)
                        <li>{{ $facility }}</li>
                    @endforeach
                </ul>
            </div>
        
            <div class="detail-section">
                <h2>Jam Operasional</h2>
                <p>{{ $info_tempats['operating_hours'] }}</p>
            </div>
        
            <div class="detail-section">
                <h2>Harga Tiket</h2>
                <p>{{ $info_tempats['ticket_price'] }}</p>
            </div>
        </div>
    </div>
@endsection
