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
                                    <h2 class="card-title">Message</h2>
                                    <p>List data</p>
                                </div>
                            </div>
                            <div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <br>
                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped" data-toggle="data-table">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Subject</th>
                                        <th>Created At</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#datatable').DataTable( {
            order: [[ 0, 'asc' ]],
            lengthMenu: [[ 5, 15, 25, 100, -1 ], [ 5, 15, 25, 100, 'All' ]],
            pageLength: 5,
            processing: true,
            serverSide: true,
            autoWidth: false,
            scrollX: true,
            ajax: function(data, callback, settings) {
                var sort_col_id = data.order[0].column;
                var sort_col_order = data.order[0].dir;
                var sort_col_name = data.columns[data.order[0].column].data;
                $.ajaxSetup({
                    headers:{
                        'Authorization': "Bearer {{$session_token}}"
                    }
                });
                $.get('/api/message', {
                    per_page: data.length,
                    page: (data.start / data.length) + 1,
                    sort: sort_col_name + ':' + sort_col_order,
                    search: data.search.value
                },
                function(json) {
                    callback({
                        recordsTotal: json.metadata.total_data,
                        recordsFiltered: json.metadata.total_data,
                        data: json.data
                    });
                });
            },
            columns: [
                {
                    data: 'id'
                },
                {
                    data: 'name',
                    render: function (data, type, row, meta) {
                        return '<span style="white-space: normal;">' + data + '</span>';
                    }
                },
                {
                    data: 'email',
                    render: function (data, type, row, meta) {
                        return '<span style="white-space: normal;">' + data + '</span>';
                    }
                },
                {
                    data: 'subject',
                    render: function (data, type, row, meta) {
                        return '<span style="white-space: normal;">' + data + '</span>';
                    }
                },
                {
                    data: 'created_at',
                    render: function (data, type, row, meta) {
                        return '<span style="white-space: normal;">' + convertStringToDate(data) + '</span>';
                    }
                },
                {
                    data: 'is_active',
                    render: function (data, type, row, meta) {
                        if(data == '1') {
                            return '<span class="badge bg-success">Active</span>';
                        } else {
                            return '<span class="badge bg-danger">Not Active</span>';
                        }
                    }
                },
                {
                    data: 'id',
                    render: function (data, type, row, meta) {
                        var btn_detail = `
                            <a href="{{ url("/admin/message/`+data+`") }}" class="btn btn-sm btn-icon btn-info flex-end" data-bs-toggle="tooltip" aria-label="Detail" data-bs-original-title="Detail">
                                <span class="btn-inner">
                                    <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="11.7669" cy="11.7666" r="8.98856" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></circle>                                    <path d="M18.0186 18.4851L21.5426 22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </span>
                            </a>`;
                        var btn_delete = `
                            <button onclick="removeData(`+data+`)" class="btn btn-sm btn-icon btn-danger flex-end" data-bs-toggle="tooltip" aria-label="Delete" data-bs-original-title="Delete">
                                <span class="btn-inner">
                                    <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
                                        <path d="M19.3248 9.46826C19.3248 9.46826 18.7818 16.2033 18.4668 19.0403C18.3168 20.3953 17.4798 21.1893 16.1088 21.2143C13.4998 21.2613 10.8878 21.2643 8.27979 21.2093C6.96079 21.1823 6.13779 20.3783 5.99079 19.0473C5.67379 16.1853 5.13379 9.46826 5.13379 9.46826" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M20.708 6.23975H3.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M17.4406 6.23973C16.6556 6.23973 15.9796 5.68473 15.8256 4.91573L15.5826 3.69973C15.4326 3.13873 14.9246 2.75073 14.3456 2.75073H10.1126C9.53358 2.75073 9.02558 3.13873 8.87558 3.69973L8.63258 4.91573C8.47858 5.68473 7.80258 6.23973 7.01758 6.23973" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </span>
                            </button>`;
                        return '<div style="display: flex;">'+btn_detail+'&nbsp;'+btn_delete+'</div>';
                    }
                }
            ],
            columnDefs: [
                {targets: [0], width: "5%"},
                {targets: [1], width: "15%"},
                {targets: [1], width: "15%"},
                {targets: [2], width: "30%"},
                {targets: [3], width: "20%"},
                {targets: [4], width: "20%"},
                {targets: [5], width: "10%", orderable: false}
            ],
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
