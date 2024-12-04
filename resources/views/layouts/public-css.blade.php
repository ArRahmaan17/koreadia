<!-- Favicons -->
<link href="{{ asset('frontend/assets/img/favicon-32x32.png') }}" rel="icon">
<link href="{{ asset('frontend') }}/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

<!-- Fonts -->
<link href="https://fonts.googleapis.com" rel="preconnect">
<link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

<!-- Vendor CSS Files -->
<link href="{{ asset('frontend') }}/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="{{ asset('frontend') }}/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
<link href="{{ asset('frontend') }}/assets/vendor/aos/aos.css" rel="stylesheet">
<link href="{{ asset('frontend') }}/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
<link href="{{ asset('frontend') }}/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('/build/libs/flatpickr/flatpickr.min.css') }}">

<!-- Main CSS File -->
<link href="{{ asset('frontend') }}/assets/css/main.css" rel="stylesheet">

<script>
    function onLoadCallback() {
        grecaptcha.render('html_element', {
            sitekey: '6LcUF5AqAAAAABKjEz6gb6pXI-GBK3dKacfvEBsd',
        });
    }
</script>

<script src="https://www.google.com/recaptcha/api.js?onload=onLoadCallback&render=explicit" async defer></script>