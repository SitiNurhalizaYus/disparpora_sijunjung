@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid content-inner mt-n5 py-0" style="margin-top: 100px !important;">
        <div class="card-header mb-2 px-3">
            <div class="flex-wrap d-flex justify-content-between align-items-center">
                <div>
                    <div class="header-title">
                        <h3 class="card-title">
                            <!-- Tombol Back -->
                            <a href="{{ url('/admin/content/') }}" style="text-decoration: none; color: inherit;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor"
                                    class="bi bi-arrow-left-short" viewBox="0 0 16 16" style="text-decoration: none;">
                                    <path fill="black"
                                        fill-rule="evenodd"d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5" />
                                </svg>
                                Konten/Edit
                            </a>
                        </h3>
                    </div>
                </div>
                <div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" class="needs-validation" id="form-data" name="form-data" novalidate>
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            <div class="form-group">
                                <label class="form-label" for="title">Judul</label>
                                <input class="form-control" type="text" id="title" name="title"
                                    placeholder="Masukkan Judul" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="slug">Slug URL</label>
                                <input class="form-control" type="text" id="slug" name="slug" readonly
                                    style="background-color: lightgray;">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="type">Tipe Konten</label>
                                <select class="form-control" id="type" name="type" required>
                                    <option value="profil">Profil</option>
                                    <option value="artikel">Artikel</option>
                                    <option value="berita">Berita</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="category_id">Kategori</label>
                                <select class="form-control" id="category_id" name="category_id">
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="arsip_id">Arsip</label>
                                <select class="form-control" id="arsip_id" name="arsip_id">
                                    <option value="">Pilih Arsip</option>
                                    @foreach ($arsips as $arsip)
                                        <option value="{{ $arsip->id }}">{{ $arsip->bulan }}/{{ $arsip->tahun }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="datetime">Tanggal dan Waktu</label>
                                <input class="form-control" type="datetime-local" id="datetime" name="datetime" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="image">Gambar</label>
                                <input class="form-control" type="file" id="file" name="file">
                                <input class="form-control" type="hidden" id="image" name="image"
                                    value="noimage.jpg">
                                <br>
                                <img src="{{ asset('/uploads/noimage.jpg') }}" id="image-preview" width="300px"
                                    style="border-radius: 2%;">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="description_short">Konten Singkat</label>
                                <textarea class="form-control" id="description_short" name="description_short" rows="5" required></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="description_long">Konten Panjang</label>
                                <textarea class="form-control" id="description_long" name="description_long" rows="5" style="display: none"></textarea>
                                <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
                            </div>
                            <div class="form-group">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active">
                                    <label class="form-check-label" for="is_active">Status Aktif</label>
                                </div>
                            </div>
                            <br><br>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{ url('/admin/content') }}" class="btn btn-danger">Batal</a>
                                <button type="submit" class="btn btn-success">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Ambil data konten
        $.ajaxSetup({
            headers: {
                'Authorization': "Bearer {{ $session_token }}"
            }
        });
        $.ajax({
            url: '/api/content/{{ $id }}',
            type: "GET",
            dataType: "json",
            success: function(result) {
                if (result['success']) {
                    $('#title').val(result['data']['title']);
                    $('#slug').val(result['data']['slug']);
                    $('#type').val(result['data']['type']);
                    $('#category_id').val(result['data']['category_id']);
                    $('#arsip_id').val(result['data']['arsip_id']);
                    $('#datetime').val(result['data']['datetime']);
                    $('#image').val(result['data']['image']);
                    $('#image-preview').attr('src', "{{ url('/') }}/" + result['data']['image'].replace(
                        '/xxx/', '/300/'));
                    $('#description_short').val(result['data']['description_short']);
                    $('#description_long').val(result['data']['description_long']);
                    $('#is_active').prop('checked', result['data']['is_active']);
                } else {
                    alert(result['message']);
                }
            }
        });

        // Handle upload gambar
        $('#file').change(function() {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(this.files[0]);
            oFReader.onload = function(oFREvent) {
                $('#image-preview').attr('src', oFREvent.target.result);
            };

            var formData = new FormData();
            formData.append('image', this.files[0]);

            $.ajaxSetup({
                headers: {
                    'Authorization': "Bearer {{ $session_token }}"
                }
            });
            $.ajax({
                url: '/api/upload',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(result) {
                    if (result.success) {
                        $('#image').val(result.data.url.replace('/xxx/', '/300/'));
                    }
                }
            });
        });

        // Handle form submit
        $('#form-data').submit(function(e) {
            e.preventDefault();

            if ($(this).valid()) {
                var formData = $(this).serializeArray();
                var data = {};

                $.map(formData, function(n, i) {
                    data[n['name']] = n['value'];
                });

                data['is_active'] = $('#is_active').is(':checked');

                $.ajaxSetup({
                    headers: {
                        'Authorization': "Bearer {{ $session_token }}"
                    }
                });
                $.ajax({
                    url: '/api/content/{{ $id }}',
                    type: 'PUT',
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    success: function(result) {
                        if (result.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: result.message,
                                confirmButtonColor: '#3A57E8',
                            }).then(function() {
                                window.location.href = "{{ url('/admin/content') }}";
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: result.message,
                                confirmButtonColor: '#3A57E8',
                            });
                        }
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Anda harus melengkapi seluruh form.',
                    confirmButtonColor: '#3A57E8',
                });
            }
        });
    </script>
@endsection
