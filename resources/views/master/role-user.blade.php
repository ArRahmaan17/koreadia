@extends('layouts.master')
@section('title')
    @lang('translation.role-user')
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('build/libs/datatable/dataTables.min.css') }}" />
    <style>
        select.is-invalid+.select2-container--default {
            border: 1px solid #f06548;
            border-radius: 5px;
        }
    </style>
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Master
        @endslot
        @slot('title')
            Role User
        @endslot
    @endcomponent
    <div class="card">
        <div class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">@lang('translation.role-user')</h4>
            <div class="flex-shrink-0">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-role-user">@lang('translation.add')</button>
            </div>
        </div><!-- end card header -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="table-role-user">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Name</td>
                            <td>Role</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="modal-role-user" class="modal fade" tabindex="-1" aria-labelledby="modal-role-user-label" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-role-user-label">Add @lang('translation.role-user')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" id="form-role-user">
                        @csrf
                        <input type="hidden" name="id">
                        <div class="mb-3">
                            <label for="user_id">User</label>
                            <select name="user_id" id="user_id" class="form-select select2"></select>
                        </div>
                        <div class="mb-3">
                            <label for="role_id">Role</label>
                            <select name="role_id" id="role_id" class="form-select select2"></select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">@lang('translation.close')</button>
                    <button type="button" class="btn btn-soft-success" id="save-role-user">@lang('translation.save') Changes</button>
                    <button type="button" class="btn btn-soft-warning d-none" id="update-role-user">@lang('translation.update') Changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('build/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('build/libs/jsvectormap/maps/world-merc.js') }}"></script>
    <!--datatable js-->
    <script src="{{ asset('build/libs/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('build/libs/datatable/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('build/libs/datatable/dataTables.responsive.min.js') }}"></script>
    <script>
        window.datatableRoleUser = null;
        window.state = 'add';

        function actionData() {
            $('.edit').click(function() {
                window.state = 'update';
                let idRoleUser = $(this).data("roleuser");
                $("#update-role-user").data("roleuser", idRoleUser);
                if (window.datatableRoleUser.rows('.selected').data().length == 0) {
                    $('#table-role-user tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }

                var data = window.datatableRoleUser.rows('.selected').data()[0];

                $('#modal-role-user').modal('show');
                $('#modal-role-user').find('.modal-title').html(`Edit @lang('translation.role-user')`);
                $('#save-role-user').addClass('d-none');
                $('#update-role-user').removeClass('d-none');
                setTimeout(() => {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('master.role-user.show') }}/" + idRoleUser,
                        dataType: "json",
                        success: function(response) {
                            $('#modal-role-user').find("form")
                                .find('select, input').map(function(index, element) {
                                    if (response.data[element.name] && element.name != '_token') {
                                        $(`[name=${element.name}]`).val(response.data[element
                                            .name]).trigger('change')
                                    }
                                });
                        },
                        error: function(error) {
                            iziToast.error({
                                id: 'alert-role-user-action',
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
                if (window.datatableRoleUser.rows('.selected').data().length == 0) {
                    $('#table-role-user tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                let idRoleUser = $(this).data("roleuser");
                var data = window.datatableRoleUser.rows('.selected').data()[0];
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
                    message: "Are you sure you want to delete this mails role-user data?",
                    position: 'center',
                    icon: 'bx bx-question-mark',
                    buttons: [
                        ['<button><b>OK</b></button>', function(instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOut'
                            }, toast, 'button');
                            $.ajax({
                                type: "DELETE",
                                url: "{{ route('master.role-user.destroy') }}/" +
                                    idRoleUser,
                                data: {
                                    _token: `{{ csrf_token() }}`,
                                },
                                dataType: "json",
                                success: function(response) {
                                    iziToast.success({
                                        id: 'alert-role-user-form',
                                        title: 'Success',
                                        message: response.message,
                                        position: 'topRight',
                                        layout: 2,
                                        displayMode: 'replace'
                                    });
                                    window.datatableRoleUser.ajax.reload()
                                },
                                error: function(error) {
                                    iziToast.error({
                                        id: 'alert-role-user-action',
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
            window.datatableRoleUser = $('#table-role-user').DataTable({
                scrollY: '100%',
                ajax: "{{ route('master.role-user.data-table') }}",
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
                    name: 'role',
                    data: 'role',
                    orderable: true,
                    searchable: true,
                    render: (data, type, row, meta) => {
                        return `<div class='text-wrap'>${data}</div>`
                    }
                }, {
                    target: 3,
                    name: 'action',
                    data: 'action',
                    orderable: false,
                    searchable: false,
                    render: (data, type, row, meta) => {
                        return `<div class='d-flex gap-1'>${data}</div>`
                    }
                }]
            });
            window.datatableRoleUser.on('draw.dt', function() {
                actionData();
            });
            $('#save-role-user').click(function() {
                let data = serializeObject($('#form-role-user'));
                $.ajax({
                    type: "POST",
                    url: `{{ route('master.role-user.store') }}`,
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        $('#modal-role-user').modal('hide')
                        iziToast.success({
                            id: 'alert-role-user-form',
                            title: 'Success',
                            message: response.message,
                            position: 'topRight',
                            layout: 2,
                            displayMode: 'replace'
                        });
                        window.datatableRoleUser.ajax.reload();

                    },
                    error: function(error) {
                        $('#modal-role-user .is-invalid').removeClass('is-invalid')
                        $.each(error.responseJSON.errors, function(indexInArray,
                            valueOfElement) {
                            $('#modal-role-user').find('[name=' + indexInArray +
                                ']').addClass('is-invalid')
                        });
                        iziToast.error({
                            id: 'alert-role-user-form',
                            title: 'Error',
                            message: error.responseJSON.message,
                            position: 'topRight',
                            layout: 2,
                            displayMode: 'replace'
                        });
                    }
                });
            });
            $('#update-role-user').click(function() {
                let data = serializeObject($('#form-role-user'));
                $.ajax({
                    type: "PUT",
                    url: `{{ route('master.role-user.update') }}/${data.id}`,
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        $('#modal-role-user').modal('hide')
                        iziToast.success({
                            id: 'alert-role-user-form',
                            title: 'Success',
                            message: response.message,
                            position: 'topRight',
                            layout: 2,
                            displayMode: 'replace'
                        });
                        window.datatableRoleUser.ajax.reload();

                    },
                    error: function(error) {
                        $('#modal-role-user .is-invalid').removeClass('is-invalid')
                        $.each(error.responseJSON.errors, function(indexInArray,
                            valueOfElement) {
                            $('#modal-role-user').find('[name=' + indexInArray +
                                ']').addClass('is-invalid')
                        });
                        iziToast.error({
                            id: 'alert-role-user-form',
                            title: 'Error',
                            message: error.responseJSON.message,
                            position: 'topRight',
                            layout: 2,
                            displayMode: 'replace'
                        });
                    }
                });
            });
            $('#modal-role-user').on('hidden.bs.modal', function() {
                window.state = 'add';
                $(this).find('form')[0].reset();
                $(this).find('.modal-title').html(`Add @lang('translation.role-user')`);
                $('#save-role-user').removeClass('d-none');
                $('#update-role-user').addClass('d-none');
                $('#modal-role-user .is-invalid').removeClass('is-invalid')
                $('#table-role-user tbody').find('tr').removeClass('selected');
            });
            $('#modal-role-user').on('shown.bs.modal', function() {
                $.ajax({
                    type: "GET",
                    url: `{{ route('master.role-user.all-user') }}`,
                    data: {
                        all: (window.state == 'update') ? true : false
                    },
                    dataType: "JSON",
                    success: function(response) {
                        $('#user_id').html(dataToOption(response.data));
                        $('.select2').select2({
                            dropdownParent: $('#modal-role-user'),
                        });
                    }
                });
                $.ajax({
                    type: "GET",
                    url: `{{ route('master.role.all') }}`,
                    dataType: "JSON",
                    success: function(response) {
                        $('#role_id').html(dataToOption(response.data));
                        $('.select2').select2({
                            dropdownParent: $('#modal-role-user'),
                        });
                    }
                });
            });
        });
    </script>
@endsection
