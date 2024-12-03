@extends('layouts.master')
@section('title')
    @lang('translation.employee')
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
            Employee
        @endslot
    @endcomponent
    <div class="card">
        <div class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">@lang('translation.employee')</h4>
            <div class="flex-shrink-0">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-employee">@lang('translation.add')</button>
            </div>
        </div><!-- end card header -->
        <div class="card-body">
            <div class="table-responsive p-2">
                <table class="table table-bordered" id="table-employee">
                    <thead>
                        <tr>
                            <th>@lang('translation.no')</th>
                            <td>@lang('translation.name')</td>
                            <td>@lang('translation.phone_number')</td>
                            <td>@lang('translation.action')</td>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="modal-employee" class="modal fade" tabindex="-1" aria-labelledby="modal-employee-label" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-employee-label">@lang('translation.add') @lang('translation.employee')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" id="form-employee">
                        @csrf
                        <input type="hidden" name="id">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name">
                            <label for="name">@lang('translation.name')</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control phone_number" id="phone_number" name="phone_number" rows="3" placeholder="Enter your phone_number"></textarea>
                            <label for="phone_number">@lang('translation.phone_number')</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">@lang('translation.close')</button>
                    <button type="button" class="btn btn-soft-success" id="save-employee">@lang('translation.save') @lang('translation.changes')</button>
                    <button type="button" class="btn btn-soft-warning d-none" id="update-employee">@lang('translation.update') @lang('translation.changes')</button>
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
        window.dataTableEmployee = null;
        window.state = 'add';

        function actionData() {
            $('.edit').click(function() {
                window.state = 'update';
                let idEmployee = $(this).data("employee");
                $("#update-employee").data("employee", idEmployee);
                if (window.dataTableEmployee.rows('.selected').data().length == 0) {
                    $('#table-employee tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }

                var data = window.dataTableEmployee.rows('.selected').data()[0];

                $('#modal-employee').modal('show');
                $('#modal-employee').find('.modal-title').html(`Edit @lang('translation.employee')`);
                $('#save-employee').addClass('d-none');
                $('#update-employee').removeClass('d-none');

                $.ajax({
                    type: "GET",
                    url: "{{ route('master.employee.show') }}/" + idEmployee,
                    dataType: "json",
                    success: function(response) {
                        $('#modal-employee').find("form")
                            .find('input, textarea').map(function(index, element) {
                                if (response.data[element.name]) {
                                    $(`[name=${element.name}]`).val(response.data[element
                                        .name])
                                }
                            });
                    },
                    error: function(error) {
                        iziToast.error({
                            id: 'alert-employee-action',
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
                if (window.dataTableEmployee.rows('.selected').data().length == 0) {
                    $('#table-employee tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                let idEmployee = $(this).data("employee");
                var data = window.dataTableEmployee.rows('.selected').data()[0];
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
                    message: "Are you sure you want to delete this mails employee data?",
                    position: 'center',
                    icon: 'bx bx-question-mark',
                    buttons: [
                        ['<button><b>OK</b></button>', function(instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOut'
                            }, toast, 'button');
                            $.ajax({
                                type: "DELETE",
                                url: "{{ route('master.employee.destroy') }}/" +
                                    idEmployee,
                                data: {
                                    _token: `{{ csrf_token() }}`,
                                },
                                dataType: "json",
                                success: function(response) {
                                    iziToast.success({
                                        id: 'alert-employee-form',
                                        title: 'Success',
                                        message: response.message,
                                        position: 'topRight',
                                        layout: 2,
                                        displayMode: 'replace'
                                    });
                                    window.dataTableEmployee.ajax.reload()
                                },
                                error: function(error) {
                                    iziToast.error({
                                        id: 'alert-employee-action',
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
            window.dataTableEmployee = $('#table-employee').DataTable({
                ajax: "{{ route('master.employee.data-table') }}",
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
                    name: 'phone_number',
                    data: 'phone_number',
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
            window.dataTableEmployee.on('draw.dt', function() {
                actionData();
            });
            $('#save-employee').click(function() {
                let data = serializeObject($('#form-employee'));
                $.ajax({
                    type: "POST",
                    url: `{{ route('master.employee.store') }}`,
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        $('#modal-employee').modal('hide')
                        iziToast.success({
                            id: 'alert-employee-form',
                            title: 'Success',
                            message: response.message,
                            position: 'topRight',
                            layout: 2,
                            displayMode: 'replace'
                        });
                        window.dataTableEmployee.ajax.reload();

                    },
                    error: function(error) {
                        $('#modal-employee .is-invalid').removeClass('is-invalid')
                        $.each(error.responseJSON.errors, function(indexInArray,
                            valueOfElement) {
                            $('#modal-employee').find('[name=' + indexInArray +
                                ']').addClass('is-invalid')
                        });
                        iziToast.error({
                            id: 'alert-employee-form',
                            title: 'Error',
                            message: error.responseJSON.message,
                            position: 'topRight',
                            layout: 2,
                            displayMode: 'replace'
                        });
                    }
                });
            });
            $('#update-employee').click(function() {
                let data = serializeObject($('#form-employee'));
                $.ajax({
                    type: "PUT",
                    url: `{{ route('master.employee.update') }}/${data.id}`,
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        $('#modal-employee').modal('hide')
                        iziToast.success({
                            id: 'alert-employee-form',
                            title: 'Success',
                            message: response.message,
                            position: 'topRight',
                            layout: 2,
                            displayMode: 'replace'
                        });
                        window.dataTableEmployee.ajax.reload();

                    },
                    error: function(error) {
                        $('#modal-employee .is-invalid').removeClass('is-invalid')
                        $.each(error.responseJSON.errors, function(indexInArray,
                            valueOfElement) {
                            $('#modal-employee').find('[name=' + indexInArray +
                                ']').addClass('is-invalid')
                        });
                        iziToast.error({
                            id: 'alert-employee-form',
                            title: 'Error',
                            message: error.responseJSON.message,
                            position: 'topRight',
                            layout: 2,
                            displayMode: 'replace'
                        });
                    }
                });
            });
            $('#modal-employee').on('hidden.bs.modal', function() {
                window.state = 'add';
                $(this).find('form')[0].reset();
                $(this).find('.modal-title').html(`Add @lang('translation.employee')`);
                $('#save-employee').removeClass('d-none');
                $('#update-employee').addClass('d-none');
                $('#modal-employee .is-invalid').removeClass('is-invalid')
                $('#table-employee tbody').find('tr').removeClass('selected');
            });
            formattedInput();
        });
    </script>
@endsection
