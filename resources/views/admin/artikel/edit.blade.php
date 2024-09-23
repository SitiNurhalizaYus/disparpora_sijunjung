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
                                Artikel/Edit
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
                            @csrf
                            <input type="hidden" name="_method" value="PUT"> <!-- Simulasi metode PUT dengan POST -->
                            <input type="hidden" name="type" value="artikel">
                            <div class="form-group">
                                <label class="form-label" for="title">Judul Artikel</label>
                                <input class="form-control" type="text" id="title" name="title"
                                    value="" placeholder="Masukkan Judul Artikel" required
                                    pattern="[A-Za-z0-9\s]+$">
                                <p class="text-danger" style="display: none; font-size: 0.75rem;" id="invalid-title">Judul
                                    harus diisi dan tidak boleh ada simbol.</p>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="slug">Slug</label>
                                <input class="form-control" type="text" id="slug" name="slug"
                                    value="" placeholder="Otomatis terisi" required
                                    pattern="[A-Za-z0-9\-]+$">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="description_short">Deskripsi Singkat</label>
                                <textarea class="form-control" id="description_short" name="description_short" rows="4"
                                    placeholder="Masukkan Deskripsi Singkat" required></textarea>
                                <p class="text-danger" style="display: none; font-size: 0.75rem;"
                                    id="invalid-description_short">Deskripsi harus diisi.</p>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="category_id">Kategori</label>
                                <select class="form-select" id="category_id" name="category_id" required>
                                    <option value="" disabled>Pilih Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id_category }}"
                                            {{ $category->id_category == old('category_id', $content->category_id) ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="text-danger" style="display: none; font-size: 0.75rem;" id="invalid-category">
                                    Silahkan pilih category</p>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="content">Konten Artikel</label>
                                <textarea class="form-control" type="text" id="content" name="content" style="display: none" required></textarea>
                                <textarea class="form-control" id="description_long" name="description_long" placeholder="Masukkan konten" required></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="image">Gambar</label>
                                <input class="form-control" type="file" id="file" name="file" accept="image/jpeg,image/png,image/jpg">
                                <input class="form-control" type="hidden" id="image" name="image"
                                    value="{{ old('image', $content->image) }}">
                                <br>
                                <img src="{{ asset('/uploads/' . old('image', $content->image)) }}" id="image-preview"
                                    name="image-preview" width="300px" style="border-radius: 2%;">
                                <label class="form-label" for="photo" style="font-size: 10pt">*Format JPG, JPEG, dan
                                    PNG</label>
                                <p class="text-danger" style="display: none; font-size: 0.75rem;" id="invalid-file">
                                    Silakan unggah gambar.</p>
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
            // Ambil data artikels menggunakan AJAX
            $.ajaxSetup({
                headers: {
                    'Authorization': "Bearer {{ $session_token }}"
                }
            });

            $.ajax({
                url: '/api/content/{{ $content->id_content }}', // URL untuk mengambil data artikels
                type: "GET",
                dataType: "json",
                success: function(result) {
                    if (result['success']) {
                        // Isi data form dengan data yang diterima dari API
                        $('#title').val(result['data']['title']);
                        $('#slug').val(result['data']['slug']);
                        $('#description_short').val(result['data']['description_short']);
                        $('#description_long').val(result['data']['content']);
                        $('#content').val(result['data']['content']);
                        $('#image').val(result['data']['image']);
                        $('#image-preview').attr('src', "{{ url('/') }}/" + result['data'][
                            'image'
                        ]);
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
                        text: "Gagal mengambil data artikels.",
                        confirmButtonColor: '#3A57E8',
                    });
                }
            });
        });

        // Fungsi validasi
        function validateTitle() {
            const titleInput = $('#title');
            const titleValue = titleInput.val();
            const titlePattern = /^[A-Za-z0-9\s]+$/;
            if (!titlePattern.test(titleValue)) {
                $('#invalid-title').show();
                return false;
            } else {
                $('#invalid-title').hide();
                generateSlug(titleValue); // Generate slug automatically
                return true;
            }
        }

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

        function validateInput(inputId, errorId, condition = true) {
            if (condition && !$(`#${inputId}`).val()) {
                $(`#${errorId}`).show();
                return false;
            } else {
                $(`#${errorId}`).hide();
                return true;
            }
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

        // Generate slug dari title
        function generateSlug(title) {
            const slug = title.trim().toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
            $('#slug').val(slug);

            // Validate slug whenever it is auto-generated
            validateSlug();
        }

        // Attach real-time validation to inputs
        $('#title').on('input', function() {
            validateTitle();
        });

        $('#slug').on('input', function() {
            validateSlug();
        });

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
                ed.on('change', function(e) {
                    $('#content').val(ed.getContent());
                });
            }
        });

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

        // Validate the entire form before submission
        function validateForm() {
            let isValid = true;
            isValid = validateTitle() && isValid;
            isValid = validateSlug() && isValid;
            isValid = validateInput('description_short', 'invalid-description_short') && isValid;
            isValid = validateFile() && isValid;
            return isValid;
        }

        // Handle form submission
        $("#form-data").submit(function(event) {
            event.preventDefault();

            if (validateForm()) {
                var form = new FormData(document.getElementById("form-data"));

                // Mengubah is_active menjadi boolean (1 atau 0) sesuai dengan nilai checkbox
                form.set('is_active', $('#is_active').is(":checked") ? 1 : 0);

                // Pastikan title dan slug terkirim dengan benar
                form.set('title', $('#title').val());
                form.set('slug', $('#slug').val());

                $.ajax({
                    url: '/api/content/{{ $content->id_content }}',
                    type: "POST", // Menggunakan POST dengan _method PUT
                    data: form,
                    contentType: false, // Supaya FormData bisa bekerja dengan benar
                    processData: false, // Supaya FormData bisa bekerja dengan benar
                    success: function(result) {
                        if (result['success'] == true) {
                            Swal.fire({
                                icon: "success",
                                title: "Success",
                                text: result['message'],
                                confirmButtonColor: '#3A57E8',
                            }).then((result) => {
                                window.location.replace("{{ url('/admin/artikels') }}");
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
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let errorMessage = '';
                            Object.keys(errors).forEach(function(key) {
                                errorMessage += errors[key][0] + '\n';
                            });
                            Swal.fire({
                                icon: "error",
                                title: "Validasi Gagal",
                                text: errorMessage,
                                confirmButtonColor: '#3A57E8',
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Terjadi kesalahan saat menyimpan data.",
                                confirmButtonColor: '#3A57E8',
                            });
                        }
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
    </script>
@endsection
