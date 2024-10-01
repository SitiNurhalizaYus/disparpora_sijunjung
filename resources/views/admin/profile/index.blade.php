@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid content-inner mt-n5 py-0" style="margin-top: 100px !important;">
        <div class="row justify-content-center">
            <div class="col-sm-10">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="header-title">
                                <h3 class="card-title">Profile</h3>
                                <p class="mb-0">Update Data</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" id="form-data" name="form-data" enctype="multipart/form-data" novalidate>
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            {{-- @if ($session_data['user_level_id'] == 1)
                            <div class="form-group">
                                <label class="form-label" for="level_id">Peran</label>
                                <select class="form-select" id="level_id" name="level_id" required>
                                    <option value="" disabled>Pilih Peran</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id_level }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <p class="text-danger" id="error-level_id" style="display: none;">Level ID is required.</p>
                            </div>
                            @endif --}}

                            <div class="form-group">
                                <label class="form-label" for="username">Username</label>
                                <input class="form-control form-control-sm" type="text" id="username" name="username"
                                    placeholder="Enter Username" required>
                                <p class="text-danger" id="error-username" style="display: none;">Username is required.</p>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="email">Email</label>
                                <input class="form-control form-control-sm" type="email" id="email" name="email"
                                    placeholder="Enter Email" required>
                                <p class="text-danger" id="error-email" style="display: none;">Email is required.</p>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="name">Nama</label>
                                <input class="form-control form-control-sm" type="text" id="name" name="name"
                                    placeholder="Enter Name" required>
                                <p class="text-danger" id="error-name" style="display: none;">Name is required.</p>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="password">Password</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_password" name="is_password">
                                    <label class="form-check-label" for="is_password">Ganti Password</label>
                                </div>
                                <input class="form-control form-control-sm" type="password" id="password" name="password"
                                    placeholder="Enter Password" disabled>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="picture">Foto</label>
                                <input class="form-control form-control-sm" type="file" id="file" name="file"
                                    accept="image/jpeg,image/png,image/jpg">
                                <br>
                                <img src="{{ asset('/uploads/noimage.jpg') }}" id="image-preview" name="image-preview"
                                    width="200px" style="border-radius: 2%;">
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{ URL::previous() }}" class="btn btn-outline-danger btn-sm">Batal</a>
                                <button type="submit" class="btn btn-outline-success btn-sm">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'Authorization': "Bearer {{ $session_token }}"
                }
            });

            // Ambil data user menggunakan AJAX
            $.ajax({
                url: '/api/user/{{ $session_data['user_id'] }}',
                type: "GET",
                dataType: "json",
                success: function(result) {
                    if (result['success']) {
                        $('#level_id').val(result['data']['level_id']);
                        $('#username').val(result['data']['username']);
                        $('#email').val(result['data']['email']);
                        $('#name').val(result['data']['name']);
                        $("#image-preview").attr("src", "{{ url('/') }}/" + result['data'][
                            'picture'
                        ].replace('/xxx/', '/300/'));
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: result['message']
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Gagal mengambil data pengguna."
                    });
                }
            });

            // Enable/disable password field
            $('#is_password').change(function() {
                $('#password').prop("disabled", !$(this).is(":checked"));
            });

            // Handle file upload
            $('#file').on('change', function() {
                var file = $(this).prop('files')[0];
                if (!file || !file.type.match('image.*')) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "File yang diunggah bukan gambar yang valid. Silakan unggah file dalam format JPG, JPEG, atau PNG.",
                    });
                    $(this).val('');
                    $('#image-preview').attr('src', '{{ asset('/uploads/noimage.jpg') }}');
                } else {
                    var oFReader = new FileReader();
                    oFReader.readAsDataURL(file);
                    oFReader.onload = function(oFREvent) {
                        $('#image-preview').attr('src', oFREvent.target.result);
                    };

                    var formdata = new FormData();
                    formdata.append("file", file);

                    $.ajax({
                        url: '/api/upload',
                        type: "POST",
                        data: formdata,
                        processData: false,
                        contentType: false,
                        success: function(result) {
                            if (result['success'] == true) {
                                $('#picture').val(result['data']['url'].replace('/xxx/',
                                    '/500/'));
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: "Oops...",
                                    text: "Gagal mengunggah gambar.",
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Terjadi kesalahan saat mengunggah gambar."
                            });
                        }
                    });
                }
            });

            // Handle form submit
            $("#form-data").submit(function(event) {
                event.preventDefault();

                var form = new FormData(this);

                $.ajax({
                    url: "/api/user/{{ $session_data['user_id'] }}",
                    type: "POST",
                    data: form,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function(result) {
                        if (result['success']) {
                            // Perbarui navigasi setelah profil diperbarui
                            $('#user-name').text(result['data']['name']);
                            $('#user-level-name').text(result['data']['levels']['name']);
                            $('#user-picture').attr('src', result['data']['picture'].replace(
                                '/xxx/', '/100/'));

                            Swal.fire({
                                icon: "success",
                                title: "Sukses",
                                text: result['message'],
                            }).then(() => {
                                    window.location.replace("{{ url('/admin') }}");
                            });
                        } else {
                            handleValidationErrors(result['data']);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            handleValidationErrors(xhr.responseJSON.data);
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Gagal memperbarui profil."
                            });
                        }
                    }
                });
            });

            function handleValidationErrors(errors) {
                $('#error-level_id').hide();
                $('#error-username').hide();
                $('#error-email').hide();
                $('#error-name').hide();

                if (errors.level_id) {
                    $('#error-level_id').text(errors.level_id[0]).show();
                }
                if (errors.username) {
                    $('#error-username').text(errors.username[0]).show();
                }
                if (errors.email) {
                    $('#error-email').text(errors.email[0]).show();
                }
                if (errors.name) {
                    $('#error-name').text(errors.name[0]).show();
                }
            }
        });
    </script>
@endsection