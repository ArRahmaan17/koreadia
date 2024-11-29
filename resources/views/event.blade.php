@extends('layouts.master')
@section('title')
    @lang('translation.event')
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
            Event
        @endslot
    @endcomponent
    <div class="card">
        <div class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1 text-wrap">@lang('translation.event')</h4>
            <div class="flex-shrink-1 text-end text-sm-start">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-event">@lang('translation.add')</button>
                <button type="button" class="btn btn-warning" id="reload-event">@lang('translation.reload')</button>
            </div>
        </div><!-- end card header -->
        <div class="card-body">
            <div class="table-responsive p-2">
                <table class="table table-bordered" id="table-event">
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
    <div id="modal-event" class="modal fade" tabindex="-1" aria-labelledby="modal-event-label" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-event-label">@lang('translation.add') @lang('translation.event')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-event">
                        <div class="row">
                            @csrf
                            <input type="hidden" name="id">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">@lang('translation.name')</label>
                                    <input type="text" class="form-control" name="name" id="name">
                                </div>
                            </div><!--end col-->
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="date" class="form-label">@lang('translation.mail_date')</label>
                                    <input type="text" class="form-control flatpikrc" placeholder="@lang('translation.enter') @lang('translation.mail_date')" id="date"
                                        name="date">
                                </div>
                            </div><!--end col-->
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="recipient" class="form-label">@lang('translation.recipient')</label>
                                    <input class="form-control" data-choices data-choices-text-unique-true data-choices-limit="your required limit"
                                        data-choices-removeItem type="text" name="recipient" id="recipient" />
                                </div>
                            </div><!--end col-->
                            <div class="col-12 agenda-container">
                                <div class="col-12 row justify-content-evenly mb-2">
                                    <div class="col-6">
                                        <h5>Agenda</h5>
                                    </div>
                                    <div class="col-6 text-end">
                                        <button type="button" id="add-agenda" class="btn btn-success">Tambah Agenda</button>
                                    </div>
                                </div>
                                <div class="container-form-agenda row row-cols-1 justify-content-center row-gap-4" style="max-height: 40vh;overflow: scroll;">
                                    <div class="col-12 row container-input-agenda">
                                        <div class="col-6 mb-2">
                                            <label class="form-label" for="name1">Name</label>
                                            <input type="text" id="name1" name="name[]" placeholder="Enter the agenda name" class="form-control"
                                                required>
                                        </div>
                                        <div class="col-6 mb-2">
                                            <label class="form-label" for="time1">Time</label>
                                            <input type="text" id="time1" name="time[]" class="form-control flatpikr-1" required>
                                        </div>
                                        <div class="col-6 mb-2">
                                            <label class="form-label" for="online1">Online</label>
                                            <select class="form-control" id="online1" name="online[]">
                                                <option selected value="false">No</option>
                                                <option value="true">Yes</option>
                                            </select>
                                        </div>
                                        <div class="col-6 mb-2 online-no">
                                            <label class="form-label" for="location1">Location</label>
                                            <input type="text" id="location1" name="location[]" placeholder="Enter the location" class="form-control"
                                                required>
                                        </div>
                                        <div class="col-6 mb-2 online-yes d-none">
                                            <label class="form-label" for="meeting[][id]1">Id meeting</label>
                                            <input type="text" id="meeting[][id]1" name="meeting[][id]" placeholder="Enter the id" class="form-control"
                                                required>
                                        </div>
                                        <div class="col-6 mb-2 online-yes d-none">
                                            <label class="form-label" for="meeting[][passcode]1">Passcode meeting</label>
                                            <input type="text" id="meeting[][passcode]1" name="meeting[][passcode]" placeholder="Enter the passcode"
                                                class="form-control" required>
                                        </div>
                                        <div class="col-6 mb-2 online-yes d-none">
                                            <label class="form-label" for="meeting[][topic]1">Topic meeting</label>
                                            <input type="text" id="meeting[][topic]1" name="meeting[][topic]" placeholder="Enter the topic"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                    <button type="button" class="btn btn-soft-success" id="save-event">@lang('translation.save') @lang('translation.changes')</button>
                    <button type="button" class="btn btn-soft-warning d-none" id="update-event">@lang('translation.update') @lang('translation.changes')</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <!-- filepond js -->
    <!-- choices.js -->
    <script type='text/javascript' src='{{ asset('build/libs/choices.js/public/assets/scripts/choices.min.js') }}'></script>
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
    <script src="{{ asset('build/js/moment.min.js') }}"></script>
    <script>
        window.datatableEvent = null;
        window.state = 'add';
        window.flatpickr = [];
        window.file_pond_file_attachment = undefined;
        window.file_pond_reply_file_attachment = undefined;

        function actionData() {
            $('.edit').click(function() {
                window.state = 'update';
                let idEvent = $(this).data("mailsin");
                $("#update-event").data("mailsin", idEvent);
                if (window.datatableEvent.rows('.selected').data().length == 0) {
                    $('#table-event tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }

                var data = window.datatableEvent.rows('.selected').data()[0];

                $('#modal-event').modal('show');
                $('#modal-event').find('.modal-title').html(`@lang('translation.edit') @lang('translation.event')`);
                $('#save-event').addClass('d-none');
                $('#update-event').removeClass('d-none');
                setTimeout(() => {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('event.show') }}/" + idEvent,
                        dataType: "json",
                        success: function(response) {
                            $('select').parents('.col-6.d-none').removeClass('d-none')
                            $('#modal-event').find("form")
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
                                id: 'alert-event-action',
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
                $("#update-event").data("file", fileId);
                if (window.datatableEvent.rows('.selected').data().length == 0) {
                    $('#table-event tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                var data = window.datatableEvent.rows('.selected').data()[0];
                $('#modal-file-event').modal('show');
                $('#modal-file-event').find('.modal-title').html(`File @lang('translation.event')`);
                $('#modal-file-event').find('.modal-body iframe').prop('src', `{{ url('/') }}/${fileId}`)
            });
            $('.delete').click(function() {
                if (window.datatableEvent.rows('.selected').data().length == 0) {
                    $('#table-event tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                let idEvent = $(this).data("mailsin");
                var data = window.datatableEvent.rows('.selected').data()[0];
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
                                url: "{{ route('event.destroy') }}/" +
                                    idEvent,
                                data: {
                                    _token: `{{ csrf_token() }}`,
                                },
                                dataType: "json",
                                success: function(response) {
                                    iziToast.success({
                                        id: 'alert-event-form',
                                        title: 'Success',
                                        message: response.message,
                                        position: 'topRight',
                                        layout: 2,
                                        displayMode: 'replace'
                                    });
                                    window.datatableEvent.ajax.reload()
                                },
                                error: function(error) {
                                    iziToast.error({
                                        id: 'alert-event-action',
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
                if (window.datatableEvent.rows('.selected').data().length == 0) {
                    $('#table-event tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                let idEvent = $(this).data("mailsin");
                var data = window.datatableEvent.rows('.selected').data()[0];
                $('#modal-status-event').modal('show');
                $('input[name=id]').val(idEvent);
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
                                    $('#modal-status-event select[name=sincerely]').html(dataToOption(response.data))
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
                        $('#modal-status-event select[name=user_id]').html(dataToOption(response.data))
                    }
                });
            });
            $('.request-notify').click(function() {
                if (window.datatableEvent.rows('.selected').data().length == 0) {
                    $('#table-event tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                console.log(window.datatableEvent.rows('.selected').data()[0])
                let idEvent = $(this).data("mailsin");
                var data = window.datatableEvent.rows('.selected').data()[0];
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

        function changeStatusEvent() {
            $('[name="online[]"]').change(function() {
                if (this.value == 'true') {
                    $(this).parents('.container-input-agenda').find('.online-yes').removeClass('d-none');
                    $(this).parents('.container-input-agenda').find('.online-no').addClass('d-none');
                } else {
                    $(this).parents('.container-input-agenda').find('.online-yes').addClass('d-none');
                    $(this).parents('.container-input-agenda').find('.online-no').removeClass('d-none');
                }
            });
        }

        function setTimeChange(lastTime, nextIndex) {
            let index = nextIndex.split('.flatpikr-').join('');
            index = parseInt(index) - 1;
            window.flatpickr[index] = $(`${nextIndex}`).flatpickr({
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true,
                defaultDate: lastTime,
                minTime: lastTime,
                maxTime: "16:00",
            });
        }

        function handleTimeChange(lastCreateElement) {
            $('[name="time[]"]').change(debounce(function() {
                let changeElement = this;
                if (!$(changeElement).hasClass(lastCreateElement)) {
                    if ($('.container-form-agenda').find('.container-input-agenda').length > 1) {
                        let matchElement = false;
                        let element = $('[name="time[]"]');
                        $.map(element, function(elementOrValue, indexOrKey) {
                            if ($(elementOrValue).prop('id') == $(elementOrValue).prop('id')) {
                                matchElement = true;
                            }
                            if (matchElement && indexOrKey != 0) {
                                let lastTimeUpdate = '';
                                let timeNow = '';
                                if ($(element[indexOrKey - 1]).data('lastTime') == undefined) {
                                    lastTimeUpdate = $(element[indexOrKey - 1]).val();
                                    timeNow = $(element[indexOrKey]).val();
                                } else {
                                    lastTimeUpdate = $(element[indexOrKey - 1]).data('lastTime');
                                    timeNow = $(element[indexOrKey]).data('lastTime');
                                }
                                let defaultTimeParent = window.flatpickr[indexOrKey - 1].config.defaultDate;
                                let defaultTimeChild = window.flatpickr[indexOrKey].config.defaultDate;
                                let dateEvent = $('#date').val();
                                console.log(lastTimeUpdate, timeNow, moment(`${dateEvent} ${lastTimeUpdate}`), moment(
                                    `${dateEvent} ${timeNow}`))
                                let classList = $(elementOrValue).attr("class").split(/\s+/);
                                // window.flatpickr[indexOrKey].destroy();
                                // setTimeChange(lastTimeUpdate, `.${classList[1]}`);
                            }
                        });
                    }
                } else {
                    $(changeElement).attr('last-time', this.value);
                }
            }, 1000))
        }
        $(function() {
            window.datatableEvent = $('#table-event').DataTable({
                ajax: "{{ route('event.data-table') }}",
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
            window.datatableEvent.on('draw.dt', function() {
                actionData();
            });
            $('#save-event').click(function() {
                let data = serializeObject($('#form-event'));
                $.ajax({
                    type: "POST",
                    url: `{{ route('event.store') }}`,
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        $('#modal-event').modal('hide')
                        iziToast.success({
                            id: 'alert-event-form',
                            title: 'Success',
                            message: response.message,
                            position: 'topRight',
                            layout: 2,
                            displayMode: 'replace'
                        });
                        window.datatableEvent.ajax.reload();
                    },
                    error: function(error) {
                        $('#modal-event .is-invalid').removeClass('is-invalid')
                        $.each(error.responseJSON.errors, function(indexInArray,
                            valueOfElement) {
                            $('#modal-event').find('[name=' + indexInArray +
                                ']').addClass('is-invalid')
                        });
                        iziToast.error({
                            id: 'alert-event-form',
                            title: 'Error',
                            message: error.responseJSON.message,
                            position: 'topRight',
                            layout: 2,
                            displayMode: 'replace'
                        });
                    }
                });
            });
            $('#add-agenda').click(function(e) {
                $('.is-invalid').removeClass('is-invalid')

                if ($('#date').val() == '') {
                    $('#date').addClass('is-invalid');
                } else {
                    let valid = true;
                    $.map($(document).find('.container-input-agenda:last-child input'), function(elementOrValue, indexOrKey) {
                        if ($(elementOrValue).parent('.d-none').length == 0 && $(elementOrValue).val() == '') {
                            $(elementOrValue).addClass('is-invalid')
                            valid = false;
                        }
                    });
                    if (valid) {
                        let elementSave = $('.container-form-agenda').find('.col-12.row.container-input-agenda:last-child [name="time[]"]');
                        elementSave.data('lastTime', elementSave.val());
                        let index = $('.container-form-agenda').find('.col-12.row.container-input-agenda').length;
                        let nextIndex = index + 1;
                        let lastTime = $(`#time${index}`).val();
                        let dateAndTime = `${$('#date').val()} ${lastTime}`;
                        lastTime = moment(dateAndTime).add(10, 'minutes').format('H:m');
                        let html = `<div class="col-12 row container-input-agenda">
                        <div class="col-6 mb-2">
                            <label class="form-label" for="name">Name</label>
                            <input type="text" id="name" name="name" placeholder="Enter the agenda name" class="form-control"
                                required>
                        </div>
                        <div class="col-6 mb-2">
                            <label class="form-label" for="time${nextIndex}">Time</label>
                            <input type="text" id="time${nextIndex}" name="time[]" class="form-control flatpikr-${nextIndex}" required>
                        </div>
                        <div class="col-6 mb-2">
                            <label class="form-label" for="online${nextIndex}">Online</label>
                            <select class="form-control" id="online${nextIndex}" name="online[]">
                                <option selected value="false">No</option>
                                <option value="true">Yes</option>
                            </select>
                        </div>
                        <div class="col-6 mb-2 online-no">
                            <label class="form-label" for="location${nextIndex}">Location</label>
                            <input type="text" id="location${nextIndex}" name="location[]" placeholder="Enter the location" class="form-control"
                                required>
                        </div>
                       <div class="col-6 mb-2 online-yes d-none">
                            <label class="form-label" for="meeting[][id]${nextIndex}">Location</label>
                            <input type="text" id="meeting[][id]${nextIndex}" name="meeting[][id]" placeholder="Enter the id" class="form-control"
                                required>
                        </div>
                        <div class="col-6 mb-2 online-yes d-none">
                            <label class="form-label" for="meeting[][passcode]${nextIndex}">Location</label>
                            <input type="text" id="meeting[][passcode]${nextIndex}" name="meeting[][passcode]" placeholder="Enter the passcode" class="form-control"
                                required>
                        </div>
                        <div class="col-6 mb-2 online-yes d-none">
                            <label class="form-label" for="meeting[][topic]${nextIndex}">Location</label>
                            <input type="text" id="meeting[][topic]${nextIndex}" name="meeting[][topic]" placeholder="Enter the topic" class="form-control"
                                required>
                        </div>
                        <div class="col-12 row justify-content-end gap-1">
                            <button type="button" class="btn btn-icon btn-danger"><i class='bx bxs-trash'></i></button>
                        </div>
                    </div>`;
                        $('.container-form-agenda').append(html);
                        let scrollBottom = document.querySelector('.container-form-agenda').scrollHeight;
                        document.querySelector('.container-form-agenda').scrollTo({
                            top: scrollBottom,
                            behavior: 'smooth'
                        });
                        changeStatusEvent();
                        setTimeChange(lastTime, `.flatpikr-${nextIndex}`);
                        handleTimeChange(`flatpikr-${nextIndex}`);
                    }
                }
            });
            $('#update-event').click(function() {
                let data = serializeObject($('#form-event'));
                $.ajax({
                    type: "PUT",
                    url: `{{ route('event.update') }}/${data.id}`,
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        $('#modal-event').modal('hide')
                        iziToast.success({
                            id: 'alert-event-form',
                            title: 'Success',
                            message: response.message,
                            position: 'topRight',
                            layout: 2,
                            displayMode: 'replace'
                        });
                        window.datatableEvent.ajax.reload();
                        $('select[name=status]').parents('.col-6').addClass('d-none')
                    },
                    error: function(error) {
                        $('#modal-event .is-invalid').removeClass('is-invalid')
                        $.each(error.responseJSON.errors, function(indexInArray,
                            valueOfElement) {
                            $('#modal-event').find('[name=' + indexInArray +
                                ']').addClass('is-invalid')
                        });
                        iziToast.error({
                            id: 'alert-event-form',
                            title: 'Error',
                            message: error.responseJSON.message,
                            position: 'topRight',
                            layout: 2,
                            displayMode: 'replace'
                        });
                    }
                });
            });
            $('#modal-event').on('hidden.bs.modal', function() {
                window.state = 'add';
                $(this).find('form')[0].reset();
                $(this).find('.modal-title').html(`@lang('translation.add') @lang('translation.event')`);
                $('#save-event').removeClass('d-none');
                $('#update-event').addClass('d-none');
                $('#modal-event .is-invalid').removeClass('is-invalid')
                $('#table-event tbody').find('tr').removeClass('selected');
                $('#file_attachment_help').addClass('d-none')
            });
            $('#modal-event').on('shown.bs.modal', function() {
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
                            dropdownParent: $('#modal-event'),
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
                            dropdownParent: $('#modal-event'),
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
                            dropdownParent: $('#modal-event'),
                        })
                    }
                });
            });
            $('#modal-status-event').on('shown.bs.modal', function() {
                $('.select2').select2({
                    dropdownParent: $('#modal-status-event'),
                });
                $('.select2multi').select2({
                    dropdownParent: $('#modal-status-event'),
                    multiple: true,
                })
            });
            $('#modal-status-event').on('hidden.bs.modal', function() {
                $('#form-status-event')[0].reset();
            });
            $('#modal-file-event').on('hidden.bs.modal', function() {
                $('#modal-file-event').find('.modal-body iframe').prop('src', ``)
            });
            $(".flatpikrc").flatpickr({
                "locale": "id",
                minDate: moment().format('YYYY-MM-DD'),
            });
            $(".flatpikrc").change(function() {
                setTimeChange(moment(`${moment().format('YYYY-MM-DD')} 07:00:00`).format('H:m'), '.flatpikr-1');
            })
            changeStatusEvent();
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
                maxFileSize: '10MB',
                allowFileTypeValidation: true,
                acceptedFileTypes: ['image/*'],
            });
            // $('#sender_phone_number').change(function() {
            //     $.ajax({
            //         type: "GET",
            //         url: `{{ env('WHATSAPP_URL') }}phone-check/${unFormattedPhoneNumber(this.value)}`,
            //         dataType: "json",
            //         success: function(response) {
            //             $('#sender_phone_number').removeClass('is-invalid');
            //             if (window.state == 'add') {
            //                 $('#save-event').removeClass('disabled');
            //             } else {
            //                 $('#update-event').removeClass('disabled');
            //             }
            //         },
            //         error: function(error) {
            //             $('#sender_phone_number').addClass('is-invalid');
            //             iziToast.error({
            //                 id: 'alert-event-form',
            //                 title: 'Error',
            //                 message: error.responseJSON.message,
            //                 position: 'topRight',
            //                 layout: 2,
            //                 displayMode: 'replace'
            //             });
            //             $('#save-event').addClass('disabled');
            //             $('#update-event').addClass('disabled');
            //         }
            //     });
            // });
            $('#reload-event').click(debounce(function() {
                window.datatableEvent.ajax.reload();
            }, 1000));
        });
    </script>
@endsection
