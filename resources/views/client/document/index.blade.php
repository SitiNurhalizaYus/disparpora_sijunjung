@extends('client.layouts.app')

@section('content')
    <div class="container-fluid position-relative p-0">
        <!-- Header dengan logo dan nama -->
        <div class="container-fluid bg-primary py-5 bg-header">
            <div class="row py-5">
                <div class="col-12 pt-lg-5 mt-lg-5 text-center">
                    <img src="{{ asset('/' . str_replace('/xxx/', '/100/', $setting['logo-parpora'])) }}" alt="Logo"
                        class="logo">
                    <div class="logo-text">
                        <h3 class="text-light">{{ $setting['name-long'] }}</h3>
                        <p>Kabupaten Sijunjung</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Breadcrumbs -->
        <div class="container-fluid bg-primary py-3 bg-light">
            <div class="text-star px-5">
                <a href="{{ url('/beranda') }}" class="text-green">Beranda</a>
                <i class="bi bi-arrow-right-short text-green px-2"></i>
                <span class="text-green">Dokumen</span>
            </div>
        </div>



        <!-- Blog Start -->
        <div class="mb-5" id="about"
            style="justify-content: center; align-items: center; width: 75%; margin: 0 auto; margin-top: 50px;">
            <div class="justify-content-between align-items-center container-table mt-5">
                <table id="datatable" class="table table-striped" data-toggle="data-table" style="margin-bottom: 0px;">
                    <thead>
                        <tr class="text-black">
                            <th class="">No</th>
                            <th class="">Nama Dokumen</th>
                            <th class="">Kategori</th>
                            <th colspan="2" class="">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Blog End -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="{{ asset('assets/js/core/libs.min.js') }}"></script>
        <script>
            $('#datatable').DataTable({
                order: [
                    [0, 'asc']
                ],
                pageLength: 10,
                processing: true,
                serverSide: true,
                autoWidth: false,
                scrollX: true,
                lengthChange: false,
                dom: 'lrtp',
                info: false,
                ajax: function(data, callback, settings) {
                    var sort_col_id = data.order[0].column;
                    var sort_col_order = data.order[0].dir;
                    var sort_col_name = data.columns[data.order[0].column].data;
                    $.ajaxSetup({
                        headers: {}
                    });
                    $.get('/api/document', {
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
                columns: [{
                        data: 'id',
                        render: function(data, type, row, meta) {
                            return '<span style="white-space: normal;">' + data + '</span>';
                        }
                    },
                    {
                        data: 'title',
                        render: function(data, type, row, meta) {
                            return '<span style="white-space: normal;">' + data + '</span>';
                        }
                    },
                    {
                        data: 'category',
                        render: function(data, type, row, meta) {
                            return '<span style="white-space: normal;">' + data + '</span>';
                        }
                    },
                    {
                        data: 'file_path',
                        render: function(data, type, row, meta) {
                            return '<a href="' + data + '" class="btn btn-primary btn-sm">Unduh</a>';
                        },
                        orderable: false
                    }
                ],
                columnDefs: [{
                        targets: [0],
                        width: "10%"
                    },
                    {
                        targets: [1],
                        width: "50%"
                    },
                    {
                        targets: [2],
                        width: "30%",
                        orderable: false
                    },
                    {
                        targets: [3],
                        width: "10%",
                        orderable: false
                    }
                ],
            });
        </script>
    @endsection
