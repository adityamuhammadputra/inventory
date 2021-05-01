@extends('layouts.master')
@section('level1', 'Master')
@section('level2', 'Barang')
@section('title', $data->title)

@section('content')
<div class="row">
    <div class="col-12">
        @include('barang.filter')
        @include('barang.form')
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header pt-4 pb-0">
                <h6 class="card-subtitle text-muted">Daftar {{ $data->title }}
                    <button class="btn btn-square btn-primary float-right" id="btn-add" data-action="/api/v1/barang"><i class="fa fa-plus"></i> Add New</button>
                    <a class="btn btn-square btn-info float-right mr-2" href="/api/v1/print-barcode?q={{ $data->kategori }}" target="_blank"><i class="mdi mdi-printer"></i> Print Barcode</a>
                </h6>
            </div>
            <div class="card-body pt-0">
                <a class="filter-icon"><span class="fa fa-filter"></span></a>
                <table class="table" id="dataTable">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Barcode</th>
                            <th>Code</th>
                            <th>Kind</th>
                            <th>Brand</th>
                            <th>Type</th>
                            <th>Serial Number</th>
                            <th>Price</th>
                            <th>created at</th>
                            <th>5 last Logs</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                    <tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@include('barang.script')

