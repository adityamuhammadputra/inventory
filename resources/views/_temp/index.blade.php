@extends('layouts.master')
@section('level2', 'User')
@section('level2', 'Profile')
@section('title', 'Profile' . request()->user()->name)

@section('content')
<div class="row">

</div>
@endsection
@include('item.script')

