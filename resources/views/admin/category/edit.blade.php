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
                                Kategori/Edit
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
                        <form method="POST" class="needs-validation" id="form-data" name="form-data" novalidate>
                            {{ csrf_field() }}
                            {{ method_field('PUT') }} <!-- Mengirim method PUT untuk update -->

                            <div class="form-group">
                                <label class="form-label" for="name">Nama Kategori</label>
                                <input class="form-control" type="text" id="name" name="name" value=""
                                    placeholder="Masukkan Nama" required>
                                <p class="text-danger" style="display: none; font-size: 0.75rem;" id="invalid-name">Nama
                                    hanya boleh berisi huruf, angka, dan spasi.</p>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="slug">Slug</label>
                                <input class="form-control" type="text" id="slug" name="slug" value=""
                                    placeholder="Otomatis terisi" required pattern="[A-Za-z0-9\-]+$">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="notes">Catatan</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                            </div>
                            <!-- Status Aktif -->
                            @if ($session_data['user_level_id'] == 1 || $session_data['user_level_id'] == 2)
                                <div class="form-group">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active">
                                        <label class="form-check-label" for="is_active">Status Aktif</label>
                                    </div>
                                </div>
                            
                            <!-- Keterangan Status (opsi muncul jika tidak aktif) -->
                            <div class="form-group" id="note-section" style="display: none;">
                                <label class="form-label" for="note-inactive">Keterangan</label>
                                <select class="form-control" id="note-inactive" name="note"> <!-- Ganti name menjadi note -->
                                    <option value="">Pilih Keterangan</option>
                                    <option value="Draft">Draft</option>
                                    <option value="Ditolak">Ditolak</option>
                                    <option value="Lakukan Perbaikan">Lakukan Perbaikan</option>
                                </select>
                            </div>

                            <!-- Keterangan Status Aktif (opsi muncul jika aktif) -->
                            <div class="form-group" id="active-note-section" style="display: none;">
                                <label class="form-label" for="note-active">Keterangan</label>
                                <select class="form-control" id="note-active" name="note"> <!-- Ganti name menjadi note -->
                                    <option value="">Pilih Keterangan</option>
                                    <option value="Diposting/Disetujui">Diposting/Disetujui</option>
                                    <option value="Diposting/Disetujui Dengan Perubahan">Diposting/Disetujui Dengan Perubahan</option>
                                </select>
                            </div>
                            @endif

                            @if ($session_data['user_level_id'] == 3)
                                <div class="form-group">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_draft" name="is_draft">
                                        <label class="form-check-label" for="is_draft">Draft</label>
                                    </div>
                                </div>
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
        // validasi name
        function validateName() {
            const nameInput = $('#name');
            const nameValue = nameInput.val();
            const namePattern = /^[A-Za-z0-9\s]+$/;
            if (!namePattern.test(nameValue)) {
                $('#invalid-name').show();
                return false;
            } else {
                $('#invalid-name').hide();
                generateSlug(nameValue); // Generate slug automatically
                return true;
            }
        }

        // validasi slug
        function validateSlug() {
            const slugInput = $('#slug');
            const slugValue = slugInput.val();
            const slugPattern = /^[A-Za-z0-9\-]+$/;
            if (!slugPattern.test(slugValue)) {
                $('#invalid-slug').show();
                return false;
            } else {
                $('#invalid-slug').hide();
                return true;
            }
        }

        // Generate slug from name
        function generateSlug(name) {
            const slug = name.trim().toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
            $('#slug').val(slug);
            validateSlug(); // Validate slug whenever it is auto-generated
        }

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

        // Attach real-time validation to inputs
        $('#name').on('input', function() {
            validateName();
        });

        $('#slug').on('input', function() {
            validateSlug();
        });

        // Validate the entire form before submission
        function validateForm() {
            let isValid = true;
            isValid = validateName() && isValid;
            isValid = validateSlug() && isValid;
            return isValid;
        }

        $(document).ready(function() {
            // Ambil data category menggunakan AJAX
            $.ajaxSetup({
                headers: {
                    'Authorization': "Bearer {{ $session_token }}"
                }
            });

            $.ajax({
                url: '/api/category/{{ $id_category }}',
                type: "GET",
                dataType: "json",
                success: function(result) {
                    if (result['success']) {
                        $('#name').val(result['data']['name']);
                        $('#slug').val(result['data']['slug']);
                        $('#is_active').prop('checked', result['data']['is_active']);

                        // Set note berdasarkan status aktif
                        if (result['data']['is_active']) {
                            $('#note-active').val(result['data']['note']);
                            $('#active-note-section').show();
                            $('#note-section').hide();
                        } else {
                            $('#note-inactive').val(result['data']['note']);
                            $('#note-section').show();
                            $('#active-note-section').hide();
                        }

                        // Jika kontributor, atur is_draft
                        if (result['data']['note'] === 'Draft') {
                            $('#is_draft').prop('checked', true);
                        } else {
                            $('#is_draft').prop('checked', false);
                        }
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
                        text: "Gagal mengambil data kategori.",
                        confirmButtonColor: '#3A57E8',
                    });
                }
            });

            // Toggle visibility of note fields based on is_active checkbox
            $('#is_active').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#note-section').hide();
                    $('#active-note-section').show();
                } else {
                    $('#note-section').show();
                    $('#active-note-section').hide();
                }
            });

            // Handle form submission
            $("#form-data").submit(function(event) {
                event.preventDefault();

                if (!validateForm()) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Silakan perbaiki form yang salah!",
                        confirmButtonColor: '#3A57E8',
                    });
                    return;
                }

                var formData = $("#form-data").serialize(); // Serialize the form data

                // Convert checkbox value to 1 or 0
                formData = formData.replace('is_active=on', 'is_active=1');
                if (!$('#is_active').is(':checked')) {
                    formData += '&is_active=0';
                }

                $.ajax({
                    url: '/api/category/{{ $id_category }}',
                    type: "PUT", // Gunakan method PUT untuk update
                    data: formData, // Gunakan serialized form
                    success: function(result) {
                        if (result['success']) {
                            Swal.fire({
                                icon: "success",
                                title: "Success",
                                text: result['message'],
                                confirmButtonColor: '#3A57E8',
                            }).then((result) => {
                                window.location.replace("{{ url('/admin/categories') }}");
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
                            text: "Terjadi kesalahan saat menyimpan data.",
                            confirmButtonColor: '#3A57E8',
                        });
                    }
                });
            });
        });
    </script>
@endsection
