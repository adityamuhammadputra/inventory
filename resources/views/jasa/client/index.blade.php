@extends('layouts.master')
@section('level1', 'Master')
@section('level2', 'Jasa')
@section('title', 'Client')

@section('content')
<div class="row">
    <div class="col-12">
        @include('jasa.client.form')
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header pt-4 pb-0">
                <h6 class="card-subtitle text-muted">Daftar Client
                    <button class="btn btn-square btn-primary float-right" id="btn-add"><i class="fa fa-plus"></i> Tambah</button>
                </h6>
            </div>
            <div class="card-body pt-0">
                <table class="table" id="dataTable" data-model="{{ $data->model }}">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Nama Client</th>
                            <th>Kontak</th>
                            <th>Alamat</th>
                            <th>Keterangan</th>
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

