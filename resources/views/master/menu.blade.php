@extends('layouts.master')
@section('title')
    @lang('translation.menu')
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('build/libs/datatable/dataTables.min.css') }}" />
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Master
        @endslot
        @slot('title')
            Menu
        @endslot
    @endcomponent
    <div class="card">
        <div class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">@lang('translation.menu')</h4>
            <div class="flex-shrink-0">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-menu">@lang('translation.add')</button>
            </div>
        </div><!-- end card header -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="table-menu">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>@lang('translation.name')</td>
                            <td>@lang('translation.description')</td>
                            <td>@lang('translation.action')</td>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="modal-menu" class="modal fade" tabindex="-1" aria-labelledby="modal-menu-label" aria-hidden="true" style="display: none;">
        <div class="modal-dialog  modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-menu-label">Add @lang('translation.menu')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" id="form-menu">
                        @csrf
                        <input type="hidden" name="id">
                        <div class="row">
                            <div class="col-12 col-md-8">
                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="parent" class="form-label">Menu Parent</label>
                                        <select name="parent" id="parent" class="form-control select2">
                                            <option value="0">Kosong</option>
                                            @foreach ($menus as $menu)
                                                <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="name" class="form-label">Menu Name</label>
                                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter Menu Name" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="route" class="form-label">Menu Route</label>
                                        <input list="routes" type="text" id="route" name="route" class="form-control"
                                            placeholder="Enter Menu Route" />
                                        <datalist id="routes">
                                            @foreach ($routes as $route)
                                                <option value="{{ $route->getName() }}">{{ url($route->uri()) }}</option>
                                            @endforeach
                                        </datalist>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="icon" class="form-label">Menu Icon</label>
                                        <input type="text" id="icon" name="icon" class="form-control" placeholder="Enter Menu Icon" />
                                        <div id="passwordHelpBlock" class="form-text">
                                            compatible icon is on <a href="https://boxicons.com/">boxicons</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mb-3">
                                        <label class="form-label">Menu Place</label>
                                        <div class="col">
                                            <div class="form-check form-check-inline">
                                                <input name="place" class="form-check-input" type="radio" value="0" id="place-sidebar">
                                                <label class="form-check-label" for="place-sidebar">
                                                    Sidebar
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input name="place" class="form-check-input" type="radio" value="1" id="place-profile">
                                                <label class="form-check-label" for="place-profile">
                                                    Profile
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="parent" class="form-label">Menu Accessibility</label>
                                        @foreach ($roles as $role)
                                            <div class="form-check form-switch form-switch-warning">
                                                <input class="form-check-input" type="checkbox" role="switch" name="roles[]" value="{{ $role->id }}"
                                                    id="role-{{ Str::lower($role->name) }}" @if ($loop->first) checked @endif>
                                                <label class="form-check-label" for="role-{{ Str::lower($role->name) }}">{{ $role->name }}
                                                    ({{ $role->description }})
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">@lang('translation.close')</button>
                    <button type="button" class="btn btn-soft-success" id="save-menu">@lang('translation.save') Changes</button>
                    <button type="button" class="btn btn-soft-warning d-none" id="update-menu">@lang('translation.update') Changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <!--datatable js-->
    <script src="{{ asset('build/libs/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('build/libs/datatable/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('build/libs/datatable/dataTables.responsive.min.js') }}"></script>
    <script>
        window.dataTableMenu = null;
        window.state = 'add';

        function actionData() {
            $('.edit').click(function() {
                window.state = 'update';
                let idMenu = $(this).data("menu");
                $("#update-menu").data("menu", idMenu);
                if (window.dataTableMenu.rows('.selected').data().length == 0) {
                    $('#table-menu tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }

                var data = window.dataTableMenu.rows('.selected').data()[0];

                $('#modal-menu').modal('show');
                $('#modal-menu').find('.modal-title').html(`Edit @lang('translation.menu')`);
                $('#save-menu').addClass('d-none');
                $('#update-menu').removeClass('d-none');

                $.ajax({
                    type: "GET",
                    url: "{{ route('master.menu.show') }}/" + idMenu,
                    dataType: "json",
                    success: function(response) {
                        $('#modal-menu').find("form")
                            .find('input, select').map(function(index, element) {
                                if (element.name != '_token') {
                                    if (element.name === 'place') {
                                        $(`[name=${element.name}][value=${response.data[element
                                                .name]}]`).prop('checked', true)
                                    } else if (element.name === 'roles[]') {
                                        response.data['roles'].forEach(role => {
                                            $(`[name="${element.name}"][value=${role.role_id}]`).prop('checked', true)
                                        });
                                    } else {
                                        $(`[name=${element.name}]`).val(response.data[element
                                            .name]).trigger('change')
                                    }
                                }
                            });
                    },
                    error: function(error) {
                        iziToast.error({
                            id: 'alert-menu-action',
                            title: 'Error',
                            message: error.responseJSON.message,
                            position: 'topRight',
                            layout: 2,
                            displayMode: 'replace'
                        });
                    }
                });
            })
            $('.parent').click(function() {
                window.state = 'add';
                let idMenu = $(this).data("menu");
                $("#edit-menu").data("menu", idMenu);
                if (window.dataTableMenu.rows('.selected').data().length == 0) {
                    $('#table-menu tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }

                var data = window.dataTableMenu.rows('.selected').data()[0];

                $('#modal-menu').modal('show');
                $('#modal-menu').find('.modal-title').html(`Add Child @yield('title')`);
                $('#save-menu').removeClass('d-none');
                $('#edit-menu').addClass('d-none');
                $('#modal-menu')
                    .find('form select')
                    .val(idMenu)
                    .trigger('change');
                setTimeout(() => {
                    $('#modal-menu')
                        .find('form select')
                        .prop("disabled", true);
                }, 200);
                $.ajax({
                    type: "GET",
                    url: "{{ route('master.menu.show') }}/" + idMenu,
                    dataType: "json",
                    success: function(response) {
                        response.data.roles.forEach(role => {
                            $(`[name="roles[]"][value=${role.role_id}]`).prop('checked', true)
                        });
                    },
                    error: function(error) {
                        iziToast.error({
                            id: 'alert-menu-action',
                            title: 'Error',
                            message: error.responseJSON.message,
                            position: 'topRight',
                            layout: 2,
                            displayMode: 'replace'
                        });
                    }
                });
            })
            $('.delete').click(function() {
                if (window.dataTableMenu.rows('.selected').data().length == 0) {
                    $('#table-menu tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                let idMenu = $(this).data("menu");
                var data = window.dataTableMenu.rows('.selected').data()[0];
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
                    message: "Are you sure you want to delete this mails type data?",
                    position: 'center',
                    icon: 'bx bx-question-mark',
                    buttons: [
                        ['<button><b>OK</b></button>', function(instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOut'
                            }, toast, 'button');
                            $.ajax({
                                type: "DELETE",
                                url: "{{ route('master.menu.destroy') }}/" +
                                    idMenu,
                                data: {
                                    _token: `{{ csrf_token() }}`,
                                },
                                dataType: "json",
                                success: function(response) {
                                    iziToast.success({
                                        id: 'alert-menu-form',
                                        title: 'Success',
                                        message: response.message,
                                        position: 'topRight',
                                        layout: 2,
                                        displayMode: 'replace'
                                    });
                                    window.dataTableMenu.ajax.reload()
                                },
                                error: function(error) {
                                    iziToast.error({
                                        id: 'alert-menu-action',
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
            window.dataTableMenu = $('#table-menu').DataTable({
                scrollY: '100%',
                ajax: "{{ route('master.menu.data-table') }}",
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
                    name: 'description',
                    data: 'description',
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
            window.dataTableMenu.on('draw.dt', function() {
                actionData();
            });
            $('#save-menu').click(function() {
                $('#modal-menu')
                    .find('form select')
                    .prop("disabled", false);
                let data = serializeObject($('#form-menu'));
                $.ajax({
                    type: "POST",
                    url: `{{ route('master.menu.store') }}`,
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        $('#modal-menu').modal('hide')
                        iziToast.success({
                            id: 'alert-menu-form',
                            title: 'Success',
                            message: response.message,
                            position: 'topRight',
                            layout: 2,
                            displayMode: 'replace'
                        });
                        window.dataTableMenu.ajax.reload();

                    },
                    error: function(error) {
                        $('#modal-menu .is-invalid').removeClass('is-invalid')
                        $.each(error.responseJSON.errors, function(indexInArray,
                            valueOfElement) {
                            $('#modal-menu').find('[name=' + indexInArray +
                                ']').addClass('is-invalid')
                        });
                        iziToast.error({
                            id: 'alert-menu-form',
                            title: 'Error',
                            message: error.responseJSON.message,
                            position: 'topRight',
                            layout: 2,
                            displayMode: 'replace'
                        });
                    }
                });
            });
            $('#update-menu').click(function() {
                let data = serializeObject($('#form-menu'));
                $.ajax({
                    type: "PUT",
                    url: `{{ route('master.menu.update') }}/${data.id}`,
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        $('#modal-menu').modal('hide')
                        iziToast.success({
                            id: 'alert-menu-form',
                            title: 'Success',
                            message: response.message,
                            position: 'topRight',
                            layout: 2,
                            displayMode: 'replace'
                        });
                        window.dataTableMenu.ajax.reload();

                    },
                    error: function(error) {
                        $('#modal-menu .is-invalid').removeClass('is-invalid')
                        $.each(error.responseJSON.errors, function(indexInArray,
                            valueOfElement) {
                            $('#modal-menu').find('[name=' + indexInArray +
                                ']').addClass('is-invalid')
                        });
                        iziToast.error({
                            id: 'alert-menu-form',
                            title: 'Error',
                            message: error.responseJSON.message,
                            position: 'topRight',
                            layout: 2,
                            displayMode: 'replace'
                        });
                    }
                });
            });
            $('#modal-menu').on('hidden.bs.modal', function() {
                window.state = 'add';
                $(this).find('form')[0].reset();
                $(this).find('.modal-title').html(`Add @lang('translation.menu')`);
                $('#save-menu').removeClass('d-none');
                $('#update-menu').addClass('d-none');
                $('#modal-menu .is-invalid').removeClass('is-invalid')
                $('#table-menu tbody').find('tr').removeClass('selected');
                $('#modal-menu')
                    .find('form select')
                    .prop("disabled", true);
            });
            $('#modal-menu').on('shown.bs.modal', function() {
                setTimeout(() => {
                    $('.select2').select2({
                        dropdownParent: $('#modal-menu'),
                    });
                }, 140);
            });

        });
    </script>
@endsection
