@extends('layouts.public')
@section('content')
<!-- Page Title -->
<div class="page-title" data-aos="fade">
    <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Starter Page</h1>
        <nav class="breadcrumbs">
            <ol>
                <li><a href="index.html">Home</a></li>
                <li class="current">Tracking Surat</li>
            </ol>
        </nav>
    </div>
</div><!-- End Page Title -->

<!-- Starter Section Section -->
<section id="starter-section" class="starter-section section">

    <div class="container mt-5">
        <h1 class="text-center">Tracking Surat</h1>

        <!-- Form untuk tracking -->
        <div class="row justify-content-center mt-4">
            <div class="col-md-6">
                <form id="trackForm">
                    <div class="mb-3">
                        <label for="nomor_surat" class="form-label">Nomor Surat</label>
                        <input type="text" class="form-control" id="nomor_surat" name="nomor_surat" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Track</button>
                </form>
            </div>
        </div>

        <!-- Hasil tracking -->
        <div id="result" class="mt-4"></div>
    </div>

</section><!-- /Starter Section Section -->

<!-- Vendor JS Files -->
<script src="{{ asset('build/js/pages/plugins/jquery.min.js') }}"></script>

<script src="{{ asset('frontend') }}/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('frontend') }}/assets/vendor/php-email-form/validate.js"></script>
<script src="{{ asset('frontend') }}/assets/vendor/aos/aos.js"></script>
<script src="{{ asset('frontend') }}/assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="{{ asset('frontend') }}/assets/vendor/swiper/swiper-bundle.min.js"></script>

<!-- Main JS File -->
<script src="{{ asset('frontend') }}/assets/js/main.js"></script>
<script>
    $(document).ready(function() {
        $('#trackForm').on('submit', function(e) {
            e.preventDefault();

            let nomorSurat = $('#nomor_surat').val();

            $.ajax({
                url: '/tracking', // Endpoint untuk tracking surat
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    number: nomorSurat
                },
                success: function(response) {
                    if (response.status === 'success') {
                        let data = response.data[0]; // Ambil data surat pertama
                        let histories = data.histories; // Ambil semua history transaksi

                        // Menampilkan data tracking
                        $('#result').html(`
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Detail Surat</h5>
                                </div>
                                <div class="card-body">
                                    <p><strong>Nomor Surat:</strong> ${data.number}</p>
                                    <p><strong>Regarding:</strong> ${data.regarding}</p>
                                    <p><strong>Date:</strong> ${data.date}</p>
                                    <p><strong>Sender:</strong> ${data.sender}</p>
                                    <p><strong>Sender Phone:</strong> ${data.sender_phone_number}</p>
                                    <p><strong>Status:</strong> ${data.status}</p>
                                    <p><strong>Date In:</strong> ${data.date_in}</p>
                                    <p><strong>File Attachment:</strong> <a href="${data.file_attachment}" target="_blank" class="btn btn-link">Download</a></p>
                                </div>
                            </div>

                            <!-- Transaction History Table -->
                            <div class="card mt-4">
                                <div class="card-header">
                                    <h5 class="card-title">Transaction History</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Status</th>
                                                <th>User</th>
                                                <th>Phone</th>
                                                <th>Avatar</th>
                                                <th>Timestamp</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ${histories.map((history, index) => `
                                                <tr>
                                                    <td>${index + 1}</td>
                                                    <td>${history.current_status}</td>
                                                    <td>${history.user.name}</td>
                                                    <td>${history.user.phone_number}</td>
                                                    <td><img src="${history.user.avatar}" alt="${history.user.name}" class="rounded-circle" width="50"></td>
                                                    <td>${history.created_at}</td>
                                                </tr>
                                            `).join('')}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        `);
                    } else {
                        $('#result').html('<div class="alert alert-danger">Surat tidak ditemukan.</div>');
                    }
                },
                error: function() {
                    $('#result').html('<div class="alert alert-danger">Terjadi kesalahan. Silakan coba lagi.</div>');
                }
            });
        });
    });
</script>
@endsection