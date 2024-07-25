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
                                    <h2 class="card-title">Partner</h2>
                                    <p>Edit data</p>
                                </div>
                            </div>
                            <div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" class="needs-validation" id="form-data" name="form-data" novalidate>
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="form-label" for="name">Name </label>
                                <input class="form-control" type="text" id="name" name="name" value="" placeholder="Enter Name" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="link">Link </label>
                                <input class="form-control" type="url" id="link" name="link" value="" placeholder="Enter Link" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="image">Image</label>
                                <input class="form-control" type="file" id="file" name="file">
                                <input class="form-control" type="hidden" id="image" name="image" value="noimage.jpg" placeholder="image">
                                <br>
                                <img src="{{ asset('/uploads/noimage.jpg') }}" id="image-preview" name="image-preview" width="300px" style="border-radius: 2%;">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="notes">Notes</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active">
                                    <label class="form-check-label" for="is_active">Active Status</label>
                                </div>
                            </div>
                            <br><br>
                            <button type="submit" class="btn btn-success">Submit</button>
                            <a href="{{ URL::previous() }}" class="btn btn-danger">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // get data
        $.ajaxSetup({
            headers:{
                'Authorization': "Bearer {{$session_token}}"
            }
        });
        $.ajax({
            url: '/api/partner/{{$id}}',
            type: "GET",
            dataType: "json",
            processData: false,
            success: function (result) {
                if(result['success'] == true) {
                    $("#detail-data-success").show();
                    $("#detail-data-failed").hide();

                    $('#name').val(result['data']['name']);
                    $('#link').val(result['data']['link']);
                    $("#image").val(result['data']['image']);
                    $("#image-preview").attr("src", "{{ url('/') }}/" + result['data']['image'].replace('/xxx/', '/300/'));
                    $('#notes').val(result['data']['notes']);
                    $('#is_active').prop("checked", result['data']['is_active']);

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


        // handle upload image
        $('#file').change(function(){
            // preview
            $('#image-preview').attr('display', 'block');
            var oFReader = new FileReader();
            oFReader.readAsDataURL( $("#file")[0].files[0]);
            oFReader.onload = function(oFREvent) {
                $('#image-preview').attr('src', oFREvent.target.result);
            };

            // upload
            formdata = new FormData();
            if($(this).prop('files').length > 0) {
                file =$(this).prop('files')[0];
                formdata.append("image", file);
            }
            $.ajaxSetup({
                headers:{
                    'Authorization': "Bearer {{$session_token}}"
                }
            });
            $.ajax({
                url: '/api/upload',
                type: "POST",
                data: formdata,
                processData: false,
                contentType: false,
                success: function (result) {
                    if(result['success'] == true) {
                        $('#image').val(result['data']['url'].replace('/xxx/', '/300/'));
                    }
                }
            });
        });

        // handle wysiwyg
        tinymce.init({
            selector: 'textarea#content',
            plugins: 'code table lists',
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image responsivefilemanager | print preview media | forecolor backcolor emoticons | codesample",
            promotion: false,
            setup:function(ed) {
                ed.on('change', function(e) {
                    $('#description_long').val(ed.getContent());
                });
            }
        });

        // handle post
        $('#form-data').submit(false);
        $("#form-data").submit( function () {

            if($(this).valid()) {
                var form = $("#form-data").serializeArray();
                var formdata = {};
                $.map(form, function(n, i){
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
                    headers:{
                        'Authorization': "Bearer {{$session_token}}"
                    }
                });
                $.ajax({
                    url: '/api/partner/{{$id}}',
                    type: "PUT",
                    data: JSON.stringify(formdata),
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
                                window.location.replace("{{ url('/admin/partner') }}");
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
