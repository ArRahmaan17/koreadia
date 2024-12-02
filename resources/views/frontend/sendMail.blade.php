<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Starter Page - QuickStart Bootstrap Template</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicons -->
    <link href="{{ asset('frontend') }}/assets/img/favicon.png" rel="icon">
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

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <!-- =======================================================
  * Template Name: QuickStart
  * Template URL: https://bootstrapmade.com/quickstart-bootstrap-startup-website-template/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/======================================================== -->
</head>

<body class="starter-page-page">

    <header id="header" class="header d-flex align-items-center sticky-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center">

            <a href="index.html" class="logo d-flex align-items-center me-auto">
                <img src="{{ asset('frontend') }}/assets/img/logo.png" alt="">
                <h1 class="sitename">QuickStart</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="#hero">Home</a></li>
                    <li><a href="#about">Tentang Kami</a></li>
                    <li><a href="#features">Fitur</a></li>
                    <li><a href="{{ route('sendMail') }}" class="active">Kirim Surat</a></li>
                    <li><a href="{{ route('tracking') }}">Lacak Surat</a></li>
                    <li><a href="#contact">Kontak Kami</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            <a class="btn-getstarted" href="{{ route('login') }}">{{ auth()->user() ? 'Dashboard' : 'Login' }}</a>

        </div>
    </header>

    <main class="main">

        <!-- Page Title -->
        <div class="page-title" data-aos="fade">
            <div class="container d-lg-flex justify-content-between align-items-center">
                <h1 class="mb-2 mb-lg-0">Starter Page</h1>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="index.html">Home</a></li>
                        <li class="current">Kirim Email</li>
                    </ol>
                </nav>
            </div>
        </div><!-- End Page Title -->

        <!-- Starter Section Section -->
        <section id="starter-section" class="starter-section section">

            <div class="container mt-2">
                <h1 class="text-center">Kirim Surat</h1>

                <!-- Form untuk kirim email -->
                <div class="justify-content-center mt-4">
                    <!-- Section 1 -->
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="number">Nomer</label>
                                <input type="text" id="number" class="form-control" placeholder="0001/TEST/PNDK/2024">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="perihal">Perihal</label>
                                <input type="text" id="perihal" class="form-control" placeholder="Masukan Perihal">
                            </div>
                        </div>
                    </div>
                    <!-- End Section 1 -->

                    <!-- Section 2 -->
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="agenda">Agenda</label>
                                <select name="priority_id" id="agenda" class="form-select">
                                    <option value="">PILIH </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="priority_id" class="form-label">Prioritas</label>
                                <select name="priority_id" id="priority_id" class="form-select select2">
                                    <option value="">PILIH </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- End Section 2 -->

                    <!-- Section 3 -->
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="type_id" class="form-label">Tipe</label>
                                <select name="type_id" id="type_id" class="form-select select2">
                                    <option value="">PILIH</option>
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
                    <!-- End Section 3 -->

                    <!-- Section 4 -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="sender" class="form-label">Pengirim</label>
                                <input type="text" class="form-control" placeholder="Masukan Pengirim" id="sender" name="sender">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="sender_phone_number" class="form-label">Nomor telepon pengirim</label>
                                <input type="text" class="form-control phone_number" placeholder="(+62) 895-451-4512" id="sender_phone_number" name="sender_phone_number">
                                <div id="emailHelp" class="form-text">nomor telepon harus nomor WhatsApp yang valid</div>
                            </div>
                        </div>
                    </div>
                    <!-- End Section 4 -->

                    <!-- Section 5 -->
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="file_attachment" class="form-label" style="display: inline-block;">Lampiran berkas</label>
                                <input type="file" class="form-control filepond-input-multiple" id="file_attachment" name="file_attachment" aria-describedby="file_attachment_help">
                                <div id="file_attachment_help" class="form-text d-none">Menambahkan file inputan diatas dapat menghilangkan file sebelumnya</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <div class="g-recaptcha" data-sitekey="6LcUF5AqAAAAABKjEz6gb6pXI-GBK3dKacfvEBsd"></div>
                            </div>
                        </div>
                    </div>
                    <!-- End Section 5 -->
                </div>

                <!-- Hasil kirim email -->
                <div id="result" class="mt-4"></div>
            </div>

        </section><!-- /Starter Section Section -->

    </main>

    <footer id="footer" class="footer position-relative light-background">

        <div class="container footer-top">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6 footer-about">
                    <a href="index.html" class="logo d-flex align-items-center">
                        <span class="sitename">QuickStart</span>
                    </a>
                    <div class="footer-contact pt-3">
                        <p>A108 Adam Street</p>
                        <p>New York, NY 535022</p>
                        <p class="mt-3"><strong>Phone:</strong> <span>+1 5589 55488 55</span></p>
                        <p><strong>Email:</strong> <span>info@example.com</span></p>
                    </div>
                    <div class="social-links d-flex mt-4">
                        <a href=""><i class="bi bi-twitter-x"></i></a>
                        <a href=""><i class="bi bi-facebook"></i></a>
                        <a href=""><i class="bi bi-instagram"></i></a>
                        <a href=""><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Useful Links</h4>
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">About us</a></li>
                        <li><a href="#">Services</a></li>
                        <li><a href="#">Terms of service</a></li>
                        <li><a href="#">Privacy policy</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Our Services</h4>
                    <ul>
                        <li><a href="#">Web Design</a></li>
                        <li><a href="#">Web Development</a></li>
                        <li><a href="#">Product Management</a></li>
                        <li><a href="#">Marketing</a></li>
                        <li><a href="#">Graphic Design</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-12 footer-newsletter">
                    <h4>Our Newsletter</h4>
                    <p>Subscribe to our newsletter and receive the latest news about our products and services!</p>
                    <form action="forms/newsletter.php" method="post" class="php-email-form">
                        <div class="newsletter-form"><input type="email" name="email"><input type="submit" value="Subscribe"></div>
                        <div class="loading">Loading</div>
                        <div class="error-message"></div>
                        <div class="sent-message">Your subscription request has been sent. Thank you!</div>
                    </form>
                </div>

            </div>
        </div>

        <div class="container copyright text-center mt-4">
            <p>© <span>Copyright</span> <strong class="px-1 sitename">QuickStart</strong><span>All Rights Reserved</span></p>
            <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you've purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
                Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
            </div>
        </div>

    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('build/js/pages/plugins/jquery.min.js') }}"></script>

    <script src="{{ asset('frontend') }}/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/vendor/php-email-form/validate.js"></script>
    <script src="{{ asset('frontend') }}/assets/vendor/aos/aos.js"></script>
    <script src="{{ asset('frontend') }}/assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="{{ asset('build/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('build/libs/flatpickr/l10n/id.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('frontend') }}/assets/js/main.js"></script>
    <script>
        $(".flatpikrc").flatpickr({
            "locale": "id"
        });
    </script>

</body>

</html>