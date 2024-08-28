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
                                Dokumen/Edit
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
                                <label class="form-label" for="title">Judul Dokumen</label>
                                <input class="form-control" type="text" id="title" name="title" value=""
                                    placeholder="Masukkan Judul Dokumen" required>
                                <p class="text-danger" style="display: none; font-size: 0.75rem;" id="invalid-title">Judul dokumen harus diisi.</p>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="category">Kategori</label>
                                <input class="form-control" type="text" id="category" name="category" value=""
                                    placeholder="Masukkan Kategori" required>
                                <p class="text-danger" style="display: none; font-size: 0.75rem;" id="invalid-category">Kategori harus diisi.</p>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="file">Unggah Dokumen (PDF)</label>
                                <input class="form-control" type="file" id="file" name="file" accept="application/pdf">
                                <input class="form-control" type="hidden" id="file_path" name="file_path" value="">
                                <!-- Menampilkan nama file yang sudah ada -->
                                @if ($document->file_path)
                                    <p>File saat ini: <a href="{{ asset($document->file_path) }}" target="_blank">{{ basename($document->file_path) }}</a></p>
                                @endif
                                <p class="text-danger" style="display: none; font-size: 0.75rem;" id="invalid-file">Silakan unggah file PDF.</p>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="description">Catatan</label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
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
        // Validate file upload
        function validateFile() {
            if ($('#file_path').val() === '' && !$('#file').val()) {
                $('#invalid-file').show();
                return false;
            } else {
                $('#invalid-file').hide();
                return true;
            }
        }

        // Handle file upload
        $('#file').on('change', function() {
            var file = $(this).prop('files')[0];
            if (file.type !== 'application/pdf') {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "File yang diunggah bukan PDF. Silakan unggah file dalam format PDF.",
                    confirmButtonColor: '#3A57E8',
                });
                // Hapus file dari input jika tidak valid
                $(this).val('');
                $('#invalid-file').show();
            } else {
                // Jika file valid, hapus pesan error dan lakukan unggah file
                $('#invalid-file').hide();

                // Unggah file ke server
                var formdata = new FormData();
                formdata.append("file", file);

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
                            // Simpan URL file ke input hidden
                            $('#file_path').val(result['data']['url']);
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Gagal mengunggah file.",
                                confirmButtonColor: '#3A57E8',
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Terjadi kesalahan saat mengunggah file.",
                            confirmButtonColor: '#3A57E8',
                        });
                    }
                });
            }
        });

        // Ambil data agenda menggunakan AJAX
        $.ajax({
                url: '/api/document/{{ $id }}',
                type: "GET",
                dataType: "json",
                success: function(result) {
                    if (result['success']) {
                        // Isi data form dengan data yang diterima dari API
                        $('#title').val(result['data']['title']);
                        $('#category').val(result['data']['category']);
                        $('#description').val(result['data']['description']);
                        $('#file_path').val(result['data']['file_path']);

                        // Tampilkan preview file jika file_path tersedia
                        if (result['data']['file_path']) {
                            const fileType = result['data']['file_path'].split('.').pop().toLowerCase();
                            let fileUrl = `{{ url('/') }}/uploads/${result['data']['file_path']}`;

                            if (fileType === 'pdf') {
                                $('#file-preview').html(
                                    `<a href="${fileUrl}" target="_blank">Lihat PDF</a>`);
                            } else if (['jpg', 'jpeg', 'png'].includes(fileType)) {
                                $('#file-preview').html(
                                    `<img src="${fileUrl}" alt="Image Preview" class="img-fluid rounded" style="max-width: 200px;">`
                                    );
                            }
                        }

                        $('#is_active').prop('checked', result['data']['is_active']);
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
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Gagal mengambil data agenda.",
                        confirmButtonColor: '#3A57E8',
                    });
                }
            });

        
            // Validate the entire form before submission
        
            function validateForm() {
            let isValid = true;
            isValid = validateInput('title', 'invalid-title') && isValid;
            isValid = validateInput('category', 'invalid-category') && isValid;
            isValid = validateFile() && isValid;
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
                    url: '/api/document/{{ $document->id }}',
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
                                window.location.replace("{{ url('/admin/document') }}");
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

        // Helper for input validation
        function validateInput(inputId, errorId) {
            if (!$(`#${inputId}`).val()) {
                $(`#${errorId}`).show();
                return false;
            } else {
                $(`#${errorId}`).hide();
                return true;
            }
        }
    </script>
@endsection
