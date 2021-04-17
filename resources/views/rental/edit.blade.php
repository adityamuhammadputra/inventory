@extends('layouts.master')
@section('level1', 'Transaksi')
@section('level2', 'Rental Detail')
@section('title', "Detail #$data->noReg")

@section('content')
<div class="row">
    <div class="col-12">
        @include('rental._form')
    </div>
</div>
@endsection
@include('rental.script')

