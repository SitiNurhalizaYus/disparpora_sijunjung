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
                                Virtual Tour/Tambah
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

                            <!-- Vr Field (Opsional) -->
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
                                    accept="image/jpeg,image/png,image/jpg" required>
                                <input class="form-control" type="hidden" id="image" name="image"
                                    value="noimage.jpg" placeholder="image">
                                <br>
                                <img src="{{ asset('/uploads/noimage.jpg') }}" id="image-preview" name="image-preview"
                                    width="300px" style="border-radius: 2%;">
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

        // Validate file upload
        function validateFile() {
            return validateInput('file', 'invalid-picture', $('#file').prop('files').length > 0);
        }

        // Attach real-time validation to inputs
        $('#name').on('input', function() {
            validateName();
            generateSlug(); // Automatically generate slug when name is input
        });
        $('#slug').on('input', validateSlug);
        $('#vr').on('input', validateVr);
        $('#link').on('input', validateLink);
        $('#facilities').on('input', validateFacilities);
        $('#operating_hours').on('input', validateOperatingHours);
        $('#ticket_price').on('input', validateTicketPrice);
        $('#file').on('change', validateFile);

        $('#description_short').on('input', function() {
            validateInput('description_short', 'invalid-description_short');
        });

        // Handle wysiwyg
        tinymce.init({
            selector: 'textarea#description_long',
            plugins: 'code table lists',
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image responsivefilemanager | print preview media | forecolor backcolor emoticons | codesample",
            promotion: false,
            setup: function(ed) {
                ed.on('change', function() {
                    $('#description').val(ed.getContent());
                });
            }
        });

        // Generate slug based on the name input
        function generateSlug() {
            const nameValue = $('#name').val();
            const slugValue = nameValue
                .toLowerCase()
                .replace(/[^\w\s-]/g, '') // Remove invalid characters
                .replace(/\s+/g, '-') // Replace spaces with hyphens
                .replace(/-+/g, '-'); // Replace multiple hyphens with a single one

            $('#slug').val(slugValue);
        }

        //handle upload
        let uploadedFilePath = ''; // Variable untuk menyimpan path file sementara
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
                $('#image').val('noimage.jpg');
                $('#invalid-picture').show();
            } else {
                $('#invalid-picture').hide();

                var oFReader = new FileReader();
                oFReader.readAsDataURL(file);
                oFReader.onload = function(oFREvent) {
                    $('#image-preview').attr('src', oFREvent.target.result);
                };

                var formdata = new FormData();
                formdata.append("file", file);

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
                            uploadedFilePath = result['data']['url'].replace('/xxx/', '/500/');
                            Swal.fire({
                                icon: "success",
                                title: "Berhasil",
                                text: "Gambar berhasil diunggah. Tekan tombol Simpan untuk menyimpan semua data.",
                                confirmButtonColor: '#3A57E8',
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

                        if (xhr.responseJSON && xhr.responseJSON.message.includes('Duplicate entry')) {
                            Swal.fire({
                                icon: "error",
                                title: "Gagal Mengunggah",
                                text: "Nama file gambar sudah ada. Ganti nama file atau unggah file yang berbeda.",
                                confirmButtonColor: '#3A57E8',
                            });

                            // Reset file input and image preview
                            $('#file').val('');
                            $('#image-preview').attr('src', '{{ asset('/uploads/noimage.jpg') }}');
                            $('#image').val('noimage.jpg');
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Terjadi kesalahan saat mengunggah gambar.",
                                confirmButtonColor: '#3A57E8',
                            });

                            // Reset file input and image preview
                            $('#file').val('');
                            $('#image-preview').attr('src', '{{ asset('/uploads/noimage.jpg') }}');
                            $('#image').val('noimage.jpg');
                        }
                    }
                });
            }
        });


        // Handle form submission
        $("#form-data").submit(function(event) {
            event.preventDefault();
            tinymce.triggerSave(); // Pastikan TinyMCE menyimpan kontennya

            // Set deskripsi dari editor TinyMCE
            $('#description').val(tinymce.get('description_long').getContent());

            // Validasi seluruh form sebelum mengirim data
            if (validateForm()) {
                var form = new FormData(document.getElementById("form-data"));

                // Kondisi untuk kontributor
                @if ($session_data['user_level_id'] == 3)
                    if ($('#is_draft').is(":checked")) {
                        form.set('note', 'Draft'); // Set note as Draft if checked
                    } else {
                        form.set('note', 'Menunggu Persetujuan'); // Set note as Menunggu Persetujuan
                    }
                @else
                    // Kondisi untuk admin/editor
                    form.set('is_active', $('#is_active').is(":checked") ? 1 : 0);
                    if ($('#is_active').is(":checked")) {
                        form.set('note', 'Diposting/Disetujui');
                    } else {
                        form.set('note', 'Draft');
                    }
                @endif

                // Mengubah is_active menjadi boolean (1 atau 0) sesuai dengan nilai checkbox
                form.set('is_active', $('#is_active').is(":checked") ? 1 : 0);

                // Sertakan path gambar yang telah diunggah
                if (uploadedFilePath !== '') {
                    form.set('image', uploadedFilePath);
                } else {
                    form.set('image', 'noimage.jpg'); // Atur gambar default jika tidak ada
                }

                $.ajaxSetup({
                    headers: {
                        'Authorization': "Bearer {{ $session_token }}",
                    }
                });

                $.ajax({
                    url: '/api/virtual_tour', // URL endpoint untuk menyimpan data
                    type: "POST",
                    data: form,
                    contentType: false, // Supaya FormData bisa bekerja dengan benar
                    processData: false, // Supaya FormData bisa bekerja dengan benar
                    success: function(result) {
                        // Debugging: Periksa respons dari server
                        console.log(result);

                        if (result['success'] == true) {
                            Swal.fire({
                                icon: "success",
                                title: "Sukses",
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
                        // Debugging: Periksa kesalahan dari server
                        console.error(xhr);
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
                // Jika validasi gagal, tampilkan pesan kesalahan dan jangan kirim form
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Anda harus melengkapi seluruh form dengan benar.",
                    confirmButtonColor: '#3A57E8',
                });
            }
            return false; // Menghentikan submit jika validasi gagal
        });


        // Validate the entire form before submission
        function validateForm() {
            let isValid = true;
            isValid = validateName() && isValid;
            isValid = validateSlug() && isValid;
            isValid = validateVr() && isValid;
            isValid = validateLink() && isValid;
            isValid = validateFacilities() && isValid;
            isValid = validateOperatingHours() && isValid;
            isValid = validateTicketPrice() && isValid;
            isValid = validateFile() && isValid;
            return isValid;
        }
    </script>
@endsection
