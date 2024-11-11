@extends('layouts.master-without-nav')
@section('title')
    @lang('translation.signin')
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
                                    <h5 class="text-primary">@lang('translation.welcome-back')</h5>
                                    <p class="text-muted">@lang('translation.please-sign-in') {{ env('APP_NAME') }}.</p>
                                </div>
                                <div class="p-2 mt-4">
                                    <form action="{{ route('login') }}" method="POST" id="form-login">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="username" class="form-label">@lang('translation.username') <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('username') is-invalid @enderror"
                                                value="{{ old('username', 'dev.rahmaan') }}" id="username" name="username"
                                                placeholder="@lang('translation.enter') username">
                                            @error('username')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <div class="float-end">
                                                <a href="{{ route('forgot-password') }}" class="text-muted">@lang('translation.forgot-password')</a>
                                            </div>
                                            <label class="form-label" for="password-input">@lang('translation.password') <span class="text-danger">*</span></label>
                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                <input type="password" class="form-control password-input pe-5 @error('password') is-invalid @enderror"
                                                    name="password" placeholder="@lang('translation.enter') password" id="password-input" value="mamanrecing">
                                                <button
                                                    class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon shadow-none"
                                                    type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="on" name="remember_me" id="remember_me">
                                            <label class="form-check-label" for="remember_me">@lang('translation.remember-me')</label>
                                        </div>

                                        <div class="mt-4">
                                            <button id="btn-login" class="btn btn-success w-100" type="button">@lang('translation.signin')</button>
                                        </div>

                                        <div class="mt-4 text-center">
                                            <div class="signin-other-title">
                                                <h5 class="fs-13 mb-4 title">@lang('translation.sign-in-with')</h5>
                                            </div>
                                            <div>
                                                <button type="button" class="btn btn-success btn-icon waves-effect waves-light"><i
                                                        class="ri-whatsapp-fill fs-16"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                        <div class="mt-4 text-center">
                            <p class="mb-0">@lang('translation.sign-up-now')<a href="{{ route('register') }}" class="fw-semibold text-primary text-decoration-underline">
                                    @lang('translation.signup') </a> </p>
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
                            <p class="mb-0 text-muted">&copy;
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> {{ env('APP_NAME') }}. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
    </div>
@endsection
@section('script')
    <script src="{{ asset('build/libs/particles.js/particles.js') }}"></script>
    <script src="{{ asset('build/js/pages/particles.app.js') }}"></script>
    <script src="{{ asset('build/js/pages/password-addon.init.js') }}"></script>
    <script src="{{ asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
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
        $(function() {
            $('#btn-login').click(function() {
                let data = serializeObject($('#form-login'));
                $.ajax({
                    type: "POST",
                    url: `{{ route('login') }}`,
                    data: data,
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
                            setTimeout(() => {
                                window.location = `{{ route('home') }}`;
                            }, 1000);
                        });
                    },
                    error: function(error) {
                        Swal.fire({
                            title: error.responseJSON.status,
                            text: error.responseJSON.message,
                            icon: 'error',
                            confirmButtonText: error.responseJSON.button ?? `@lang('translation.reload')`,
                            customClass: {
                                confirmButton: 'btn btn-danger w-xs mt-2',
                            },
                            buttonsStyling: false,
                            showCloseButton: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.close();
                            }
                        });
                    }
                });
            })
        });
    </script>
@endsection
