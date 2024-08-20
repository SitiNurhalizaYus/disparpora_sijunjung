@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid content-inner mt-n5 py-0" style="margin-top: 100px !important;">
        <div class="card-header mb-2 px-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="header-title">
                    <h3 class="card-title">
                        <!-- Tombol Back -->
                        <a href="{{ url('/admin/user/') }}" style="text-decoration: none; color: inherit;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor"
                                class="bi bi-arrow-left-short" viewBox="0 0 16 16" style="text-decoration: none;">
                                <path fill="black"
                                    fill-rule="evenodd"d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5" />
                            </svg>
                            User/Detail
                        </a>
                    </h3>
                </div>
                <div>
                    <a href="{{ url('/admin/user/' . $id . '/edit') }}" class="btn btn-warning btn-sm">
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
                    <div class="card-body" id="detail-data-success" style="display: none;">
                        <div class="mt-2">
                            <h6 class="mb-1">Peran</h6>
                            <p id="level_name"></p>
                        </div>
                        <div class="mt-2">
                            <h6 class="mb-1">Username</h6>
                            <p id="username"></p>
                        </div>
                        <div class="mt-2">
                            <h6 class="mb-1">Email</h6>
                            <p id="email"></p>
                        </div>
                        <div class="mt-2">
                            <h6 class="mb-1">Nama</h6>
                            <p id="name"></p>
                        </div>
                        <div class="mt-2">
                            <h6 class="mb-1">Foto</h6>
                            <img id="picture" width="300px" style="border-radius: 2%;">
                        </div>
                        <div class="mt-2">
                            <hr style="height: 2px">
                        </div>
                        <div class="mt-2">
                            <h6 class="mb-1">Catatan</h6>
                            <p id="notes"></p>&nbsp;
                        </div>
                        <div class="mt-2">
                            <h6 class="mb-1">Status</h6>
                            <p id="is_active"> </p>
                        </div>
                        <div class="mt-2">
                            <h6 class="mb-1">Dibuat</h6>
                            <p id="created_at"></p>
                        </div>
                    </div>
                    <div class="card-body" id="detail-data-failed" style="display: none;">
                        <p id="message"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $("#detail-data-success").hide();
        $("#detail-data-failed").hide();

        $.ajaxSetup({
            headers: {
                'Authorization': "Bearer {{ $session_token }}"
            }
        });
        $.ajax({
            url: '/api/user/{{ $id }}',
            type: "GET",
            dataType: "json",
            processData: false,
            success: function(result) {
                if (result['success'] == true) {
                    $("#detail-data-success").show();
                    $("#detail-data-failed").hide();

                    $('#level_name').html(result['data']['level_name']);
                    $('#username').html(result['data']['username']);
                    $('#email').html(result['data']['email']);
                    $('#name').html(result['data']['name']);
                    $("#picture").attr("src", "{{ url('/') }}/" + result['data']['picture'].replace(
                        '/xxx/', '/300/'));
                    $('#notes').html(result['data']['notes']);
                    if (result['data']['is_active'] == 1) {
                        $('#is_active').html('<span class="badge bg-success">Active</span>');
                    } else {
                        $('#is_active').html('<span class="badge bg-danger">Not Active</span>');
                    }
                    $('#created_at').html(convertStringToDate(result['data']['created_at']));

                } else {
                    $("#detail-data-success").hide();
                    $("#detail-data-failed").show();

                    $('#message').html(result['message']);
                }
            },
            fail: function() {
                $("#detail-data-success").hide();
                $("#detail-data-failed").show();

                $('#message').html(result['message']);
            }
        });

        function removeData(id) {
            Swal.fire({
                title: "Are you sure want to delete?",
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: "Yes",
                denyButtonText: "No",
                confirmButtonColor: '#1AA053',
            }).then((result) => {
                if (result.isConfirmed) {

                    // delete
                    $.ajaxSetup({
                        headers: {
                            'Authorization': "Bearer {{ $session_token }}"
                        }
                    });
                    $.ajax({
                        url: '/api/user/' + id,
                        type: "DELETE",
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
                                    window.location.replace("{{ url('/admin/user') }}");
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
    </script>
@endsection
