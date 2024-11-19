@extends('layouts.master')
@section('title')
    @lang('translation.mail_type')
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
            Mail Type
        @endslot
    @endcomponent
    <div class="card">
        <div class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">@lang('translation.mail_type')</h4>
            <div class="flex-shrink-0">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-type">@lang('translation.add')</button>
            </div>
        </div><!-- end card header -->
        <div class="card-body">
            <div class="table-responsive p-2">
                <table class="table table-bordered" id="table-type">
                    <thead>
                        <tr>
                            <th>@lang('translation.no')</th>
                            <th>@lang('translation.name')</th>
                            <th>@lang('translation.description')</th>
                            <th>@lang('translation.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="modal-type" class="modal fade" tabindex="-1" aria-labelledby="modal-type-label" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-type-label">@lang('translation.add') @lang('translation.mail_type')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" id="form-type">
                        @csrf
                        <input type="hidden" name="id">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name type mail">
                            <label for="name">@lang('translation.name')</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter your description type mail"></textarea>
                            <label for="description">@lang('translation.description')</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">@lang('translation.close')</button>
                    <button type="button" class="btn btn-soft-success" id="save-type">@lang('translation.save') @lang('translation.changes')</button>
                    <button type="button" class="btn btn-soft-warning d-none" id="update-type">@lang('translation.update') @lang('translation.changes')</button>
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
        window.dataTableType = null;
        window.state = 'add';

        function actionData() {
            $('.edit').click(function() {
                window.state = 'update';
                let idType = $(this).data("type");
                $("#update-type").data("type", idType);
                if (window.dataTableType.rows('.selected').data().length == 0) {
                    $('#table-type tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }

                var data = window.dataTableType.rows('.selected').data()[0];

                $('#modal-type').modal('show');
                $('#modal-type').find('.modal-title').html(`Edit @lang('translation.mail_type')`);
                $('#save-type').addClass('d-none');
                $('#update-type').removeClass('d-none');

                $.ajax({
                    type: "GET",
                    url: "{{ route('master.type.show') }}/" + idType,
                    dataType: "json",
                    success: function(response) {
                        $('#modal-type').find("form")
                            .find('input, textarea').map(function(index, element) {
                                if (response.data[element.name]) {
                                    $(`[name=${element.name}]`).val(response.data[element
                                        .name])
                                }
                            });
                    },
                    error: function(error) {
                        iziToast.error({
                            id: 'alert-type-action',
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
                if (window.dataTableType.rows('.selected').data().length == 0) {
                    $('#table-type tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                let idType = $(this).data("type");
                var data = window.dataTableType.rows('.selected').data()[0];
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
                                url: "{{ route('master.type.destroy') }}/" +
                                    idType,
                                data: {
                                    _token: `{{ csrf_token() }}`,
                                },
                                dataType: "json",
                                success: function(response) {
                                    iziToast.success({
                                        id: 'alert-type-form',
                                        title: 'Success',
                                        message: response.message,
                                        position: 'topRight',
                                        layout: 2,
                                        displayMode: 'replace'
                                    });
                                    window.dataTableType.ajax.reload()
                                },
                                error: function(error) {
                                    iziToast.error({
                                        id: 'alert-type-action',
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
            window.dataTableType = $('#table-type').DataTable({
               // scrollY: '100%',
                // scrollX: '100%',
                ajax: "{{ route('master.type.data-table') }}",
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
            window.dataTableType.on('draw.dt', function() {
                actionData();
            });
            $('#save-type').click(function() {
                let data = serializeObject($('#form-type'));
                $.ajax({
                    type: "POST",
                    url: `{{ route('master.type.store') }}`,
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        $('#modal-type').modal('hide')
                        iziToast.success({
                            id: 'alert-type-form',
                            title: 'Success',
                            message: response.message,
                            position: 'topRight',
                            layout: 2,
                            displayMode: 'replace'
                        });
                        window.dataTableType.ajax.reload();

                    },
                    error: function(error) {
                        $('#modal-type .is-invalid').removeClass('is-invalid')
                        $.each(error.responseJSON.errors, function(indexInArray,
                            valueOfElement) {
                            $('#modal-type').find('[name=' + indexInArray +
                                ']').addClass('is-invalid')
                        });
                        iziToast.error({
                            id: 'alert-type-form',
                            title: 'Error',
                            message: error.responseJSON.message,
                            position: 'topRight',
                            layout: 2,
                            displayMode: 'replace'
                        });
                    }
                });
            });
            $('#update-type').click(function() {
                let data = serializeObject($('#form-type'));
                $.ajax({
                    type: "PUT",
                    url: `{{ route('master.type.update') }}/${data.id}`,
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        $('#modal-type').modal('hide')
                        iziToast.success({
                            id: 'alert-type-form',
                            title: 'Success',
                            message: response.message,
                            position: 'topRight',
                            layout: 2,
                            displayMode: 'replace'
                        });
                        window.dataTableType.ajax.reload();

                    },
                    error: function(error) {
                        $('#modal-type .is-invalid').removeClass('is-invalid')
                        $.each(error.responseJSON.errors, function(indexInArray,
                            valueOfElement) {
                            $('#modal-type').find('[name=' + indexInArray +
                                ']').addClass('is-invalid')
                        });
                        iziToast.error({
                            id: 'alert-type-form',
                            title: 'Error',
                            message: error.responseJSON.message,
                            position: 'topRight',
                            layout: 2,
                            displayMode: 'replace'
                        });
                    }
                });
            });
            $('#modal-type').on('hidden.bs.modal', function() {
                window.state = 'add';
                $(this).find('form')[0].reset();
                $(this).find('.modal-title').html(`Add @lang('translation.mail_type')`);
                $('#save-type').removeClass('d-none');
                $('#update-type').addClass('d-none');
                $('#modal-type .is-invalid').removeClass('is-invalid')
                $('#table-type tbody').find('tr').removeClass('selected');
            });
        });
    </script>
@endsection
