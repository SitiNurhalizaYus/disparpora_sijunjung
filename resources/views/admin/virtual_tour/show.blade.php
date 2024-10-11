@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid content-inner mt-n5 py-0" style="margin-top: 100px !important;">
        <div class="card-header mb-2 px-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="header-title">
                    <h3 class="card-title">
                        <!-- Tombol Back -->
                        <a href="{{ url('/admin/lokawisatas/') }}" class="text-decoration-none text-dark">
                            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor"
                                class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                                <path fill="black" fill-rule="evenodd"
                                    d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 0 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z" />
                            </svg>
                            Virtual Tour/Detail
                        </a>
                    </h3>
                </div>
                <div>
                    <a href="{{ url('/admin/lokawisatas/' . $id . '/edit') }}" class="btn btn-warning btn-sm">
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
                    <div class="card-body text-center" id="loading-spinner">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>

                    <!-- Konten data lokawisatas -->
                    <div class="card-body" id="detail-data-success" style="display: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mb-3" style="box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);">
                                    <div class="card-header bg-info text-white"><strong>Informasi Virtual Tour</strong></div>
                                    <div class="card-body">
                                        <h4 class="card-title"><span id="name"></span></h4>
                                        <p class="card-text">
                                        <h6>Virtual Tour: </h6><a href="#" id="vr"></a></p>
                                        <p class="card-text">
                                        <h6>Link: </h6><a href="#" id="link"></a></p>
                                        <p class="card-text">
                                        <h6>Fasilitas: </h6><span id="facilities"></span></p>
                                        <p class="card-text">
                                        <h6>Jam Operasi: </h6><span id="operating_hours"></span></p>
                                        <p class="card-text">
                                        <h6>Harga Tiket: </h6><span id="ticket_price"></span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card mb-3" style="box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);">
                                    <div class="card-header bg-secondary text-white"><strong>Detail Tambahan</strong></div>
                                    <div class="card-body">
                                        <p class="card-text">
                                        <h6>Status: </h6><span id="is_active"></span> <span class="badge bg-black"
                                            id="note"></span></p>
                                        <p class="card-text">
                                        <h6>Dibuat: </h6><span id="created_by"></span><br><span id="created_at"></span></p>
                                        <p class="card-text">
                                        <h6>Diperbarui: </h6><span id="updated_by"></span><br><span id="updated_at"></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mb-3" style="box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);">
                                    <div class="card-header bg-dark text-white text-center"><strong>Gambar</strong></div>
                                    <div class="card-body text-center">
                                        <img id="image" class="img-fluid rounded" alt="Virtual Tour Image"
                                            style="max-width: 100%;">
                                    </div>
                                </div>
                                <div class="card mb-3" style="box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);">
                                    <div class="card-header bg-gray text-white text-center"><strong>Deskripsi</strong>
                                    </div>
                                    <div class="card-body">
                                        <div id="description_long" style="color: black;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pesan error jika gagal memuat data -->
                    <div class="card-body text-center" id="detail-data-failed" style="display: none;">
                        <p id="message" class="text-danger"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fungsi untuk memformat harga ke format rupiah
        function formatRupiah(angka) {
            var number_string = angka.toString().replace(/[^,\d]/g, ''),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            return 'Rp. ' + rupiah;
        }
        $(document).ready(function() {
            // Tampilkan spinner saat loading data
            $("#loading-spinner").show();
            $("#detail-data-success").hide();
            $("#detail-data-failed").hide();

            $.ajaxSetup({
                headers: {
                    'Authorization': "Bearer {{ $session_token }}"
                }
            });

            // Request untuk mendapatkan data lokawisatas
            $.ajax({
                url: '/api/virtual-tour/{{ $id }}',
                type: "GET",
                dataType: "json",
                processData: false,
                success: function(result) {
                    // Sembunyikan spinner
                    $("#loading-spinner").hide();

                    if (result['success']) {
                        // Tampilkan data jika berhasil memuat
                        $("#detail-data-success").show();
                        $("#detail-data-failed").hide();

                        $('#name').text(result['data']['name']);
                        $('#vr').attr('href', result['data']['vr']).text(result['data']['vr']);
                        $('#link').attr('href', result['data']['link']).text(result['data']['link']);
                        $("#image").attr("src", "{{ url('/') }}/" + result['data']['image']
                            .replace('/xxx/', '/300/'));
                        $('#description_long').html(result['data']['description']);
                        $('#facilities').text(result['data']['facilities']);
                        $('#operating_hours').text(result['data']['operating_hours']);
                        // Format harga tiket ke format rupiah
                        $('#ticket_price').text(formatRupiah(result['data']['ticket_price']));
                        $('#is_active').html(result['data']['is_active'] == 1 ?
                            '<span class="badge bg-success">Aktif</span>' :
                            '<span class="badge bg-danger">Tidak Aktif</span>');
                        $('#note').html(result['data']['note']);
                        $('#created_at').text(convertStringToDate(result['data']['created_at']));
                        $('#created_by').text(result['data']['created_by']['name']);
                        $('#updated_at').text(convertStringToDate(result['data']['updated_at']));
                        $('#updated_by').text(result['data']['updated_by']['name']);
                    } else {
                        // Tampilkan pesan error jika gagal memuat data
                        $("#detail-data-success").hide();
                        $("#detail-data-failed").show();
                        $('#message').text(result['message']);
                    }
                },
                fail: function() {
                    // Tampilkan pesan error jika terjadi kegagalan saat memuat data
                    $("#loading-spinner").hide();
                    $("#detail-data-success").hide();
                    $("#detail-data-failed").show();
                    $('#message').text("Failed to load data.");
                }
            });
        });

        // Fungsi untuk menghapus data
        function removeData(id) {
            Swal.fire({
                title: "Kamu yakin ingin menghapus?",
                showDenyButton: true,
                confirmButtonText: "Yes",
                denyButtonText: "No",
                confirmButtonColor: '#1AA053',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Request untuk menghapus data lokawisatas
                    $.ajaxSetup({
                        headers: {
                            'Authorization': "Bearer {{ $session_token }}"
                        }
                    });
                    $.ajax({
                        url: '/api/virtual-tour/' + id,
                        type: "DELETE",
                        dataType: "json",
                        processData: false,
                        success: function(result) {
                            if (result['success']) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Deleted",
                                    text: result['message'],
                                    confirmButtonColor: '#3A57E8',
                                }).then(() => {
                                    window.location.replace("{{ url('/admin/lokawisatas') }}");
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

        // Fungsi untuk mengonversi string tanggal menjadi format yang lebih ramah
        function convertStringToDate(dateString) {
            const options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            };
            return new Date(dateString).toLocaleDateString('id-ID', options);
        }
    </script>
@endsection
