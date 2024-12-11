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
                                    <p class="fw-medium text-muted mb-0">@lang('translation.mail_in')</p>
                                    <h2 class="mt-4 ff-secondary cfs-22 fw-semibold"><span class="counter-value" data-target="{{ $countIn }}">0</span></h2>
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
                                    <p class="fw-medium text-muted mb-0">@lang('translation.mail_out')</p>
                                    <h2 class="mt-4 ff-secondary cfs-22 fw-semibold"><span class="counter-value" data-target="{{ $countOut }}">0</span>
                                    </h2>
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
                                    <p class="fw-medium text-muted mb-0">@lang('translation.mail_process')</p>
                                    <h2 class="mt-4 ff-secondary cfs-22 fw-semibold"><span class="counter-value" data-target="{{ $countProcess }}">0</span>
                                    </h2>
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
            <h4 class="card-title mb-0">@lang('translation.upcoming_events') :</h4>
        </div>
        <div class="card-body pt-0">
            @forelse ($eventHighlights as $event)
                <a href="{{ route('event.show-timeline', $event->id) }}" target="_blank" class="mini-stats-wid d-flex align-items-center mt-3">
                    <div class="flex-shrink-0 avatar-sm">
                        <span class="mini-stat-icon avatar-title rounded-circle text-light bg-light-subtle fs-4">
                            <img style="filter: grayscale(100%);" src="{{ $event->file_attachment }}" alt="">
                        </span>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-1">{{ $event->name }}</h6>
                        <p class="text-muted mb-0">{{ $event->recipient }}</p>
                    </div>
                    <div class="flex-shrink-0">
                        <p class="text-muted mb-0">{{ localizationDate($event->date) }}</p>
                    </div>
                </a>
            @empty
                <div class="mini-stats-wid d-flex align-items-center mt-3">
                    <div class="flex-shrink-0 avatar-sm">
                        <span class="mini-stat-icon avatar-title rounded-circle text-body-tertiary bg-body-tertiary fs-4">
                            404
                        </span>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-1">Tidak ada acara dalam waktu dekat</h6>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
    <!-- End Event -->
@endsection
