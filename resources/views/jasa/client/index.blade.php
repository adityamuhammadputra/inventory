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
                <h6 class="card-subtitle text-muted">Client List
                    <button class="btn btn-square btn-primary float-right" id="btn-add" data-action="/api/v1/jasa?model={{ $data->model }}"><i class="fa fa-plus"></i> Add New</button>
                </h6>
            </div>
            <div class="card-body pt-0">
                <table class="table" id="dataTable" data-model="{{ $data->model }}">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Nama Client</th>
                            <th>Contact</th>
                            <th>Address</th>
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

