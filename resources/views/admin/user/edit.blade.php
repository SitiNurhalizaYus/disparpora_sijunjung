@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid content-inner mt-n5 py-0" style="margin-top: 100px !important;">
        <div class="card-header mb-2 px-3">
            <div class="flex-wrap d-flex justify-content-between align-items-center">
                <div>
                    <div class="header-title">
                        <h3 class="card-title">
                            <!-- Tombol Back -->
                            <a href="{{ URL::previous() }}" style="text-decoration: none; color: inherit;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor"
                                    class="bi bi-arrow-left-short" viewBox="0 0 16 16" style="text-decoration: none;">
                                    <path fill="black"
                                        fill-rule="evenodd"d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5" />
                                </svg>
                                User/Edit
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
                                <label class="form-label" for="level_id">Peran</label>
                                <select class="form-select" id="level_id" name="level_id" required>
                                    <option value="" disabled selected>Pilih Peran</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id_level }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <p class="text-danger" style="display: none; font-size: 0.75rem;" id="invalid-category">
                                    Silahkan pilih peran</p>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="username">Username </label>
                                <input class="form-control" type="text" id="username" name="username" value=""
                                    placeholder="Enter Username" required>
                                <div class="invalid-feedback" style="font-size: 0.75rem;">
                                    Username wajib diisi.
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="email">Email </label>
                                <input class="form-control" type="email" id="email" name="email" value=""
                                    placeholder="Enter Email" required>
                                <div class="invalid-feedback" style="font-size: 0.75rem;">
                                    Masukkan email yang valid.
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="name">Nama </label>
                                <input class="form-control" type="text" id="name" name="name" value=""
                                    placeholder="Enter Name" required>
                                <div class="invalid-feedback" style="font-size: 0.75rem;">
                                    Nama wajib diisi.
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="password">Password </label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="is_password"
                                        name="is_password">
                                    <label class="form-check-label" for="is_password">
                                        Ganti Password
                                    </label>
                                </div>
                                <input class="form-control" type="password" id="password" name="password" value=""
                                    placeholder="Enter Password" required>
                                <div class="invalid-feedback" style="font-size: 0.75rem;">
                                    Password wajib diisi jika mengganti.
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="picture">Foto</label>
                                <input class="form-control" type="file" id="file" name="file"
                                    accept="image/jpeg,image/png,image/jpg">
                                <input class="form-control" type="hidden" id="picture" name="picture">
                                <br>
                                <img id="image-preview" name="image-preview" width="300px" style="border-radius: 2%;">
                                <br><label class="form-label" for="photo" style="font-size: 10pt">*Format JPG, JPEG,
                                    dan PNG</label>
                                <p class="text-danger" style="display: none; font-size: 0.75rem;" id="invalid-picture">
                                    Silakan unggah foto.</p>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="notes">Catatan</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active">
                                    <label class="form-check-label" for="is_active">Status Aktif</label>
                                </div>
                            </div>
                            <br><br>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{ URL::previous() }}" class="btn btn-danger">Batal</a>
                                <button type="submit" class="btn btn-success">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Ambil data beritas menggunakan AJAX
            $.ajaxSetup({
                headers: {
                    'Authorization': "Bearer {{ $session_token }}"
                }
            });
            // get data
            $.ajaxSetup({
                headers: {
                    'Authorization': "Bearer {{ $session_token }}"
                }
            });
            $.ajax({
                url: '/api/user/{{ $id_user }}',
                type: "GET",
                dataType: "json",
                processData: false,
                success: function(result) {
                    if (result['success'] == true) {
                        $("#detail-data-success").show();
                        $("#detail-data-failed").hide();

                        $('#level_id').val(result['data']['level_id']);
                        $('#username').val(result['data']['username']);
                        $('#email').val(result['data']['email']);
                        $('#name').val(result['data']['name']);
                        $("#picture").val(result['data']['picture']);
                        $("#image-preview").attr("src", "{{ url('/') }}/" + result['data'][
                            'picture'
                        ].replace(
                            '/xxx/', '/300/'));
                        $('#notes').val(result['data']['notes']);
                        $('#is_active').prop("checked", result['data']['is_active']);

                    } else {
                        $("#detail-data-success").hide();
                        $("#detail-data-failed").show();

                        $('#message').html(result['message']);
                    }
                },
                fail: function() {
                    $("#detail-data-success").hide();
                    $("#detail-data-failed").show();

                    $('#message').html(result['message']);
                }
            });
        });
        // Enable form validation
        (function() {
            'use strict';
            var forms = document.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();

        $('#password').prop("disabled", true);
        $('#is_password').change(function() {
            if ($('#is_password').is(":checked")) {
                $('#password').prop("disabled", false);
            } else {
                $('#password').prop("disabled", true);
            }
        });

        function validateInput(inputId, errorId, condition = true) {
            if (condition && !$(`#${inputId}`).val()) {
                $(`#${errorId}`).show();
                return false;
            } else {
                $(`#${errorId}`).hide();
                return true;
            }
        }

        // Handle validation for email and username uniqueness
        function handleUniqueError(error) {
            if (error.email) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Email ini sudah terdaftar. Silakan gunakan email lain.",
                    confirmButtonColor: '#3A57E8',
                });
                $('#email').addClass('is-invalid');
            }
            if (error.username) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Username ini sudah digunakan. Silakan gunakan username lain.",
                    confirmButtonColor: '#3A57E8',
                });
                $('#username').addClass('is-invalid');
            }
        }

        // Validasi file gambar yang diunggah
        function validateFile() {
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            const file = $('#file')[0].files[0];

            if (file && !allowedTypes.includes(file.type)) {
                $('#invalid-file').show();
                $('#file').val(''); // Kosongkan input file jika tidak valid

                // Tampilkan pemberitahuan menggunakan Swal
                Swal.fire({
                    icon: 'error',
                    title: 'File tidak valid',
                    text: 'File yang diunggah harus berupa gambar (.jpg, .jpeg, .png).',
                    confirmButtonColor: '#3A57E8',
                });

                return false;
            } else {
                $('#invalid-file').hide();
                return true;
            }
        }

        let uploadedFilePath = ''; // Variable untuk menyimpan path file sementara
        $('#file').change(function() {
            if (validateFile()) {
                // Preview image
                $('#image-preview').attr('display', 'block');
                var oFReader = new FileReader();
                oFReader.readAsDataURL($("#file")[0].files[0]);
                oFReader.onload = function(oFREvent) {
                    $('#image-preview').attr('src', oFREvent.target.result);
                };

                // Upload image
                var formdata = new FormData();
                if ($(this).prop('files').length > 0) {
                    var file = $(this).prop('files')[0];
                    formdata.append("file", file);
                }
                // Tampilkan loading
                Swal.fire({
                    title: 'Mengunggah...',
                    html: 'Tunggu sebentar, gambar sedang diunggah',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajaxSetup({
                    headers: {
                        'Authorization': "Bearer {{ $session_token }}",
                    }
                });

                $.ajax({
                    url: '/api/upload', // Endpoint untuk mengunggah gambar
                    type: "POST",
                    data: formdata,
                    processData: false,
                    contentType: false,
                    success: function(result) {
                        Swal.close(); // Tutup dialog loading
                        if (result['success'] == true) {
                            // Simpan path file sementara ke dalam variabel
                            $('#picture').val(result['data']['url'].replace('/xxx/', '/500/'));
                            Swal.fire({
                                icon: "success",
                                title: "Berhasil",
                                text: "Gambar berhasil diunggah.",
                                timer: 2000, // Notifikasi akan ditutup otomatis setelah 2 detik
                                showConfirmButton: false, // Tidak menampilkan tombol OK
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Gagal mengunggah gambar.",
                                confirmButtonColor: '#3A57E8',
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.close(); // Tutup dialog loading
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Terjadi kesalahan saat mengunggah gambar.",
                            confirmButtonColor: '#3A57E8',
                        });

                        // Reset file input and image preview
                        $('#file').val('');
                        $('#image-preview').attr('src', '{{ asset('/uploads/noimage.jpg') }}');
                        $('#picture').val('noimage.jpg');
                    }

                });
            }
        });

        function validateForm() {
            let isValid = true;
            isValid = validateInput('level_id', 'invalid-category') && isValid;
            isValid = validateInput('username', 'invalid-username') && isValid;
            isValid = validateInput('email', 'invalid-email') && isValid;
            isValid = validateInput('name', 'invalid-name') && isValid;
            return isValid;
        }

        // Handle form submission
        $("#form-data").submit(function(event) {
            event.preventDefault();

            if (validateForm()) {
                var form = new FormData(document.getElementById("form-data"));

                // Mengubah is_active menjadi boolean (1 atau 0) sesuai dengan nilai checkbox
                form.set('is_active', $('#is_active').is(":checked") ? 1 : 0);

                $.ajax({
                    url: '/api/user/{{ $id_user }}',
                    type: "POST", // Menggunakan POST dengan _method PUT
                    data: form,
                    contentType: false, // Supaya FormData bisa bekerja dengan benar
                    processData: false, // Supaya FormData bisa bekerja dengan benar
                    success: function(result) {
                        if (result['success'] == true) {
                            Swal.fire({
                                icon: "success",
                                title: "Success",
                                text: result['message'],
                                confirmButtonColor: '#3A57E8',
                            }).then((result) => {
                                window.location.replace("{{ url('/admin/users') }}");
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: result['message'],
                                confirmButtonColor: '#3A57E8',
                            });
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let errorMessage = '';
                            Object.keys(errors).forEach(function(key) {
                                errorMessage += errors[key][0] + '\n';
                            });
                            Swal.fire({
                                icon: "error",
                                title: "Validasi Gagal",
                                text: errorMessage,
                                confirmButtonColor: '#3A57E8',
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Terjadi kesalahan saat menyimpan data.",
                                confirmButtonColor: '#3A57E8',
                            });
                        }
                    }
                });
            } else {
                // Jika validasi gagal, tampilkan pesan kesalahan dan jangan kirim form
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Anda harus melengkapi seluruh form dengan benar.",
                    confirmButtonColor: '#3A57E8',
                });
            }
            return false; // Menghentikan submit jika validasi gagal
        });
    </script>
@endsection
