@extends('layouts.master')
@section('level1', 'Transaksi')
@section('level2', 'Event Detail')
@section('title', "Detail #$data->noReg")

@section('content')
<div class="row">
    <div class="col-12">
        {{-- @include('rental.filter') --}}
        @include('event._form')
    </div>
</div>
@endsection
@include('event.script')

