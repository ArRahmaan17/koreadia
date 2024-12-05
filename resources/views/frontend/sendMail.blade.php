@extends('layouts.public')
@section('css')
    <link rel="stylesheet" href="{{ asset('build/libs/filepond/filepond.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('build/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css') }}">
    <link rel="stylesheet" href="{{ asset('build/libs/flatpickr/flatpickr.min.css') }}">
    <link href="{{ asset('build/libs/iziToast/iziToast.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <!-- Page Title -->
    <div class="page-title" data-aos="fade">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Kirim Surat</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="index.html">Home</a></li>
                    <li class="current">Kirim Surat</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <!-- Starter Section Section -->
    <section id="starter-section" class="starter-section section">
        <div class="container-lg mt-2">
            <h1 class="text-center">Kirim Surat</h1>
            <div class="justify-content-center mt-4">
                <form id="form-mail-in">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="number">Nomer</label>
                                <input type="text" id="number" name="number" class="form-control" placeholder="0001/TEST/PNDK/2024">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="regarding">Perihal</label>
                                <input type="text" name="regarding" id="regarding" class="form-control" placeholder="Masukan Perihal">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="agenda_id">Agenda</label>
                                <select name="agenda_id" id="agenda_id" class="form-select select2">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="priority_id" class="form-label">Prioritas</label>
                                <select name="priority_id" id="priority_id" class="form-select select2 select2">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="type_id" class="form-label">Tipe</label>
                                <select name="type_id" id="type_id" class="form-select select2 select2">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date" class="form-label">Tanggal</label>
                                <input type="text" class="form-control flatpikrc" placeholder="Masukan Tanggal" id="date" name="date">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="sender" class="form-label">Pengirim</label>
                                <input type="text" class="form-control" placeholder="Masukan Pengirim" id="sender" name="sender">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="sender_phone_number" class="form-label">Nomor telepon pengirim</label>
                            <input type="tel" class="form-control phone_number" placeholder="(+62) 895-451-4512" id="sender_phone_number"
                                name="sender_phone_number">
                            <div class="form-text text-muted">
                                <small>Nomor telepon harus nomor WhatsApp yang valid</small>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="file_attachment" class="form-label">Lampiran berkas</label>
                                <input type="file" class="filepond-input-multiple" id="file_attachment" name="file_attachment">
                            </div>
                        </div>
                        {{-- <div class="col-md-6">
                            <div class="form-group">
                                <label for="file_attachment" class="form-label">Validasi</label>
                                <div class="g-recaptcha" id="recaptcha"></div>
                            </div>
                        </div> --}}
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <button type="button" id="save-mail-in" class="btn btn-primary">Kirim Surat</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </section>
@endsection
@section('script')
    <!-- Vendor JS Files -->
    <script src="{{ asset('build/js/pages/plugins/jquery.min.js') }}"></script>
    <!-- filepond js -->
    <script src="{{ asset('build/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js') }}"></script>
    <script src="{{ asset('build/libs/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js') }}"></script>
    <script src="{{ asset('build/libs/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js') }}"></script>
    <script src="{{ asset('build/libs/filepond-plugin-file-encode/filepond-plugin-file-encode.min.js') }}"></script>
    <script src="{{ asset('build/libs/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.js') }}"></script>
    <script src="{{ asset('build/libs/filepond/filepond.min.js') }}"></script>

    <script src="{{ asset('frontend') }}/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/vendor/php-email-form/validate.js"></script>
    <script src="{{ asset('frontend') }}/assets/vendor/aos/aos.js"></script>
    <script src="{{ asset('frontend') }}/assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="{{ asset('build/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('build/libs/flatpickr/l10n/id.js') }}"></script>
    <script src="{{ asset('build/js/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('build/libs/select2/select2.min.js') }}"></script>
    <script src="{{ asset('build/libs/iziToast/iziToast.min.js') }}"></script>
    {{-- <script src="https://www.google.com/recaptcha/api.js?onload=onLoadCallback&render=explicit" async defer></script> --}}
    <!-- Main JS File -->
    <script src="{{ asset('frontend') }}/assets/js/main.js"></script>
    <script>
        window.recaptcha = undefined;

        // function onLoadCallback() {
        //     window.recaptcha = grecaptcha.render('recaptcha', {
        //         sitekey: `{{ env('KEY_RECAPTCHA') }}`,
        //     });
        // }

        function serializeObject(node) {
            var o = {};
            var a = node.serializeArray();
            $.each(a, function() {
                if (this.value !== "") {
                    if (o[this.name]) {
                        if (!o[this.name].push) {
                            o[this.name] = [o[this.name]];
                        }
                        o[this.name].push(this.value || '');
                    } else {
                        o[this.name] = this.value || '';
                    }
                }
            });
            return o;
        }

        function dataToOption(allData, attr = false) {
            let html = "<option value=''>Mohon Pilih</option>";

            allData.forEach(data => {
                if (attr) {
                    html +=
                        `<option data-attr='${data.attribute}' value='${data.id ? data.id : data.name}'>${data.name} ( Tersedia di ${data.attribute})</option>`;
                } else {
                    html += `<option value='${data.id ? data.id : data.name}'>${data.name}</option>`;
                }
            });

            return html;
        }

        $(function() {
            $('#save-mail-in').click(function() {
                let data = serializeObject($('#form-mail-in'));
                // let responseCaptcha = grecaptcha.getResponse(window.recaptcha)['g-recaptcha-response'];
                // $.ajax({
                //     type: "POST",
                //     headers: {
                //         "Access-Control-Allow-Origin": "*",
                //     },
                //     crossDomain: 'true',
                //     cache: false,
                //     url: "https://www.google.com/recaptcha/api/siteverify",
                //     data: {
                //         secret: `{{ env('KEY_RECAPTCHA') }}`,
                //         response: responseCaptcha,
                //     },
                //     dataType: "json",
                //     success: function(response) {
                $.ajax({
                    type: "POST",
                    url: `{{ route('mail.in.store') }}`,
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        $('.is-invalid').removeClass('is-invalid')
                        iziToast.success({
                            id: 'alert-mail-in-form',
                            title: 'Success',
                            message: response.message,
                            position: 'topRight',
                            layout: 2,
                            displayMode: 'replace'
                        });
                        $('#form-mail-in').find('select, input').map(function(index, element) {
                            $(element).val('').trigger('change');
                        });
                        window.file_pond_file_attachment.removeFiles(window.file_pond_file_attachment.getFiles());
                    },
                    error: function(error) {
                        $('.is-invalid').removeClass('is-invalid')
                        $.each(error.responseJSON.errors, function(indexInArray,
                            valueOfElement) {
                            $('#form-mail-in').find('[name=' + indexInArray +
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
                //     }
                // });
            });
            $.ajax({
                type: "GET",
                url: `{{ route('master.agenda.all') }}`,
                dataType: "json",
                success: function(response) {
                    $("#agenda_id").html(dataToOption(response.data));
                }
            });
            $.ajax({
                type: "GET",
                url: `{{ route('master.priority.all') }}`,
                dataType: "json",
                success: function(response) {
                    $("#priority_id").html(dataToOption(response.data));
                }
            });
            $.ajax({
                type: "GET",
                url: `{{ route('master.type.all') }}`,
                dataType: "json",
                success: function(response) {
                    $("#type_id").html(dataToOption(response.data));
                }
            });
            $(".flatpikrc").flatpickr({
                "locale": "id"
            });
            $('.phone_number').inputmask('(+62) 999-999-9999[9]')
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
            $('.select2').select2();
            var file_pond = document.getElementById('file_attachment');
            window.file_pond_file_attachment = FilePond.create(file_pond, {
                maxFiles: 1,
                maxFileSize: '50MB',
                allowFileTypeValidation: true,
                acceptedFileTypes: ['application/pdf'],
            });
        });
    </script>
@endsection
