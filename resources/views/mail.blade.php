@extends('layouts.master')
@section('title')
    @lang('translation.mail_in')
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('build/libs/datatable/dataTables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('build/libs/filepond/filepond.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('build/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css') }}">
    <link rel="stylesheet" href="{{ asset('build/libs/flatpickr/flatpickr.min.css') }}">
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
            Mail
        @endslot
    @endcomponent
    <div class="card">
        <div class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">@lang('translation.mail_in')</h4>
            <div class="flex-shrink-0">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-mail-in">@lang('translation.add')</button>
                <button type="button" class="btn btn-warning" id="reload-mail-in">@lang('translation.reload')</button>
            </div>
        </div><!-- end card header -->
        <div class="card-body">
            <div class="table-responsive p-2">
                <table class="table table-bordered" id="table-mail-in">
                    <thead>
                        <tr>
                            <th>@lang('translation.no')</th>
                            <th>@lang('translation.mail_number')</th>
                            <th>@lang('translation.mail_regarding')</th>
                            <th>@lang('translation.mail_agenda')</th>
                            <th>@lang('translation.mail_priority')</th>
                            <th>@lang('translation.mail_type')</th>
                            <th>@lang('translation.mail_date')</th>
                            <th>@lang('translation.mail_sender')</th>
                            <th>@lang('translation.mail_sender_phone_number')</th>
                            <th>@lang('translation.mail_file_attachment')</th>
                            <th>@lang('translation.mail_status')</th>
                            <th>@lang('translation.mail_date_in')</th>
                            <th>@lang('translation.mail_admin')</th>
                            <th>@lang('translation.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="modal-mail-in" class="modal fade" tabindex="-1" aria-labelledby="modal-mail-in-label" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-mail-in-label">@lang('translation.add') @lang('translation.mail_in')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-mail-in">
                        <div class="row">
                            @csrf
                            <input type="hidden" name="id">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="admin" class="form-label">@lang('translation.mail_admin')</label>
                                    <input type="text" class="form-control" name="admin" value="{{ auth()->user()->name }}" readonly id="admin">
                                </div>
                            </div><!--end col-->
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="number" class="form-label">@lang('translation.mail_number')</label>
                                    <input type="text" class="form-control number-mail" name="number" id="number" placeholder="0001/TEST/PNDK/2024">
                                </div>
                            </div><!--end col-->
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="regarding" class="form-label">@lang('translation.mail_regarding')</label>
                                    <input type="text" class="form-control" name="regarding" placeholder="@lang('translation.enter') @lang('translation.mail_regarding')"
                                        id="regarding">
                                </div>
                            </div><!--end col-->
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="agenda_id" class="form-label">@lang('translation.mail_agenda')</label>
                                    <select name="agenda_id" id="agenda_id" class="form-select select2">
                                        <option value="">PILIH </option>
                                    </select>
                                </div>
                            </div><!--end col-->
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="priority_id" class="form-label">@lang('translation.mail_priority')</label>
                                    <select name="priority_id" id="priority_id" class="form-select select2">
                                        <option value="">PILIH </option>
                                    </select>
                                </div>
                            </div><!--end col-->
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="type_id" class="form-label">@lang('translation.mail_type')</label>
                                    <select name="type_id" id="type_id" class="form-select select2">
                                        <option value="">PILIH</option>
                                    </select>
                                </div>
                            </div><!--end col-->
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="date" class="form-label">@lang('translation.mail_date')</label>
                                    <input type="text" class="form-control flatpikrc" placeholder="@lang('translation.enter') @lang('translation.mail_date')" id="date"
                                        name="date">
                                </div>
                            </div><!--end col-->
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="sender" class="form-label">@lang('translation.mail_sender')</label>
                                    <input type="text" class="form-control" placeholder="@lang('translation.enter') @lang('translation.mail_sender')" id="sender"
                                        name="sender">
                                </div>
                            </div><!--end col-->
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="sender_phone_number" class="form-label">@lang('translation.mail_sender_phone_number')</label>
                                    <input type="text" class="form-control phone_number" placeholder="(+62) 895-451-4512" id="sender_phone_number"
                                        name="sender_phone_number">
                                    <div id="emailHelp" class="form-text">@lang('translation.must_valid_wa_number')</div>
                                </div>
                            </div><!--end col-->
                            <div class="col-6 d-none">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select id="status" name="status" class="form-select select2">
                                        <option value="ARCHIVE">ARCHIVE</option>
                                        <option selected value="IN">IN</option>
                                        <option value="PROCESS">PROCESS</option>
                                        <option value="DISPOSITION">DISPOSITION</option>
                                        <option value="REPLIED">REPLIED</option>
                                        <option value="OUT">OUT</option>
                                    </select>
                                </div>
                            </div><!--end col-->
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="file_attachment" class="form-label">@lang('translation.mail_file_attachment')</label>
                                    <input type="file" class="filepond-input-multiple" id="file_attachment" name="file_attachment"
                                        aria-describedby="file_attachment_help">
                                    <div id="file_attachment_help" class="form-text d-none">@lang('translation.image_update_help')</div>
                                </div>
                            </div><!--end col-->
                        </div><!--end row-->
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">@lang('translation.close')</button>
                    <button type="button" class="btn btn-soft-success" id="save-mail-in">@lang('translation.save') @lang('translation.changes')</button>
                    <button type="button" class="btn btn-soft-warning d-none" id="update-mail-in">@lang('translation.update') @lang('translation.changes')</button>
                </div>
            </div>
        </div>
    </div>
    <div id="modal-status-mail-in" class="modal fade" tabindex="-1" aria-labelledby="modal-status-mail-in-label" aria-hidden="true"
        style="display: none;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-status-mail-in-label">Update Status @lang('translation.mail_in')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-status-mail-in">
                        @csrf
                        <input type="hidden" name="id">
                        <input type="hidden" name="status">
                        <div class="alert alert-warning">@lang('translation.mail_warning_status')</div>
                        <div class="mb-3">
                            <label for="user_id">@lang('translation.mail_processor')</label>
                            <select name="user_id" id="user_id" class="form-select select2"></select>
                        </div>
                        <div class="col-status-process d-none">
                            <div class="mb-3">
                                <label for="sincerely">@lang('translation.mail_sincerely')</label>
                                <select name="sincerely" id="sincerely" class="form-select select2multi"></select>
                            </div>
                            <div class="mb-3">
                                <label for="note">@lang('translation.mail_note')</label>
                                <input type="text" name="note" id="note" class="form-control">
                            </div>
                        </div>
                        <div class="col-status-disposision d-none">
                            <div class="mb-3">
                                <label for="reply_file_attachment" class="form-label">@lang('translation.mail_reply_file_attachment')</label>
                                <input type="file" class="filepond-input-multiple" id="reply_file_attachment" name="reply_file_attachment"
                                    aria-describedby="file_attachment_help">
                            </div>
                            <div class="mb-3">
                                <label for="reply_note">@lang('translation.mail_reply_note')</label>
                                <input type="text" name="reply_note" id="reply_note" class="form-control">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">@lang('translation.close')</button>
                    <button type="button" class="btn btn-soft-warning" id="update-status-mail-in">@lang('translation.update') @lang('translation.changes')</button>
                </div>
            </div>
        </div>
    </div>
    <div id="modal-file-mail-in" class="modal fade" tabindex="-1" aria-labelledby="modal-file-mail-in-label" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-file-mail-in-label">File @lang('translation.mail_in')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe class="col-12" style="min-height: 80vh;" src="" frameborder="0"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">@lang('translation.close')</button>
                </div>
            </div>
        </div>
    </div>
    <div id="modal-report-mail-in" class="modal fade" tabindex="-1" aria-labelledby="modal-file-mail-in-label" aria-hidden="true"
        style="display: none;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-file-mail-in-label">Report @lang('translation.mail_in')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe class="col-12" style="min-height: 80vh;" src="" frameborder="0"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">@lang('translation.close')</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <!-- filepond js -->
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
    <script src="{{ asset('build/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('build/libs/flatpickr/l10n/id.js') }}"></script>
    <script>
        window.dataTableMail = null;
        window.state = 'add';
        window.file_pond_file_attachment = undefined;
        window.file_pond_reply_file_attachment = undefined;

        function actionData() {
            $('.edit').click(function() {
                window.state = 'update';
                let idMail = $(this).data("mailsin");
                $("#update-mail-in").data("mailsin", idMail);
                if (window.dataTableMail.rows('.selected').data().length == 0) {
                    $('#table-mail-in tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }

                var data = window.dataTableMail.rows('.selected').data()[0];

                $('#modal-mail-in').modal('show');
                $('#modal-mail-in').find('.modal-title').html(`@lang('translation.edit') @lang('translation.mail_in')`);
                $('#save-mail-in').addClass('d-none');
                $('#update-mail-in').removeClass('d-none');
                setTimeout(() => {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('mail.in.show') }}/" + idMail,
                        dataType: "json",
                        success: function(response) {
                            $('select').parents('.col-6.d-none').removeClass('d-none')
                            $('#modal-mail-in').find("form")
                                .find('input, select').map(function(index, element) {
                                    if (element.name != 'file_attachment' && element.name != '_token') {
                                        if (response.data[element.name] != undefined) {
                                            $(`[name=${element.name}]`).val(response.data[element
                                                .name]).trigger('change')
                                        }
                                    }
                                });
                        },
                        error: function(error) {
                            iziToast.error({
                                id: 'alert-mail-in-action',
                                title: 'Error',
                                message: error.responseJSON.message,
                                position: 'topRight',
                                layout: 2,
                                displayMode: 'replace'
                            });
                        }
                    });
                }, 2000);
            });
            $('.file').click(function() {
                window.state = 'update';
                let fileId = $(this).data("file");
                $("#update-mail-in").data("file", fileId);
                if (window.dataTableMail.rows('.selected').data().length == 0) {
                    $('#table-mail-in tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                var data = window.dataTableMail.rows('.selected').data()[0];
                $('#modal-file-mail-in').modal('show');
                $('#modal-file-mail-in').find('.modal-title').html(`File @lang('translation.mail_in')`);
                $('#modal-file-mail-in').find('.modal-body iframe').prop('src', `{{ url('/') }}/${fileId}`)
            });
            $('.print-report').click(function() {
                let fileId = $(this).data("mailsin");
                if (window.dataTableMail.rows('.selected').data().length == 0) {
                    $('#table-mail-in tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                var data = window.dataTableMail.rows('.selected').data()[0];
                $('#modal-report-mail-in').modal('show');
                $('#modal-report-mail-in').find('.modal-title').html(`Report @lang('translation.mail_in')`);
                $('#modal-report-mail-in').find('.modal-body iframe').prop('src', `{{ route('mail.in.report') }}/${fileId}`)
            })
            $('.delete').click(function() {
                if (window.dataTableMail.rows('.selected').data().length == 0) {
                    $('#table-mail-in tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                let idMail = $(this).data("mailsin");
                var data = window.dataTableMail.rows('.selected').data()[0];
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
                    message: "Are you sure you want to delete this mails data?",
                    position: 'center',
                    icon: 'bx bx-question-mark',
                    buttons: [
                        ['<button><b>OK</b></button>', function(instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOut'
                            }, toast, 'button');
                            $.ajax({
                                type: "DELETE",
                                url: "{{ route('mail.in.destroy') }}/" +
                                    idMail,
                                data: {
                                    _token: `{{ csrf_token() }}`,
                                },
                                dataType: "json",
                                success: function(response) {
                                    iziToast.success({
                                        id: 'alert-mail-in-form',
                                        title: 'Success',
                                        message: response.message,
                                        position: 'topRight',
                                        layout: 2,
                                        displayMode: 'replace'
                                    });
                                    window.dataTableMail.ajax.reload()
                                },
                                error: function(error) {
                                    iziToast.error({
                                        id: 'alert-mail-in-action',
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
            $('.update-status').click(function() {
                if (window.dataTableMail.rows('.selected').data().length == 0) {
                    $('#table-mail-in tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                let idMail = $(this).data("mailsin");
                var data = window.dataTableMail.rows('.selected').data()[0];
                $('#modal-status-mail-in').modal('show');
                $('input[name=id]').val(idMail);
                $.ajax({
                    type: "GET",
                    url: `{{ route('master.user.all') }}`,
                    dataType: "json",
                    success: function(response) {
                        if (data.status == 'IN') {
                            $('input[name=status]').val('PROCESS');
                            $('.col-status-process').addClass('d-none');
                            $('.col-status-disposision').addClass('d-none');
                        } else if (data.status == 'PROCESS') {
                            $('input[name=status]').val('FILED');
                            $('.col-status-process').removeClass('d-none');
                            $('.col-status-disposision').addClass('d-none');
                            $.ajax({
                                type: "GET",
                                url: `{{ route('master.sincerely-word.all') }}`,
                                dataType: "json",
                                success: function(response) {
                                    $('#modal-status-mail-in select[name=sincerely]').html(dataToOption(response.data))
                                }
                            });
                        } else if (data.status == 'FILED') {
                            $('input[name=status]').val('DISPOSITION');
                            $('.col-status-process').addClass('d-none');
                            $('.col-status-disposision').removeClass('d-none');
                        } else if (data.status == 'DISPOSITION') {
                            $('input[name=status]').val('REPLIED');
                            $('.col-status-process').addClass('d-none');
                            $('.col-status-disposision').removeClass('d-none');
                        } else if (data.status == 'REPLIED') {
                            $('input[name=status]').val('ARCHIVE');
                            $('.col-status-process').addClass('d-none');
                            $('.col-status-disposision').addClass('d-none');
                        }
                        $('#modal-status-mail-in select[name=user_id]').html(dataToOption(response.data))
                    }
                });
            });
            $('.request-notify').click(function() {
                if (window.dataTableMail.rows('.selected').data().length == 0) {
                    $('#table-mail-in tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                console.log(window.dataTableMail.rows('.selected').data()[0])
                let idMail = $(this).data("mailsin");
                var data = window.dataTableMail.rows('.selected').data()[0];
                iziToast.question({
                    timeout: 5000,
                    layout: 2,
                    close: false,
                    overlay: true,
                    color: 'green',
                    displayMode: 'once',
                    id: 'question',
                    zindex: 9999,
                    title: 'Confirmation',
                    message: "Are you sure you want to request notified this mails?",
                    position: 'center',
                    icon: 'bx bx-question-mark',
                    buttons: [
                        ['<button><b>OK</b></button>', function(instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOut'
                            }, toast, 'button');
                            let isRegisteredPhoneNumber = new Promise((resolve, reject) => {
                                $.ajax({
                                    type: "GET",
                                    url: `{{ env('WHATSAPP_URL') }}phone-check/${unFormattedPhoneNumber(data.sender_phone_number)}`,
                                    // url: `{{ env('WHATSAPP_URL') }}phone-check/6289522983271`,
                                    dataType: "json",
                                    success: function(response) {
                                        return resolve(true);
                                    },
                                    error: function(error) {
                                        return reject(false)
                                    }
                                });
                            });
                            isRegisteredPhoneNumber.then(result => {
                                $.ajax({
                                    type: "PUT",
                                    url: "{{ route('mail.in.request-notified') }}/" +
                                        idMail,
                                    data: {
                                        _token: `{{ csrf_token() }}`,
                                        skip: !result,
                                    },
                                    dataType: "json",
                                    success: function(response) {
                                        iziToast.success({
                                            id: 'alert-mail-in-form',
                                            title: 'Success',
                                            message: response.message,
                                            position: 'topRight',
                                            layout: 2,
                                            displayMode: 'replace'
                                        });
                                        window.dataTableMail.ajax.reload()
                                    },
                                    error: function(error) {
                                        iziToast.error({
                                            id: 'alert-mail-in-action',
                                            title: 'Error',
                                            message: error.responseJSON.message,
                                            position: 'topRight',
                                            layout: 2,
                                            displayMode: 'replace'
                                        });
                                    }
                                });
                            }).catch(error => {
                                $.ajax({
                                    type: "PUT",
                                    url: "{{ route('mail.in.request-notified') }}/" +
                                        idMail,
                                    data: {
                                        _token: `{{ csrf_token() }}`,
                                        skip: !result,
                                    },
                                    dataType: "json",
                                    success: function(response) {
                                        iziToast.success({
                                            id: 'alert-mail-in-form',
                                            title: 'Success',
                                            message: response.message,
                                            position: 'topRight',
                                            layout: 2,
                                            displayMode: 'replace'
                                        });
                                        window.dataTableMail.ajax.reload()
                                    },
                                    error: function(error) {
                                        iziToast.error({
                                            id: 'alert-mail-in-action',
                                            title: 'Error',
                                            message: error.responseJSON.message,
                                            position: 'topRight',
                                            layout: 2,
                                            displayMode: 'replace'
                                        });
                                    }
                                });
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
            window.dataTableMail = $('#table-mail-in').DataTable({
                ajax: "{{ route('mail.in.data-table') }}",
                processing: true,
                serverSide: true,
                order: [
                    [1, 'desc']
                ],
                columns: [{
                    target: 0,
                    name: 'index',
                    data: 'index',
                    orderable: false,
                    searchable: false,
                    render: (data, type, row, meta) => {
                        return `<div class='text-wrap'>${data}</div>`
                    }
                }, {
                    target: 1,
                    name: 'number',
                    data: 'number',
                    orderable: true,
                    searchable: true,
                    render: (data, type, row, meta) => {
                        return `<div class='text-wrap'>${data}</div>`
                    }
                }, {
                    target: 2,
                    name: 'regarding',
                    data: 'regarding',
                    orderable: true,
                    searchable: true,
                    render: (data, type, row, meta) => {
                        return `<div class='text-wrap'>${data}</div>`
                    }
                }, {
                    target: 3,
                    name: 'agenda',
                    data: 'agenda',
                    orderable: true,
                    searchable: true,
                    render: (data, type, row, meta) => {
                        return `<div class='text-wrap'>${data}</div>`
                    }
                }, {
                    target: 4,
                    name: 'priority',
                    data: 'priority',
                    orderable: true,
                    searchable: true,
                    render: (data, type, row, meta) => {
                        return `<div class='text-wrap'>${data}</div>`
                    }
                }, {
                    target: 5,
                    name: 'type',
                    data: 'type',
                    orderable: true,
                    searchable: true,
                    render: (data, type, row, meta) => {
                        return `<div class='text-wrap'>${data}</div>`
                    }
                }, {
                    target: 6,
                    name: 'date',
                    data: 'date',
                    orderable: true,
                    searchable: true,
                    render: (data, type, row, meta) => {
                        return `<div class='text-wrap'>${data}</div>`
                    }
                }, {
                    target: 7,
                    name: 'sender',
                    data: 'sender',
                    orderable: true,
                    searchable: true,
                    render: (data, type, row, meta) => {
                        return `<div class='text-wrap'>${data}</div>`
                    }
                }, {
                    target: 8,
                    name: 'sender_phone_number',
                    data: 'sender_phone_number',
                    orderable: true,
                    searchable: true,
                    render: (data, type, row, meta) => {
                        return `<div class='text-wrap'>${data}</div>`
                    }
                }, {
                    target: 9,
                    name: 'file_attachment',
                    data: 'file_attachment',
                    orderable: false,
                    searchable: false,
                    render: (data, type, row, meta) => {
                        return `<div class='d-flex m-0 p-0 g-1'>${data}</div>`
                    }
                }, {
                    target: 10,
                    name: 'status',
                    data: 'status',
                    orderable: true,
                    searchable: true,
                    render: (data, type, row, meta) => {
                        return `<div class='text-wrap'>${data}</div>`
                    }
                }, {
                    target: 11,
                    name: 'date_in',
                    data: 'date_in',
                    orderable: true,
                    searchable: true,
                    render: (data, type, row, meta) => {
                        return `<div class='text-wrap'>${data}</div>`
                    }
                }, {
                    target: 12,
                    name: 'admin',
                    data: 'admin',
                    orderable: true,
                    searchable: true,
                    render: (data, type, row, meta) => {
                        return `<div class='d-flex gap-1'>${data}</div>`
                    }
                }, {
                    target: 13,
                    name: 'action',
                    data: 'action',
                    orderable: false,
                    searchable: false,
                    render: (data, type, row, meta) => {
                        return `<div class='d-flex m-0 p-0 g-1'>${data}</div>`
                    }
                }, ]
            });
            window.dataTableMail.on('draw.dt', function() {
                actionData();
            });
            $('#save-mail-in').click(function() {
                let data = serializeObject($('#form-mail-in'));
                $.ajax({
                    type: "POST",
                    url: `{{ route('mail.in.store') }}`,
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        $('#modal-mail-in').modal('hide')
                        iziToast.success({
                            id: 'alert-mail-in-form',
                            title: 'Success',
                            message: response.message,
                            position: 'topRight',
                            layout: 2,
                            displayMode: 'replace'
                        });
                        window.dataTableMail.ajax.reload();
                    },
                    error: function(error) {
                        $('#modal-mail-in .is-invalid').removeClass('is-invalid')
                        $.each(error.responseJSON.errors, function(indexInArray,
                            valueOfElement) {
                            $('#modal-mail-in').find('[name=' + indexInArray +
                                ']').addClass('is-invalid')
                        });
                        iziToast.error({
                            id: 'alert-mail-in-form',
                            title: 'Error',
                            message: error.responseJSON.message,
                            position: 'topRight',
                            layout: 2,
                            displayMode: 'replace'
                        });
                    }
                });
            });
            $('#update-mail-in').click(function() {
                let data = serializeObject($('#form-mail-in'));
                $.ajax({
                    type: "PUT",
                    url: `{{ route('mail.in.update') }}/${data.id}`,
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        $('#modal-mail-in').modal('hide')
                        iziToast.success({
                            id: 'alert-mail-in-form',
                            title: 'Success',
                            message: response.message,
                            position: 'topRight',
                            layout: 2,
                            displayMode: 'replace'
                        });
                        window.dataTableMail.ajax.reload();
                        $('select[name=status]').parents('.col-6').addClass('d-none')
                    },
                    error: function(error) {
                        $('#modal-mail-in .is-invalid').removeClass('is-invalid')
                        $.each(error.responseJSON.errors, function(indexInArray,
                            valueOfElement) {
                            $('#modal-mail-in').find('[name=' + indexInArray +
                                ']').addClass('is-invalid')
                        });
                        iziToast.error({
                            id: 'alert-mail-in-form',
                            title: 'Error',
                            message: error.responseJSON.message,
                            position: 'topRight',
                            layout: 2,
                            displayMode: 'replace'
                        });
                    }
                });
            });
            $('#update-status-mail-in').click(function() {
                let data = serializeObject($('#form-status-mail-in'));
                $.ajax({
                    type: "PUT",
                    url: `{{ route('mail.in.status-update') }}/${data.id}`,
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        $('#modal-status-mail-in').modal('hide')
                        iziToast.success({
                            id: 'alert-mail-in-form',
                            title: 'Success',
                            message: response.message,
                            position: 'topRight',
                            layout: 2,
                            displayMode: 'replace'
                        });
                        window.dataTableMail.ajax.reload();
                        $('select[name=status]').parents('.col-6').addClass('d-none')
                    },
                    error: function(error) {
                        $('#modal-status-mail-in .is-invalid').removeClass('is-invalid')
                        $.each(error.responseJSON.errors, function(indexInArray,
                            valueOfElement) {
                            $('#modal-status-mail-in').find('[name=' + indexInArray +
                                ']').addClass('is-invalid')
                        });
                        iziToast.error({
                            id: 'alert-mail-in-form',
                            title: 'Error',
                            message: error.responseJSON.message,
                            position: 'topRight',
                            layout: 2,
                            displayMode: 'replace'
                        });
                    }
                });
            });
            $('#modal-mail-in').on('hidden.bs.modal', function() {
                window.state = 'add';
                $(this).find('form')[0].reset();
                $(this).find('.modal-title').html(`@lang('translation.add') @lang('translation.mail_in')`);
                $('#save-mail-in').removeClass('d-none');
                $('#update-mail-in').addClass('d-none');
                $('#modal-mail-in .is-invalid').removeClass('is-invalid')
                $('#table-mail-in tbody').find('tr').removeClass('selected');
                $('#file_attachment_help').addClass('d-none')
            });
            $('#modal-mail-in').on('shown.bs.modal', function() {
                if (window.state == 'update') {
                    $('#file_attachment_help').removeClass('d-none')
                }
                $.ajax({
                    type: "GET",
                    url: `{{ route('master.agenda.all') }}`,
                    dataType: "json",
                    success: function(response) {
                        $("#agenda_id").html(dataToOption(response.data));
                        $('.select2').select2({
                            dropdownParent: $('#modal-mail-in'),
                        })
                    }
                });
                $.ajax({
                    type: "GET",
                    url: `{{ route('master.priority.all') }}`,
                    dataType: "json",
                    success: function(response) {
                        $("#priority_id").html(dataToOption(response.data));
                        $('.select2').select2({
                            dropdownParent: $('#modal-mail-in'),
                        });
                    }
                });
                $.ajax({
                    type: "GET",
                    url: `{{ route('master.type.all') }}`,
                    dataType: "json",
                    success: function(response) {
                        $("#type_id").html(dataToOption(response.data));
                        $('.select2').select2({
                            dropdownParent: $('#modal-mail-in'),
                        })
                    }
                });
            });
            $('#modal-status-mail-in').on('shown.bs.modal', function() {
                $('.select2').select2({
                    dropdownParent: $('#modal-status-mail-in'),
                });
                $('.select2multi').select2({
                    dropdownParent: $('#modal-status-mail-in'),
                    multiple: true,
                })
            });
            $('#modal-status-mail-in').on('hidden.bs.modal', function() {
                $('#modal-status-mail-in .form-select.select2').select2('destroy');
                $('#modal-status-mail-in .form-select.select2multi').select2('destroy');
                $('#form-status-mail-in')[0].reset();
            });
            $('#modal-file-mail-in').on('hidden.bs.modal', function() {
                $('#modal-file-mail-in').find('.modal-body iframe').prop('src', ``)
            });
            $(".flatpikrc").flatpickr({
                "locale": "id"
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
            var file_pond = document.getElementById('file_attachment');
            var reply_file_pond = document.getElementById('reply_file_attachment');
            window.file_pond_file_attachment = FilePond.create(file_pond, {
                maxFiles: 1,
                maxFileSize: '50MB',
                allowFileTypeValidation: true,
                acceptedFileTypes: ['application/pdf'],
            });
            window.file_pond_reply_file_attachment = FilePond.create(reply_file_pond, {
                maxFiles: 1,
                maxFileSize: '50MB',
                allowFileTypeValidation: true,
                acceptedFileTypes: ['application/pdf'],
            });
            window.file_pond_reply_file_attachment.on('addfile', function() {
                $('#modal-status-mail-in input[name=status]').val('REPLIED')
            });
            window.file_pond_reply_file_attachment.on('removefile', function() {
                $('#modal-status-mail-in input[name=status]').val('OUT')
                $('#modal-status-mail-in input[name=note]').val('')
            });
            // $('#sender_phone_number').change(function() {
            //     $.ajax({
            //         type: "GET",
            //         url: `{{ env('WHATSAPP_URL') }}phone-check/${unFormattedPhoneNumber(this.value)}`,
            //         dataType: "json",
            //         success: function(response) {
            //             $('#sender_phone_number').removeClass('is-invalid');
            //             if (window.state == 'add') {
            //                 $('#save-mail-in').removeClass('disabled');
            //             } else {
            //                 $('#update-mail-in').removeClass('disabled');
            //             }
            //         },
            //         error: function(error) {
            //             $('#sender_phone_number').addClass('is-invalid');
            //             iziToast.error({
            //                 id: 'alert-mail-in-form',
            //                 title: 'Error',
            //                 message: error.responseJSON.message,
            //                 position: 'topRight',
            //                 layout: 2,
            //                 displayMode: 'replace'
            //             });
            //             $('#save-mail-in').addClass('disabled');
            //             $('#update-mail-in').addClass('disabled');
            //         }
            //     });
            // });
            $('#reload-mail-in').click(debounce(function() {
                window.dataTableMail.ajax.reload();
            }, 1000));
        });
    </script>
@endsection
