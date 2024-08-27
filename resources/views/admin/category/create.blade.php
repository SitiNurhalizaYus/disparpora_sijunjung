@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid content-inner mt-n5 py-0" style="margin-top: 100px !important;">
        <div class="card-header mb-3">
            <div class="flex-wrap d-flex justify-content-between align-items-center">
                <div class="header-title">
                    <h3 class="card-title">
                        <!-- Tombol Back -->
                        <a href="{{ URL::previous() }}" style="text-decoration: none; color: inherit;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor"
                                class="bi bi-arrow-left-short" viewBox="0 0 16 16" style="text-decoration: none;">
                                <path fill="black"
                                    fill-rule="evenodd"d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5" />
                            </svg>
                            Portofolio/Kategori - Tambah
                        </a>
                    </h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" class="needs-validation" id="form-data" name="form-data" novalidate>
                            {{ csrf_field() }}
                            {{-- @method('PUT') --}}
                            <div class="form-group">
                                <label class="form-label" for="name">Input Kategori Layanan</label>
                                <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" name="name" value=""
                                    placeholder="Masukan Kategori Layanan" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                    <div class="invalid-feedback">Silahkan masukan kategori, maksimal 100 karakter</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="active_status" name="active_status">
                                    <label class="form-check-label" for="active_status">Status Aktif</label>
                                </div>
                            </div>
                            <br><br>
                            <a href="{{ URL::previous() }}" class="btn btn-danger">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        document.getElementById('name').addEventListener('input', function() {
            var words = this.value.trim().split(/\s+/).length;
            if (words > 100) {
                document.getElementById('name-error').style.display = 'block';
                this.setCustomValidity('');
            } else {
                document.getElementById('name-error').style.display = 'none';
                this.setCustomValidity('');
            }
        });

        // handle post
        $('#form-data').submit(false);
        $("#form-data").submit(function() {

            if ($(this).valid()) {
                var form = $("#form-data").serializeArray();
                var formdata = {};
                $.map(form, function(n, i) {
                    formdata[n['name']] = n['value'];
                });
                // formdata['posting_date'] = convertStringToDate(formdata['posting_date']);
                console.log('Data to be Sent:', formdata);
                if ('active_status' in formdata) {
                    if (formdata['active_status'] == 'on') {
                        formdata['active_status'] = true;
                    } else {
                        formdata['active_status'] = false;
                    }
                } else {
                    formdata['active_status'] = false;
                }

                $.ajaxSetup({
                    headers: {
                        'Authorization': "Bearer {{ $session_token }}"
                    }
                });
                $.ajax({
                    url: '/api/project_category',
                    type: "POST",
                    data: JSON.stringify(formdata),
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
                                window.location.replace("{{ url('/admin/projectcategory') }}");
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
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "You must complete the entire form.",
                    confirmButtonColor: '#3A57E8',
                });
            }
            return false;
        });
    </script>
@endsection
