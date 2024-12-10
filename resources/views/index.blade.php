@extends('layouts.master')
@section('title')
    @lang('translation.dashboards')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('translation.dashboards')
        @endslot
    @endcomponent

    <!-- Start mail -->
    <div class="row">
        <div class="d-flex flex-column h-100">
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-muted mb-0">Surat Masuk</p>
                                    <h2 class="mt-4 ff-secondary cfs-22 fw-semibold"><span class="counter-value" data-target="20">0</span></h2>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                            <i class="ri-mail-download-line text-info"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div> <!-- end card-->
                </div> <!-- end col-->
                <div class="col-12 col-md-4">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-muted mb-0">Surat Keluar</p>
                                    <h2 class="mt-4 ff-secondary cfs-22 fw-semibold"><span class="counter-value" data-target="12">0</span></h2>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-danger-subtle rounded-circle fs-2">
                                            <i class="ri-mail-send-line text-info"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div> <!-- end card-->
                </div> <!-- end col-->
                <div class="col-12 col-md-4">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-muted mb-0">Surat Diproses</p>
                                    <h2 class="mt-4 ff-secondary cfs-22 fw-semibold"><span class="counter-value" data-target="24">0</span></h2>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-success-subtle rounded-circle fs-2">
                                            <i class="ri-mail-settings-line text-info"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div> <!-- end card-->
                </div> <!-- end col-->
            </div> <!-- end row-->
        </div>
    </div>
    <!-- End mail  -->

    <!-- Start Event -->
    <div class="card">
        <div class="card-header border-0">
            <h4 class="card-title mb-0">Event Sekarang :</h4>
        </div>
        <div class="card-body pt-0">
            <div class="mini-stats-wid d-flex align-items-center mt-3">
                <div class="flex-shrink-0 avatar-sm">
                    <span class="mini-stat-icon avatar-title rounded-circle text-success bg-success-subtle fs-4">
                        09
                    </span>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="mb-1">Development planning</h6>
                    <p class="text-muted mb-0">iTest Factory </p>
                </div>
                <div class="flex-shrink-0">
                    <p class="text-muted mb-0">9:20 <span class="text-uppercase">am</span></p>
                </div>
            </div><!-- end -->
            <div class="mini-stats-wid d-flex align-items-center mt-3">
                <div class="flex-shrink-0 avatar-sm">
                    <span class="mini-stat-icon avatar-title rounded-circle text-success bg-success-subtle fs-4">
                        12
                    </span>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="mb-1">Design new UI and check sales</h6>
                    <p class="text-muted mb-0">Meta4Systems</p>
                </div>
                <div class="flex-shrink-0">
                    <p class="text-muted mb-0">11:30 <span class="text-uppercase">am</span></p>
                </div>
            </div><!-- end -->
            <div class="mini-stats-wid d-flex align-items-center mt-3">
                <div class="flex-shrink-0 avatar-sm">
                    <span class="mini-stat-icon avatar-title rounded-circle text-success bg-success-subtle fs-4">
                        25
                    </span>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="mb-1">Weekly catch-up </h6>
                    <p class="text-muted mb-0">Nesta Technologies</p>
                </div>
                <div class="flex-shrink-0">
                    <p class="text-muted mb-0">02:00 <span class="text-uppercase">pm</span></p>
                </div>
            </div><!-- end -->
            <div class="mini-stats-wid d-flex align-items-center mt-3">
                <div class="flex-shrink-0 avatar-sm">
                    <span class="mini-stat-icon avatar-title rounded-circle text-success bg-success-subtle fs-4">
                        27
                    </span>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="mb-1">James Bangs (Client) Meeting</h6>
                    <p class="text-muted mb-0">Nesta Technologies</p>
                </div>
                <div class="flex-shrink-0">
                    <p class="text-muted mb-0">03:45 <span class="text-uppercase">pm</span></p>
                </div>
            </div><!-- end -->
        </div>
    </div>
    <!-- End Event -->
@endsection
