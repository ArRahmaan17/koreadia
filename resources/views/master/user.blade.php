@extends('layouts.master')
@section('title')
    @lang('translation.user')
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('build/libs/datatable/dataTables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('build/libs/filepond/filepond.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('build/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css') }}">
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Master
        @endslot
        @slot('title')
            @lang('translation.user')
        @endslot
    @endcomponent
    <div class="card">
        <div class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">@lang('translation.user')</h4>
            <div class="flex-shrink-0">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-user">@lang('translation.add')</button>
            </div>
        </div><!-- end card header -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="table-user">
                    <thead>
                        <tr>
                            <td>@lang('translation.no')</td>
                            <td>@lang('translation.name')</td>
                            <td>@lang('translation.username')</td>
                            <td>@lang('translation.phone_number')</td>
                            <td>@lang('translation.role-user')</td>
                            <td>Valid</td>
                            <td>@lang('translation.action')</td>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="modal-user" class="modal fade" tabindex="-1" aria-labelledby="modal-user-label" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-user-label">Add @lang('translation.user')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        @lang('translation.user_valided')
                    </div>
                    <form action="#" id="form-user">
                        @csrf
                        <input type="hidden" name="id">
                        <input type="hidden" name="valid" value="TRUE">
                        <div class="mb-3">
                            <label for="avatar">Avatar</label>
                            <div class="col-3 mx-auto">
                                <input type="file" class="form-control" id="avatar" name="avatar" placeholder="Enter your name user mail">
                            </div>
                            <div id="avatar_help" class="form-text text-center text-danger d-none">@lang('translation.image_update_help')</div>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name user mail">
                            <label for="name">Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter your name user mail">
                            <label for="username">@lang('translation.username')</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control phone_number" id="phone_number" name="phone_number"
                                placeholder="Enter your name user mail">
                            <label for="phone_number">@lang('translation.phone_number')</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your name user mail">
                            <label for="password">Password</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Enter your name user mail">
                            <label for="confirm_password">Confirm Password</label>
                        </div>
                        <div class="mb-3">
                            <label for="role">@lang('translation.role')</label>
                            <select name="role" id="role" class="form-select"></select>
                        </div>
                        <div class="mb-3 d-none container-organization">
                            <label for="organization">@lang('translation.organization')</label>
                            <select name="organization" id="organization" class="form-select"></select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">@lang('translation.close')</button>
                    <button type="button" class="btn btn-soft-success disabled" id="save-user">@lang('translation.save') @lang('translation.changes')</button>
                    <button type="button" class="btn btn-soft-warning d-none" id="update-user">@lang('translation.update') @lang('translation.changes')</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('build/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js') }}"></script>
    <script src="{{ asset('build/libs/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js') }}"></script>
    <script src="{{ asset('build/libs/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js') }}"></script>
    <script src="{{ asset('build/libs/filepond-plugin-file-encode/filepond-plugin-file-encode.min.js') }}"></script>
    <script src="{{ asset('build/libs/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.js') }}"></script>
    <script src="{{ asset('build/libs/filepond/filepond.min.js') }}"></script>
    <!--datatable js-->
    <script src="{{ asset('build/libs/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('build/libs/datatable/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('build/libs/datatable/dataTables.responsive.min.js') }}"></script>
    <script>
        window.datatableUser = null;
        window.state = 'add';
        window.file_pond = undefined;

        function actionData() {
            $('.edit').click(function() {
                window.state = 'update';
                let idUser = $(this).data("user");
                $("#update-user").data("user", idUser);
                if (window.datatableUser.rows('.selected').data().length == 0) {
                    $('#table-user tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }

                var data = window.datatableUser.rows('.selected').data()[0];

                $('#modal-user').modal('show');
                $('#modal-user').find('.modal-title').html(`Edit @lang('translation.user')`);
                $('#save-user').addClass('d-none');
                $('#update-user').removeClass('d-none');
                $('#avatar_help').removeClass('d-none')
                setTimeout(() => {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('master.user.show') }}/" + idUser,
                        dataType: "json",
                        success: function(response) {
                            $('#modal-user').find("form")
                                .find('input, select').map(function(index, element) {
                                    if (element.name == 'role') {
                                        $(`select[name=${element.name}]`).val(response.data.role.roles.id).trigger('change')
                                    } else if (response.data[element.name] != undefined && element.name != '_token' && element
                                        .name !=
                                        'avatar') {
                                        $(`[name=${element.name}]`).val(response.data[element
                                            .name])
                                    }
                                });
                        },
                        error: function(error) {
                            iziToast.error({
                                id: 'alert-user-action',
                                title: 'Error',
                                message: error.responseJSON.message,
                                position: 'topRight',
                                layout: 2,
                                displayMode: 'replace'
                            });
                        }
                    });
                }, 3000);
            })

            $('.delete').click(function() {
                if (window.datatableUser.rows('.selected').data().length == 0) {
                    $('#table-user tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                let idUser = $(this).data("user");
                var data = window.datatableUser.rows('.selected').data()[0];
                iziToast.question({
                    timeout: 5000,
                    layout: 2,
                    close: false,
                    overlay: true,
                    color: 'red',
                    displayMode: 'once',
                    id: 'question',
                    zindex: 9999,
                    title: 'Confirmation',
                    message: "Are you sure you want to delete this mails user data?",
                    position: 'center',
                    icon: 'bx bx-question-mark',
                    buttons: [
                        ['<button><b>OK</b></button>', function(instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOut'
                            }, toast, 'button');
                            $.ajax({
                                type: "DELETE",
                                url: "{{ route('master.user.destroy') }}/" +
                                    idUser,
                                data: {
                                    _token: `{{ csrf_token() }}`,
                                },
                                dataType: "json",
                                success: function(response) {
                                    iziToast.success({
                                        id: 'alert-user-form',
                                        title: 'Success',
                                        message: response.message,
                                        position: 'topRight',
                                        layout: 2,
                                        displayMode: 'replace'
                                    });
                                    window.datatableUser.ajax.reload()
                                },
                                error: function(error) {
                                    iziToast.error({
                                        id: 'alert-user-action',
                                        title: 'Error',
                                        message: error.responseJSON.message,
                                        position: 'topRight',
                                        layout: 2,
                                        displayMode: 'replace'
                                    });
                                }
                            });
                        }, true],
                        ['<button>CANCEL</button>', function(instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOut'
                            }, toast, 'button');
                        }],
                    ],
                });
            });
        }
        $(function() {
            window.datatableUser = $('#table-user').DataTable({
                scrollY: '100%',
                ajax: "{{ route('master.user.data-table') }}",
                processing: true,
                serverSide: true,
                order: [
                    [1, 'desc']
                ],
                columns: [{
                    target: 0,
                    name: 'number',
                    data: 'number',
                    orderable: false,
                    searchable: false,
                    render: (data, type, row, meta) => {
                        return `<div class='text-wrap'>${data}</div>`
                    }
                }, {
                    target: 1,
                    name: 'name',
                    data: 'name',
                    orderable: true,
                    searchable: true,
                    render: (data, type, row, meta) => {
                        return `<div class='text-wrap'>${data}</div>`
                    }
                }, {
                    target: 2,
                    name: 'username',
                    data: 'username',
                    orderable: true,
                    searchable: true,
                    render: (data, type, row, meta) => {
                        return `<div class='text-wrap'>${data}</div>`
                    }
                }, {
                    target: 3,
                    name: 'phone_number',
                    data: 'phone_number',
                    orderable: true,
                    searchable: true,
                    render: (data, type, row, meta) => {
                        return `<div class='text-wrap'>${data}</div>`
                    }
                },{
                    target: 4,
                    name: 'role',
                    data: 'role',
                    orderable: true,
                    searchable: true,
                    render: (data, type, row, meta) => {
                        return `<div class='text-wrap'>${data}</div>`
                    }
                }, {
                    target: 5,
                    name: 'valid',
                    data: 'valid',
                    orderable: true,
                    searchable: true,
                    render: (data, type, row, meta) => {
                        return `<div class='text-wrap'>${data}</div>`
                    }
                }, {
                    target: 6,
                    name: 'action',
                    data: 'action',
                    orderable: false,
                    searchable: false,
                    render: (data, type, row, meta) => {
                        return `<div class='d-flex gap-1'>${data}</div>`
                    }
                }]
            });
            window.datatableUser.on('draw.dt', function() {
                actionData();
            });
            $('#save-user').click(function() {
                let data = serializeObject($('#form-user'));
                $.ajax({
                    type: "POST",
                    url: `{{ route('master.user.store') }}`,
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        $('#modal-user').modal('hide')
                        iziToast.success({
                            id: 'alert-user-form',
                            title: 'Success',
                            message: response.message,
                            position: 'topRight',
                            layout: 2,
                            displayMode: 'replace'
                        });
                        window.datatableUser.ajax.reload();
                    },
                    error: function(error) {
                        $('#modal-user .is-invalid').removeClass('is-invalid')
                        $.each(error.responseJSON.errors, function(indexInArray,
                            valueOfElement) {
                            $('#modal-user').find('[name=' + indexInArray +
                                ']').addClass('is-invalid')
                        });
                        iziToast.error({
                            id: 'alert-user-form',
                            title: 'Error',
                            message: error.responseJSON.message,
                            position: 'topRight',
                            layout: 2,
                            displayMode: 'replace'
                        });
                    }
                });
            });
            $('#update-user').click(function() {
                let data = serializeObject($('#form-user'));
                $.ajax({
                    type: "PUT",
                    url: `{{ route('master.user.update') }}/${data.id}`,
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        $('#modal-user').modal('hide')
                        iziToast.success({
                            id: 'alert-user-form',
                            title: 'Success',
                            message: response.message,
                            position: 'topRight',
                            layout: 2,
                            displayMode: 'replace'
                        });
                        window.datatableUser.ajax.reload();

                    },
                    error: function(error) {
                        $('#modal-user .is-invalid').removeClass('is-invalid')
                        $.each(error.responseJSON.errors, function(indexInArray,
                            valueOfElement) {
                            $('#modal-user').find('[name=' + indexInArray +
                                ']').addClass('is-invalid')
                        });
                        iziToast.error({
                            id: 'alert-user-form',
                            title: 'Error',
                            message: error.responseJSON.message,
                            position: 'topRight',
                            layout: 2,
                            displayMode: 'replace'
                        });
                    }
                });
            });
            $('#modal-user').on('hidden.bs.modal', function() {
                window.state = 'add';
                $(this).find('form')[0].reset();
                $(this).find('.modal-title').html(`Add @lang('translation.user')`);
                $('#save-user').removeClass('d-none');
                $('#update-user').addClass('d-none');
                $('#modal-user .is-invalid').removeClass('is-invalid')
                $('#table-user tbody').find('tr').removeClass('selected');
                $('#avatar_help').addClass('d-none');
                $('.container-organization').addClass('d-none');
            });
            $('#modal-user').on('shown.bs.modal', function() {
                $.ajax({
                    type: "GET",
                    url: `{{ route('master.role.all') }}`,
                    dataType: "json",
                    success: function(response) {
                        $('#role').html(dataToOption(response.data))
                    }
                });
                $.ajax({
                    type: "GET",
                    url: `{{ route('master.organization.all') }}`,
                    dataType: "json",
                    success: function(response) {
                        $('#organization').html(dataToOption(response.data))
                    }
                });
                $('#role').change(function() {
                    if ($(this).val() == '3') {
                        $('.container-organization').val('').removeClass('d-none');
                    } else {
                        $('.container-organization').val('').addClass('d-none');
                    }
                });
            });
            formattedInput();
            FilePond.registerPlugin(
                // encodes the file as base64 data
                FilePondPluginFileEncode,
                // validates the size of the file
                FilePondPluginFileValidateSize,
                // corrects mobile image orientation
                FilePondPluginImageExifOrientation,
                // previews dropped images
                FilePondPluginImagePreview,
                // validates the type of the file
                FilePondPluginFileValidateType
            );
            var avatar_file_pond = document.getElementById('avatar');
            window.file_pond_file_attachment = FilePond.create(avatar_file_pond, {
                maxFiles: 1,
                maxFileSize: '50MB',
                allowFileTypeValidation: true,
                labelIdle: `Drag & Drop your picture or <span class="filepond--label-action">Browse</span>`,
                imagePreviewHeight: 170,
                imageCropAspectRatio: '1:1',
                imageResizeTargetWidth: 200,
                imageResizeTargetHeight: 200,
                stylePanelLayout: 'compact circle',
                styleLoadIndicatorPosition: 'center bottom',
                styleProgressIndicatorPosition: 'right bottom',
                styleButtonRemoveItemPosition: 'left bottom',
                styleButtonProcessItemPosition: 'right bottom',
                acceptedFileTypes: ['image/jpg', 'image/png', 'image/jpeg'],
            });
            $('#confirm_password').keyup(function(e) {
                if ($(this).val() == $('#password').val()) {
                    $('#save-user').removeClass('disabled');
                }
            });
        });
    </script>
@endsection
