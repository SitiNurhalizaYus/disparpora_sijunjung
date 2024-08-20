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
                            Slider/Tambah
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
                            <label class="form-label" for="name">Nama </label>
                            <input class="form-control" type="text" id="name" name="name" placeholder="Masukkan Nama" required>
                            <p class="text-danger" style="display: none; font-size: 0.75rem;" id="invalid-name">Nama harus diisi.</p>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="description">Deskripsi </label>
                            <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
                            <p class="text-danger" style="display: none; font-size: 0.75rem;" id="invalid-description">Deskripsi harus diisi.</p>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="link">Link </label>
                            <input class="form-control" type="url" id="link" name="link" placeholder="Masukkan Link" required>
                            <p class="text-danger" style="display: none; font-size: 0.75rem;" id="invalid-link">Link harus diisi dengan format yang benar.</p>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="file">Gambar </label>
                            <input class="form-control" type="file" id="file" name="file" required>
                            <input class="form-control" type="hidden" id="image" name="image" value="noimage.jpg" placeholder="image">
                            <br>
                            <img src="{{ asset('/uploads/noimage.jpg') }}" id="image-preview" name="image-preview" width="300px" style="border-radius: 2%;">
                            <p class="text-danger" style="display: none; font-size: 0.75rem;" id="invalid-file">Silakan unggah gambar.</p>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="notes">Catatan </label>
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

    // Validate the entire form before submission
    function validateForm() {
        let isValid = true;
        isValid = validateInput('name', 'invalid-name') && isValid;
        isValid = validateInput('description', 'invalid-description') && isValid;
        isValid = validateInput('link', 'invalid-link') && isValid;
        isValid = validateInput('file', 'invalid-file', $('#file').prop('files').length > 0) && isValid;
        return isValid;
    }

    // handle form submission
    $("#form-data").submit(function (event) {
        event.preventDefault();

        if (validateForm()) {
            var form = $("#form-data").serializeArray();
            var formdata = {};
            $.map(form, function (n, i) {
                formdata[n['name']] = n['value'];
            });

            formdata['is_active'] = $('#is_active').is(":checked") ? 1 : 0;

            $.ajaxSetup({
                headers: {
                    'Authorization': "Bearer {{$session_token}}"
                }
            });
            $.ajax({
                url: '/api/slider',
                type: "POST",
                data: JSON.stringify(formdata),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                processData: false,
                success: function (result) {
                    if (result['success'] == true) {
                        Swal.fire({
                            icon: "success",
                            title: "Success",
                            text: result['message'],
                            confirmButtonColor: '#3A57E8',
                        }).then((result) => {
                            window.location.replace("{{ url('/admin/slider') }}");
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
                text: "You must complete the entire form correctly.",
                confirmButtonColor: '#3A57E8',
            });
        }
        return false;
    });

    // handle upload image
    $('#file').change(function () {
        // preview
        $('#image-preview').attr('display', 'block');
        var oFReader = new FileReader();
        oFReader.readAsDataURL($("#file")[0].files[0]);
        oFReader.onload = function (oFREvent) {
            $('#image-preview').attr('src', oFREvent.target.result);
        };

        // upload
        var formdata = new FormData();
        if ($(this).prop('files').length > 0) {
            var file = $(this).prop('files')[0];
            formdata.append("image", file);
        }
        $.ajaxSetup({
            headers: {
                'Authorization': "Bearer {{$session_token}}"
            }
        });
        $.ajax({
            url: '/api/upload',
            type: "POST",
            data: formdata,
            processData: false,
            contentType: false,
            success: function (result) {
                if (result['success'] == true) {
                    $('#image').val(result['data']['url'].replace('/xxx/', '/300/'));
                }
            }
        });
    });
</script>
@endsection
