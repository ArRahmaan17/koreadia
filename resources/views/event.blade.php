@extends('layouts.master')
@section('title')
    @lang('translation.event')
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('build/libs/datatable/dataTables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('build/libs/filepond/filepond.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('build/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css') }}">
    <link rel="stylesheet" href="{{ asset('build/libs/flatpickr/flatpickr.min.css') }}">
    <link href="{{ asset('build/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />
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
                            <th></th>
                            <th>@lang('translation.name')</th>
                            <th>@lang('translation.mail_date')</th>
                            <th>@lang('translation.recipient')</th>
                            <th>@lang('translation.event_file_attachment')</th>
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
                                    <input class="form-control js-choice" data-choices data-choices-text-unique-true data-choices-limit="your required limit"
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
                                            <input type="text" id="name1" name="agenda.name" placeholder="Enter the agenda name" class="form-control"
                                                required>
                                        </div>
                                        <div class="col-6 mb-2">
                                            <label class="form-label" for="time1">Time</label>
                                            <input type="text" id="time1" name="agenda.time" class="form-control flatpikr-1" required>
                                        </div>
                                        <div class="col-12 mb-2">
                                            <label for="speaker1" class="form-label">@lang('translation.speaker')</label>
                                            <input class="form-control js-choice" data-choices data-choices-text-unique-true
                                                data-choices-limit="your required limit" data-choices-removeItem type="text" name="agenda.speaker"
                                                id="speaker1" />
                                        </div>
                                        <div class="col-6 mb-2">
                                            <label class="form-label" for="online1">Online</label>
                                            <select class="form-control" id="online1" name="agenda.online">
                                                <option selected value="false">No</option>
                                                <option value="true">Yes</option>
                                            </select>
                                        </div>
                                        <div class="col-6 mb-2 online-no">
                                            <label class="form-label" for="location1">Location</label>
                                            <input type="text" id="location1" name="agenda.location" placeholder="Enter the location"
                                                class="form-control" required>
                                        </div>
                                        <div class="col-6 mb-2 online-yes d-none">
                                            <label class="form-label" for="meeting.id1">Id meeting</label>
                                            <input type="text" id="meeting.id1" name="agenda.meeting.id[]" placeholder="Enter the id"
                                                class="form-control" required>
                                        </div>
                                        <div class="col-6 mb-2 online-yes d-none">
                                            <label class="form-label" for="meeting.passcode1">Passcode meeting</label>
                                            <input type="text" id="meeting.passcode1" name="agenda.meeting.passcode[]" placeholder="Enter the passcode"
                                                class="form-control" required>
                                        </div>
                                        <div class="col-6 mb-2 online-yes d-none">
                                            <label class="form-label" for="meeting.topic1">Topic meeting</label>
                                            <input type="text" id="meeting.topic1" name="agenda.meeting.topic[]" placeholder="Enter the topic"
                                                class="form-control" required>
                                        </div>
                                    </div><!--end col-->
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="file_attachment" class="form-label">@lang('translation.mail_file_attachment')</label>
                                <input type="file" class="filepond-input-multiple" id="file_attachment" name="file_attachment"
                                    aria-describedby="file_attachment_help">
                                <div id="file_attachment_help" class="form-text d-none">@lang('translation.image_update_help')</div>
                            </div><!--end col-->
                        </div>
                    </form>
                </div><!--end row-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">@lang('translation.close')</button>
                    <button type="button" class="btn btn-soft-success" id="save-event">@lang('translation.save') @lang('translation.changes')</button>
                    <button type="button" class="btn btn-soft-warning d-none" id="update-event">@lang('translation.update') @lang('translation.changes')</button>
                </div>
            </div>
        </div>
    </div>
    <div id="modal-event-update" class="modal fade" tabindex="-1" aria-labelledby="modal-event-update-label" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-event-update-label">@lang('translation.add') @lang('translation.event')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-event-update">
                        <div class="row">
                            @csrf
                            <input type="hidden" name="id">
                            <div class="form-check form-switch" dir="ltr">
                                <input type="checkbox" class="form-check-input employee-checkbox" value="" name="employee[]" id="employee-all">
                                <label class="form-check-label" for="employee-all">@lang('translation.all')</label>
                            </div>
                            <div class="employee-container flex flex-wrap px-0">
                                @foreach ($employees as $employee)
                                    <div class="form-check form-switch" dir="ltr">
                                        <input type="checkbox" class="form-check-input employee-checkbox" @disabled(!$employee->valid)
                                            value="{{ $employee->id }}" name="employee[]" id="employee{{ $employee->id }}">
                                        <label class="form-check-label" for="employee{{ $employee->id }}">{{ $employee->name }}
                                            [{{ $employee->phone_number }}]<span
                                                class="badge border {{(($employee->valid)? 'border-success text-success': 'border-danger text-danger')}}">{{ ($employee->valid ? trans('translation.phone_number') . ' valid' : 'mohon validasi ' . trans('translation.phone_number')) }}</span></label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </form>
                </div><!--end row-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">@lang('translation.close')</button>
                    <button type="button" class="btn btn-soft-success" id="save-event-update">@lang('translation.save') @lang('translation.changes')</button>
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
    <script src="{{ asset('build/libs/swiper/swiper-bundle.min.js') }}"></script>
    <script>
        window.dataTableEvent = null;
        window.state = 'add';
        window.flatpickr = [];
        window.file_pond_file_attachment = undefined;
        window.swiper_timeline = undefined;

        function actionData() {
            $('.edit').click(function() {
                window.state = 'update';
                let idEvent = $(this).data("mailsin");
                $("#update-event").data("mailsin", idEvent);
                if (window.dataTableEvent.rows('.selected').data().length == 0) {
                    $('#table-event tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }

                var data = window.dataTableEvent.rows('.selected').data()[0];

                $('#modal-event-update').modal('show');
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
                if (window.dataTableEvent.rows('.selected').data().length == 0) {
                    $('#table-event tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                var data = window.dataTableEvent.rows('.selected').data()[0];
                $('#modal-file-event').modal('show');
                $('#modal-file-event').find('.modal-title').html(`File @lang('translation.event')`);
                $('#modal-file-event').find('.modal-body iframe').prop('src', `{{ url('/') }}/${fileId}`)
            });
            $('.delete').click(function() {
                if (window.dataTableEvent.rows('.selected').data().length == 0) {
                    $('#table-event tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                let idEvent = $(this).data("mailsin");
                var data = window.dataTableEvent.rows('.selected').data()[0];
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
                                    window.dataTableEvent.ajax.reload()
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
                if (window.dataTableEvent.rows('.selected').data().length == 0) {
                    $('#table-event tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                let idEvent = $(this).data("mailsin");
                var data = window.dataTableEvent.rows('.selected').data()[0];
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
            $('.send-broadcast').click(function() {
                $('#modal-event-update').modal('show');
                $('#modal-event-update').find('input[name=id]').val($(this).data('event'));
                $('#modal-event-update').find('#save-event-update').data('event', $(this).data('event'));
            });
            $('.show-timeline').click(function() {
                let id = $(this).data('event');
                window.open(`{{ route('event.show-timeline') }}/${id}`, true);
            });
        }

        function changeStatusEvent() {
            $('[name="agenda.online"]').change(function() {
                if (this.value == 'true') {
                    $(this).parents('.container-input-agenda').find('.online-yes').removeClass('d-none').find('input').val('');
                    $(this).parents('.container-input-agenda').find('.online-no').addClass('d-none').find('input').val('');
                } else {
                    $(this).parents('.container-input-agenda').find('.online-no').removeClass('d-none').find('input').val('');
                    $(this).parents('.container-input-agenda').find('.online-yes').addClass('d-none').find('input').val('');
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
                    let countElement = $('.container-form-agenda').find('.container-input-agenda').length;
                    if (countElement > 1) {
                        let element = $('[name="time[]"]');
                        let matchElement = false;
                        let indexElementChange = 0;
                        let dateEvent = '';
                        let minTime = '';
                        let additionOrSubtraction = 0;
                        $.map(element, function(elementOrValue, indexOrKey) {
                            if ($(elementOrValue).prop('id') == $(changeElement).prop('id')) {
                                matchElement = true;
                                indexElementChange = indexOrKey;
                                dateEvent = $('#date').val();
                                additionOrSubtraction = moment(`${dateEvent} ${$(changeElement).val()}`).diff(moment(
                                        `${dateEvent} ${$(changeElement).data('lastTime')}`),
                                    'minutes', true);
                                $(elementOrValue).data('lastTime', $(changeElement).val());
                                minTime = moment(`${dateEvent} ${$(changeElement).val()}`).add(10, 'minutes');
                            }
                            if (matchElement && indexOrKey > indexElementChange) {
                                console.log(additionOrSubtraction)
                                let resultTime = moment(`${dateEvent} ${$(elementOrValue).val()}`).add(additionOrSubtraction, 'minutes');
                                window.flatpickr[indexOrKey].set('defaultDate', resultTime.format('H:m'));
                                window.flatpickr[indexOrKey].set('minTime', minTime.format('H:m'));
                                window.flatpickr[indexOrKey].setDate(resultTime.format('H:m'), true);
                                $(elementOrValue).data('lastTime', resultTime.format('H:m'));
                            }
                            // if (matchElement && ($(element[indexElementChange]).data('lastTime') != undefined || indexOrKey >
                            //         indexElementChange)) {
                            //     let lastTimeEvent, timeEvent = '';
                            //     if ($(element[indexOrKey]).data('lastTime') == undefined) {
                            //         timeEvent = $(element[indexOrKey]).val();
                            //         lastTimeEvent = $(element[indexOrKey - 1]).data('lastTime');
                            //     } else {
                            //         lastTimeEvent = $(element[indexOrKey]).data('lastTime');
                            //         if (indexOrKey == 0) {
                            //             timeEvent = $(element[indexOrKey]).val();
                            //         } else {
                            //             timeEvent = $(element[indexOrKey - 1]).val();
                            //         }
                            //     }
                            //     console.log(indexOrKey, (countElement - 1))
                            //     if (indexOrKey != 0 || indexOrKey != (countElement - 1)) {
                            //         let dateEvent = $('#date').val();
                            //         let eventDuration = moment(`${dateEvent} ${timeEvent}`).diff(moment(`${dateEvent} ${lastTimeEvent}`),
                            //             'minutes', true);
                            //         let classList = $(elementOrValue).attr("class").split(/\s+/);
                            //         console.log(eventDuration)
                            //         // window.flatpickr[indexOrKey].destroy();
                            //         // setTimeChange(lastTimeUpdate, `.${classList[1]}`);
                            //     }
                            // } else {
                            //     console.log(elementOrValue)
                            // }
                        });
                    }
                } else {
                    $(changeElement).attr('last-time', this.value);
                }
            }, 1000))
        }

        function setupChoices(initial = true) {
            if (initial) {
                new Choices('.js-choice');
            } else {
                new Choices($('.js-choice:last-child')[0]);
            }
        }

        function swiperInit() {
            return new Swiper('.timelineSlider', {
                slidesPerView: 1,
                spaceBetween: 0,
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                autoplay: {
                    delay: 2500,
                    disableOnInteraction: false,
                },
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 20,
                    },
                    768: {
                        slidesPerView: 3,
                        spaceBetween: 40,
                    },
                    1024: {
                        slidesPerView: 4,
                        spaceBetween: 50,
                    },
                    1200: {
                        slidesPerView: 5,
                        spaceBetween: 50,
                    }
                }
            })
        }

        function swiperDestroy() {
            window.swiper_timeline.destroy(true, true);
        }

        function convertToAmPm(time) {
            // Split the time into hours, minutes, and seconds
            const [hour, minute, second] = time.split(":").map(Number);

            // Determine AM/PM
            const period = hour >= 12 ? "PM" : "AM";

            // Convert hour to 12-hour format
            const hour12 = hour % 12 || 12;

            // Return the formatted time
            return `${hour12.toString().padStart(2, '0')}:${minute.toString().padStart(2, '0')} ${period}`;
        }

        function format(d) {
            let html = '';
            d.detail_event.forEach(detail_event => {
                if (detail_event.online && (typeof detail_event.meeting) == 'string') {
                    detail_event.meeting = JSON.parse(detail_event.meeting);
                }
                let timeInterval = moment(`${d.date} ${detail_event.time}`).diff(moment(), 'second');
                let classBadge = timeInterval < 0 ? 'bg-success' : (timeInterval < 3600) ? 'bg-warning' : 'bg-secondary';
                html += `<div class="swiper-slide">
                            <div class="card pt-2 border-0 item-box text-center">
                                <div class="timeline-content p-3 rounded">
                                    <div>
                                        <h6 class="fs-2 mb-0">${detail_event.name}</h6>
                                        <dl class='mb-1'>${detail_event.speaker} - ${detail_event.location ?? 'daring'}</dl>
                                        <div class="container-fluid text-muted mt-0">
                                            ${(detail_event.online)?
                                                `<div class='col-12'><dl class='mb-1 d-flex'><dt class='col-12 col-md-6 col-lg-5 text-start'>Id:</dt><div class='col-12 col-md-6 col-lg-7 rounded text-start fw-bold'>${detail_event.meeting.id}</div></dl><dl class='mb-1 d-flex'><dt class='col-12 col-md-6 col-lg-5 text-start'>Code:</dt><div class='col-12 col-md-6 col-lg-7 rounded text-start fw-bold'>${detail_event.meeting.passcode}</div></dl><dl class='mb-1 d-flex'><dt class='col-12 col-md-6 col-lg-5 text-start'>Topic:</dt><div class='col-12 col-md-6 col-lg-7 rounded text-start fw-bold'>${detail_event.meeting.topic}</div></dl></div>`
                                            : ""}
                                        </div>
                                    </div>
                                </div>
                                <div class="time"><span class="badge ${classBadge}">${convertToAmPm(detail_event.time)}</span></div>
                            </div>
                        </div>`;
            });
            return (
                `<div class="col-lg-12">
                    <div>
                        <h5>@lang('translation.event_timeline')</h5>
                        <div class="horizontal-timeline my-3 bg-body-tertiary">
                            <div class="swiper timelineSlider">
                                <div class="swiper-wrapper p-3">
                                    ${html}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`
            );
        }
        $(function() {
            window.dataTableEvent = $('#table-event').DataTable({
                ajax: "{{ route('event.data-table') }}",
                processing: true,
                serverSide: true,
                order: [
                    [1, 'desc']
                ],
                columns: [{
                        target: 0,
                        className: 'dt-control',
                        orderable: false,
                        data: null,
                        defaultContent: ''
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
                        name: 'date',
                        data: 'date',
                        orderable: true,
                        searchable: true,
                        render: (data, type, row, meta) => {
                            return `<div class='text-wrap'>${data}</div>`
                        }
                    }, {
                        target: 3,
                        name: 'recipient',
                        data: 'recipient',
                        orderable: true,
                        searchable: true,
                        render: (data, type, row, meta) => {
                            return `<div class='text-wrap'>${data}</div>`
                        },
                    },
                    {
                        target: 4,
                        name: 'file_attachment',
                        data: 'file_attachment',
                        orderable: false,
                        searchable: false,
                        render: (data, type, row, meta) => {
                            return `<div class='d-flex justify-content-center'>${data}</div>`
                        },
                    },
                    {
                        target: 5,
                        name: 'admin',
                        data: 'admin',
                        orderable: true,
                        searchable: true,
                        render: (data, type, row, meta) => {
                            return `<div class='text-wrap'>${data}</div>`
                        }
                    }, {
                        target: 6,
                        name: 'action',
                        data: 'action',
                        orderable: true,
                        searchable: true,
                        render: (data, type, row, meta) => {
                            return `<div class='d-flex justify-content-center'>${data}</div>`
                        }
                    }
                ]
            });
            window.dataTableEvent.on('draw.dt', function() {
                actionData();
            });
            window.dataTableEvent.on('click', 'td.dt-control', function(e) {
                let tr = e.target.closest('tr');
                let row = window.dataTableEvent.row(tr);

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    swiperDestroy();
                } else {
                    // Open this row
                    row.child(format(row.data())).show();
                    window.swiper_timeline = swiperInit();
                }
            });
            $('#save-event').click(function() {
                let data = serializeObject($('#form-event'));
                let agendas = [];
                $.map($('.container-input-agenda'), function(elementOrValue, indexOrKey) {
                    let agenda = {};
                    $(elementOrValue).find('select, input:not(".d-none >input")[type=text]').map(function(indexOrKeyInput,
                        elementOrValueInput) {
                        let element = $(elementOrValueInput);
                        let elementId = element.prop('name').split('agenda.').join('').split('[]').join('');
                        if (element.val().trim() != '') {
                            agenda[elementId] = element.val();
                        }
                    });
                    agendas.push(agenda);
                });
                let file_attachment = data["file_attachment"];
                delete data["agenda.location"];
                delete data["agenda.name"];
                delete data["agenda.online"];
                delete data["agenda.speaker"];
                delete data["agenda.time"];
                delete data["agenda.meeting.id"];
                delete data["agenda.meeting.passcode"];
                delete data["agenda.meeting.topic"];
                delete data["file_attachment"];

                $.ajax({
                    type: "POST",
                    url: `{{ route('event.store') }}`,
                    data: {
                        ...data,
                        agendas: agendas,
                        file_attachment: JSON.parse(file_attachment),
                    },
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
                        window.dataTableEvent.ajax.reload();
                    },
                    error: function(error) {
                        $('#modal-event .is-invalid').removeClass('is-invalid')
                        $.each(error.responseJSON.errors, function(indexInArray,
                            valueOfElement) {
                            if (indexInArray.split('agendas.').length > 1) {
                                let indexSplitting = indexInArray.split('agendas.').join('').split('.')
                                let name = indexSplitting[1];
                                let index = indexSplitting[0];
                                $($('.container-input-agenda')[index]).find('[name="agenda.' + name + '"]').addClass(
                                    'is-invalid');
                            } else {
                                $('#modal-event').find('[name=' + indexInArray +
                                    ']').addClass('is-invalid')
                            }
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
            $('#save-event-update').click(function() {
                let id = $(this).data('event');
                let data = serializeObject($('#form-event-update'));
                $.ajax({
                    type: "PUT",
                    url: `{{ route('event.event-update') }}/${id}`,
                    data: {
                        ...data
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#modal-event-update').modal('hide')
                        iziToast.success({
                            id: 'alert-event-form',
                            title: 'Success',
                            message: response.message,
                            position: 'topRight',
                            layout: 2,
                            displayMode: 'replace'
                        });
                        window.dataTableEvent.ajax.reload();
                    },
                    error: function(error) {
                        $('#modal-event-update .is-invalid').removeClass('is-invalid')
                        $.each(error.responseJSON.errors, function(indexInArray,
                            valueOfElement) {
                            if (indexInArray.split('agendas.').length > 1) {
                                let indexSplitting = indexInArray.split('agendas.').join('').split('.')
                                let name = indexSplitting[1];
                                let index = indexSplitting[0];
                                $($('.container-input-agenda')[index]).find('[name="agenda.' + name + '"]').addClass(
                                    'is-invalid');
                            } else {
                                $('#modal-event').find('[name=' + indexInArray +
                                    ']').addClass('is-invalid')
                            }
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
                    $.map($(document).find('.container-input-agenda:last-child input:not(input.choices__input)'), function(elementOrValue,
                        indexOrKey) {
                        if ($(elementOrValue).parent('.d-none').length == 0 && $(elementOrValue).val() == '') {
                            $(elementOrValue).addClass('is-invalid');
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
                                <label class="form-label" for="name${nextIndex}">Name</label>
                                <input type="text" id="name${nextIndex}" name="agenda.name" placeholder="Enter the agenda name" class="form-control"
                                    required>
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-label" for="time${nextIndex}">Time</label>
                                <input type="text" id="time${nextIndex}" name="agenda.time" class="form-control flatpikr-${nextIndex}" required>
                            </div>
                            <div class="col-12 mb-2">
                                <label for="speaker${nextIndex}" class="form-label">@lang('translation.speaker')</label>
                                <input type="text" class="form-control js-choice" data-choices data-choices-text-unique-true
                                    data-choices-limit="your required limit" data-choices-removeItem  name="agenda.speaker" id="speaker${nextIndex}" />
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-label" for="online${nextIndex}">Online</label>
                                <select class="form-control" id="online${nextIndex}" name="agenda.online">
                                    <option selected value="false">No</option>
                                    <option value="true">Yes</option>
                                </select>
                            </div>
                            <div class="col-6 mb-2 online-no">
                                <label class="form-label" for="location${nextIndex}">Location</label>
                                <input type="text" id="location${nextIndex}" name="agenda.location" placeholder="Enter the location" class="form-control"
                                    required>
                            </div>
                            <div class="col-6 mb-2 online-yes d-none">
                                <label class="form-label" for="meeting.id${nextIndex}">Id meeting</label>
                                <input type="text" id="meeting.id${nextIndex}" name="agenda.meeting.id" placeholder="Enter the id" class="form-control"
                                    required>
                            </div>
                            <div class="col-6 mb-2 online-yes d-none">
                                <label class="form-label" for="meeting.passcode${nextIndex}">Passcode meeting</label>
                                <input type="text" id="meeting.passcode${nextIndex}" name="agenda.meeting.passcode" placeholder="Enter the passcode" class="form-control"
                                    required>
                            </div>
                            <div class="col-6 mb-2 online-yes d-none">
                                <label class="form-label" for="meeting.topic${nextIndex}">Topic meeting</label>
                                <input type="text" id="meeting.topic${nextIndex}" name="agenda.meeting.topic" placeholder="Enter the topic" class="form-control"
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
                setupChoices(false);
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
                        window.dataTableEvent.ajax.reload();
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
            });
            $('#modal-status-event').on('hidden.bs.modal', function() {
                $('#form-status-event')[0].reset();
                $('.employee-checkbox').prop('checked', false);
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
            });
            $('.employee-checkbox').click(function() {
                if (this.value == '' && $('.employee-checkbox[value=""]').prop('checked') == false) {
                    $('.employee-checkbox').prop('checked', false);
                } else if ((this.value == '' && $('.employee-checkbox[value=""]').prop('checked') == true) || $(
                        '.employee-checkbox:not(.employee-checkbox[value=""], .employee-checkbox:checked)').length == 0) {
                    $('.employee-checkbox').prop('checked', true);
                } else {
                    $('.employee-checkbox[value=""]').prop('checked', false);
                }
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
                window.dataTableEvent.ajax.reload();
            }, 1000));
        });
    </script>
@endsection
