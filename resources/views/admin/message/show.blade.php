@extends('admin.layouts.app')

@section('content')
    <div class="conatiner-fluid content-inner mt-n5 py-0" style="margin-top: 100px !important;">
        <div class="card-header mb-2 px-3">
            <div class="flex-wrap d-flex justify-content-between align-items-center">
                <div>
                    <div class="header-title">
                        <h2 class="card-title">
                            <!-- Tombol Back -->
                            <a href="{{ url('/admin/message/') }}" style="text-decoration: none; color: inherit;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                                    fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16"
                                    style="text-decoration: none;">
                                    <path fill="black"
                                        fill-rule="evenodd"d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5" />
                                </svg>
                                Pesan - Detail
                            </a>
                        </h2>
                    </div>
                </div>
                <div style="display: flex;">
                    <button onclick="removeData({{$id}})" class="btn btn-sm btn-icon btn-danger flex-end" data-bs-toggle="tooltip" aria-label="Delete" data-bs-original-title="Delete">
                        <span class="btn-inner">
                            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
                                <path d="M19.3248 9.46826C19.3248 9.46826 18.7818 16.2033 18.4668 19.0403C18.3168 20.3953 17.4798 21.1893 16.1088 21.2143C13.4998 21.2613 10.8878 21.2643 8.27979 21.2093C6.96079 21.1823 6.13779 20.3783 5.99079 19.0473C5.67379 16.1853 5.13379 9.46826 5.13379 9.46826" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M20.708 6.23975H3.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M17.4406 6.23973C16.6556 6.23973 15.9796 5.68473 15.8256 4.91573L15.5826 3.69973C15.4326 3.13873 14.9246 2.75073 14.3456 2.75073H10.1126C9.53358 2.75073 9.02558 3.13873 8.87558 3.69973L8.63258 4.91573C8.47858 5.68473 7.80258 6.23973 7.01758 6.23973" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </span>
                    </button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body" id="detail-data-success" style="display: none;">
                        <div class="mt-2">
                            <h6 class="mb-1">Nama</h6>
                            <p id="name"></p>
                        </div>
                        <div class="mt-2">
                            <h6 class="mb-1">Nomor Whatsapp</h6>
                            <p id="whatsapp_number"></p>
                        </div>
                        <div class="mt-2">
                            <h6 class="mb-1">Email</h6>
                            <p id="email"></p>
                        </div>
                        <div class="mt-2">
                            <h6 class="mb-1">Pesan</h6>
                            <p id="message"></p>
                        </div>
                        <div class="mt-2">
                            <h6 class="mb-1">Created At</h6>
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
            headers:{
                'Authorization': "Bearer {{$session_token}}"
            }
        });
        $.ajax({
            url: '/api/message/{{$id}}',
            type: "GET",
            dataType: "json",
            processData: false,
            success: function (result) {
                if(result['success'] == true) {
                    $("#detail-data-success").show();
                    $("#detail-data-failed").hide();

                    $('#name').html(result['data']['name']);
                    $('#whatsapp_number').html(result['data']['whatsapp_number']);
                    $('#email').html(result['data']['email']);
                    $('#message').html(result['data']['message']);
                    $('#created_at').html(convertStringToDate(result['data']['created_at']));

                } else {
                    $("#detail-data-success").hide();
                    $("#detail-data-failed").show();

                    $('#message').html(result['message']);
                }
            },
            fail: function () {
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
                        headers:{
                            'Authorization': "Bearer {{$session_token}}"
                        }
                    });
                    $.ajax({
                        url: '/api/message/'+id,
                        type: "DELETE",
                        contentType: "application/json; charset=utf-8",
                        dataType: "json",
                        processData: false,
                        success: function (result) {
                            if(result['success'] == true) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Success",
                                    text: result['message'],
                                    confirmButtonColor: '#3A57E8',
                                }).then((result) => {
                                    window.location.replace("{{ url('/admin/message') }}");
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
