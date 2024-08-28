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
                <div class="card-body p-4">
                    <form method="POST" class="needs-validation" id="form-data" name="form-data" novalidate>
                        {{ csrf_field() }}
                        <div class="form-group mb-3">
                            <label class="form-label" for="level_id">Peran</label>
                            <select class="form-select form-control-sm" id="level_id" name="level_id" required disabled>
                                <option value="2">Editor</option>
                                <option value="1">Admin</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="username">Username</label>
                            <input class="form-control form-control-sm" type="text" id="username" name="username" placeholder="Enter Username" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="email">Email</label>
                            <input class="form-control form-control-sm" type="text" id="email" name="email" placeholder="Enter Email" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="name">Nama</label>
                            <input class="form-control form-control-sm" type="text" id="name" name="name" placeholder="Enter Name" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="password">Password</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="is_password" name="is_password">
                                <label class="form-check-label" for="is_password">
                                    Ganti Password
                                </label>
                            </div>
                            <input class="form-control form-control-sm" type="password" id="password" name="password" placeholder="Enter Password" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="picture">Foto</label>
                            <input class="form-control form-control-sm" type="file" id="file" name="file">
                            <input class="form-control form-control-sm" type="hidden" id="picture" name="picture" value="noimage.jpg" placeholder="image">
                            <br>
                            <img src="{{ asset('/uploads/noimage.jpg') }}" id="image-preview" name="image-preview" width="200px" style="border-radius: 2%;">
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
        url: "/api/user/{{ $session_data['user_id'] }}",
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
                    $('#picture').val(result['data']['url'].replace('/xxx/', '/300/'));
                }
            }
        });
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
            if ('active_status' in formdata) {
                if (formdata['active_status'] == 'on') {
                    formdata['active_status'] = true;
                } else {
                    formdata['active_status'] = false;
                }
            } else {
                formdata['active_status'] = false;
            }

            $.ajaxSetup({
                headers: {
                    'Authorization': "Bearer {{ $session_token }}"
                }
            });
            $.ajax({
                url: "/api/user/{{ $session_data['user_id'] }}",
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
                            window.location.replace("{{ url('/admin') }}");
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
