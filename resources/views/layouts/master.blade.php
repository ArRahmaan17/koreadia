<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default" data-preloader="enable">

<head>
    <meta charset="utf-8" />
    <title>@yield('title') | {{ env('APP_NAME') }} - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('build/images/favicon.ico') }}">
    @include('layouts.head-css')
</head>

<body>
    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('layouts.topbar')
        @include('layouts.sidebar')
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid"  data-simplebar-track="primary">
                    @yield('content')
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            @include('layouts.footer')
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    @include('layouts.customizer')

    <!-- JAVASCRIPT -->
    @include('layouts.vendor-scripts')
    <script>
        function unFormattedPhoneNumber(formattedNumber) {
            // Remove any characters that are not digits
            let unformattedNumber = formattedNumber.replace(/\D/g, '');

            // Ensure the number starts with '62' after removing non-digit characters
            if (unformattedNumber.substr(0, 2) !== '62') {
                return 'Invalid Indonesian phone number.';
            }

            return unformattedNumber;
        }

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
            let html = "<option>Mohon Pilih</option>";

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

        function serializeFiles(node) {
            let form = $(node),
                formData = new FormData(),
                formParams = form.serializeArray();

            $.each(form.find('input[type="file"]'), function(i, tag) {
                if ($(tag)[0].files.length > 0) {
                    $.each($(tag)[0].files, function(i, file) {
                        formData.append(tag.name, file);
                    });
                }
            });

            $.each(formParams, function(i, val) {
                formData.append(val.name, val.value);
            });
            return formData;
        };

        function formattedInput() {
            $('.phone_number').inputmask('(+62) 999-999-9999[9]')
            // $('.number-mail').inputmask({
            //     regex: `[0-9A-Za-z]{3,10}\/[0-9A-Za-z]{2,10}\/[0-9A-Za-z]{2,4}\/\[0-9A-Za-z]{4}`
            // })
            $('.email').inputmask({
                mask: "*{1,15}[.*{1,15}][.*{1,15}][.*{1,15}]@*{1,15}[.*{2,6}][.*{1,2}]",
                greedy: false,
                onBeforePaste: function(pastedValue, opts) {
                    pastedValue = pastedValue.toLowerCase();
                    return pastedValue.replace("mailto:", "");
                },
                definitions: {
                    '*': {
                        validator: "[0-9A-Za-z!#$%&'*+/=?^_`{|}~\-]",
                    casing: "lower"
                }
            }
        });
    }

    function debounce(func, delay) {
        let timer;
        return function(...args) {
            clearTimeout(timer);
            timer = setTimeout(() => {
                func.apply(this, args);
            }, delay);
        };
    }
    </script>
    @if (env('APP_ENV') === 'production')
        <script>
            document.addEventListener('contextmenu', (e) => {
                e.preventDefault();
            })
        </script>
    @endif
</body>

</html>
