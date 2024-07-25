@extends('client.layouts.app')

@section('content')
    <div class="inner-box">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mt-4">
                        <div class="card-body p-3">
                            <img src="{{ asset('/' . str_replace("/xxx/", "/500/", $blog['image'])) }}" class="img-fluid rounded w-50" loading="lazy">
                            <p></p>
                            <a href="{{url('blog/detail/' . $blog['slug'])}}" class="pt-3 my-3 h5">{{ $blog['name'] }}</a>
                            <div class="d-flex align-items-center my-3">  
                                <span>{{ $blog['datetime_local'] }}</span>
                                <span class="ms-3 text-primary">{{ $blog['created_name'] }}</span>
                            </div>
                            <div>
                                <p class="">{!! $blog['description_long'] !!}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
