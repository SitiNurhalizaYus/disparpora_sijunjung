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
                                    <h2 class="card-title">Setting</h2>
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
                                <label class="form-label" for="question">Type </label>
                                <select class="form-select" id="type" name="type" required>
                                    <option value="text">Text</option>
                                    <option value="longtext">Long Text</option>
                                    <option value="wysiwyg">What You See is What You Get</option>
                                    <option value="image">Image</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="key">Key </label>
                                <input class="form-control" type="text" id="key" name="key" value="" placeholder="Enter Key" required readonly style="background-color: lightgray">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="value">Value</label>
                                <input class="form-control" type="text" id="value-text" name="value-text" value="" placeholder="Enter Value">
                                <textarea class="form-control" id="value-longtext" name="value-longtext" rows="3"></textarea>
                                <textarea class="form-control" id="value-wysiwyg" name="value-wysiwyg" rows="5"></textarea>
                                <input class="form-control" type="file" id="value-image" name="value-image"></textarea>
                                <img src="{{ asset('/uploads/noimage.jpg') }}" id="image-preview" name="image-preview" width="300px" style="border-radius: 2%;">

                                <textarea class="form-control" id="value" name="value" rows="5" required hidden></textarea>
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

        // hide
        function hideAll() {
            $("#value-text").hide();
            $("#value-longtext").hide();
            $("#value-wysiwyg").hide();
            $("#value-image").hide();
            $("#image-preview").hide();
            $(".tox-tinymce").hide();
        }

        function setHidden(type, value) {
            if (type == 'text') {
                hideAll();
                $("#value-text").show();
                $("#value-text").val(value);
            } else if (type == 'longtext') {
                hideAll();
                $("#value-longtext").show();
                $("#value-longtext").val(value);
            } else if (type == 'wysiwyg') {
                hideAll();
                $("#value-wysiwyg").show();
                $("#value-wysiwyg").val(value);

                // handle wysiwyg
                tinymce.init({
                    selector: 'textarea#value-wysiwyg',
                    plugins: 'code table lists',
                    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image responsivefilemanager | print preview media | forecolor backcolor emoticons | codesample",
                    promotion: false,
                    setup:function(ed) {
                        ed.on('change', function(e) {
                            $('#value').val(ed.getContent());
                        });
                    }
                });
                $(".tox-tinymce").show();
            } else if (type == 'image') {
                hideAll();
                $("#value-image").show();
                $("#image-preview").show();
                $('#image-preview').attr('src', '/'+value.replace('/xxx/', '/300/'));
            }
        }

        $('#type').change(function(){
            setHidden(this.value, $('#value').val());
        });

        $('#value-text').change(function(){
            $('#value').val(this.value);
        });

        $('#value-longtext').change(function(){
            $('#value').val(this.value);
        });

        $('#value-wysiwyg').change(function(){
            $('#value').val(this.value);
        });

        // handle upload image
        $('#value-image').change(function(){
            // preview
            $('#image-preview').attr('display', 'block');
            var oFReader = new FileReader();
            oFReader.readAsDataURL( $("#value-image")[0].files[0]);
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
                        $('#value').val(result['data']['url'].replace('/xxx/', '/300/'));
                    }
                }
            });
        });

        // get data
        $.ajaxSetup({
            headers:{
                'Authorization': "Bearer {{$session_token}}"
            }
        });
        $.ajax({
            url: '/api/setting/{{$id}}',
            type: "GET",
            dataType: "json",
            processData: false,
            success: function (result) {
                if(result['success'] == true) {
                    $("#detail-data-success").show();
                    $("#detail-data-failed").hide();

                    $('#type').val(result['data']['type']);
                    $('#key').val(result['data']['key']);
                    $('#value').val(result['data']['value']);
                    $('#notes').val(result['data']['notes']);
                    $('#is_active').prop("checked", result['data']['is_active']);

                    setHidden(result['data']['type'], result['data']['value']);

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
                    url: '/api/setting/{{$id}}',
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
                                window.location.replace("{{ url('/admin/setting') }}");
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
