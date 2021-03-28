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
                        <th>Date of Birth</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <img src="img/avatars/avatar-5.jpg" width="48" height="48" class="rounded-circle mr-2" alt="Avatar"> Vanessa Tucker
                        </td>
                        <td>864-348-0485</td>
                        <td>June 21, 1961</td>
                    </tr>
                    <tr>
                        <td>
                            <img src="img/avatars/avatar-2.jpg" width="48" height="48" class="rounded-circle mr-2" alt="Avatar"> William Harris
                        </td>
                        <td>914-939-2458</td>
                        <td>May 15, 1948</td>
                    </tr>
                    <tr>
                        <td>
                            <img src="img/avatars/avatar-3.jpg" width="48" height="48" class="rounded-circle mr-2" alt="Avatar"> Sharon Lessman
                        </td>
                        <td>704-993-5435</td>
                        <td>September 14, 1965</td>
                    </tr>
                    <tr>
                        <td>
                            <img src="img/avatars/avatar-4.jpg" width="48" height="48" class="rounded-circle mr-2" alt="Avatar"> Christina Mason
                        </td>
                        <td>765-382-8195</td>
                        <td>April 2, 1971</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


@include('user.script')
@endsection
