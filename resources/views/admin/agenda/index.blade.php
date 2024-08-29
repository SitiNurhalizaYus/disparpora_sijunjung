@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid content-inner mt-n5 py-0" style="margin-top: 100px !important;">
        <div class="card-header mb-2 px-3">
            <div class="flex-wrap d-flex justify-content-between align-items-center">
                <div>
                    <div class="header-title">
                        <h2 class="card-title">Agenda List</h2>
                        <p>List data artikels</p>
                    </div>
                </div>
                <div>
                    <a href="{{ url('/admin/agendas/create') }}" class="btn btn-md btn-primary">ADD+</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <br>
                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped" data-toggle="data-table">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Judul</th>
                                        <th class="text-center">Tanggal Acara</th>
                                        <th class="text-center">Penyelenggara</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
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
        $('#datatable').DataTable({
            order: [
                [0, 'asc'] // Pastikan pengurutan berdasarkan kolom pertama secara default
            ],
            lengthMenu: [
                [5, 15, 25, 100, -1],
                [5, 15, 25, 100, 'All']
            ],
            pageLength: 5,
            processing: true,
            serverSide: true,
            autoWidth: false,
            scrollX: true,
            ajax: function(data, callback, settings) {
                var sort_col_index = data.order[0].column;
                var sort_col_order = data.order[0].dir;
                var sort_col_name = data.columns[sort_col_index].data;

                // Pastikan sort_col_name valid
                if (!sort_col_name || sort_col_name === null) {
                    sort_col_name = 'id'; // Set kolom default untuk pengurutan jika tidak valid
                }

                $.ajaxSetup({
                    headers: {
                        'Authorization': "Bearer {{ $session_token }}"
                    }
                });

                $.get('/api/agenda', {
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
                    }).fail(function(xhr, status, error) {
                    console.log(xhr.responseText); // Debugging response
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Terjadi kesalahan saat memuat data.",
                        confirmButtonColor: '#3A57E8',
                    });
                });
            },
            columns: [{
                    data: null, // Kolom urutan nomor
                    className: 'text-center',
                    render: function(data, type, row, meta) {
                        return meta.row + 1; // Nomor urut
                    }
                },
                {
                    data: 'title',
                    render: function(data) {
                        return '<span style="white-space: normal;">' + data + '</span>';
                    }
                },
                {
                    data: 'event_date',
                    className: 'text-center',
                    render: function(data) {
                        return '<span style="white-space: normal;">' + convertStringToDate(
                            data) + '</span>';
                    }
                },
                {
                    data: 'organizer',
                    className: 'text-center',
                    render: function(data) {
                        return '<span style="white-space: normal;">' + data + '</span>';
                    }
                },
                {
                    data: 'is_active',
                    className: 'text-center',
                    render: function(data, type, row, meta) {
                        return data == 1 ? '<span class="badge bg-success">Aktif</span>' :
                            '<span class="badge bg-danger">Tidak Aktif</span>';
                    }
                },
                {
                    data: 'id',
                    render: function(data, type, row, meta) {
                        var btn_detail = `
                            <a href="{{ url('/admin/agendas/`+data+`') }}" class="btn btn-sm btn-icon btn-info" data-bs-toggle="tooltip" aria-label="Detail" data-bs-original-title="Detail">
                                <span class="btn-inner">
                                    <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="11.7669" cy="11.7666" r="8.98856" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></circle>
                                        <path d="M18.0186 18.4851L21.5426 22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </span>
                            </a>`;
                        var btn_edit = `
                            <a href="{{ url('/admin/agendas/`+data+`/edit') }}" class="btn btn-sm btn-icon btn-warning" data-bs-toggle="tooltip" aria-label="Edit" data-bs-original-title="Edit">
                                <span class="btn-inner">
                                    <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11.4925 2.78906H7.75349C4.67849 2.78906 2.75049 4.96606 2.75049 8.04806V16.3621C2.75049 19.4441 4.66949 21.6211 7.75349 21.6211H16.5775C19.6625 21.6211 21.5815 19.4441 21.5815 16.3621V12.3341" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.82812 10.921L16.3011 3.44799C17.2321 2.51799 18.7411 2.51799 19.6721 3.44799L20.8891 4.66499C21.8201 5.59599 21.8201 7.10599 20.8891 8.03599L13.3801 15.545C12.9731 15.952 12.4211 16.181 11.8451 16.181H8.09912L8.19312 12.401C8.20712 11.845 8.43412 11.315 8.82812 10.921Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M15.1655 4.60254L19.7315 9.16854" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </span>
                            </a>`;
                        var btn_delete = `
                            <button onclick="removeData(` + data + `)" class="btn btn-sm btn-icon btn-danger" data-bs-toggle="tooltip" aria-label="Delete" data-bs-original-title="Delete">
                                <span class="btn-inner">
                                    <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
                                        <path d="M19.3248 9.46826C19.3248 9.46826 18.7818 16.2033 18.4668 19.0403C18.3168 20.3953 17.4798 21.1893 16.1088 21.2143C13.4998 21.2613 10.8878 21.2643 8.27979 21.2093C6.96079 21.1823 6.13779 20.3783 5.99079 19.0473C5.67379 16.1853 5.13379 9.46826 5.13379 9.46826" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M20.708 6.23975H3.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M17.4406 6.23973C16.6556 6.23973 15.9796 5.68473 15.8256 4.91573L15.5826 3.69973C15.4326 3.13873 14.9246 2.75073 14.3456 2.75073H10.1126C9.53358 2.75073 9.02558 3.13873 8.87558 3.69973L8.63258 4.91573C8.47858 5.68473 7.80258 6.23973 7.01758 6.23973" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </span>
                            </button>`;
                        return '<div style="display: flex;">' + btn_detail + '&nbsp;' +
                            btn_edit + '&nbsp;' + btn_delete + '</div>';
                    }
                }
            ],
            columnDefs: [{
                    targets: [0],
                    width: "5%"
                },
                {
                    targets: [1],
                    width: "20%"
                },
                {
                    targets: [2],
                    width: "15%"
                },
                {
                    targets: [3],
                    width: "20%"
                },
                {
                    targets: [4],
                    width: "10%"
                },
                {
                    targets: [5],
                    width: "5%",
                    orderable: false
                }
            ]
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
                        url: '/api/agenda/' + id,
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
                                }).then(() => {
                                    window.location.reload();
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
