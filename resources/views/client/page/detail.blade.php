@extends('client.layouts.app')

@section('content')
<link rel="stylesheet" href="{{asset('vendor/laraberg/css/laraberg.css')}}">
    <div class="inner-box">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mt-4">
                        <div class="card-body p-3">
                            <img src="{{ asset('/' . str_replace('/xxx/', '/500/', $page['image'])) }}" class="img-fluid rounded w-50" loading="lazy">
                            <p></p>
                            <a href="{{url('page/' . $page['slug'])}}" class="pt-3 my-3 h5">{{ $page['name'] }}</a>
                            <div class="d-flex align-items-center my-3">
                                <span>{{ $page['datetime_local'] }}</span>
                                <span class="ms-3 text-primary">{{ $page['created_name'] }}</span>
                            </div>
                            <div>
                                <p class="">{!! $page['description_long'] !!}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
