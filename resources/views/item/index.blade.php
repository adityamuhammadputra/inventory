@extends('layouts.master')
@section('level1', 'Master')
@section('level2', 'Barang')
@section('title', 'Item')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">Advanced Filter</div>
            <div class="card-body">
                <form class="form" id="wrap-filter">
                    <select name="type" id="type" class="form-control select2">
                        <option disabled selected>---pilih type---</option>
                        <option value="1">Type 1</option>
                        <option value="2">Type 2</option>
                    </select>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header pt-4">
                <h6 class="card-subtitle text-muted">Daftar <code>Item</code>
                    <button class="btn btn-square btn-primary float-right"><i class="fa fa-plus"></i> Tambah</button>
                </h6>
            </div>
            <div class="card-body pt-0">
                <table class="table" id="dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>kode</th>
                            <th>jenis</th>
                            <th>merk</th>
                            <th>type</th>
                            <th>harga</th>
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
@include('item.script')

