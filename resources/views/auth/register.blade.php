@extends('layouts.master-without-nav')
@section('title')
    @lang('translation.signup')
@endsection
@section('css')
    <link href="{{ asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="auth-page-wrapper pt-5">
        <!-- auth page bg -->
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay"></div>

            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>

        <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-4 text-white-50">
                            <p class="mt-3 fs-15 fw-medium">{{env('APP_NAME')}}</p>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4">

                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">Create New Account</h5>
                                    <p class="text-muted">Get your free {{ env('APP_NAME') }} account now</p>
                                </div>
                                <div class="p-2 mt-4">
                                    <form id="form-register">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="username" class="form-label"> @lang('translation.username') <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="username" value="{{ old('username') }}" id="username"
                                                placeholder="@lang('translation.enter') @lang('translation.username')">
                                            <span class="invalid-feedback" role="alert">
                                                <strong></strong>
                                            </span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="phone_number" class="form-label">@lang('translation.phone_number') <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control phone_number" name="phone_number" value="{{ old('phone_number') }}"
                                                id="phone_number" placeholder="@lang('translation.enter') @lang('translation.phone_number')">
                                            <span class="invalid-feedback" role="alert">
                                                <strong></strong>
                                            </span>
                                        </div>

                                        <div class="mb-3">
                                            <label for="password" class="form-label"> @lang('translation.password') <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" name="password" id="password"
                                                placeholder="@lang('translation.enter') @lang('translation.password')">
                                            <span class="invalid-feedback" role="alert">
                                                <strong></strong>
                                            </span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="confirm_password"> @lang('translation.confirm-password') <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" name="confirm_password" id="confirm_password"
                                                placeholder="@lang('translation.enter') @lang('translation.confirm-password')">
                                            <span class="invalid-feedback" role="alert">
                                                <strong></strong>
                                            </span>
                                        </div>
                                        <div class="mb-3">
                                            <p class="mb-0 fs-12 text-muted fst-italic">@lang('translation.consequence-warning') <a href="#"
                                                    class="text-primary text-decoration-underline fst-normal fw-medium">@lang('translation.tou')</a></p>
                                        </div>

                                        <div class="mt-3">
                                            <button class="btn btn-success w-100" type="button" id="btn-register">@lang('translation.signup')</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                        <div class="mt-4 text-center">
                            <p class="mb-0">@lang('translation.sign-in-now') <a href="{{ route('login') }}" class="fw-semibold text-primary text-decoration-underline">
                                    @lang('translation.signin') </a> </p>
                        </div>

                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        <!-- footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> {{ env('APP_NAME') }}. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand</p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
    </div>
    <!-- end auth-page-wrapper -->
@endsection
@section('script')
    <script src="{{ URL::asset('build/libs/particles.js/particles.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/particles.app.js') }}"></script>
    <script src="{{ asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(function() {
            formattedInput();
            $('#phone_number').change(function() {
                if (this.value != '') {
                    $.ajax({
                        type: "GET",
                        url: `{{ env('WHATSAPP_URL') }}phone-check/${unFormattedPhoneNumber(this.value)}`,
                        dataType: "json",
                        success: function(response) {
                            $('#sender_phone_number').removeClass('is-invalid');
                            if (window.state == 'add') {
                                $('#save-mail-in').removeClass('disabled');
                            } else {
                                $('#update-mail-in').removeClass('disabled');
                            }
                        },
                        error: function(error) {
                            $('#sender_phone_number').addClass('is-invalid');
                            iziToast.error({
                                id: 'alert-mail-in-form',
                                title: 'Error',
                                message: error.responseJSON.message,
                                position: 'topRight',
                                layout: 2,
                                displayMode: 'replace'
                            });
                            $('#save-mail-in').addClass('disabled');
                            $('#update-mail-in').addClass('disabled');
                        }
                    });
                }
            });
            $('#btn-register').click(function() {
                let data = serializeObject($('#form-register'));
                $.ajax({
                    type: "POST",
                    url: `{{ route('register') }}`,
                    data: {
                        ...data
                    },
                    dataType: "JSON",
                    success: function(response) {
                        Swal.fire({
                            title: response.status,
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: response.button,
                            customClass: {
                                confirmButton: 'btn btn-success w-xs mt-2',
                            },
                            buttonsStyling: false,
                            showCloseButton: true
                        }).then((result) => {
                            // setTimeout(() => {
                            //     window.location = `{{ route('home') }}`;
                            // }, 1000);
                        });
                    },
                    error: function(error) {
                        $.each(error.responseJSON.errors, function(indexInArray,
                            valueOfElement) {
                            $('#form-register').find('[name=' + indexInArray +
                                ']').addClass('is-invalid');
                            $('#form-register').find('[name=' + indexInArray +
                                ']').siblings('.invalid-feedback').find('strong').html(valueOfElement[0]);
                        });
                    }
                });
            })
        });
    </script>
@endsection
