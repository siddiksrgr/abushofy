@extends('layouts.admin')

@section('title')
Edit Kategori
@endsection

@section('content')
<!-- Page Content -->
<div class="col-md-9 ml-sm-auto col-lg-10 px-md-4 bg-light">
    <div class="container">
        <div class="dashboard-heading mt-3">
            <h2 class="dashboard-tittle">Kategori</h2>
            <p class="dashboard-subtittle">Edit Kategori</p>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('category.update', $category->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Kategori Utama</label>
                                <select name="main_category" class="form-control" required>
                                    <option selected value="{{$category->main_category}}">{{$category->main_category}}</option>
                                    <option disabled value="">----------------------------</option>
                                    <option value="pakaian">Pakaian</option>
                                    <option value="aksesoris">Aksesoris</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Kategori Kelamin</label>
                                <select name="gender_category" class="form-control" required>
                                    <option selected value="{{$category->gender_category}}">{{$category->gender_category}}</option>
                                    <option disabled value="">----------------------------</option>
                                    <option value="pria">Pria</option>
                                    <option value="wanita">Wanita</option>
                                    <option value="pria & wanita">Pria & Wanita</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Nama Kategori</label>
                                <input type="text" name="name_category" class="form-control" value="{{ $category->name_category }}" placeholder="Nama Kategori.." required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
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