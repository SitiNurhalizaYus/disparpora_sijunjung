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
                                    <h2 class="card-title">User</h2>
                                    <p>Create data</p>
                                </div>
                            </div>
                            <div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" class="needs-validation" id="form-data" name="form-data"
                            enctype="multipart/form-data" novalidate>
                            {{ csrf_field() }}
                            {{-- @method('PUT') --}}
                            <div class="form-group">
                                <label class="form-label" for="role_id">Role</label>
                                <select class="form-control" id="role_id" name="role_id" required>
                                    <option value="" disabled selected>Pilih role</option>
                                    <option value="1">Administrator</option>
                                    <option value="2">Pengelola Objek Wisata</option>
                                    <option value="3">Pengelola Penginapan</option>
                                    <option value="4">Pengelola Restoran</option>
                                </select>
                                <p class="text-danger" id="invalid-role_id" style="display: none;font-size: 0.75rem;">Silahkan Pilih Role</p>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="nik">NIK</label>
                                <input class="form-control" type="text" id="nik" name="nik"
                                    placeholder="Enter NIK" required>
                                    <p class="text-danger" id="invalid-value-nik" style="display: none;font-size: 0.75rem;">Silahkan Input NIK dengan Angka Saja</p>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="name">Name</label>
                                <input class="form-control" type="text" id="name" name="name"
                                    placeholder="Enter Name" required>
                                <p class="text-danger" id="invalid-value-name" style="display: none;font-size: 0.75rem;">Silahkan Input Name
                                </p>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="gender">Gender</label>
                                <select class="form-control" id="gender" name="gender" required>
                                    <option value="" disabled selected>Pilih Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                <p class="text-danger" id="invalid-gender" style="display: none;font-size: 0.75rem;">Silahkan Pilih Gender</p>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="reg_date">Registration Date</label>
                                <input class="form-control" type="date" id="reg_date" name="reg_date" required>
                                <p class="text-danger" id="invalid-reg_date" style="display: none;font-size: 0.75rem;">Silahkan Input
                                    Registration Date</p>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="email">Email</label>
                                <input class="form-control" type="email" id="email" name="email"
                                    placeholder="Enter Email" required>
                                <p class="text-danger" id="invalid-value-email" style="display: none;font-size: 0.75rem;">Silahkan Input Email
                                </p>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="password">Password</label>
                                <input class="form-control" type="password" id="password" name="password"
                                    placeholder="Enter Password" required>
                                <p class="text-danger" id="invalid-value-password" style="display: none;font-size: 0.75rem;">Silahkan Input
                                    Password</p>
                                <input type="checkbox" onclick="togglePasswordVisibility()"> Show Password
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="address">Address</label>
                                <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter Address" required></textarea>
                                <p class="text-danger" id="invalid-value-address" style="display: none;font-size: 0.75rem;">Silahkan Input
                                    Address</p>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="phone_number">Phone Number</label>
                                <input class="form-control" type="text" id="phone_number" name="phone_number"
                                    placeholder="Enter Phone Number" required>
                                <p class="text-danger" id="invalid-value-phone_number" style="display: none;font-size: 0.75rem;">Silahkan
                                    Input Phone Number</p>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="photo">Upload Photo</label>
                                <input class="form-control" accept="image/*" type="file" id="file"
                                    name="file" required>
                                <input class="form-control" type="hidden" id="photo" name="photo"
                                    value="noimage.jpg" placeholder="photo">
                                <label class="form-label" for="image" style="font-size: 10pt">*Format JPG, JPEG, dan
                                    PNG</label>
                                <p class="text-danger" id="invalid-input-photo" style="display: none;font-size: 0.75rem;">Silahkan Input
                                    Photo</p>
                                <br>
                                <img src="{{ asset('/uploads/noimage.jpg') }}" id="image-preview" name="image-preview"
                                    width="300px" style="border-radius: 2%;">
                            </div>
                            <div class="form-group">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active">
                                    <label class="form-check-label" for="is_active">Active Status</label>
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
        //handle show password
        function togglePasswordVisibility() {
            var passwordField = document.getElementById("password");
            if (passwordField.type === "password") {
                passwordField.type = "text";
            } else {
                passwordField.type = "password";
            }
        }

        document.getElementById('form-data').addEventListener('submit', function(e) {
            e.preventDefault();
            var valid = true;

            if (!document.getElementById('role_id').value) {
                document.getElementById('invalid-role_id').style.display = 'block';
                valid = false;
            } else {
                document.getElementById('invalid-role_id').style.display = 'none';
            }

            if (!document.getElementById('nik').value || !/^\d+$/.test(document.getElementById('nik').value)) {
                document.getElementById('invalid-value-nik').style.display = 'block';
                valid = false;
            } else {
                document.getElementById('invalid-value-nik').style.display = 'none';
            }

            if (!document.getElementById('name').value) {
                document.getElementById('invalid-value-name').style.display = 'block';
                valid = false;
            } else {
                document.getElementById('invalid-value-name').style.display = 'none';
            }

            if (!document.getElementById('gender').value) {
                document.getElementById('invalid-gender').style.display = 'block';
                valid = false;
            } else {
                document.getElementById('invalid-gender').style.display = 'none';
            }

            if (!document.getElementById('reg_date').value) {
                document.getElementById('invalid-reg_date').style.display = 'block';
                valid = false;
            } else {
                document.getElementById('invalid-reg_date').style.display = 'none';
            }

            if (!document.getElementById('email').value) {
                document.getElementById('invalid-value-email').style.display = 'block';
                valid = false;
            } else {
                document.getElementById('invalid-value-email').style.display = 'none';
            }

            if (!document.getElementById('password').value) {
                document.getElementById('invalid-value-password').style.display = 'block';
                valid = false;
            } else {
                document.getElementById('invalid-value-password').style.display = 'none';
            }

            if (!document.getElementById('address').value) {
                document.getElementById('invalid-value-address').style.display = 'block';
                valid = false;
            } else {
                document.getElementById('invalid-value-address').style.display = 'none';
            }

            if (!document.getElementById('phone_number').value) {
                document.getElementById('invalid-value-phone_number').style.display = 'block';
                valid = false;
            } else {
                document.getElementById('invalid-value-phone_number').style.display = 'none';
            }

            if (!document.getElementById('file').files.length) {
                document.getElementById('invalid-input-photo').style.display = 'block';
                valid = false;
            } else {
                document.getElementById('invalid-input-photo').style.display = 'none';
            }

            if (valid) {
                this.submit();
            }
        });
        // handle upload image
        $('#file').change(function() {
            // preview
            $('#image-preview').attr('display', 'block');
            var oFReader = new FileReader();
            oFReader.readAsDataURL($("#file")[0].files[0]);
            oFReader.onload = function(oFREvent) {
                $('#image-preview').attr('src', oFREvent.target.result);
            };

            // upload
            formdata = new FormData();
            if ($(this).prop('files').length > 0) {
                file = $(this).prop('files')[0];
                formdata.append("image", file);
            }
            $.ajaxSetup({
                headers: {
                    'Authorization': "Bearer {{ $session_token }}"
                }
            });
            $.ajax({
                url: '/api/upload',
                type: "POST",
                data: formdata,
                processData: false,
                contentType: false,
                success: function(result) {
                    if (result['success'] == true) {
                        $('#photo').val(result['data']['url'].replace('/xxx/', '/300/'));
                    }
                }
            });
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
                if ('is_active' in formdata) {
                    if (formdata['is_active'] == 'on') {
                        formdata['is_active'] = true;
                    } else {
                        formdata['is_active'] = false;
                    }
                } else {
                    formdata['is_active'] = false;
                }

                $.ajaxSetup({
                    headers: {
                        'Authorization': "Bearer {{ $session_token }}"
                    }
                });
                $.ajax({
                    url: '/api/user',
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
