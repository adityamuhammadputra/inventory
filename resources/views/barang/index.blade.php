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
                    <button class="btn btn-square btn-primary float-right" id="btn-add"><i class="fa fa-plus"></i> Tambah</button>
                </h6>
            </div>
            <div class="card-body pt-0">
                <a class="filter-icon"><span class="fa fa-filter"></span></a>
                <table class="table" id="dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>barcode</th>
                            <th>kode</th>
                            <th>jenis</th>
                            <th>merk</th>
                            <th>type</th>
                            <th>Serial Number</th>
                            <th>harga</th>
                            <th>status</th>
                            <th>action</th>
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

