@extends('layouts.admin')

@section('title')
Akun
@endsection

@section('content')
<!-- Page Content -->
<div class="col-md-9 ml-sm-auto col-lg-10 px-md-4 bg-light">
    <div class="container">
        <div class="dashboard-heading mt-3">
            <h2 class="dashboard-tittle">Akun</h2>
            <p class="dashboard-subtittle">Data Akun</p>
        </div> 

        @if(session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill"></i> {{ session('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        <div class="card">
            <div class="card-body">
                        <table class="table table-hover scroll-horizontal-vertical w-100">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>HP</th>
                                    <th>Role</th>
                                    <th>Tanggal Daftar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->phone_number}}</td>
                                    <td class="text-uppercase">{{$user->role}}</td>
                                    <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d-m-Y, H:i') }}</td>
                                    <td>
                                        <a href="{{ route('account.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    </td>
                                </tr>

                            </tbody>
                    </table>
            </div>
        </div>
    </div>
</div>
@endsection
