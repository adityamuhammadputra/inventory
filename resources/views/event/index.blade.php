@extends('layouts.master')
@section('level1', 'Transaction')
@section('level2', 'Event')
@section('title', 'Event Equipment & Item')

@section('content')
<div class="row">
    <div class="col-12">
        @include('event._form')
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header pt-4 pb-0">
                <h6 class="card-subtitle text-muted">Rental List
                    <button class="btn btn-square btn-primary float-right" id="btn-add" data-action="/event"><i class="fa fa-plus"></i> Add New</button>
                </h6>
            </div>
            <div class="card-body pt-0">
                @include('event.filter')
                <table class="table" id="dataTable">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Noreg</th>
                            <th>Vendor</th>
                            <th>Client</th>
                            <th>Event Detail</th>
                            <th>Event Date</th>
                            <th>Operator</th>
                            <th>Equipment</th>
                            <th>Item</th>
                            <th>Subtotal</th>
                            <th>Discount</th>
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
@include('event.script')

