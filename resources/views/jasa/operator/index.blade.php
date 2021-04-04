@extends('layouts.master')
@section('level1', 'Master')
@section('level2', 'Jasa')
@section('title', 'Operator')

@section('content')
<div class="row">
    <div class="col-12">
        @include('jasa.operator.form')
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header pt-4 pb-0">
                <h6 class="card-subtitle text-muted">Daftar Operator
                    <button class="btn btn-square btn-primary float-right" id="btn-add"><i class="fa fa-plus"></i> Tambah</button>
                </h6>
            </div>
            <div class="card-body pt-0">
                <table class="table" id="dataTable" data-model="{{ $data->model }}">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Vendor</th>
                            <th>Kode</th>
                            <th>Nama Opertor</th>
                            <th>Tugas</th>
                            <th>Harga</th>
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
@include('jasa.script')

