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
                            <div class="form-group">
                                <label class="form-label" for="level_id">Peran </label>
                                <select class="form-select" id="level_id" name="level_id" required>
                                    <option value="" disabled selected>Pilih Peran</option>
                                    <option value="1">Admin</option>
                                    <option value="2">Editor</option>
                                </select>
                                <div class="invalid-feedback" style="font-size: 0.75rem;">
                                    Pilih peran yang valid.
                                </div>
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
                                <input class="form-control" type="file" id="file" name="file" accept="image/jpeg,image/png,image/jpg">
                                <input class="form-control" type="hidden" id="picture" name="picture" value="noimage.jpg"
                                    placeholder="image">
                                <br>
                                <img src="{{ asset('/uploads/noimage.jpg') }}" id="image-preview" name="image-preview"
                                    width="300px" style="border-radius: 2%;">
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
                    $("#image-preview").attr("src", "{{ url('/') }}/" + result['data']['picture'].replace(
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

       // handle upload image
       $('#file').change(function() {
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
                formdata.append("file", file);
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
                        $('#picture').val(result['data']['url']);
                    }
                }
            });
        });

        // handle wysiwyg
        tinymce.init({
            selector: 'textarea#content',
            plugins: 'code table lists',
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image responsivefilemanager | print preview media | forecolor backcolor emoticons | codesample",
            promotion: false,
            setup: function(ed) {
                ed.on('change', function(e) {
                    $('#description_long').val(ed.getContent());
                });
            }
        });

        // handle post
        $('#form-data').submit(false);
        $("#form-data").submit(function() {

            if ($(this).valid()) {
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
                    url: '/api/user/{{ $id_user }}',
                    type: "PUT",
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
                    text: "You must complete the entire form.",
                    confirmButtonColor: '#3A57E8',
                });
            }
            return false;
        });
    </script>
@endsection
