@extends('layouts.master')
@section('level2', 'Dashboard')
@section('title', 'Dashboard & Analitic')

@section('content')

<div class="row">
    <div class="col-xl-6 col-xxl-5 d-flex">
        <div class="card flex-fill w-100">
            <div class="card-body">
                <div id="calendar"></div>
                <a class="eventOnly"><span class="mdi mdi-checkbox-blank-circle" style="color: #f98c01;"></span> Event</a>
                <a class="rentalOnly"><span class="mdi mdi-checkbox-blank-circle pl-4" style="color: #3b7ddd;"></span> Rental</a>
                <a class="rentalOnly"><span class="mdi mdi-checkbox-blank-circle pl-4" style="color: #d0d0d0;"></span> Approved</a>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-xxl-7">
        <div class="card flex-fill w-100">
            <div class="card-header">
                <h5 class="card-title">Event & Rental
                    <a href="/dashboard" class="float-right text-secondary"><span class="mdi mdi-reload"></span></a>
                </h5>
                <h6 class="card-subtitle text-muted">List Active <code>Event & Rental</code> During <b class="timeline-time">Month {{ \Carbon\Carbon::now()->format('F, Y') }}</b>.</h6>
            </div>
            <div class="card-body pt-0" style="height: 447px;overflow-y: auto;overflow-x: hidden;">
                <ul class="timeline">
                    @include('dashboard._timeline')
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-6 col-xxl-5 d-flex">
        <div class="w-100">
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Total Event</h5>
                            <h1 class="display-5 mt-1 mb-3">{{ $data->totalEvent }} Transaction</h1>
                            <div class="mb-1">
                                {{-- <span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> -3.65% </span> --}}
                                <span class="text-muted">Since frist use this apps</span>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Total Rental</h5>
                            <h2 class="display-5 mt-1 mb-3">{{ $data->totalRental }} Transaction</h2>
                            <div class="mb-1">
                                {{-- <span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i> 5.25% </span> --}}
                                <span class="text-muted">Since frist use this apps</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Earnings Event</h5>
                            <h2 class="display-5 mt-1 mb-3">{{ $data->EarningEvent }}</h2>
                            <div class="mb-1">
                                {{-- <span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i> 6.65% </span> --}}
                                <span class="text-muted">Just estimation</span>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Earnings Event</h5>
                            <h2 class="display-5 mt-1 mb-3">{{ $data->EarningRental }}</h2>
                            <div class="mb-1">
                                {{-- <span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> -2.25% </span> --}}
                                <span class="text-muted">Just estimation</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-xxl-7">
        <div class="card flex-fill w-100">
            <div class="card-header">
                <h5 class="card-title mb-0">Monthly Chart, <b>2021</b></h5>
            </div>
            <div class="card-body py-3">
                <div class="chart chart-sm">
                    <canvas id="chartjs-dashboard-line"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@include('dashboard.script')
