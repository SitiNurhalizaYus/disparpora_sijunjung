@extends('client.layouts.app')

@section('content')

    <div class="banner-one-app">
        <div class="container">

            <div class="overflow-hidden slider-circle-btn" id="testimonial-slider">
                <ul class="p-0 m-0 swiper-wrapper list-inline">
                    @foreach($sliders as $slider)
                        <li class="swiper-slide">
                            <div class="row">
                                <div class="col-sm-6 banner-one-img text-center ms-2 ms-sm-0">
                                    <img src="{{ asset('/' . str_replace("/xxx/", "/500/", $slider['image'])) }}" alt="" class="img-fluid ">
                                </div>
                                <div class="col-sm-6 inner-box">
                                    <h1 class="text-secondary mb-4">
                                        {{ $slider['name'] }}
                                    </h1>
                                    <p class="mb-5">
                                        {{ $slider['description'] }}
                                    </p>
                                    <div class="d-flex align-items-center store-btn">
                                        <a href="{{ $slider['link'] }}" target="_blank" class="btn btn-primary">Click Here</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="swiper-button swiper-button-next"></div>
                <div class="swiper-button swiper-button-prev"></div>
            </div>
        </div>
    </div>
    <div class="bg-secondary features-card">
        <div class="container">
            <div class="row mx-2 mx-sm-0">
                <div class="col-lg-6"></div>
                <div class="col-lg-6 top-feature">
                    <div class="text-right">
                        <p><br></p>
                        <h2 class="mb-3 text-white notch-feature-txt">Big Number</h2>
                        <p><br><br><br></p>
                    </div>
                </div>
            </div>
            <div class="row align-items-center text-center row-cols-2 row-cols-sm-2 row-cols-md-2 row-cols-lg-4">
                @foreach($big_numbers as $big_number)
                <div class="col mb-lg-0 mb-4">
                    <h2 class=" mb-2 counter" style="color: white;">{{ $big_number['number'] }}</h2>
                    <h6 style="color: white;">{{ $big_number['name'] }}</h6>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="section-card-padding bg-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-12 text-center">
                    <p class="mb-2 text-uppercase text-secondary">
                        team
                    </p>
                    <h2 class="text-secondary mb-4">Expert
                        <span class="text-primary">Teams</span>
                    </h2>
                </div>
                @foreach($teams as $team)
                <div class="col-md-3 col-sm-2">
                    <div class="card team-image">
                        <img src="{{ asset('/' . str_replace("/xxx/", "/300/", $team['image'])) }}" alt="team-details"
                            class="img-fluid rounded-top" loading="lazy">
                        <div class="card-body">
                            <h6 class="my-2">{{ $team['name'] }}</h6>
                            <p class="mb-0">{{ $team['role'] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="inner-box bg-secondary">
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-5 justify-content-center ">
                @foreach ($partners as $partner)
                <div class="col mb-md-0 mb-5 d-flex justify-content-center">
                    <img src="{{ asset('/' . str_replace("/xxx/", "/300/", $partner['image'])) }}" alt="client-details"
                        class="img-fluid client-img" loading="lazy">
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="section-padding">
        <div class="container">
            <div class="row align-items-center text-center">
                <div class="col-lg-12">
                    <p class="mb-4 text-uppercase text-secondary">Testimony</p>
                    <h2 class="text-secondary customer-txt">What our Customer’s <br>are saying
                    </h2>
                </div>
                <div class="overflow-hidden slider-circle-btn" id="testimonial-slider">
                    <ul class="p-0 m-0 swiper-wrapper list-inline">
                        @foreach ($testimonies as $testimony)
                        <li class="swiper-slide">

                            <svg width="98" height="99" class="mt-5" viewbox="0 0 98 99" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M65.1171 0.5H93.4687L97.4572 8.44811L65.2733 98.5H50.2545L65.1171 0.5ZM14.9113 0.5H42.7957L46.7842 8.44811L14.6003 98.5H-0.415726L14.9113 0.5Z"
                                    stroke="#3A57E8" />
                            </svg>
                            <p class="mt-4 test-text">{{ $testimony['testimony'] }}</p>
                            <h6 class="">{{ $testimony['name'] }}</h6>
                            <p class="mb-0 text-primary">{{ $testimony['role'] }}</p>
                        </li>
                        @endforeach
                    </ul>
                    <div class="swiper-button swiper-button-next"></div>
                    <div class="swiper-button swiper-button-prev"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
