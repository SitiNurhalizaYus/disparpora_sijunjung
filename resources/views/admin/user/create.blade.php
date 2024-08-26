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
                        <div class="form-group">
                            <label class="form-label" for="level_id">Peran </label>
                            <select class="form-select" id="level_id" name="level_id" required>
                                <option value="" disabled selected>Pilih Peran</option>
                                <option value="1">Admin</option>
                                <option value="2">Editor</option>
                            </select>
                            <p class="text-danger" style="display: none; font-size: 0.75rem;" id="invalid-level_id">Silakan pilih peran.</p>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="username">Username </label>
                            <input class="form-control" type="text" id="username" name="username" placeholder="Masukkan Username" required pattern="[A-Za-z0-9\s]+$">
                            <p class="text-danger" style="display: none; font-size: 0.75rem;" id="invalid-username">Username hanya boleh berisi huruf, angka, dan spasi.</p>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="email">Email </label>
                            <input class="form-control" type="email" id="email" name="email" placeholder="Masukkan Email" required>
                            <p class="text-danger" style="display: none; font-size: 0.75rem;" id="invalid-email">Silakan masukkan email yang valid.</p>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="name">Nama </label>
                            <input class="form-control" type="text" id="name" name="name" placeholder="Masukkan Nama" required pattern="[A-Za-z0-9\s]+$">
                            <p class="text-danger" style="display: none; font-size: 0.75rem;" id="invalid-name">Nama harus diisi dan tidak boleh ada simbol.</p>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="password">Password </label>
                            <input class="form-control" type="password" id="password" name="password" placeholder="Masukkan Password" required minlength="6">
                            <p class="text-danger" style="display: none; font-size: 0.75rem;" id="invalid-password">Password harus minimal 6 karakter.</p>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="picture">Foto</label>
                            <input class="form-control" type="file" id="file" name="file" required>
                            <input class="form-control" type="hidden" id="picture" name="picture" value="noimage.jpg" placeholder="image">
                            <br>
                            <img src="{{ asset('/uploads/noimage.jpg') }}" id="image-preview" name="image-preview" width="300px" style="border-radius: 2%;">
                            <label class="form-label" for="photo" style="font-size: 10pt">*Format JPG,JPEG, dan PNG</label>
                            <p class="text-danger" style="display: none; font-size: 0.75rem;" id="invalid-picture">Silakan unggah foto.</p>
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
    // Handle validation display
    function validateInput(inputId, errorId, condition = true) {
        if (condition && !$(`#${inputId}`).val()) {
            $(`#${errorId}`).show();
            return false;
        } else {
            $(`#${errorId}`).hide();
            return true;
        }
    }

    // Custom validation for name and username fields (only letters, numbers, and spaces)
    function validateText(inputId, errorId) {
        const input = $(`#${inputId}`);
        const value = input.val();
        const pattern = /^[A-Za-z0-9\s]+$/;
        if (!pattern.test(value)) {
            $(`#${errorId}`).show();
            return false;
        } else {
            $(`#${errorId}`).hide();
            return true;
        }
    }

    // Custom validation for email
    function validateEmail() {
        const emailInput = $('#email');
        const emailValue = emailInput.val();
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(emailValue)) {
            $('#invalid-email').show();
            return false;
        } else {
            $('#invalid-email').hide();
            return true;
        }
    }

    // Custom validation for password field
    function validatePassword() {
        const passwordInput = $('#password').val();
        if (passwordInput.length < 6) {
            $('#invalid-password').show();
            return false;
        } else {
            $('#invalid-password').hide();
            return true;
        }
    }

    // Attach real-time validation to inputs
    $('#level_id').on('change', function() {
        validateInput('level_id', 'invalid-level_id');
    });

    $('#username').on('input', function() {
        validateText('username', 'invalid-username');
    });

    $('#name').on('input', function() {
        validateText('name', 'invalid-name');
    });

    $('#email').on('input', function() {
        validateEmail();
    });

    $('#password').on('input', function() {
        validatePassword();
    });

    $('#file').on('change', function() {
        var file = $(this).prop('files')[0];
        if (!file || !file.type.match('image.*')) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "File yang diunggah bukan gambar yang valid. Silakan unggah file dalam format JPG, JPEG, atau PNG.",
                confirmButtonColor: '#3A57E8',
            });
            $(this).val('');
            $('#image-preview').attr('src', '{{ asset('/uploads/noimage.jpg') }}');
            $('#invalid-picture').show();
        } else {
            $('#invalid-picture').hide();

            var oFReader = new FileReader();
            oFReader.readAsDataURL(file);
            oFReader.onload = function(oFREvent) {
                $('#image-preview').attr('src', oFREvent.target.result);
            };

            var formdata = new FormData();
            formdata.append("image", file);

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
                        $('#picture').val(result['data']['url'].replace('/xxx/', '/300/'));
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Gagal mengunggah gambar.",
                            confirmButtonColor: '#3A57E8',
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Terjadi kesalahan saat mengunggah gambar.",
                        confirmButtonColor: '#3A57E8',
                    });
                }
            });
        }
    });

    // Validate the entire form before submission
    function validateForm() {
        let isValid = true;
        isValid = validateInput('level_id', 'invalid-level_id') && isValid;
        isValid = validateText('username', 'invalid-username') && isValid;
        isValid = validateEmail() && isValid;
        isValid = validateText('name', 'invalid-name') && isValid;
        isValid = validatePassword() && isValid;
        isValid = validateInput('file', 'invalid-picture', $('#file').prop('files').length > 0) && isValid;
        return isValid;
    }

    // handle form submission
    $("#form-data").submit(function(event) {
        event.preventDefault();

        if (validateForm()) {
            var form = $("#form-data").serializeArray();
            var formdata = {};
            $.map(form, function(n, i) {
                formdata[n['name']] = n['value'];
            });

            formdata['is_active'] = $('#is_active').is(":checked") ? 1 : 0;

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
                text: "Anda harus melengkapi seluruh form dengan benar.",
                confirmButtonColor: '#3A57E8',
            });
        }
        return false;
    });
</script>
@endsection
