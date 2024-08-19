@extends('layouts.admin')

@section('title')
Kategori
@endsection

@section('content')
<!-- Page Content -->
<div class="col-md-9 ml-sm-auto col-lg-10 px-md-4 bg-light">
    <div class="container">
        <div class="dashboard-heading mt-3">
            <h2 class="dashboard-tittle">Kategori</h2>
            <p class="dashboard-subtittle">Data Kategori</p>
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
                @if(auth()->user()->role == 'pegawai')
                <a href="/admin/category/create" class="btn btn-primary btn-sm mb-3"><i class="bi bi-plus-circle"></i> Tambah</a>
                @endif
                    <div class="table-responsive">
                        <table class="table table-hover scroll-horizontal-vertical w-100" id="dataTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kategori Utama</th>
                                    <th>Kategori Kelamin</th>
                                    <th>Nama Kategori</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                <tr>
                                    <td class="text-bold">{{$loop->iteration}}</td>
                                    <td class="text-capitalize">{{$category->main_category}}</td>
                                    <td class="text-capitalize">{{$category->gender_category}}</td>
                                    <td class="text-capitalize">{{$category->name_category}}</td>
                                    <td>
                                    @if(auth()->user()->role == 'pegawai')
                                        <div class="row">
                                            <a href="{{ route('category.edit', $category->id) }}" class="btn btn-warning btn-sm mr-1">Edit</a>
                                            <form action="{{ route('category.destroy', $category->id) }}" method="POST">
                                                @method('delete') 
                                                @csrf()
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin akan menghapus data?')">Hapus</button>
                                            </form>
                                        </div>
                                    @endif 
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
