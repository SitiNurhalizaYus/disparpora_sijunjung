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
                                User/Tambah
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
                            {{-- @method('PUT') --}}
                            <div class="form-group">
                                <label class="form-label" for="level_id">Peran</label>
                                <select class="form-control" id="level_id" name="level_id" required>
                                    <option value="" disabled selected>Pilih Kategori</option>
                                    <option value="1">Admin</option>
                                    <option value="2">User</option>
                                </select>
                                <p class="text-danger" id="invalid-level_id"></p>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="username">Username </label>
                                <input class="form-control"
                                type="name" id="username" name="username" value=""
                                    placeholder="Enter Username" required >
                                    <p class="text-danger" style="display: none;" id="invalid-value-username">Silahkan Input Username
                                    </p>
                                    <p class="text-danger" style="display: none;" id="invalid-username">Maksimal 255 Karakter</p>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="name">Nama </label>
                                <input class="form-control" type="text" id="name" name="name" value=""
                                    placeholder="Masukan Nama " required>
                                <p class="text-danger" style="display: none;" id="invalid-value-name">Silahkan Input Nama
                                </p>
                                <p class="text-danger" style="display: none;" id="invalid-name">Maksimal 255 Karakter</p>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="email">Email </label>
                                <input class="form-control "
                                type="email" id="email" name="email" value=""
                                    placeholder="Enter Email" required >
                                <p class="text-danger" style="display: none;" id="invalid-value-email">Silahkan Input Email</p>
                                <p class="text-danger" style="display: none;" id="invalid-email">Maksimal 255 Karakter</p>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="password">Password </label>
                                <input class="form-control " type="password" id="password" name="password" value=""
                                    placeholder="Enter Password" required>
                                    <p class="text-danger" style="display: none;" id="invalid-value-password">Silahkan Input Password
                                    </p>
                                    <p class="text-danger" style="display: none;" id="invalid-password">Maksimal 255 Karakter</p>

                            </div>
                            
                            <div class="form-group">
                                <label class="form-label" for="picture">Upload Foto</label>
                                <input class="form-control" accept="image/*" type="file" id="file" name="file"
                                    required>
                                <input class="form-control" type="hidden" id="picture" name="picture" value="noimage.jpg"
                                    placeholder="picture">
                                <label class="form-label" for="image" style="font-size: 10pt">*Format JPG, JPEG, dan
                                    PNG</label>
                                <p class="text-danger" style="display: none;" id="invalid-input-picture">Silahkan Input Gambar
                                </p>
                                <br>
                                <img src="{{ asset('/uploads/noimage.jpg') }}" id="image-preview" name="image-preview"
                                    width="300px" style="border-radius: 2%;">
                            </div>
                            <div class="form-group">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active">
                                    <label class="form-check-label" for="is_active">Active Status</label>
                                </div>
                            </div>
                            <br><br>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end"">
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
        // handle upload image
        $('#file').change(function() {
            var fileInput = $(this);
            var file = fileInput.prop('files')[0];
            var validImageTypes = ['image/jpeg', 'image/png', 'image/jpg'];

            if ($.inArray(file.type, validImageTypes) < 0) {
                Swal.fire({
                    icon: "error",
                    title: "Invalid File",
                    text: "File harus berupa gambar dengan format JPG, JPEG, atau PNG.",
                    confirmButtonColor: '#3A57E8',
                });
                fileInput.val(''); // Clear the input value
                $('#image-preview').attr('src', '{{ asset('/uploads/noimage.jpg') }}'); // Reset the preview image
                return;
            }

            // preview
            $('#image-preview').attr('display', 'block');
            var oFReader = new FileReader();
            oFReader.readAsDataURL($("#file")[0].files[0]);
            oFReader.onload = function(oFREvent) {
                $('#image-preview').attr('src', oFREvent.target.result);
            };

            // upload
            formdata = new FormData();
            if ($(this).prop('files').length > 0) {
                file = $(this).prop('files')[0];
                formdata.append("image", file);
            }
            $.ajaxSetup({
                headers: {
                    'Authorization': "Bearer {{ $session_token }}"
                }
            });
            $.ajax({
                url: '/api/upload',
                type: "POST",
                data: formdata,
                processData: false,
                contentType: false,
                success: function(result) {
                    if (result['success'] == true) {
                        $('#picture').val(result['data']['url'].replace(/\\/g, '').replace('/xxx/',
                            '/300/'));
                    }
                }
            });
        });

        // Validate name length and characters on input
        $('#name, #username, #email, #password').on('input', function() {
            let invalidName = $('#invalid-name');
            let invalidUsername = $('#invalid-username');
            let invalidPassword = $('#invalid-password');
            let invalidEmail = $('#invalid-email');
            let nameValue = $('#name').val();
            let usernameValue = $('#username').val();
            let emailValue = $('#email').val();
            let passwordValue = $('#password').val();

            if (nameValue.length >255) {
                invalidName.show();
            } else {
                invalidName.hide();
            }

            if (usernameValue.length >255) {
                invalidUsername.show();
            } else {
                invalidUsername.hide();
            }

            if (passwordValue.length >255) {
                invalidPassword.show();
            } else {
                invalidPassword.hide();
            }

            if (emailValue.length >255) {
                invalidEmail.show();
            } else {
                invalidEmail.hide();
            }

        });

        // handle post
        $('#form-data').submit(false);
        $("#form-data").submit(function(event) {
            event.preventDefault();

            let valid = true;
            let invalidLevelId = $('#invalid-level_id');
            let invalidName = $('#invalid-name');
            let invalidUsername = $('#invalid-username');
            let invalidEmail = $('#invalid-email');
            let invalidPassword = $('#invalid-password');
            let invalidValueName = $('#invalid-value-name');
            let invalidValueUsername = $('#invalid-value-username');
            let invalidValueEmail = $('#invalid-value-email');
            let invalidValuePassword = $('#invalid-value-password');
            let invalidInputPicture = $('#invalid-input-picture ');

            // Reset validation messages
            invalidLevelId.text('');
            invalidName.hide();
            invalidUsername.hide();
            invalidEmail.hide();
            invalidPassword.hide();
            invalidValueName.hide();
            invalidValueUsername.hide();
            invalidValuePassword.hide();
            invalidValueEmail.hide();
            invalidInputPicture.hide();

            // Validate category
            if (!$('#level_id').val()) {
                invalidLevelId.text('Pilih kategori');
                valid = false;
            }

            // Validate name length
            let nameValue = $('#name').val();
            if (nameValue.length > 255) {
                invalidName.show();
                valid = false;
            }
            // Validate name is not udefined
            if (nameValue.trim() === '') {
                invalidValueName.show();
                valid = false;
            }

            let usernameValue = $('#email').val();
            if (usernameValue.length > 255) {
                invalidUsername.show();
                valid = false;
            }
            if (usernameValue.trim() === ''){
                invalidValueUsername.show();
                valid = false;
            }
            let emailValue = $('#email').val();
            if (emailValue.length > 255) {
                invalidEmail.show();
                valid = false;
            }
            if (emailValue.trim() === ''){
                invalidValueEmail.show();
                valid = false;
            }
            let passwordValue = $('#password').val();
            if (passwordValue.length > 255) {
                invalidPassword.show();
                valid = false;
            }
            if (passwordValue.trim() === ''){
                invalidValuePassword.show();
                valid = false;
            }



            // Validate photo input
            let pictureValue = $('#file').prop('files')[0];
            if (!pictureValue) {
                invalidInputPicture.show();
                valid = false;
            }

            if (valid) {
                var form = $("#form-data").serializeArray();
                var formdata = {};
                $.map(form, function(n, i) {
                    formdata[n['name']] = n['value'];
                });
                if ('is_active' in formdata) {
                    if (formdata['is_active'] == 'on') {
                        formdata['is_active'] = true;
                    } else {
                        formdata['is_active'] = false;
                    }
                } else {
                    formdata['is_active'] = false;
                }

                $.ajaxSetup({
                    headers: {
                        'Authorization': "Bearer {{ $session_token }}"
                    }
                });
                $.ajax({
                    url: '/api/user',
                    type: "POST",
                    data: JSON.stringify(formdata),
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    processData: false,
                    success: function(result) {
                        if (result['success'] == true) {
                            Swal.fire({
                                icon: "success",
                                title: "Success",
                                text: result['message'],
                                confirmButtonColor: '#3A57E8',
                            }).then((result) => {
                                window.location.replace("{{ url('/admin/user') }}");
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: result['message'],
                                confirmButtonColor: '#3A57E8',
                            });
                        }
                    }
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Please correct the errors in the form.",
                    confirmButtonColor: '#3A57E8',
                });
            }
        });
    </script>
@endsection
