@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid content-inner mt-n5 py-0" style="margin-top: 100px !important;">
        <div class="card-header mb-2 px-3">
            <div class="header-title">
                <h2 class="card-title">Edit {{ ucfirst($type) }}</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ url('/admin/content/'.$content->id.'?type='.$type) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="title">Judul</label>
                                <input type="text" name="title" class="form-control" id="title" value="{{ $content->title }}" required>
                            </div>
                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input type="text" name="slug" class="form-control" id="slug" value="{{ $content->slug }}" required>
                            </div>
                            <div class="form-group">
                                <label for="content">Konten</label>
                                <textarea name="content" class="form-control" id="content" rows="5" required>{{ $content->content }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="description_short">Deskripsi Singkat</label>
                                <textarea name="description_short" class="form-control" id="description_short" rows="3">{{ $content->description_short }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="image">Gambar</label>
                                <input type="file" name="image" class="form-control-file" id="image">
                                @if($content->image)
                                    <img src="{{ url($content->image) }}" style="width: 100px; height: 100px; object-fit: cover;" alt="{{ $content->title }}">
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="is_active">Status Aktif</label>
                                <select name="is_active" class="form-control" id="is_active">
                                    <option value="1" {{ $content->is_active == 1 ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ $content->is_active == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
