@extends('layouts.app')

@section('content')
<div class="container" data-aos="fade-down">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Sign Up</li>
          </ol>
        </nav>
      </div>

      <div class="container" data-aos="fade-up">
        <div class="row justify-content-center">
            <div class="col-lg-6 my-5">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <h1 class="h3 mb-3 font-weight-normal text-center">Please Sign Up</h1>

                    <label class="sr-only">Nama</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Nama" required autofocus>
                    @error('name')
                        <span class="invalid-feedback mb-3" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror 

                    <label class="sr-only">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Email" required>
                    @error('email')
                        <span class="invalid-feedback mb-3" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    
                    <label class="sr-only">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required>
                    @error('password')
                        <span class="invalid-feedback mb-3" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <label class="sr-only">Konfirmasi Password</label>
                    <input name="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Konfirmasi Password" required>
                    @error('password_confirmation')
                        <span class="invalid-feedback mb-3" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <button class="btn btn-lg btn-primary btn-block mt-3" type="submit">Sign Up</button>
                </form>
            </div>
        </div>
      </div>
@endsection