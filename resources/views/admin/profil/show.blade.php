@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid content-inner mt-n5 py-0" style="margin-top: 100px !important;">
        <div class="card-header mb-2 px-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="header-title">
                    <h3 class="card-title">
                        <!-- Tombol Back -->
                        <a href="{{ url('/admin/partner/') }}" class="text-decoration-none text-dark">
                            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor"
                                class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                                <path fill="black" fill-rule="evenodd"
                                    d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z" />
                            </svg>
                            Profil/Detail
                        </a>
                    </h3>
                </div>
                <div>
                    <a href="{{ url('/admin/partner/' . $id_content . '/edit') }}" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <button onclick="removeData({{ $id_content }})" class="btn btn-danger btn-sm">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <!-- Spinner saat loading -->
                    <div class="card-body text-center" id="loading-spinner">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label" for="title">Judul Profil:</label>
                            <p id="title"></p>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="slug">Slug:</label>
                            <p id="slug"></p>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="description_short">Deskripsi Singkat:</label>
                            <p id="description_short"></p>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="description_long">Konten Profil:</label>
                            <div id="description_long"></div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="image">Gambar:</label>
                            <img id="image" src="{{ asset('/uploads/noimage.jpg') }}" alt="Profil Image"
                                style="max-width:300px;">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="is_active">Status Aktif:</label>
                            <p id="is_active"></p>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="created_at">Dibuat Pada:</label>
                            <p id="created_at"></p>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="updated_at">Diperbarui Pada:</label>
                            <p id="updated_at"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Konfigurasi AJAX
            $.ajaxSetup({
                headers: {
                    'Authorization': "Bearer {{ $session_token }}"
                }
            });

            // Mendapatkan data profil dengan AJAX
            $.ajax({
                url: '/api/content/{{ $id_content }}?type=profil',
                type: 'GET',
                dataType: 'json',
                success: function(result) {
                    if (result.success) {
                        const data = result.data;
                        $('#title').text(data.title);
                        $('#slug').text(data.slug);
                        $('#description_short').text(data.description_short);
                        $('#description_long').html(data.content);
                        $('#image').attr('src', "{{ asset('/') }}" + data.image.replace('/xxx/', '/300/'));
                        $('#is_active').text(data.is_active ? 'Aktif' : 'Tidak Aktif');
                        $('#created_at').text(convertStringToDate(data.created_at));
                        $('#updated_at').text(convertStringToDate(data.updated_at));
                        $('#editButton').attr('href', '/admin/profil/' + data.id_content + '/edit');
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: result.message,
                            confirmButtonColor: '#3A57E8',
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Terjadi kesalahan saat memuat data profil.",
                        confirmButtonColor: '#3A57E8',
                    });
                }
            });
        });

        // Fungsi untuk menghapus data profil
        function removeData(id_content) {
            Swal.fire({
                title: "Kamu yakin ingin menghapus data ini?",
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: "Ya, hapus!",
                denyButtonText: "Tidak",
                confirmButtonColor: '#1AA053',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/api/content/' + id_content + '?type=profil',
                        type: 'DELETE',
                        dataType: 'json',
                        success: function(result) {
                            if (result.success) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Success",
                                    text: result.message,
                                    confirmButtonColor: '#3A57E8',
                                }).then(() => {
                                    window.location.replace("{{ url('/admin/profil') }}");
                                });
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: "Oops...",
                                    text: result.message,
                                    confirmButtonColor: '#3A57E8',
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Terjadi kesalahan saat menghapus data.",
                                confirmButtonColor: '#3A57E8',
                            });
                        }
                    });
                }
            });
        }

        function convertStringToDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString() + ' ' + date.toLocaleTimeString();
        }
    </script>
@endsection
