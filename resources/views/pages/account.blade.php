@extends('layouts.app')

@section('title')
Akun
@endsection

@section('content')
<div class="container" data-aos="fade-down">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Akun</li>
        </ol>
    </nav> 

    @if(session()->has('message'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill"></i> {{ session('message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif


    <div class="row justify-content-center mb-3">
        <div class="col-lg-2">
            <div class="form-group gallery-container">
                <img src="{{ asset('storage/'. $user->photo) }}" alt="" class="w-100"> 
                @if($user->photo !== 'users/user-default.jpg')
                    <form action="/account/{{$user->id}}" method="POST">
                    @csrf
                    @method('delete')
                        <button type="submit" class="delete-gallery" data-toggle="tooltip" data-placement="right" title="Delete Photo" onclick="return confirm('Are you sure to delete your photo?')">
                            <img src="{{ asset('storage/product-card-remove.svg') }}" alt="">
                        </button>
                    </form>
                @else
                    <form action="/account/photo/{{$user->id}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" id="file" name="photo" style="display: none;" onchange="form.submit()">
                        <a type="button" class="add-gallery" onclick="thisFileUpload()">
                            <img src="{{ asset('storage/camera.png') }}" alt="" style="width:50px" data-toggle="tooltip" data-placement="right" title="Add Photo">
                        </a>
                    </form>
                @endif
            </div>
        </div>
    </div>

        <form action="/account/{{$user->id}}" method="POST">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{$user->name}}" required>
                        @error('name')
                        <span class="invalid-feedback mb-3" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control  @error('email') is-invalid @enderror" id="email" name="email" value="{{$user->email}}" required>
                        @error('email')
                        <span class="invalid-feedback mb-3" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="phone_number">Nomor Handphone</label>
                        <input type="number" class="form-control" id="phone_number" name="phone_number" value="{{$user->phone_number}}">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                        <small class="form-text text-muted">kosongkan jika tidak ingin ganti password</small>
                        @error('password')
                        <span class="invalid-feedback mb-3" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" class="form-control  @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation">
                        <small class="form-text text-muted">kosongkan jika tidak ingin ganti password</small>
                        @error('password_confirmation')
                        <span class="invalid-feedback mb-3" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-12 mt-3">
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </div>
        </form>
</div>
@endsection

@push('addon-script')
<script>
    function thisFileUpload() {
        document.getElementById("file").click()
    };
</script>
@endpush