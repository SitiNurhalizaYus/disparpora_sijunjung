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
                                    <path fill="black" fill-rule="evenodd"
                                        d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5" />
                                </svg>
                                Agenda/Edit
                            </a>
                        </h3>
                    </div>
                </div>
                <div></div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" class="needs-validation" id="form-data" name="form-data"
                            enctype="multipart/form-data" novalidate>
                            {{ csrf_field() }}
                            @method('PUT')
                            <div class="form-group">
                                <label class="form-label" for="title">Judul Agenda</label>
                                <input class="form-control" type="text" id="title" name="title"
                                    placeholder="Masukkan Judul Agenda" required>
                                <p class="text-danger" style="display: none; font-size: 0.75rem;" id="invalid-title">Judul
                                    harus diisi.</p>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="event_date">Tanggal Acara</label>
                                <input class="form-control" type="date" id="event_date" name="event_date" required>
                                <p class="text-danger" style="display: none; font-size: 0.75rem;" id="invalid-event_date">
                                    Tanggal acara harus diisi.</p>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="organizer">Penyelenggara</label>
                                <input class="form-control" type="text" id="organizer" name="organizer"
                                    placeholder="Masukkan Penyelenggara" required>
                                <p class="text-danger" style="display: none; font-size: 0.75rem;" id="invalid-organizer">
                                    Penyelenggara harus diisi.</p>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="content">Konten Agenda</label>
                                <textarea class="form-control" id="content" name="content" rows="4" placeholder="Masukkan Konten Agenda"
                                    required></textarea>
                                <p class="text-danger" style="display: none; font-size: 0.75rem;" id="invalid-content">
                                    Konten harus diisi.</p>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="file">Unggah Dokumen (PDF)</label>
                                <input class="form-control" type="file" id="file" name="file"
                                    accept="application/pdf">
                                <input class="form-control" type="hidden" id="file_path" name="file_path" value="">
                                <!-- Menampilkan nama file yang sudah ada -->
                                @if ($agenda->file_path)
                                    <p>File saat ini: <a href="{{ asset($agenda->file_path) }}" target="_blank">{{ basename($agenda->file_path) }}</a></p>
                                @endif
                                <p class="text-danger" style="display: none; font-size: 0.75rem;" id="invalid-file">Silakan
                                    unggah file PDF.</p>
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
        $(document).ready(function() {
            // Setup token authorization
            $.ajaxSetup({
                headers: {
                    'Authorization': "Bearer {{ $session_token }}"
                }
            });

            // Ambil data agenda menggunakan AJAX
            $.ajax({
                url: '/api/agenda/{{ $id }}',
                type: "GET",
                dataType: "json",
                success: function(result) {
                    if (result['success']) {
                        // Isi data form dengan data yang diterima dari API
                        $('#title').val(result['data']['title']);
                        $('#event_date').val(result['data']['event_date']);
                        $('#organizer').val(result['data']['organizer']);
                        $('#content').val(result['data']['content']);
                        $('#file_path').val(result['data']['file_path']);

                        // Tampilkan preview file jika file_path tersedia
                        if (result['data']['file_path']) {
                            let fileUrl = `{{ url('/') }}/uploads/${result['data']['file_path']}`;
                            $('#file-preview').html(
                                `<a href="${fileUrl}" target="_blank">Lihat PDF</a>`);
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
        });

        // Fungsi validasi input
        function validateInput(inputId, errorId, condition = true) {
            if (condition && !$(`#${inputId}`).val()) {
                $(`#${errorId}`).show();
                return false;
            } else {
                $(`#${errorId}`).hide();
                return true;
            }
        }

        // Validasi file PDF yang diunggah
        function validateFile() {
            const file = $('#file')[0].files[0];

            if (file && file.type !== 'application/pdf') {
                $('#invalid-file').show();
                $('#file').val(''); // Kosongkan input file jika tidak valid
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

        // Handle upload file PDF
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
                                text: "File berhasil diunggah.",
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
                        $('#file').val(''); // Kosongkan input file jika terjadi kesalahan
                    }
                });
            }
        });

        // Validasi form sebelum disubmit
        function validateForm() {
            let isValid = true;
            isValid = validateInput('title', 'invalid-title') && isValid;
            isValid = validateInput('event_date', 'invalid-event_date') && isValid;
            isValid = validateInput('organizer', 'invalid-organizer') && isValid;
            isValid = validateInput('content', 'invalid-content') && isValid;
            isValid = validateFile() && isValid;
            return isValid;
        }

        // Handle form submission
        $("#form-data").submit(function(event) {
            event.preventDefault();

            if (validateForm()) {
                var form = new FormData(document.getElementById("form-data"));
                form.set('is_active', $('#is_active').is(":checked") ? 1 : 0);

                $.ajaxSetup({
                    headers: {
                        'Authorization': "Bearer {{ $session_token }}"
                    }
                });

                $.ajax({
                    url: '/api/agenda/{{ $id }}',
                    type: "POST",
                    data: form,
                    contentType: false,
                    processData: false,
                    success: function(result) {
                        if (result['success'] == true) {
                            Swal.fire({
                                icon: "success",
                                title: "Success",
                                text: result['message'],
                                confirmButtonColor: '#3A57E8',
                            }).then((result) => {
                                window.location.replace("{{ url('/admin/agendas') }}");
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
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: xhr.responseJSON ? xhr.responseJSON.message :
                                "Terjadi kesalahan saat menyimpan data.",
                            confirmButtonColor: '#3A57E8',
                        });
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

        // Handle TinyMCE initialization
        tinymce.init({
            selector: 'textarea#content',
            plugins: 'code table lists',
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image responsivefilemanager | print preview media | forecolor backcolor emoticons | codesample",
            promotion: false,
            setup: function(ed) {
                ed.on('change', function(e) {
                    $('#content').val(ed.getContent());
                    validateInput('content',
                        'invalid-content'); // Hide error message if content is valid
                });
            }
        });

        // Real-time validation: Hide error messages when the input is correct
        $('#title').on('input', function() {
            validateInput('title', 'invalid-title');
        });

        $('#event_date').on('change', function() {
            validateInput('event_date', 'invalid-event_date');
        });

        $('#organizer').on('input', function() {
            validateInput('organizer', 'invalid-organizer');
        });

        $('#file_path').on('input', function() {
            validateFile('file_path', 'invalid-file');
        });
    </script>
@endsection
