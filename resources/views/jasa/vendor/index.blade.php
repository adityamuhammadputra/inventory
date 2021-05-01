@extends('layouts.master')
@section('level1', 'Master')
@section('level2', 'Services')
@section('title', 'Vendor')

@section('content')
<div class="row">
    <div class="col-12">
        @include('jasa.vendor.form')
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header pt-4 pb-0">
                <h6 class="card-subtitle text-muted">Vendor List
                    <button class="btn btn-square btn-primary float-right" id="btn-add"><i class="fa fa-plus" data-action="/api/v1/jasa?model={{ $data->model }}"></i> Add New</button>
                </h6>
            </div>
            <div class="card-body pt-0">
                <table class="table" id="dataTable" data-model="{{ $data->model }}">
                    <thead>
                        <tr>
                            <th style="width: 5px;"></th>
                            <th>Vendor Code</th>
                            <th>Vendor Name</th>
                            <th>Contact</th>
                            <th>Price</th>
                            <th>Information</th>
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

