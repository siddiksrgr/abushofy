@extends('layouts.admin')

@section('title')
Stok Pakaian
@endsection

@section('content')
<!-- Page Content -->
<div class="col-md-9 ml-sm-auto col-lg-10 px-md-4 bg-light">
    <div class="container">
        <div class="dashboard-heading mt-3">
            <h2 class="dashboard-tittle">Stok Pakaian</h2>
            <p class="dashboard-subtittle">Data Stok Pakaian</p>
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
                <a href="/admin/clothing-stock/create" class="btn btn-primary btn-sm mb-3"><i class="bi bi-plus-circle"></i> Tambah</a>
            @endif
                <a href="/admin/stock-clothing/exportPDF" class="btn btn-secondary btn-sm mb-3"><i class="bi bi-printer"></i> Print</a>
                    <div class="table-responsive">
                        <table class="table table-hover scroll-horizontal-vertical w-100" id="dataTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Produk</th>
                                    <th>Ukuran</th>
                                    <th>Stok</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($clothing_stocks as $stock)
                                <tr>
                                    <td class="text-bold">{{$loop->iteration}}</td>
                                    <td>{{$stock->clothing_size->product->name}}</td>
                                    <td>{{$stock->clothing_size->size_name}}</td>
                                    <td>{{$stock->stock}}</td>
                                    <td>
                                    @if(auth()->user()->role == 'pegawai')
                                        <div class="row">
                                            <a href="{{ route('clothing-stock.edit', $stock->id) }}" class="btn btn-warning btn-sm mr-1">Tambah Stok</a>
                                            <form action="{{ route('clothing-stock.destroy', $stock->id) }}" method="POST">
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
