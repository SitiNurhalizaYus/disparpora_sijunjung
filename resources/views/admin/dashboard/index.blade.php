@extends('admin.layouts.app')

@section('content')
    @if ($session_data['user_level_id'] == 1 || $session_data['user_level_id'] == 2)
        {{-- Konten halaman dashboard yang hanya bisa diakses oleh admin (user_level_id 1) atau editor (user_level_id 2) --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.0/dist/chart.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

        <div class="conatiner-fluid content-inner mt-n5 py-0" style="margin-top: 100px !important;">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="row row-cols-1">
                        <div class="overflow-hidden d-slider1 ">
                            <ul class="p-0 m-0 mb-2 swiper-wrapper list-inline">
                                <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="700">
                                    <div class="card-body">
                                        <div class="progress-widget">
                                            <svg class="icon-60" width="60" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.4"
                                                    d="M18.8088 9.021C18.3573 9.021 17.7592 9.011 17.0146 9.011C15.1987 9.011 13.7055 7.508 13.7055 5.675V2.459C13.7055 2.206 13.5036 2 13.253 2H7.96363C5.49517 2 3.5 4.026 3.5 6.509V17.284C3.5 19.889 5.59022 22 8.16958 22H16.0463C18.5058 22 20.5 19.987 20.5 17.502V9.471C20.5 9.217 20.299 9.012 20.0475 9.013C19.6247 9.016 19.1177 9.021 18.8088 9.021Z"
                                                    fill="currentColor"></path>
                                                <path opacity="0.4"
                                                    d="M16.0842 2.56737C15.7852 2.25637 15.2632 2.47037 15.2632 2.90137V5.53837C15.2632 6.64437 16.1742 7.55437 17.2802 7.55437C17.9772 7.56237 18.9452 7.56437 19.7672 7.56237C20.1882 7.56137 20.4022 7.05837 20.1102 6.75437C19.0552 5.65737 17.1662 3.69137 16.0842 2.56737Z"
                                                    fill="currentColor"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M8.97398 11.3877H12.359C12.77 11.3877 13.104 11.0547 13.104 10.6437C13.104 10.2327 12.77 9.89868 12.359 9.89868H8.97398C8.56298 9.89868 8.22998 10.2327 8.22998 10.6437C8.22998 11.0547 8.56298 11.3877 8.97398 11.3877ZM8.97408 16.3819H14.4181C14.8291 16.3819 15.1631 16.0489 15.1631 15.6379C15.1631 15.2269 14.8291 14.8929 14.4181 14.8929H8.97408C8.56308 14.8929 8.23008 15.2269 8.23008 15.6379C8.23008 16.0489 8.56308 16.3819 8.97408 16.3819Z"
                                                    fill="currentColor"></path>
                                            </svg>
                                            <div class="progress-detail" style="margin-left: 1rem;">
                                                <p class="mb-2">Total Berita</p>
                                                <h4 class="counter" id="counter_berita">0</h4>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="800">
                                    <div class="card-body">
                                        <div class="progress-widget">
                                            <svg class="icon-60" width="60" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.4"
                                                    d="M16.8843 5.11485H13.9413C13.2081 5.11969 12.512 4.79355 12.0474 4.22751L11.0782 2.88762C10.6214 2.31661 9.9253 1.98894 9.19321 2.00028H7.11261C3.37819 2.00028 2.00001 4.19201 2.00001 7.91884V11.9474C1.99536 12.3904 21.9956 12.3898 21.9969 11.9474V10.7761C22.0147 7.04924 20.6721 5.11485 16.8843 5.11485Z"
                                                    fill="currentColor"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M20.8321 6.54353C21.1521 6.91761 21.3993 7.34793 21.5612 7.81243C21.8798 8.76711 22.0273 9.77037 21.9969 10.7761V16.0292C21.9956 16.4717 21.963 16.9135 21.8991 17.3513C21.7775 18.1241 21.5057 18.8656 21.0989 19.5342C20.9119 19.8571 20.6849 20.1553 20.4231 20.4215C19.2383 21.5089 17.665 22.0749 16.0574 21.9921H7.93061C6.32049 22.0743 4.74462 21.5086 3.55601 20.4215C3.2974 20.1547 3.07337 19.8566 2.88915 19.5342C2.48475 18.8661 2.21869 18.1238 2.1067 17.3513C2.03549 16.9142 1.99981 16.4721 2 16.0292V10.7761C1.99983 10.3374 2.02357 9.89902 2.07113 9.46288C2.08113 9.38636 2.09614 9.31109 2.11098 9.23659C2.13573 9.11241 2.16005 8.99038 2.16005 8.86836C2.25031 8.34204 2.41496 7.83116 2.64908 7.35101C3.34261 5.86916 4.76525 5.11492 7.09481 5.11492H16.8754C18.1802 5.01401 19.4753 5.4068 20.5032 6.21522C20.6215 6.3156 20.7316 6.4254 20.8321 6.54353ZM6.97033 15.5412H17.0355H17.0533C17.2741 15.5507 17.4896 15.4717 17.6517 15.3217C17.8137 15.1716 17.9088 14.963 17.9157 14.7425C17.9282 14.5487 17.8644 14.3577 17.7379 14.2101C17.5924 14.0118 17.3618 13.8935 17.1155 13.8907H6.97033C6.51365 13.8907 6.14343 14.2602 6.14343 14.7159C6.14343 15.1717 6.51365 15.5412 6.97033 15.5412Z"
                                                    fill="currentColor"></path>
                                            </svg>
                                            <div class="progress-detail" style="margin-left: 1rem;">
                                                <p class="mb-2">Total Artikel</p>
                                                <h4 class="counter" id="counter_artikel">0</h4>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="900">
                                    <div class="card-body">
                                        <div class="progress-widget">
                                            <svg class="icon-60" width="60" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.4"
                                                    d="M22 15.94C22 18.73 19.76 20.99 16.97 21H16.96H7.05C4.27 21 2 18.75 2 15.96V15.95C2 15.95 2.006 11.524 2.014 9.298C2.015 8.88 2.495 8.646 2.822 8.906C5.198 10.791 9.447 14.228 9.5 14.273C10.21 14.842 11.11 15.163 12.03 15.163C12.95 15.163 13.85 14.842 14.56 14.262C14.613 14.227 18.767 10.893 21.179 8.977C21.507 8.716 21.989 8.95 21.99 9.367C22 11.576 22 15.94 22 15.94Z"
                                                    fill="currentColor"></path>
                                                <path
                                                    d="M21.4759 5.67351C20.6099 4.04151 18.9059 2.99951 17.0299 2.99951H7.04988C5.17388 2.99951 3.46988 4.04151 2.60388 5.67351C2.40988 6.03851 2.50188 6.49351 2.82488 6.75151L10.2499 12.6905C10.7699 13.1105 11.3999 13.3195 12.0299 13.3195C12.0339 13.3195 12.0369 13.3195 12.0399 13.3195C12.0429 13.3195 12.0469 13.3195 12.0499 13.3195C12.6799 13.3195 13.3099 13.1105 13.8299 12.6905L21.2549 6.75151C21.5779 6.49351 21.6699 6.03851 21.4759 5.67351Z"
                                                    fill="currentColor"></path>
                                            </svg>
                                            <div class="progress-detail" style="margin-left: 1rem;">
                                                <p class="mb-2">Total Pesan</p>
                                                <h4 class="counter" id="counter_message">0</h4>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="1000">
                                    <div class="card-body">
                                        <div class="progress-widget">
                                            <svg class="icon-60" width="60" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.4"
                                                    d="M16.6203 22H7.3797C4.68923 22 2.5 19.8311 2.5 17.1646V11.8354C2.5 9.16894 4.68923 7 7.3797 7H16.6203C19.3108 7 21.5 9.16894 21.5 11.8354V17.1646C21.5 19.8311 19.3108 22 16.6203 22Z"
                                                    fill="currentColor"></path>
                                                <path
                                                    d="M15.7551 10C15.344 10 15.0103 9.67634 15.0103 9.27754V6.35689C15.0103 4.75111 13.6635 3.44491 12.0089 3.44491C11.2472 3.44491 10.4477 3.7416 9.87861 4.28778C9.30854 4.83588 8.99272 5.56508 8.98974 6.34341V9.27754C8.98974 9.67634 8.65604 10 8.24487 10C7.8337 10 7.5 9.67634 7.5 9.27754V6.35689C7.50497 5.17303 7.97771 4.08067 8.82984 3.26285C9.68098 2.44311 10.7814 2.03179 12.0119 2C14.4849 2 16.5 3.95449 16.5 6.35689V9.27754C16.5 9.67634 16.1663 10 15.7551 10Z"
                                                    fill="currentColor"></path>
                                            </svg>
                                            <div class="progress-detail" style="margin-left: 1rem;">
                                                <p class="mb-2">Total Agenda</p>
                                                <h4 class="counter" id="counter_agenda">0</h4>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="1000">
                                    <div class="card-body">
                                        <div class="progress-widget">
                                            <svg class="icon-60" width="60" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.4"
                                                    d="M18.8088 9.021C18.3573 9.021 17.7592 9.011 17.0146 9.011C15.1987 9.011 13.7055 7.508 13.7055 5.675V2.459C13.7055 2.206 13.5036 2 13.253 2H7.96363C5.49517 2 3.5 4.026 3.5 6.509V17.284C3.5 19.889 5.59022 22 8.16958 22H16.0463C18.5058 22 20.5 19.987 20.5 17.502V9.471C20.5 9.217 20.299 9.012 20.0475 9.013C19.6247 9.016 19.1177 9.021 18.8088 9.021Z"
                                                    fill="currentColor"></path>
                                                <path opacity="0.4"
                                                    d="M16.0842 2.56737C15.7852 2.25637 15.2632 2.47037 15.2632 2.90137V5.53837C15.2632 6.64437 16.1742 7.55437 17.2802 7.55437C17.9772 7.56237 18.9452 7.56437 19.7672 7.56237C20.1882 7.56137 20.4022 7.05837 20.1102 6.75437C19.0552 5.65737 17.1662 3.69137 16.0842 2.56737Z"
                                                    fill="currentColor"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M8.97398 11.3877H12.359C12.77 11.3877 13.104 11.0547 13.104 10.6437C13.104 10.2327 12.77 9.89868 12.359 9.89868H8.97398C8.56298 9.89868 8.22998 10.2327 8.22998 10.6437C8.22998 11.0547 8.56298 11.3877 8.97398 11.3877ZM8.97408 16.3819H14.4181C14.8291 16.3819 15.1631 16.0489 15.1631 15.6379C15.1631 15.2269 14.8291 14.8929 14.4181 14.8929H8.97408C8.56308 14.8929 8.23008 15.2269 8.23008 15.6379C8.23008 16.0489 8.56308 16.3819 8.97408 16.3819Z"
                                                    fill="currentColor"></path>
                                            </svg>
                                            <div class="progress-detail" style="margin-left: 1rem;">
                                                <p class="mb-2">Total Dokumen Publik</p>
                                                <h4 class="counter" id="counter_document">0</h4>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="1000">
                                    <div class="card-body">
                                        <div class="progress-widget">
                                            <svg class="icon-60" width="60" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.4"
                                                    d="M16.8843 5.11485H13.9413C13.2081 5.11969 12.512 4.79355 12.0474 4.22751L11.0782 2.88762C10.6214 2.31661 9.9253 1.98894 9.19321 2.00028H7.11261C3.37819 2.00028 2.00001 4.19201 2.00001 7.91884V11.9474C1.99536 12.3904 21.9956 12.3898 21.9969 11.9474V10.7761C22.0147 7.04924 20.6721 5.11485 16.8843 5.11485Z"
                                                    fill="currentColor"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M20.8321 6.54353C21.1521 6.91761 21.3993 7.34793 21.5612 7.81243C21.8798 8.76711 22.0273 9.77037 21.9969 10.7761V16.0292C21.9956 16.4717 21.963 16.9135 21.8991 17.3513C21.7775 18.1241 21.5057 18.8656 21.0989 19.5342C20.9119 19.8571 20.6849 20.1553 20.4231 20.4215C19.2383 21.5089 17.665 22.0749 16.0574 21.9921H7.93061C6.32049 22.0743 4.74462 21.5086 3.55601 20.4215C3.2974 20.1547 3.07337 19.8566 2.88915 19.5342C2.48475 18.8661 2.21869 18.1238 2.1067 17.3513C2.03549 16.9142 1.99981 16.4721 2 16.0292V10.7761C1.99983 10.3374 2.02357 9.89902 2.07113 9.46288C2.08113 9.38636 2.09614 9.31109 2.11098 9.23659C2.13573 9.11241 2.16005 8.99038 2.16005 8.86836C2.25031 8.34204 2.41496 7.83116 2.64908 7.35101C3.34261 5.86916 4.76525 5.11492 7.09481 5.11492H16.8754C18.1802 5.01401 19.4753 5.4068 20.5032 6.21522C20.6215 6.3156 20.7316 6.4254 20.8321 6.54353ZM6.97033 15.5412H17.0355H17.0533C17.2741 15.5507 17.4896 15.4717 17.6517 15.3217C17.8137 15.1716 17.9088 14.963 17.9157 14.7425C17.9282 14.5487 17.8644 14.3577 17.7379 14.2101C17.5924 14.0118 17.3618 13.8935 17.1155 13.8907H6.97033C6.51365 13.8907 6.14343 14.2602 6.14343 14.7159C6.14343 15.1717 6.51365 15.5412 6.97033 15.5412Z"
                                                    fill="currentColor"></path>
                                            </svg>
                                            <div class="progress-detail" style="margin-left: 1rem;">
                                                <p class="mb-2">Total Lokawisata</p>
                                                <h4 class="counter" id="counter_lokawisata">0</h4>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                
                            </ul>
                            <div class="swiper-button swiper-button-next"></div>
                            <div class="swiper-button swiper-button-prev"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-lg-8">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card" data-aos="fade-up" data-aos-delay="800">
                                <div class="flex-wrap card-header d-flex justify-content-between align-items-center">
                                    <div class="header-title">
                                        <h4 class="card-title">Daily Access (Last 30 Days)</h4>
                                    </div>
                                </div>
                                <div class="card-body" style="height: 350px">
                                    <canvas id="chart-daily-access"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card" data-aos="fade-up" data-aos-delay="800">
                                <div class="flex-wrap card-header d-flex justify-content-between align-items-center">
                                    <div class="header-title">
                                        <h4 class="card-title">Top Device</h4>
                                    </div>
                                </div>
                                <div class="card-body" style="height: 350px">
                                    <canvas id="chart-top-device"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-lg-8">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card" data-aos="fade-up" data-aos-delay="800">
                                <div class="flex-wrap card-header d-flex justify-content-between align-items-center">
                                    <div class="header-title">
                                        <h4 class="card-title">Monthly Access (Last 12 Month)</h4>
                                    </div>
                                </div>
                                <div class="card-body" style="height: 350px">
                                    <canvas id="chart-monthly-access"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card" data-aos="fade-up" data-aos-delay="800">
                                <div class="flex-wrap card-header d-flex justify-content-between align-items-center">
                                    <div class="header-title">
                                        <h4 class="card-title">Top Operating System</h4>
                                    </div>
                                </div>
                                <div class="card-body" style="height: 350px">
                                    <canvas id="chart-top-os"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card" data-aos="fade-up" data-aos-delay="800">
                                <div class="flex-wrap card-header d-flex justify-content-between align-items-center">
                                    <div class="header-title">
                                        <h4 class="card-title">Top Page</h4>
                                    </div>
                                </div>
                                <div class="card-body" style="height: 500px">
                                    <canvas id="chart-top-page"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $.ajaxSetup({
                headers: {
                    'Authorization': "Bearer {{ $session_token }}"
                }
            });

            // berita
            $.ajax({
                url: '/api/berita?count=true',
                type: "GET",
                dataType: "json",
                processData: false,
                success: function(result) {
                    if (result['success'] == true) {
                        $('#counter_berita').html(result['metadata']['count']);
                    }
                }
            });

            // artikel
            $.ajax({
                url: '/api/artikel?count=true',
                type: "GET",
                dataType: "json",
                processData: false,
                success: function(result) {
                    if (result['success'] == true) {
                        $('#counter_artikel').html(result['metadata']['count']);
                    }
                }
            });

            //agenda
            $.ajax({
                url: '/api/agenda?count=true',
                type: "GET",
                dataType: "json",
                processData: false,
                success: function(result) {
                    if (result['success'] == true) {
                        $('#counter_agenda').html(result['metadata']['count']);
                    }
                }
            });

            // message
            $.ajax({
                url: '/api/message?count=true',
                type: "GET",
                dataType: "json",
                processData: false,
                success: function(result) {
                    if (result['success'] == true) {
                        $('#counter_message').html(result['metadata']['count']);
                    }
                }
            });

            //lokawisata
            $.ajax({
                url: '/api/lokawisata?count=true',
                type: "GET",
                dataType: "json",
                processData: false,
                success: function(result) {
                    if (result['success'] == true) {
                        $('#counter_lokawisata').html(result['metadata']['count']);
                    }
                }
            });

            //dokumen
            $.ajax({
                url: '/api/document?count=true',
                type: "GET",
                dataType: "json",
                processData: false,
                success: function(result) {
                    if (result['success'] == true) {
                        $('#counter_document').html(result['metadata']['count']);
                    }
                }
            });

            // team
            $.ajax({
                url: '/api/team?count=true',
                type: "GET",
                dataType: "json",
                processData: false,
                success: function(result) {
                    if (result['success'] == true) {
                        $('#counter_team').html(result['data']['count']);
                    }
                }
            });

            // faq
            $.ajax({
                url: '/api/faq?count=true',
                type: "GET",
                dataType: "json",
                processData: false,
                success: function(result) {
                    if (result['success'] == true) {
                        $('#counter_faq').html(result['data']['count']);
                    }
                }
            });

            // access daily
            $.ajax({
                url: '/api/dashboard/access-daily',
                type: "GET",
                dataType: "json",
                processData: false,
                success: function(result) {
                    if (result['success'] == true) {
                        // prepare data
                        var label = [];
                        var data = [];
                        result['data'].forEach(element => {
                            label.push(element['dates_indo']);
                            data.push(Number(element['count']));
                        });

                        // chart
                        new Chart('chart-daily-access', {
                            type: 'line',
                            data: {
                                labels: label,
                                datasets: [{
                                    fill: false,
                                    lineTension: 0,
                                    backgroundColor: "rgba(7,65,115,1.0)",
                                    borderColor: "rgba(7,65,115,0.1)",
                                    data: data,
                                    label: 'Total Count'
                                }]
                            },
                            options: {
                                plugins: {
                                    legend: {
                                        display: false,
                                    },
                                },
                                responsive: true,
                                maintainAspectRatio: false
                            },
                        });
                    }
                }
            });

            // access monthly
            $.ajax({
                url: '/api/dashboard/access-monthly',
                type: "GET",
                dataType: "json",
                processData: false,
                success: function(result) {
                    if (result['success'] == true) {
                        // prepare data
                        var label = [];
                        var data = [];
                        result['data'].forEach(element => {
                            label.push(element['months_indo']);
                            data.push(Number(element['count']));
                        });

                        // chart
                        new Chart('chart-monthly-access', {
                            type: 'bar',
                            data: {
                                labels: label,
                                datasets: [{
                                    fill: false,
                                    lineTension: 0,
                                    backgroundColor: "rgba(22,121,171,1.0)",
                                    borderColor: "rgba(22,121,171,0.1)",
                                    data: data,
                                    label: 'Total Count'
                                }]
                            },
                            options: {
                                plugins: {
                                    legend: {
                                        display: false,
                                    },
                                },
                                responsive: true,
                                maintainAspectRatio: false
                            },
                        });
                    }
                }
            });

            // top device
            $.ajax({
                url: '/api/dashboard/top-device',
                type: "GET",
                dataType: "json",
                processData: false,
                success: function(result) {
                    if (result['success'] == true) {
                        // prepare data
                        var label = [];
                        var data = [];
                        result['data'].forEach(element => {
                            label.push(element['device']);
                            data.push(Number(element['total']));
                        });

                        // chart
                        new Chart('chart-top-device', {
                            type: 'doughnut',
                            data: {
                                labels: label,
                                datasets: [{
                                    data: data,
                                    label: 'Total Count',
                                    backgroundColor: [
                                        'rgb(243,206,123)',
                                        'rgb(19,170,185)',
                                        'rgb(240,130,95)'
                                    ],
                                    datalabels: {
                                        anchor: 'center',
                                        backgroundColor: null,
                                        borderWidth: 0
                                    }
                                }]
                            },
                            options: {
                                plugins: {
                                    legend: {
                                        display: true,
                                        position: 'bottom'
                                    },
                                },
                                responsive: true,
                                maintainAspectRatio: false
                            },
                        });
                    }
                }
            });

            // top os
            $.ajax({
                url: '/api/dashboard/top-os',
                type: "GET",
                dataType: "json",
                processData: false,
                success: function(result) {
                    if (result['success'] == true) {
                        // prepare data
                        var label = [];
                        var data = [];
                        result['data'].forEach(element => {
                            label.push(element['os']);
                            data.push(Number(element['total']));
                        });

                        // chart
                        new Chart('chart-top-os', {
                            type: 'pie',
                            data: {
                                labels: label,
                                datasets: [{
                                    data: data,
                                    label: 'Total Count',
                                    backgroundColor: [
                                        'rgb(255,152,0)',
                                        'rgb(44,120,101)',
                                        'rgb(87,85,254)',
                                        'rgb(210,0,98)',
                                    ],
                                }]
                            },
                            options: {
                                plugins: {
                                    legend: {
                                        display: true,
                                        position: 'bottom'
                                    },
                                },
                                responsive: true,
                                maintainAspectRatio: false
                            },
                        });
                    }
                }
            });

            // top page
            $.ajax({
                url: '/api/dashboard/top-page',
                type: "GET",
                dataType: "json",
                processData: false,
                success: function(result) {
                    if (result['success'] == true) {
                        // prepare data
                        var label = [];
                        var data = [];
                        result['data'].forEach(element => {
                            label.push(element['path']);
                            data.push(Number(element['total']));
                        });

                        // chart
                        new Chart('chart-top-page', {
                            type: 'bar',
                            data: {
                                labels: label,
                                datasets: [{
                                    data: data,
                                    label: 'Total Count',
                                    backgroundColor: 'rgb(215,75,118)'
                                }]
                            },
                            options: {
                                // indexAxis: 'y',
                                plugins: {
                                    legend: {
                                        display: false,
                                        position: 'bottom'
                                    },
                                },
                                responsive: true,
                                maintainAspectRatio: false
                            },
                        });
                    }
                }
            });

            // // top country
            // $.ajax({
            //     url: '/api/dashboard/top-country',
            //     type: "GET",
            //     dataType: "json",
            //     processData: false,
            //     success: function(result) {
            //         if (result['success'] == true) {
            //             // prepare data
            //             var label = [];
            //             var data = [];
            //             result['data'].forEach(element => {
            //                 label.push(element['country_name']);
            //                 data.push(Number(element['total']));
            //             });

            //             // chart
            //             new Chart('chart-top-country', {
            //                 type: 'bar',
            //                 data: {
            //                     labels: label,
            //                     datasets: [{
            //                         data: data,
            //                         label: 'Total Count',
            //                         backgroundColor: 'rgb(197,255,149)'
            //                     }]
            //                 },
            //                 options: {
            //                     indexAxis: 'y',
            //                     plugins: {
            //                         legend: {
            //                             display: false,
            //                             position: 'bottom'
            //                         },
            //                     },
            //                     responsive: true,
            //                     maintainAspectRatio: false
            //                 },
            //             });
            //         }
            //     }
            // });

            // // top city
            // $.ajax({
            //     url: '/api/dashboard/top-city',
            //     type: "GET",
            //     dataType: "json",
            //     processData: false,
            //     success: function(result) {
            //         if (result['success'] == true) {
            //             // prepare data
            //             var label = [];
            //             var data = [];
            //             result['data'].forEach(element => {
            //                 label.push(element['city_name']);
            //                 data.push(Number(element['total']));
            //             });

            //             // chart
            //             new Chart('chart-top-city', {
            //                 type: 'bar',
            //                 data: {
            //                     labels: label,
            //                     datasets: [{
            //                         data: data,
            //                         label: 'Total Count',
            //                         backgroundColor: 'rgb(255,250,183)'
            //                     }]
            //                 },
            //                 options: {
            //                     indexAxis: 'y',
            //                     plugins: {
            //                         legend: {
            //                             display: false,
            //                             position: 'bottom'
            //                         },
            //                     },
            //                     responsive: true,
            //                     maintainAspectRatio: false
            //                 },
            //             });
            //         }
            //     }
            // });
        </script>
    @endif
    @if ($session_data['user_level_id'] == 3)
        <div class="conatiner-fluid content-inner mt-n5 py-0" style="margin-top: 100px !important;">
            <div class="container-fluid py-5">
                <div class="container">
                    <h2 class="text-center mb-4">Statistik Informasi Publik</h2>

                    <!-- Pilihan untuk melihat statistik berdasarkan Total Kunjungan atau Kunjungan Bulanan -->
                    <div class="row mb-4 left-content-center">
                        <div class="col-md-4 d-flex align-items-center">
                            <label for="statistikOption" class="form-label fw-normal me-2">Lihat Berdasarkan:</label>
                            <select id="statistikOption" class="form-select form-select-sm w-auto">
                                <option value="total">Total Kunjungan per Halaman</option>
                                <option value="monthly">Kunjungan Bulanan</option>
                            </select>
                        </div>
                    </div>

                    <!-- Grafik -->
                    <div class="row">
                        <div class="col-md-12">
                            <h3 id="chartTitle" class="text-left">Total Kunjungan per Halaman</h3>
                            <canvas id="statistikChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Library Chart.js dan jQuery -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                const ctx = document.getElementById('statistikChart').getContext('2d');
                let chart;

                // Fungsi untuk memuat data total kunjungan
                function loadTotalKunjungan() {
                    $('#chartTitle').text('Total Kunjungan per Halaman');
                    $.ajax({
                        url: "{{ url('/api/statistik') }}", // Ganti dengan URL API yang sesuai
                        method: "GET",
                        success: function(response) {
                            const data = response.data;
                            let labels = [];
                            let totals = [];

                            $.each(data, function(index, page) {
                                if (page.path !== '/') { // Filter untuk tidak menampilkan '/'
                                    labels.push(page.path);
                                    totals.push(page.total);
                                }
                            });

                            // Update chart data
                            if (chart) chart.destroy(); // Hapus chart lama
                            chart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: labels,
                                    datasets: [{
                                        label: 'Total Kunjungan',
                                        data: totals,
                                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                        borderColor: 'rgba(75, 192, 192, 1)',
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error("Error: " + error);
                        }
                    });
                }

                // Fungsi untuk memuat data kunjungan bulanan
                function loadKunjunganBulanan() {
                    $('#chartTitle').text('Jumlah Kunjungan Bulanan');
                    $.ajax({
                        url: "{{ url('/api/statistik-bulanan') }}", // Ganti dengan URL API statistik bulanan
                        method: "GET",
                        success: function(response) {
                            const data = response.data;
                            let labels = [];
                            let totals = [];

                            $.each(data, function(index, month) {
                                labels.push(month.month);
                                totals.push(month.total);
                            });

                            // Update chart data
                            if (chart) chart.destroy(); // Hapus chart lama
                            chart = new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: labels,
                                    datasets: [{
                                        label: 'Kunjungan Bulanan',
                                        data: totals,
                                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                                        borderColor: 'rgba(153, 102, 255, 1)',
                                        borderWidth: 1,
                                        fill: true
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error("Error: " + error);
                        }
                    });
                }

                // Inisialisasi dengan Total Kunjungan
                loadTotalKunjungan();

                // Event listener untuk dropdown pilihan statistik
                $('#statistikOption').change(function() {
                    const selectedOption = $(this).val();
                    if (selectedOption === 'total') {
                        loadTotalKunjungan();
                    } else if (selectedOption === 'monthly') {
                        loadKunjunganBulanan();
                    }
                });
            });
        </script>
    @endif
@endsection
