@extends('layouts.admin')

@section('title')
Ukuran Pakaian
@endsection

@section('content')
<!-- Page Content -->
<div class="col-md-9 ml-sm-auto col-lg-10 px-md-4 bg-light">
    <div class="container">
        <div class="dashboard-heading mt-3">
            <h2 class="dashboard-tittle">Ukuran Pakaian</h2>
            <p class="dashboard-subtittle">Data Ukuran Pakaian</p>
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
                <a href="/admin/clothing-size/create" class="btn btn-primary btn-sm mb-3"><i class="bi bi-plus-circle"></i> Tambah</a>
            @endif
                    <div class="table-responsive">
                        <table class="table table-hover scroll-horizontal-vertical w-100" id="dataTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Produk</th>
                                    <th>Nama Ukuran</th>
                                    <th>Panjang Badan</th>
                                    <th>Lebar Badan</th>
                                    <th>Panjang Tangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($clothing_sizes as $size)
                                <tr>
                                    <td class="text-bold">{{$loop->iteration}}</td>
                                    <td>{{$size->product->name}}</td>
                                    <td>{{$size->size_name}}</td>
                                    <td>{{$size->body_length}} cm</td>
                                    <td>{{$size->body_width}} cm</td>
                                    <td>{{$size->slevee_length}} cm</td>
                                    <td>
                                    @if(auth()->user()->role == 'pegawai')
                                        <div class="row">
                                            <a href="{{ route('clothing-size.edit', $size->id) }}" class="btn btn-warning btn-sm mr-1">Edit</a>
                                            <form action="{{ route('clothing-size.destroy', $size->id) }}" method="POST">
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
