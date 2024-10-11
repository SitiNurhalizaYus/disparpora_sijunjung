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
                                Kategori/Tambah
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
                                <label class="form-label" for="name">Nama Kategori</label>
                                <input class="form-control" type="text" id="name" name="name" value=""
                                    placeholder="Masukkan Nama Kategori" required pattern="[A-Za-z0-9\s]+$">
                                <p class="text-danger" style="display: none; font-size: 0.75rem;" id="invalid-name">Nama category harus diisi dan tidak boleh ada simbol.</p>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="slug">Slug</label>
                                <input class="form-control" type="text" id="slug" name="slug"
                                    placeholder="Otomatis terisi" required pattern="[A-Za-z0-9\-]+$">
                            </div>
                            @if ($session_data['user_level_id'] == 1 || $session_data['user_level_id'] == 2)
                                <!-- Admin/Editor Status Aktif -->
                                <div class="form-group">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active">
                                        <label class="form-check-label" for="is_active">Status Aktif</label>
                                    </div>
                                </div>
                            @endif
                            @if ($session_data['user_level_id'] == 3)
                                <!-- Kontributor Status Draft -->
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

        // Custom validation for name field (only letters and numbers)
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

        // Custom validation for slug field
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

                // Kondisi untuk kontributor
                @if ($session_data['user_level_id'] == 3)
                    if ($('#is_draft').is(":checked")) {
                        formdata['note'] = 'Draft'; // Set note as Draft if checked
                    } else {
                        formdata['note'] = 'Menunggu Persetujuan'; // Set note as Menunggu Persetujuan
                    }
                @else
                    // Kondisi untuk admin/editor
                    if ($('#is_active').is(":checked")) {
                        formdata['note'] = 'Diposting/Disetujui';
                    } else {
                        formdata['note'] = 'Draft';
                    }
                @endif

                $.ajaxSetup({
                    headers: {
                        'Authorization': "Bearer {{ $session_token }}"
                    }
                });
                $.ajax({
                    url: '/api/category',
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
