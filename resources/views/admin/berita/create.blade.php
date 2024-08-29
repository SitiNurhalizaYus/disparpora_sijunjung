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
                                Berita/Tambah
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
                            <input type="hidden" name="type" value="berita">
                            <div class="form-group">
                                <label class="form-label" for="title">Judul Berita</label>
                                <input class="form-control" type="text" id="title" name="title"
                                    placeholder="Masukkan Judul Berita" required pattern="[A-Za-z0-9\s]+$">
                                <p class="text-danger" style="display: none; font-size: 0.75rem;" id="invalid-title">Judul
                                    harus diisi dan tidak boleh ada simbol.</p>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="slug">Slug</label>
                                <input class="form-control" type="text" id="slug" name="slug"
                                    placeholder="Otomatis terisi" required pattern="[A-Za-z0-9\-]+$">
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
                                    <option value="" disabled selected>Pilih Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id_category }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <p class="text-danger" style="display: none; font-size: 0.75rem;" id="invalid-category">
                                    Silahkan pilih category</p>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="content">Konten Berita</label>
                                <textarea class="form-control" type="text" id="content" name="content" style="display: none" required></textarea>
                                <textarea class="form-control" id="description_long" name="description_long" placeholder="Masukkan konten" required></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="image">Gambar</label>
                                <input class="form-control" type="file" id="file" name="file" accept="image/jpeg,image/png,image/jpg" required>
                                <input class="form-control" type="hidden" id="image" name="image"
                                    value="noimage.jpg">
                                <br>
                                <img src="{{ asset('/uploads/noimage.jpg') }}" id="image-preview" name="image-preview"
                                    width="300px" style="border-radius: 2%;">
                                <label class="form-label" for="image" style="font-size: 10pt">*Format JPG,JPEG, dan
                                    PNG</label>
                                <p class="text-danger" style="display: none; font-size: 0.75rem;" id="invalid-file">
                                    Silakan unggah gambar.</p>
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
         // Handle fetching categories via AJAX
         $(document).ready(function() {
            $.ajax({
                url: '/api/category', // API endpoint untuk mengambil kategori
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    let categories = response.data || response; // Cek apakah data ada di dalam properti data atau langsung di response
                    let categoryDropdown = $('#category_id');
                    categoryDropdown.empty(); // Kosongkan dropdown sebelum mengisi ulang
                    categoryDropdown.append('<option value="" disabled selected>Pilih Kategori</option>');

                    // Loop melalui hasil dan tambahkan opsi ke dropdown
                    $.each(categories, function(index, category) {
                        categoryDropdown.append('<option value="' + category.id_category + '">' + category.name + '</option>');
                    });

                    // Jika ada validasi yang gagal sebelumnya dan nilai lama ada, set kembali nilai dropdown
                    let oldCategoryId = "{{ old('category_id') }}";
                    if (oldCategoryId) {
                        categoryDropdown.val(oldCategoryId);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching categories:', error, xhr.responseText);
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Gagal memuat kategori. Silakan coba lagi.",
                        confirmButtonColor: '#3A57E8',
                    });
                }
            });
        });

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

        // Custom validation for title field (only letters and numbers)
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

        // Generate slug from title
        function generateSlug(title) {
            const slug = title.trim().toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
            $('#slug').val(slug);
            validateSlug(); // Validate slug whenever it is auto-generated
        }

        // Validate category
        function validateKategori() {
            const category = $('#category_id');
            if (!category.val()) {
                $('#invalid-category').show();
                return false;
            } else {
                $('#invalid-category').hide();
                return true;
            }
        }

        // Attach event listener for category
        $('#category_id').on('change', function() {
            validateKategori(); // Call the validation function when a category is selected
        });

        // Validate file upload
        function validateFile() {
            const fileInput = $('#file').prop('files')[0];
            if (!fileInput) {
                $('#invalid-file').show();
                return false;
            } else {
                $('#invalid-file').hide();
                return true;
            }
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
                $('#invalid-file').show();
            } else {
                $('#invalid-file').hide();

                var oFReader = new FileReader();
                oFReader.readAsDataURL(file);
                oFReader.onload = function(oFREvent) {
                    $('#image-preview').attr('src', oFREvent.target.result);
                };

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
                            $('#image').val(result['data']['url'].replace('/xxx/', '/500/'));
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Gagal mengunggah gambar.",
                                confirmButtonColor: '#3A57E8',
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Terjadi kesalahan saat mengunggah gambar.",
                            confirmButtonColor: '#3A57E8',
                        });
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
            isValid = validateKategori() && isValid;
            isValid = validateFile() && isValid;
            return isValid;
        }

        //handle post
        $("#form-data").submit(function(event) {
            event.preventDefault();

            if (validateForm()) {
                var form = new FormData(document.getElementById("form-data"));

                // Mengubah is_active menjadi boolean (1 atau 0) sesuai dengan nilai checkbox
                form.set('is_active', $('#is_active').is(":checked") ? 1 : 0);

                // Debugging: Tampilkan semua data form ke console
                for (var pair of form.entries()) {
                    console.log(pair[0] + ', ' + pair[1]);
                }

                $.ajaxSetup({
                    headers: {
                        'Authorization': "Bearer {{ $session_token }}"
                    }
                });

                $.ajax({
                    url: '/api/content?type=berita',
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
                                title: "Success",
                                text: result['message'],
                                confirmButtonColor: '#3A57E8',
                            }).then((result) => {
                                window.location.replace("{{ url('/admin/beritas') }}");
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
    </script>
@endsection
