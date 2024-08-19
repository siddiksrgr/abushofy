@extends('layouts.admin')

@section('title')
Tambah Stok
@endsection

@section('content')
<!-- Page Content -->
<div class="col-md-9 ml-sm-auto col-lg-10 px-md-4 bg-light">
    <div class="container">
        <div class="dashboard-heading mt-3">
            <h2 class="dashboard-tittle">Tambah Stok</h2>
            <p class="dashboard-subtittle">Tambah Stok</p>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('clothing-stock.update', $clothing_stock->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Ukuran</label>
                                <input class="form-control" placeholder="{{$clothing_stock->clothing_size->product->name}} - Ukuran {{$clothing_stock->clothing_size->size_name}}" readonly>
                                <input class="form-control" type="hidden" name="clothing_size_id" value="{{$clothing_stock->clothing_size_id}}">
                            </div>
                            <div class="form-group">
                                <label>Stok</label>
                                <input class="form-control" placeholder="{{$clothing_stock->stock}}" readonly>
                            </div>
                            <div class="form-group">
                                <label>Tambah Stok</label>
                                <input type="number" min="1" name="stock" class="form-control" placeholder="Tambahkan stok.." autofocus required>
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