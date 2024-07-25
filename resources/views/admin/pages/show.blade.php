@extends('admin.layouts.app')

@section('content')
    <div class="conatiner-fluid content-inner mt-n5 py-0" style="margin-top: 100px !important;">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="flex-wrap d-flex justify-content-between align-items-center">
                            <div>
                                <div class="header-title">
                                    <h2 class="card-title">Pages</h2>
                                    <p>Detail data</p>
                                </div>
                            </div>
                            <div style="display: flex;">
                                <a href="{{ url("/admin/pages/".$id."/edit") }}" class="btn btn-sm btn-icon btn-warning flex-end" data-bs-toggle="tooltip" aria-label="Edit" data-bs-original-title="Edit">
                                    <span class="btn-inner">
                                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M11.4925 2.78906H7.75349C4.67849 2.78906 2.75049 4.96606 2.75049 8.04806V16.3621C2.75049 19.4441 4.66949 21.6211 7.75349 21.6211H16.5775C19.6625 21.6211 21.5815 19.4441 21.5815 16.3621V12.3341" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.82812 10.921L16.3011 3.44799C17.2321 2.51799 18.7411 2.51799 19.6721 3.44799L20.8891 4.66499C21.8201 5.59599 21.8201 7.10599 20.8891 8.03599L13.3801 15.545C12.9731 15.952 12.4211 16.181 11.8451 16.181H8.09912L8.19312 12.401C8.20712 11.845 8.43412 11.315 8.82812 10.921Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M15.1655 4.60254L19.7315 9.16854" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </span>
                                </a>
                                &nbsp;
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
                    <div class="card-body" id="detail-data-success" style="display: none;">
                        <div class="mt-2">
                            <h6 class="mb-1">Title</h6>
                            <p id="name"></p>
                        </div>
                        <div class="mt-2">
                            <h6 class="mb-1">Slug</h6>
                            <p id="slug"></p>
                        </div>
                        <div class="mt-2">
                            <h6 class="mb-1">Image</h6>
                            <img id="image" width="300px" style="border-radius: 2%;">
                        </div>
                        <div class="mt-2">
                            <h6 class="mb-1">Short Content</h6>
                            <p id="description_short"></p>
                        </div>
                        <div class="mt-2">
                            <h6 class="mb-1">Long Content</h6>
                            <p id="description_long"></p>
                        </div>
                        <div class="mt-2">
                            <hr style="height: 2px">
                        </div>
                        <div class="mt-2">
                            <h6 class="mb-1">Notes</h6>
                            <p id="notes"></p>&nbsp;
                        </div>
                        <div class="mt-2">
                            <h6 class="mb-1">Status Active</h6>
                            <p id="is_active"> </p>
                        </div>
                        <div class="mt-2">
                            <h6 class="mb-1">Created At</h6>
                            <p id="created_at"></p>
                        </div>
                        <div class="mt-2">
                            <h6 class="mb-1">Created By</h6>
                            <p id="created_by"></p>
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
            url: '/api/page/{{$id}}',
            type: "GET",
            dataType: "json",
            processData: false,
            success: function (result) {
                if(result['success'] == true) {
                    $("#detail-data-success").show();
                    $("#detail-data-failed").hide();

                    $('#name').html(result['data']['name']);
                    $('#slug').html(result['data']['slug']);
                    $("#image").attr("src", "{{ url('/') }}/" + result['data']['image'].replace('/xxx/', '/300/'));
                    $('#description_short').html(result['data']['description_short']);
                    $('#description_long').html(result['data']['description_long']);
                    $('#notes').html(result['data']['notes']);
                    if(result['data']['is_active'] == 1) {
                        $('#is_active').html('<span class="badge bg-success">Active</span>');
                    } else {
                        $('#is_active').html('<span class="badge bg-danger">Not Active</span>');
                    }
                    $('#created_at').html(convertStringToDate(result['data']['created_at']));
                    $('#created_by').html(result['data']['created_name']);

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
                        url: '/api/page/'+id,
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
                                    window.location.replace("{{ url('/admin/pages') }}");
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
