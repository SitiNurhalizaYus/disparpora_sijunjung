@extends('client.layouts.app')

@section('content')
    <div class="sub-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h3 class="text-white mb-4">Blog</h3>
                    <h6 class="text-white">Home <svg fill="none" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24">
                            <path
                                d="M12.1415 6.5899C11.9075 6.71614 11.7616 6.95618 11.7616 7.21726V11.2827H3.73429C3.32896 11.2827 3 11.604 3 12C3 12.3959 3.32896 12.7172 3.73429 12.7172H11.7616V16.7827C11.7616 17.0447 11.9075 17.2848 12.1415 17.4101C12.3755 17.5372 12.6614 17.5286 12.8875 17.39L20.6573 12.6073C20.8708 12.4753 21 12.2467 21 12C21 11.7532 20.8708 11.5247 20.6573 11.3927L12.8875 6.60998C12.7681 6.5373 12.632 6.5 12.4959 6.5C12.3745 6.5 12.2521 6.5306 12.1415 6.5899Z"
                                fill="currentColor" />
                        </svg> Blog</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="inner-card-box">
        <div class="container">
            <div class="row"  id="data-wrapper">
            </div>
            <div class="auto-load text-center">
                <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                    x="0px" y="0px" height="60" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
                    <path fill="#000"
                        d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
                        <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s"
                            from="0 50 50" to="360 50 50" repeatCount="indefinite" />
                    </path>
                </svg>
            </div>

            <div class="d-flex align-items-center justify-content-center">
                <button class="btn btn-secondary ms-2" onclick="infinteLoadMore()">Load More</button>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        var ENDPOINT = "{{ url('/') }}";
        var ASSET_UPLOAD = "{{ asset('/') }}";
        var page = 0;

        infinteLoadMore();

        function infinteLoadMore() {
            page += 1;
            $('.auto-load').show();
            $.ajax({
                    url: ENDPOINT + "/api/blog?per_page=1&page=" + page,
                    type: "get",
                    dataType: "json",
                })
                .done(function (response) {
                    if (response.success == true) {
                        if (response.data.length > 0) {
                            response.data.forEach(element => {
                                var html =  '';
                                html += '<div class="col-lg-4 col-md-6">';
                                html += '   <div class="card">';
                                html += '       <div class="card-body p-3">';
                                html += '           <img src="' + ASSET_UPLOAD + element.image.replace('/xxx/', '/300/') + '" class="img-fluid rounded" loading="lazy" style="width: 100%">';
                                html += '           <p></p>';
                                html += '           <div class="d-flex align-items-center my-3">';
                                html += '               <span>' + element.datetime_local + '</span>';
                                html += '               <span class="ms-3 text-primary">' + element.created_name + '</span>';
                                html += '           </div>';
                                html += '           <a href="' + ENDPOINT + '/blog/detail/' + element.slug + '" class="my-3 h5">'+ element.name +  '</a>';
                                html += '           <p class="">' + element.description_short + '</p>';
                                html += '           <a href="' + ENDPOINT + '/blog/detail/' +  element.slug + '" class="btn btn-primary">Read More</a>';
                                html += '       </div>';
                                html += '   </div>';
                                html += '</div>';
                                html = $.parseHTML( html);
                                $("#data-wrapper").append(html);
                            });
                        }
                    }
                    setTimeout(() => {
                        $('.auto-load').hide();
                    }, 1000);
                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {
                    setTimeout(() => {
                        $('.auto-load').hide();
                    }, 1000);
                });
        }
    </script>
@endsection
