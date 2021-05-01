@extends('layouts.master')
@section('level1', 'User')
@section('level2', 'Profile')
@section('title', 'Profile ' . request()->user()->name)

@section('content')
<div class="row">
    <div class="col-md-4 col-xl-3">
        <div class="card mb-3">
            <form action="/profile/{{ request()->user()->id }}" method="POST" id="form-submit" >
                @csrf
                @method('PATCH')
                <div class="card-header">
                    <h5 class="card-title mb-0">Profile Details
                        <a class="userEdit" href="#"><span data-feather="edit" class="feather-sm float-right"></span></a>
                        <a class="saveEdit" href="#" style="display: none;"><span class="mdi mdi-check-circle float-right"></span></a>
                        <a class="cancelEdit text-default" href="/profile" style="display: none;"><span class="mdi mdi-close float-right"></span></a>
                    </h5>
                </div>
                <div class="card-body text-center">
                    <img src="{{ request()->user()->avatar ?? '/img/avatars/1.jpg' }}" alt="Christina Mason" class="img-fluid rounded-circle mb-2" width="128" height="128" />
                    <h5 class="card-title mb-0">{{ request()->user()->name }}</h5>
                    <div>
                        <a class="btn btn-primary btn-sm" href="#"><span data-feather="award"></span> Admin Aplikasi</a>
                    </div>
                </div>
                <hr class="my-0" />
                <div class="card-body">
                    <h5 class="h6 card-title">Notes</h5>
                    <textarea class="form-control notes" name="" id="notes-temp"></textarea>
                    <textarea class="form-control" name="notes" id="notes" style="display: none;">{{ request()->user()->notes ?? 'Hello there im using Panorama Apps' }}</textarea>
                </div>
                <hr class="my-0" />
                <div class="card-body">
                    <h5 class="h6 card-title">About</h5>
                    <ul class="list-unstyled mb-0" id="temp-attr">
                        <li class="mb-1">
                            <span data-feather="user" class="feather-sm mr-1"></span> <a href="#">{{ request()->user()->name }}</a>
                        </li>
                        <li class="mb-1">
                            <span data-feather="mail" class="feather-sm mr-1"></span> <a href="#">{{ request()->user()->email }}</a>
                        </li>
                        <li class="mb-1">
                            <span data-feather="smartphone" class="feather-sm mr-1"></span> <a href="#">{{ request()->user()->phone ?? '-' }}</a>
                        </li>
                        <li class="mb-1">
                            <span data-feather="power" class="feather-sm mr-1"></span> Created At <a href="#">{{ dateTimeOutput(request()->user()->created_at) ?? '' }}</a>
                        </li>
                    </ul>
                    <ul class="list-unstyled mb-0" style="display: none;" id="attr">
                        <li class="mb-1">
                            <span data-feather="user" class="feather-sm mr-1"></span> <input type="text" class="name" id="name" name="name" value="{{ request()->user()->name ?? '-' }}" required>
                        </li>
                        <li class="mb-1">
                            <span data-feather="mail" class="feather-sm mr-1"></span> <input type="email" class="email" id="email" name="email" value="{{ request()->user()->email }}" required>
                        </li>
                        <li class="mb-1">
                            <span data-feather="smartphone" class="feather-sm mr-1"></span> <input type="number" class="phone" id="phone" name="phone" value="{{ request()->user()->phone ?? '-' }}" required>
                        </li>
                        <li class="mb-1">
                            <span data-feather="lock" class="feather-sm mr-1"></span>
                            <input type="password" class="password" id="password" name="password" placeholder="Password" data-rule-password="true" required min="8">
                            <input type="password" class="confirm_password" id="confirm_password" name="confirm_password" placeholder="Password Confirmation"
                                data-rule-password="true"
                                data-rule-equalTo="#password"
                                required
                                min="8"
                                style="margin-left: 22px;">
                        </li>
                        <hr>
                        <span class="mdi mdi-information"></span> Info <br>
                        Password minimal 8 caracter <br>
                        Password confirmation must be the same
                    </ul>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-8 col-xl-9">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Last Activities User</h5>
            </div>
            <div class="card-body h-100">
                @foreach ($data as $item)
                    <div class="media">
                        <i class="rounded-circle mr-2 text-{{ $item->icon->color }}" data-feather="{{ $item->icon->data }}" style="width: 30px; height: 30px;"></i>
                        <div class="media-body">
                            <small class="float-right text-navy">{{ $item->created_at->diffforhumans() }}</small>
                            <strong>{{ $item->user->name }} - {{ $item->content }} </strong><br />
                            <small class="text-muted">{{ $item->url }} | {{ $item->method }}</small><br />
                        </div>
                    </div>
                    <hr/>
                @endforeach
                <a href="#" class="btn btn-primary btn-block">Only 20 last Logs</a>
            </div>
        </div>
    </div>
</div>
@endsection
@include('profile.script')

