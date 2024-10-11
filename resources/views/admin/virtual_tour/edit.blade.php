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
                                Virtual Tour/Edit
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

                            <!-- Nama Field -->
                            <div class="form-group">
                                <label class="form-label" for="name">Nama </label>
                                <input class="form-control" type="text" id="name" name="name"
                                    placeholder="Masukkan Nama" required pattern="[A-Za-z0-9\s]+$">
                                <p class="text-danger" style="display: none; font-size: 0.75rem;" id="invalid-name">Nama
                                    harus diisi dan tidak boleh mengandung simbol.</p>
                            </div>

                            <!-- Slug Field (Auto-filled) -->
                            <div class="form-group">
                                <label class="form-label" for="slug">Slug </label>
                                <input class="form-control" type="text" id="slug" name="slug"
                                    placeholder="Slug terisi otomatis" required>
                                <p class="text-danger" style="display: none; font-size: 0.75rem;" id="invalid-slug">Slug
                                    harus diisi.</p>
                            </div>

                             <!-- Link Vr Field (Opsional) -->
                             <div class="form-group">
                                <label class="form-label" for="vr">Link Virtual Tour (jika tersedia)</label>
                                <input class="form-control" type="url" id="vr" name="vr"
                                    placeholder="Masukkan Link (Opsional)" pattern="https?://.+">
                                <p class="text-danger" style="display: none; font-size: 0.75rem;" id="invalid-vr">Format
                                    link vr tidak valid, pastikan menggunakan URL yang benar.</p>
                            </div>

                            <!-- Link Field (Opsional) -->
                            <div class="form-group">
                                <label class="form-label" for="link">Link (Opsional)</label>
                                <input class="form-control" type="url" id="link" name="link"
                                    placeholder="Masukkan Link (Opsional)" pattern="https?://.+">
                                <p class="text-danger" style="display: none; font-size: 0.75rem;" id="invalid-link">Format
                                    link tidak valid, pastikan menggunakan URL yang benar.</p>
                            </div>

                            <!-- Fasilitas Field -->
                            <div class="form-group">
                                <label class="form-label" for="facilities">Fasilitas </label>
                                <textarea class="form-control" id="facilities" name="facilities" rows="3" placeholder="Masukkan Fasilitas"
                                    required></textarea>
                                <p class="text-danger" style="display: none; font-size: 0.75rem;" id="invalid-facilities">
                                    Fasilitas harus diisi.</p>
                            </div>

                            <!-- Jam Operasional Field -->
                            <div class="form-group">
                                <label class="form-label" for="operating_hours">Jam Operasional </label>
                                <input class="form-control" type="text" id="operating_hours" name="operating_hours"
                                    placeholder="Masukkan Jam Operasional" required>
                                <p class="text-danger" style="display: none; font-size: 0.75rem;"
                                    id="invalid-operating_hours">Jam Operasional harus diisi.</p>
                            </div>

                            <!-- Harga Tiket Field -->
                            <div class="form-group">
                                <label class="form-label" for="ticket_price">Harga Tiket </label>
                                <input class="form-control" type="number" id="ticket_price" name="ticket_price"
                                    placeholder="Masukkan Harga Tiket" required>
                                <p class="text-danger" style="display: none; font-size: 0.75rem;" id="invalid-ticket_price">
                                    Harga Tiket harus diisi dengan format yang benar.</p>
                            </div>

                            <!-- Gambar Field -->
                            <div class="form-group">
                                <label class="form-label" for="image">Gambar</label>
                                <input class="form-control" type="file" id="file" name="file"
                                    accept="image/jpeg,image/png,image/jpg">
                                <input class="form-control" type="hidden" id="image" name="image">
                                <br>
                                <img id="image-preview" name="image-preview" width="300px" style="border-radius: 2%;">
                                <br><label class="form-label" for="photo" style="font-size: 10pt">*Format JPG, JPEG,
                                    dan PNG</label>
                                <p class="text-danger" style="display: none; font-size: 0.75rem;" id="invalid-picture">
                                    Silakan unggah gambar.</p>
                            </div>

                            <!-- Deskripsi Field -->
                            <div class="form-group">
                                <label class="form-label" for="description">Deskripsi</label>
                                <textarea class="form-control" type="text" id="description" name="description" style="display: none" required></textarea>
                                <textarea class="form-control" id="description_long" name="description_long" placeholder="Masukkan konten" required></textarea>
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
        // Handle validation display
        function validateInput(inputId, errorId, condition = true) {
            const input = $(`#${inputId}`);
            const value = input.val();

            if (!condition || !value) {
                $(`#${errorId}`).show();
                return false;
            } else {
                $(`#${errorId}`).hide();
                return true;
            }
        }

        // Custom validation for name field (only letters and numbers)
        function validateName() {
            const nameValue = $('#name').val();
            const namePattern = /^[A-Za-z0-9\s]+$/;
            return validateInput('name', 'invalid-name', namePattern.test(nameValue));
        }

        // Custom validation for slug field
        function validateSlug() {
            const slugValue = $('#slug').val();
            return validateInput('slug', 'invalid-slug', slugValue !== '');
        }

        // Custom validation for link field (optional)
        function validateVr() {
            const vrValue = $('#vr').val();
            const urlPattern = /^(https?:\/\/).+/;
            return vrValue ? validateInput('vr', 'invalid-vr', urlPattern.test(vrValue)) : true;
        }

        // Custom validation for link field (optional)
        function validateLink() {
            const linkValue = $('#link').val();
            const urlPattern = /^(https?:\/\/).+/;
            return linkValue ? validateInput('link', 'invalid-link', urlPattern.test(linkValue)) : true;
        }

        // Validate facilities field (now textarea)
        function validateFacilities() {
            return validateInput('facilities', 'invalid-facilities');
        }

        // Validate operating hours field
        function validateOperatingHours() {
            return validateInput('operating_hours', 'invalid-operating_hours');
        }

        // Validate ticket price field
        function validateTicketPrice() {
            const ticketPrice = $('#ticket_price').val();
            return validateInput('ticket_price', 'invalid-ticket_price', ticketPrice !== '' && ticketPrice >= 0);
        }

        // Validasi file gambar yang diunggah
        function validateFile() {
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            const file = $('#file')[0].files[0];

            if (file && !allowedTypes.includes(file.type)) {
                $('#invalid-file').show();
                $('#file').val(''); // Kosongkan input file jika tidak valid

                // Tampilkan pemberitahuan menggunakan Swal
                Swal.fire({
                    icon: 'error',
                    title: 'File tidak valid',
                    text: 'File yang diunggah harus berupa gambar (.jpg, .jpeg, .png).',
                    confirmButtonColor: '#3A57E8',
                });

                return false;
            } else {
                $('#invalid-file').hide();
                return true;
            }
        }

        //handle upload
        $('#file').change(function() {
            if (validateFile()) {
                // Preview image
                $('#image-preview').attr('display', 'block');
                var oFReader = new FileReader();
                oFReader.readAsDataURL($("#file")[0].files[0]);
                oFReader.onload = function(oFREvent) {
                    $('#image-preview').attr('src', oFREvent.target.result);
                };

                // Upload image
                var formdata = new FormData();
                if ($(this).prop('files').length > 0) {
                    var file = $(this).prop('files')[0];
                    formdata.append("file", file);
                }
                // Tampilkan loading
                Swal.fire({
                    title: 'Mengunggah...',
                    html: 'Tunggu sebentar, gambar sedang diunggah',
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
                    url: '/api/upload', // Endpoint untuk mengunggah gambar
                    type: "POST",
                    data: formdata,
                    processData: false,
                    contentType: false,
                    success: function(result) {
                        Swal.close(); // Tutup dialog loading
                        if (result['success'] == true) {
                            // Simpan path file sementara ke dalam variabel
                            $('#image').val(result['data']['url'].replace('/xxx/', '/500/'));
                            Swal.fire({
                                icon: "success",
                                title: "Berhasil",
                                text: "Gambar berhasil diunggah.",
                                timer: 2000, // Notifikasi akan ditutup otomatis setelah 2 detik
                                showConfirmButton: false, // Tidak menampilkan tombol OK
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Gagal mengunggah gambar.",
                                confirmButtonColor: '#3A57E8',
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.close(); // Tutup dialog loading
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Terjadi kesalahan saat mengunggah gambar.",
                            confirmButtonColor: '#3A57E8',
                        });

                        // Reset file input and image preview
                        $('#file').val('');
                        $('#image-preview').attr('src', '{{ asset('/uploads/noimage.jpg') }}');
                        $('#picture').val('noimage.jpg');
                    }

                });
            }
        });

        $('#description').on('input', function() {
            validateInput('description', 'invalid-description');
        });

        // Handle wysiwyg
        tinymce.init({
            selector: 'textarea#description_long',
            plugins: 'code table lists',
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image responsivefilemanager | print preview media | forecolor backcolor emoticons | codesample",
            promotion: false,
            setup: function(ed) {
                ed.on('change', function(e) {
                    $('#description').val(ed.getContent());
                });
            }
        });

        // Validate the entire form before submission
        function validateForm() {
            let isValid = true;
            isValid = validateInput('name', 'invalid-name') && isValid;
            isValid = validateInput('slug', 'invalid-slug') && isValid;
            isValid = validateInput('facilities', 'invalid-facilities') && isValid;
            isValid = validateInput('operating_hours', 'invalid-operating_hours') && isValid;
            isValid = validateInput('ticket_price', 'invalid-ticket_price') && isValid;
            return isValid;
        }

        $(document).ready(function() {
            // Ambil data virtual-tour menggunakan AJAX
            $.ajaxSetup({
                headers: {
                    'Authorization': "Bearer {{ $session_token }}"
                }
            });

            $.ajax({
                url: '/api/virtual-tour/{{ $id }}',
                type: "GET",
                dataType: "json",
                success: function(result) {
                    if (result['success']) {
                        // Isi data form dengan data yang diterima dari API
                        $('#name').val(result['data']['name']);
                        $('#slug').val(result['data']['slug']);
                        $('#vr').val(result['data']['vr']);
                        $('#link').val(result['data']['link']);
                        $('#facilities').val(result['data']['facilities']);
                        $('#operating_hours').val(result['data']['operating_hours']);
                        $('#ticket_price').val(result['data']['ticket_price']);
                        $('#description_long').val(result['data']['description']);
                        $('#description').val(result['data']['description']);
                        $('#image').val(result['data']['image']);
                        $("#image-preview").attr("src", "{{ url('/') }}/" + result['data'][
                            'image'
                        ].replace(
                            '/xxx/', '/300/'));

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
                        text: "Gagal mengambil data Virtual Tour.",
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
                
                var form = new FormData(document.getElementById("form-data"));
                
                // Mengubah is_active menjadi boolean (1 atau 0) sesuai dengan nilai checkbox
                form.set('is_active', $('#is_active').is(":checked") ? 1 : 0);
                
                // Set note sesuai dengan pilihan yang dibuat
                if ($('#is_active').is(":checked")) {
                    form.set('note', $('#note-active').val());
                } else {
                    form.set('note', $('#note-inactive').val());
                }

                // Khusus untuk kontributor
                @if ($session_data['user_level_id'] == 3)
                    if ($('#is_draft').is(":checked")) {
                        form.set('note', 'Draft');
                    } else {
                        form.set('note', 'Menunggu Persetujuan');
                    }
                @endif



                $.ajax({
                    url: '/api/virtual-tour/{{ $id }}',
                    type: "POST",
                    data: form,
                    contentType: false,
                    processData: false,
                    success: function(result) {
                        if (result['success']) {
                            Swal.fire({
                                icon: "success",
                                title: "Success",
                                text: result['message'],
                                confirmButtonColor: '#3A57E8',
                            }).then((result) => {
                                window.location.replace("{{ url('/admin/lokawisatas') }}");
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
