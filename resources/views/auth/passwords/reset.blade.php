@extends('layouts.master-without-nav')
@section('title')
    @lang('translation.password-reset')
@endsection
@section('content')
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
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
                            <div>
                                <a href="index" class="d-inline-block auth-logo">
                                    <img src="{{ URL::asset('build/images/logo-light.png') }}" alt="" height="20">
                                </a>
                            </div>
                            <p class="mt-3 fs-15 fw-medium">{{ env('APP_NAME') }}</p>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4">

                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">@lang('translation.forgot-password')</h5>
                                    <p class="text-muted">Reset password with {{ env('APP_NAME') }}</p>
                                    <lord-icon src="https://cdn.lordicon.com/fjuachvi.json" trigger="loop" delay="2000" state="hover-draw"
                                        style="width:100px;height:100px">
                                    </lord-icon>
                                </div>

                                <div class="alert border-0 alert-warning text-center mb-2 mx-2" role="alert">
                                    @lang('translation.reset-instructions')
                                </div>
                                <div class="p-2">
                                    <form class="form-horizontal" method="POST" action="{{ route('password-update') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="phone_number" class="form-label">@lang('translation.phone_number')</label>
                                            <input type="text" class="form-control phone_number @error('phone_number') is-invalid @enderror"
                                                id="phone_number" name="phone_number" placeholder="@lang('translation.enter') @lang('translation.phone_number')"
                                                value="{{ $phone_number ?? old('phone_number') }}" id="phone_number">
                                            @error('phone_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="userpassword">@lang('translation.password')</label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                                                id="userpassword" placeholder="@lang('translation.enter') @lang('translation.password')">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="userpassword">
                                                @lang('translation.confirm-password')
                                            </label>
                                            <input id="password-confirm" type="password" name="password_confirmation" class="form-control"
                                                placeholder="@lang('translation.enter')  @lang('translation.confirm-password')">
                                        </div>

                                        <div class="text-end">
                                            <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Reset</button>
                                        </div>

                                    </form><!-- end form -->
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                        <div class="mt-4 text-center">
                            <p class="mb-0">Wait, I remember my password... <a href="auth-signin-basic"
                                    class="fw-semibold text-primary text-decoration-underline"> Click here </a> </p>
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
        });
    </script>
@endsection
