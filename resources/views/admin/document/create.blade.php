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
                                Dokumen/Tambah
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
                                <input class="form-control" type="file" id="file" name="file" accept="application/pdf" required>
                                <input class="form-control" type="hidden" id="file_path" name="file_path" value="">
                                <p class="text-danger" style="display: none; font-size: 0.75rem;" id="invalid-file">Silakan unggah file PDF.</p>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="notes">Catatan</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                            </div>
                            @if ($session_data['user_level_id'] == 1 || $session_data['user_level_id'] == 2)
                                <div class="form-group">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active">
                                        <label class="form-check-label" for="is_active">Status Aktif</label>
                                    </div>
                                </div>
                            @endif
                            @if ($session_data['user_level_id'] == 3)
                                <input type="hidden" name="is_active" value="0">
                            @endif
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
        // Validasi file PDF yang diunggah
        function validateFile() {
            const file = $('#file')[0].files[0];

            if (file && file.type !== 'application/pdf') {
                $('#invalid-file').show();
                $('#file').val(''); // Kosongkan input file jika tidak valid

                // Tampilkan pemberitahuan menggunakan Swal
                Swal.fire({
                    icon: 'error',
                    title: 'File tidak valid',
                    text: 'File yang diunggah harus berupa PDF.',
                    confirmButtonColor: '#3A57E8',
                });

                return false;
            } else {
                $('#invalid-file').hide();
                return true;
            }
        }

        // Handle upload
        $('#file').change(function() {
            if (validateFile()) {
                var formdata = new FormData();
                var file = $('#file')[0].files[0];
                formdata.append("file", file);

                // Tampilkan loading
                Swal.fire({
                    title: 'Mengunggah...',
                    html: 'Tunggu sebentar, file sedang diunggah',
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
                    url: '/api/upload', // Endpoint untuk mengunggah PDF
                    type: "POST",
                    data: formdata,
                    processData: false,
                    contentType: false,
                    success: function(result) {
                        Swal.close(); // Tutup dialog loading
                        if (result['success'] == true) {
                            // Simpan path file ke dalam variabel hidden
                            $('#file_path').val(result['data']['url']);
                            Swal.fire({
                                icon: "success",
                                title: "Berhasil",
                                text: "File PDF berhasil diunggah.",
                                timer: 2000, // Notifikasi akan ditutup otomatis setelah 2 detik
                                showConfirmButton: false, // Tidak menampilkan tombol OK
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Gagal mengunggah file.",
                                confirmButtonColor: '#3A57E8',
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.close(); // Tutup dialog loading
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Terjadi kesalahan saat mengunggah file.",
                            confirmButtonColor: '#3A57E8',
                        });

                        // Reset file input
                        $('#file').val('');
                    }
                });
            }
        });

        // Attach real-time validation to inputs
        $('#title').on('input', function() {
            validateInput('title', 'invalid-title');
        });
        
        $('#category').on('input', function() {
            validateInput('category', 'invalid-category');
        });

        $('#file_path').on('input', function() {
            validateFile();
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
                    url: '/api/document',
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
                            }).then(() => {
                                window.location.replace("{{ url('/admin/documents') }}");
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
