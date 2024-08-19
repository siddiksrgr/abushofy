@extends('layouts.admin')

@section('title')
Edit User
@endsection

@section('content')
<!-- Page Content -->
<div class="col-md-9 ml-sm-auto col-lg-10 px-md-4 bg-light">
    <div class="container">
        <div class="dashboard-heading mt-3">
            <h2 class="dashboard-tittle">User</h2>
            <p class="dashboard-subtittle">Edit User</p>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $user->name }}" placeholder="Nama" required autofocus>
                                @error('name')
                                    <span class="invalid-feedback mb-3" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror 
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ $user->email }}" placeholder="Email" required>
                                @error('email')
                                    <span class="invalid-feedback mb-3" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required>
                                @error('password')
                                    <span class="invalid-feedback mb-3" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Konfirmasi Password</label>
                                <input name="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Konfirmasi Password" required>
                                @error('password_confirmation')
                                    <span class="invalid-feedback mb-3" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Role</label>
                                <select name="role" class="form-control" required>
                                    <option selected value="{{$user->role}}" class="text-uppercase">{{$user->role}}</option>
                                    <option disabled>--------------------</option>
                                    <option value="pembeli">PEMBELI</option>
                                    <option value="pegawai">PEGAWAI</option>
                                    <option value="pemilik">PEMILIK</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-success px-5 mt-3">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection