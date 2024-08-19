@extends('layouts.admin')

@section('title')
Produk
@endsection

@section('content')
<!-- Page Content -->
<div class="col-md-9 ml-sm-auto col-lg-10 px-md-4 bg-light">
    <div class="container">
        <div class="dashboard-heading mt-3">
            <h2 class="dashboard-tittle">Produk</h2>
            <p class="dashboard-subtittle">Data Produk</p>
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
                <a href="/admin/product/create" class="btn btn-primary btn-sm mb-3"><i class="bi bi-plus-circle"></i> Tambah</a>
                @endif
                    <div class="table-responsive">
                        <table class="table table-hover scroll-horizontal-vertical w-100" id="dataTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Harga</th>
                                    <th>Harga PO</th>
                                    <th>Foto</th>
                                    <th>Kategori</th>
                                    <th>Bahan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td class="text-bold">{{$loop->iteration}}</td>
                                    <td>{{$product->name}}</td>
                                    <td>@currency($product->price)</td>
                                    <td>@currency($product->pre_order_price)</td>
                                    <td>
                                        <a href="{{ asset('storage/'. $product->galleries->first()->photo) }}">
                                            <img src="{{ asset('storage/'. $product->galleries->first()->photo) }} " style="max-height: 48px;">
                                        </a>
                                    </td>
                                    <td>{{$product->category->name_category}} ({{$product->category->main_category}} {{$product->category->gender_category}})</td>
                                    <td>{{$product->material}}</td>
                                    <td>
                                    @if(auth()->user()->role == 'pegawai')
                                        <div class="row">
                                            <a href="{{ route('product.edit', $product->id) }}" class="btn btn-warning btn-sm mr-1">Edit</a>
                                            <form action="{{ route('product.destroy', $product->id) }}" method="POST">
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
