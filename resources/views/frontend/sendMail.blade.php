@extends('layouts.public')
@section('content')
<!-- Page Title -->
<div class="page-title" data-aos="fade">
    <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Starter Page</h1>
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
                    <div class="mb-3">
                        <label for="sender_phone_number" class="form-label">Nomor telepon pengirim</label>
                        <input type="tel" class="form-control phone_number" placeholder="(+62) 895-451-4512" id="sender_phone_number" name="sender_phone_number" pattern="^\+62\s?\d{3}[-\s]?\d{3}[-\s]?\d{4}$" title="Masukkan nomor telepon dengan format (+62) 895-451-4512">
                        <div class="form-text text-muted">
                            <small>Nomor telepon harus nomor WhatsApp yang valid</small>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Section 4 -->

            <!-- Section 5 -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="file_attachment" class="form-label" style="display: inline-block;">Lampiran berkas</label>
                        <input type="file" class="form-control filepond-input-multiple" id="file_attachment" name="file_attachment" aria-describedby="file_attachment_help">
                        <div id="file_attachment_help" class="form-text d-none">Menambahkan file inputan diatas dapat menghilangkan file sebelumnya</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="g-recaptcha" id="html_element"></div>
                    </div>
                </div>
            </div>
            <!-- End Section 5 -->
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Kirim Email</button>
                </div>
            </div>
        </div>

        <!-- Hasil kirim email -->
        <div id="result" class="mt-4"></div>
    </div>

</section>

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

    $(document).ready(function() {
        $('.phone_number').on('input', function() {
            if ($(this).val().length === 0 || $(this).val().indexOf('+62') !== 0) {
                $(this).val('+62 ' + $(this).val());
            }
        });
    });
</script>
@endsection