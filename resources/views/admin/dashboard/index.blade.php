@extends('admin.layouts.app')

@section('content')
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
                                        <svg class="icon-60" width="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.4" d="M18.8088 9.021C18.3573 9.021 17.7592 9.011 17.0146 9.011C15.1987 9.011 13.7055 7.508 13.7055 5.675V2.459C13.7055 2.206 13.5036 2 13.253 2H7.96363C5.49517 2 3.5 4.026 3.5 6.509V17.284C3.5 19.889 5.59022 22 8.16958 22H16.0463C18.5058 22 20.5 19.987 20.5 17.502V9.471C20.5 9.217 20.299 9.012 20.0475 9.013C19.6247 9.016 19.1177 9.021 18.8088 9.021Z" fill="currentColor"></path>
                                            <path opacity="0.4" d="M16.0842 2.56737C15.7852 2.25637 15.2632 2.47037 15.2632 2.90137V5.53837C15.2632 6.64437 16.1742 7.55437 17.2802 7.55437C17.9772 7.56237 18.9452 7.56437 19.7672 7.56237C20.1882 7.56137 20.4022 7.05837 20.1102 6.75437C19.0552 5.65737 17.1662 3.69137 16.0842 2.56737Z" fill="currentColor"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.97398 11.3877H12.359C12.77 11.3877 13.104 11.0547 13.104 10.6437C13.104 10.2327 12.77 9.89868 12.359 9.89868H8.97398C8.56298 9.89868 8.22998 10.2327 8.22998 10.6437C8.22998 11.0547 8.56298 11.3877 8.97398 11.3877ZM8.97408 16.3819H14.4181C14.8291 16.3819 15.1631 16.0489 15.1631 15.6379C15.1631 15.2269 14.8291 14.8929 14.4181 14.8929H8.97408C8.56308 14.8929 8.23008 15.2269 8.23008 15.6379C8.23008 16.0489 8.56308 16.3819 8.97408 16.3819Z" fill="currentColor"></path>
                                        </svg>
                                        <div class="progress-detail" style="margin-left: 1rem;">
                                            <p class="mb-2">Total Pages</p>
                                            <h4 class="counter" id="counter_page">0</h4>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="800">
                                <div class="card-body">
                                    <div class="progress-widget">
                                        <svg class="icon-60" width="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.4" d="M16.8843 5.11485H13.9413C13.2081 5.11969 12.512 4.79355 12.0474 4.22751L11.0782 2.88762C10.6214 2.31661 9.9253 1.98894 9.19321 2.00028H7.11261C3.37819 2.00028 2.00001 4.19201 2.00001 7.91884V11.9474C1.99536 12.3904 21.9956 12.3898 21.9969 11.9474V10.7761C22.0147 7.04924 20.6721 5.11485 16.8843 5.11485Z" fill="currentColor"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M20.8321 6.54353C21.1521 6.91761 21.3993 7.34793 21.5612 7.81243C21.8798 8.76711 22.0273 9.77037 21.9969 10.7761V16.0292C21.9956 16.4717 21.963 16.9135 21.8991 17.3513C21.7775 18.1241 21.5057 18.8656 21.0989 19.5342C20.9119 19.8571 20.6849 20.1553 20.4231 20.4215C19.2383 21.5089 17.665 22.0749 16.0574 21.9921H7.93061C6.32049 22.0743 4.74462 21.5086 3.55601 20.4215C3.2974 20.1547 3.07337 19.8566 2.88915 19.5342C2.48475 18.8661 2.21869 18.1238 2.1067 17.3513C2.03549 16.9142 1.99981 16.4721 2 16.0292V10.7761C1.99983 10.3374 2.02357 9.89902 2.07113 9.46288C2.08113 9.38636 2.09614 9.31109 2.11098 9.23659C2.13573 9.11241 2.16005 8.99038 2.16005 8.86836C2.25031 8.34204 2.41496 7.83116 2.64908 7.35101C3.34261 5.86916 4.76525 5.11492 7.09481 5.11492H16.8754C18.1802 5.01401 19.4753 5.4068 20.5032 6.21522C20.6215 6.3156 20.7316 6.4254 20.8321 6.54353ZM6.97033 15.5412H17.0355H17.0533C17.2741 15.5507 17.4896 15.4717 17.6517 15.3217C17.8137 15.1716 17.9088 14.963 17.9157 14.7425C17.9282 14.5487 17.8644 14.3577 17.7379 14.2101C17.5924 14.0118 17.3618 13.8935 17.1155 13.8907H6.97033C6.51365 13.8907 6.14343 14.2602 6.14343 14.7159C6.14343 15.1717 6.51365 15.5412 6.97033 15.5412Z" fill="currentColor"></path>
                                        </svg>
                                        <div class="progress-detail" style="margin-left: 1rem;">
                                            <p class="mb-2">Total Blog</p>
                                            <h4 class="counter" id="counter_blog">0</h4>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="900">
                                <div class="card-body">
                                    <div class="progress-widget">
                                        <svg class="icon-60" width="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.4" d="M22 15.94C22 18.73 19.76 20.99 16.97 21H16.96H7.05C4.27 21 2 18.75 2 15.96V15.95C2 15.95 2.006 11.524 2.014 9.298C2.015 8.88 2.495 8.646 2.822 8.906C5.198 10.791 9.447 14.228 9.5 14.273C10.21 14.842 11.11 15.163 12.03 15.163C12.95 15.163 13.85 14.842 14.56 14.262C14.613 14.227 18.767 10.893 21.179 8.977C21.507 8.716 21.989 8.95 21.99 9.367C22 11.576 22 15.94 22 15.94Z" fill="currentColor"></path>
                                            <path d="M21.4759 5.67351C20.6099 4.04151 18.9059 2.99951 17.0299 2.99951H7.04988C5.17388 2.99951 3.46988 4.04151 2.60388 5.67351C2.40988 6.03851 2.50188 6.49351 2.82488 6.75151L10.2499 12.6905C10.7699 13.1105 11.3999 13.3195 12.0299 13.3195C12.0339 13.3195 12.0369 13.3195 12.0399 13.3195C12.0429 13.3195 12.0469 13.3195 12.0499 13.3195C12.6799 13.3195 13.3099 13.1105 13.8299 12.6905L21.2549 6.75151C21.5779 6.49351 21.6699 6.03851 21.4759 5.67351Z" fill="currentColor"></path>
                                        </svg>
                                        <div class="progress-detail" style="margin-left: 1rem;">
                                            <p class="mb-2">Total Message</p>
                                            <h4 class="counter" id="counter_message">0</h4>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="1000">
                                <div class="card-body">
                                    <div class="progress-widget">
                                        <svg class="icon-60" width="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.4" d="M16.6203 22H7.3797C4.68923 22 2.5 19.8311 2.5 17.1646V11.8354C2.5 9.16894 4.68923 7 7.3797 7H16.6203C19.3108 7 21.5 9.16894 21.5 11.8354V17.1646C21.5 19.8311 19.3108 22 16.6203 22Z" fill="currentColor"></path>
                                            <path d="M15.7551 10C15.344 10 15.0103 9.67634 15.0103 9.27754V6.35689C15.0103 4.75111 13.6635 3.44491 12.0089 3.44491C11.2472 3.44491 10.4477 3.7416 9.87861 4.28778C9.30854 4.83588 8.99272 5.56508 8.98974 6.34341V9.27754C8.98974 9.67634 8.65604 10 8.24487 10C7.8337 10 7.5 9.67634 7.5 9.27754V6.35689C7.50497 5.17303 7.97771 4.08067 8.82984 3.26285C9.68098 2.44311 10.7814 2.03179 12.0119 2C14.4849 2 16.5 3.95449 16.5 6.35689V9.27754C16.5 9.67634 16.1663 10 15.7551 10Z" fill="currentColor"></path>
                                        </svg>
                                        <div class="progress-detail" style="margin-left: 1rem;">
                                            <p class="mb-2">Total Partner</p>
                                            <h4 class="counter" id="counter_partner">0</h4>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="1100">
                                <div class="card-body">
                                    <div class="progress-widget">
                                        <svg class="icon-60" width="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M11.9488 14.54C8.49884 14.54 5.58789 15.1038 5.58789 17.2795C5.58789 19.4562 8.51765 20.0001 11.9488 20.0001C15.3988 20.0001 18.3098 19.4364 18.3098 17.2606C18.3098 15.084 15.38 14.54 11.9488 14.54Z" fill="currentColor"></path>
                                            <path opacity="0.4" d="M11.949 12.467C14.2851 12.467 16.1583 10.5831 16.1583 8.23351C16.1583 5.88306 14.2851 4 11.949 4C9.61293 4 7.73975 5.88306 7.73975 8.23351C7.73975 10.5831 9.61293 12.467 11.949 12.467Z" fill="currentColor"></path>
                                            <path opacity="0.4" d="M21.0881 9.21923C21.6925 6.84176 19.9205 4.70654 17.664 4.70654C17.4187 4.70654 17.1841 4.73356 16.9549 4.77949C16.9244 4.78669 16.8904 4.802 16.8725 4.82902C16.8519 4.86324 16.8671 4.90917 16.8895 4.93889C17.5673 5.89528 17.9568 7.0597 17.9568 8.30967C17.9568 9.50741 17.5996 10.6241 16.9728 11.5508C16.9083 11.6462 16.9656 11.775 17.0793 11.7948C17.2369 11.8227 17.3981 11.8371 17.5629 11.8416C19.2059 11.8849 20.6807 10.8213 21.0881 9.21923Z" fill="currentColor"></path>
                                            <path d="M22.8094 14.817C22.5086 14.1722 21.7824 13.73 20.6783 13.513C20.1572 13.3851 18.747 13.205 17.4352 13.2293C17.4155 13.232 17.4048 13.2455 17.403 13.2545C17.4003 13.2671 17.4057 13.2887 17.4316 13.3022C18.0378 13.6039 20.3811 14.916 20.0865 17.6834C20.074 17.8032 20.1698 17.9068 20.2888 17.8888C20.8655 17.8059 22.3492 17.4853 22.8094 16.4866C23.0637 15.9589 23.0637 15.3456 22.8094 14.817Z" fill="currentColor"></path>
                                            <path opacity="0.4" d="M7.04459 4.77973C6.81626 4.7329 6.58077 4.70679 6.33543 4.70679C4.07901 4.70679 2.30701 6.84201 2.9123 9.21947C3.31882 10.8216 4.79355 11.8851 6.43661 11.8419C6.60136 11.8374 6.76343 11.8221 6.92013 11.7951C7.03384 11.7753 7.09115 11.6465 7.02668 11.551C6.3999 10.6234 6.04263 9.50765 6.04263 8.30991C6.04263 7.05904 6.43303 5.89462 7.11085 4.93913C7.13234 4.90941 7.14845 4.86348 7.12696 4.82926C7.10906 4.80135 7.07593 4.78694 7.04459 4.77973Z" fill="currentColor"></path>
                                            <path d="M3.32156 13.5127C2.21752 13.7297 1.49225 14.1719 1.19139 14.8167C0.936203 15.3453 0.936203 15.9586 1.19139 16.4872C1.65163 17.4851 3.13531 17.8066 3.71195 17.8885C3.83104 17.9065 3.92595 17.8038 3.91342 17.6832C3.61883 14.9167 5.9621 13.6046 6.56918 13.3029C6.59425 13.2885 6.59962 13.2677 6.59694 13.2542C6.59515 13.2452 6.5853 13.2317 6.5656 13.2299C5.25294 13.2047 3.84358 13.3848 3.32156 13.5127Z" fill="currentColor"></path>
                                        </svg>
                                        <div class="progress-detail" style="margin-left: 1rem;">
                                            <p class="mb-2">Total Team</p>
                                            <h4 class="counter" id="counter_team">0</h4>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="1200">
                                <div class="card-body">
                                    <div class="progress-widget">
                                        <svg class="icon-60" width="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.4" d="M12.9763 3.11361L15.2028 7.58789C15.3668 7.91205 15.6799 8.13717 16.041 8.18719L21.042 8.91556C21.3341 8.95658 21.5992 9.11066 21.7782 9.34578C21.9552 9.5779 22.0312 9.87205 21.9882 10.1612C21.9532 10.4013 21.8402 10.6234 21.6672 10.7935L18.0434 14.3063C17.7783 14.5514 17.6583 14.9146 17.7223 15.2698L18.6145 20.2083C18.7095 20.8046 18.3144 21.3669 17.7223 21.48C17.4783 21.519 17.2282 21.478 17.0082 21.3659L12.5472 19.0417C12.2161 18.8746 11.8251 18.8746 11.494 19.0417L7.03303 21.3659C6.48491 21.657 5.80576 21.4589 5.5007 20.9187C5.38767 20.7036 5.34766 20.4584 5.38467 20.2193L6.27686 15.2798C6.34088 14.9256 6.21985 14.5604 5.95579 14.3153L2.33202 10.8045C1.90092 10.3883 1.88792 9.70296 2.30301 9.27175C2.31201 9.26274 2.32201 9.25274 2.33202 9.24273C2.50405 9.06764 2.7301 8.95658 2.97415 8.92757L7.97523 8.1982C8.33531 8.14717 8.64837 7.92406 8.81341 7.59789L10.9599 3.11361C11.1509 2.72942 11.547 2.4903 11.9771 2.5003H12.1111C12.4842 2.54533 12.8093 2.77644 12.9763 3.11361Z" fill="currentColor"></path>
                                            <path d="M11.992 18.9171C11.7983 18.9231 11.6096 18.9752 11.4399 19.0682L7.00072 21.3871C6.45756 21.6464 5.80756 21.4452 5.50303 20.9258C5.39021 20.7136 5.34927 20.4704 5.38721 20.2322L6.27384 15.3032C6.33375 14.9449 6.21394 14.5806 5.95334 14.3284L2.32794 10.8185C1.8976 10.3971 1.88961 9.70556 2.31096 9.27421C2.31695 9.26821 2.32195 9.2632 2.32794 9.2582C2.49967 9.08806 2.72133 8.97597 2.95996 8.94094L7.96523 8.20433C8.32767 8.1583 8.64219 7.93211 8.80194 7.60384L10.9776 3.06312C11.1843 2.69682 11.5806 2.47864 12 2.50166C11.992 2.7989 11.992 18.715 11.992 18.9171Z" fill="currentColor"></path>
                                        </svg>
                                        <div class="progress-detail" style="margin-left: 1rem;">
                                            <p class="mb-2">Total FAQ</p>
                                            <h4 class="counter" id="counter_faq">0</h4>
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
        <div class="row">
            <div class="col-md-12 col-lg-6">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card" data-aos="fade-up" data-aos-delay="800">
                            <div class="flex-wrap card-header d-flex justify-content-between align-items-center">
                                <div class="header-title">
                                    <h4 class="card-title">Top Country</h4>
                                </div>
                            </div>
                            <div class="card-body" style="height: 400px">
                                <canvas id="chart-top-country"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-6">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card" data-aos="fade-up" data-aos-delay="800">
                            <div class="flex-wrap card-header d-flex justify-content-between align-items-center">
                                <div class="header-title">
                                    <h4 class="card-title">Top City</h4>
                                </div>
                            </div>
                            <div class="card-body" style="height: 400px">
                                <canvas id="chart-top-city"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $.ajaxSetup({headers:{'Authorization': "Bearer {{$session_token}}"}});

        // page
        $.ajax({
            url: '/api/page?count=true',
            type: "GET",
            dataType: "json",
            processData: false,
            success: function (result) {
                if(result['success'] == true) {
                    $('#counter_page').html(result['data']['count']);
                }
            }
        });

        // blog
        $.ajax({
            url: '/api/blog?count=true',
            type: "GET",
            dataType: "json",
            processData: false,
            success: function (result) {
                if(result['success'] == true) {
                    $('#counter_blog').html(result['data']['count']);
                }
            }
        });

        // partner
        $.ajax({
            url: '/api/partner?count=true',
            type: "GET",
            dataType: "json",
            processData: false,
            success: function (result) {
                if(result['success'] == true) {
                    $('#counter_partner').html(result['data']['count']);
                }
            }
        });

        // message
        $.ajax({
            url: '/api/message?count=true',
            type: "GET",
            dataType: "json",
            processData: false,
            success: function (result) {
                if(result['success'] == true) {
                    $('#counter_message').html(result['data']['count']);
                }
            }
        });

        // team
        $.ajax({
            url: '/api/team?count=true',
            type: "GET",
            dataType: "json",
            processData: false,
            success: function (result) {
                if(result['success'] == true) {
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
            success: function (result) {
                if(result['success'] == true) {
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
            success: function (result) {
                if(result['success'] == true) {
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
            success: function (result) {
                if(result['success'] == true) {
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
            success: function (result) {
                if(result['success'] == true) {
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
            success: function (result) {
                if(result['success'] == true) {
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
            success: function (result) {
                if(result['success'] == true) {
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

        // top country
        $.ajax({
            url: '/api/dashboard/top-country',
            type: "GET",
            dataType: "json",
            processData: false,
            success: function (result) {
                if(result['success'] == true) {
                    // prepare data
                    var label = [];
                    var data = [];
                    result['data'].forEach(element => {
                        label.push(element['country_name']);
                        data.push(Number(element['total']));
                    });

                    // chart
                    new Chart('chart-top-country', {
                        type: 'bar',
                        data: {
                            labels: label,
                            datasets: [{
                                data: data,
                                label: 'Total Count',
                                backgroundColor: 'rgb(197,255,149)'
                            }]
                        },
                        options: {
                            indexAxis: 'y',
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

        // top city
        $.ajax({
            url: '/api/dashboard/top-city',
            type: "GET",
            dataType: "json",
            processData: false,
            success: function (result) {
                if(result['success'] == true) {
                    // prepare data
                    var label = [];
                    var data = [];
                    result['data'].forEach(element => {
                        label.push(element['city_name']);
                        data.push(Number(element['total']));
                    });

                    // chart
                    new Chart('chart-top-city', {
                        type: 'bar',
                        data: {
                            labels: label,
                            datasets: [{
                                data: data,
                                label: 'Total Count',
                                backgroundColor: 'rgb(255,250,183)'
                            }]
                        },
                        options: {
                            indexAxis: 'y',
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
    </script>
@endsection
