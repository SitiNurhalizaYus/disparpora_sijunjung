@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid content-inner mt-n5 py-0" style="margin-top: 100px !important;">
        <div class="card-header mb-2 px-3">
            <div class="header-title">
                <h2 class="card-title">Detail {{ ucfirst($type) }}</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Judul:</label>
                            <p>{{ $content->title }}</p>
                        </div>
                        <div class="form-group">
                            <label>Slug:</label>
                            <p>{{ $content->slug }}</p>
                        </div>
                        <div class="form-group">
                            <label>Konten:</label>
                            <p>{{ $content->content }}</p>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi Singkat:</label>
                            <p>{{ $content->description_short }}</p>
                        </div>
                        <div class="form-group">
                            <label>Gambar:</label>
                            @if($content->image)
                                <img src="{{ url
