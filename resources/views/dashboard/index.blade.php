@extends('layouts.master')
@section('level2', 'Dashboard')
@section('title', 'Dashboard & Analitic')

@section('content')

<div class="row">
    <div class="col-xl-6 col-xxl-5 d-flex">
        <div class="card flex-fill w-100">
            <div class="card-body">
                <div id="calendar"></div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-xxl-7">
        <div class="card flex-fill w-100">
            <div class="card-header">
                <h5 class="card-title">Bordered Table</h5>
                <h6 class="card-subtitle text-muted">Add <code>.table-bordered</code> for borders on all sides of the table and cells.</h6>
            </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width:40%;">Name</th>
                            <th style="width:25%">Phone Number</th>
                            <th class="d-none d-md-table-cell" style="width:25%">Date of Birth</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
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
                            <h5 class="card-title mb-4">Sales</h5>
                            <h1 class="display-5 mt-1 mb-3">2.382</h1>
                            <div class="mb-1">
                                <span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> -3.65% </span>
                                <span class="text-muted">Since last week</span>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Visitors</h5>
                            <h1 class="display-5 mt-1 mb-3">14.212</h1>
                            <div class="mb-1">
                                <span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i> 5.25% </span>
                                <span class="text-muted">Since last week</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Earnings</h5>
                            <h1 class="display-5 mt-1 mb-3">$21.300</h1>
                            <div class="mb-1">
                                <span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i> 6.65% </span>
                                <span class="text-muted">Since last week</span>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Orders</h5>
                            <h1 class="display-5 mt-1 mb-3">64</h1>
                            <div class="mb-1">
                                <span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> -2.25% </span>
                                <span class="text-muted">Since last week</span>
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
                <h5 class="card-title mb-0">Penjualan <b>2021</b></h5>
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
