@extends('layouts.master')
@section('level1', 'User')
@section('level2', 'User List')
@section('title', 'User List')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header pt-4">
                <h6 class="card-subtitle text-muted">Daftar <code>User/Pengguna</code> aplikasi. Hak akses semua <code>User</code> sama</h6>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Crated At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $key => $item)
                    <tr>
                        <td>
                            <img src="img/avatars/1.jpg" width="48" height="48" class="rounded-circle mr-2" alt="Avatar"> {{ $item->name }} <br> <a href="#" class="email-detail">{{ $item->email }}</a>
                        </td>
                        <td><span class="mdi mdi-account"></span></td>
                        <td>{{ $item->created_at }}</td>
                        <td>
                            <a href="#" class="userEdit">
                                <span data-feather="edit" class="mr-1"></span>
                                <span data-feather="trash-2" class="mr-1"></span>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@include('user.script')
