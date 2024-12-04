<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-topbar="light" data-sidebar-image="none" data-theme="material" data-theme-colors="default">

<head>
    <meta charset="utf-8" />
    <title>@yield('title') | {{ env('APP_NAME') }} - {{env('APP_WILAYAH')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('build/images/favicon.ico') }}">
    @include('layouts.head-css')
    @yield('css')
</head>

@yield('body')

@yield('content')

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
</script>
</body>

</html>
