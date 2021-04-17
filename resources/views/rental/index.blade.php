@extends('layouts.master')
@section('level1', 'Transaksi')
@section('level2', 'Rental')
@section('title', 'Rental Equipment & Item')

@section('content')
<div class="row">
    <div class="col-12">
        {{-- @include('rental.filter') --}}
        @include('rental._form')
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header pt-4 pb-0">
                <h6 class="card-subtitle text-muted">Daftar Rental
                    <button class="btn btn-square btn-primary float-right" id="btn-add" data-action="/rental"><i class="fa fa-plus"></i> Tambah</button>
                </h6>
            </div>
            <div class="card-body pt-0">
                <a class="filter-icon"><span class="fa fa-filter"></span></a>
                <table class="table" id="dataTable">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Noreg</th>
                            <th>Client</th>
                            <th>Tanggal Rental</th>
                            <th>Jumlah Equipment</th>
                            <th>Jumlah Item</th>
                            <th>Subtotal</th>
                            <th>Diskon</th>
                            <th>Total</th>
                            <th>created at</th>
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
@include('rental.script')

