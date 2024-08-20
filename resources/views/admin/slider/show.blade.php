@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid content-inner mt-n5 py-0" style="margin-top: 100px !important;">
        <div class="card-header mb-2 px-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="header-title">
                    <h3 class="card-title">
                        <!-- Tombol Back -->
                        <a href="{{ url('/admin/slider/') }}" style="text-decoration: none; color: inherit;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor"
                                class="bi bi-arrow-left-short" viewBox="0 0 16 16" style="text-decoration: none;">
                                <path fill="black"
                                    fill-rule="evenodd"d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5" />
                            </svg>
                            Slider/Detail
                        </a>
                    </h3>
                </div>
                <div>
                    <a href="{{ url('/admin/slider/' . $id . '/edit') }}" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <button onclick="removeData({{ $id }})" class="btn btn-danger btn-sm">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <!-- Spinner saat loading -->
                    <div class="card-body" id="loading-spinner" style="text-align: center;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    
                    <!-- Konten data slider -->
                    <div class="card-body" id="detail-data-success" style="display: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mb-3">
                                    <div class="card-header bg-primary text-white">Slider Information</div>
                                    <div class="card-body">
                                        <h5 class="card-title">Name: <span id="name"></span></h5>
                                        <p class="card-text">Description: <span id="description"></span></p>
                                        <p class="card-text">Link: <a href="#" id="link"></a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card mb-3">
                                    <div class="card-header bg-secondary text-white">Additional Details</div>
                                    <div class="card-body">
                                        <p class="card-text">Notes: <span id="notes"></span></p>
                                        <p class="card-text">Status: <span id="is_active"></span></p>
                                        <p class="card-text">Created At: <span id="created_at"></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mb-3">
                                    <div class="card-header bg-dark text-white">Slider Image</div>
                                    <div class="card-body text-center">
                                        <img id="image" class="img-fluid rounded" alt="Slider Image" style="max-width: 100%;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pesan error jika gagal memuat data -->
                    <div class="card-body" id="detail-data-failed" style="display: none;">
                        <p id="message" class="text-danger"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#loading-spinner").show();
            $("#detail-data-success").hide();
            $("#detail-data-failed").hide();

            $.ajaxSetup({
                headers: {
                    'Authorization': "Bearer {{ $session_token }}"
                }
            });

            $.ajax({
                url: '/api/slider/{{ $id }}',
                type: "GET",
                dataType: "json",
                processData: false,
                success: function(result) {
                    $("#loading-spinner").hide();
                    if (result['success'] == true) {
                        $("#detail-data-success").show();
                        $("#detail-data-failed").hide();

                        $('#name').text(result['data']['name']);
                        $('#description').text(result['data']['description']);
                        $('#link').attr('href', result['data']['link']).text(result['data']['link']);
                        $("#image").attr("src", "{{ url('/') }}/" + result['data']['image'].replace('/xxx/', '/300/'));
                        $('#notes').text(result['data']['notes']);
                        if (result['data']['is_active'] == 1) {
                            $('#is_active').html('<span class="badge bg-success">Aktif</span>');
                        } else {
                            $('#is_active').html('<span class="badge bg-danger">Tidak Aktif</span>');
                        }
                        $('#created_at').text(convertStringToDate(result['data']['created_at']));
                    } else {
                        $("#detail-data-success").hide();
                        $("#detail-data-failed").show();
                        $('#message').text(result['message']);
                    }
                },
                fail: function() {
                    $("#loading-spinner").hide();
                    $("#detail-data-success").hide();
                    $("#detail-data-failed").show();
                    $('#message').text("Failed to load data.");
                }
            });
        });

        function removeData(id) {
            Swal.fire({
                title: "Kamu yakin ingin menghapus?",
                showDenyButton: true,
                confirmButtonText: "Yes",
                denyButtonText: "No",
                confirmButtonColor: '#1AA053',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            'Authorization': "Bearer {{ $session_token }}"
                        }
                    });
                    $.ajax({
                        url: '/api/slider/' + id,
                        type: "DELETE",
                        dataType: "json",
                        processData: false,
                        success: function(result) {
                            if (result['success'] == true) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Deleted",
                                    text: result['message'],
                                    confirmButtonColor: '#3A57E8',
                                }).then(() => {
                                    window.location.replace("{{ url('/admin/slider') }}");
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
                }
            });
        }

        function convertStringToDate(dateString) {
            const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
            return new Date(dateString).toLocaleDateString('id-ID', options);
        }
    </script>
@endsection
