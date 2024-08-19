@extends('layouts.admin')

@section('title')
Tambah Stok Aksesoris Baru
@endsection

@section('content')
<!-- Page Content -->
<div class="col-md-9 ml-sm-auto col-lg-10 px-md-4 bg-light">
    <div class="container">
        <div class="dashboard-heading mt-3">
            <h2 class="dashboard-tittle">Stok Aksesoris</h2>
            <p class="dashboard-subtittle">Tambah Stok Aksesoris Baru</p>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('accessories-stock.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Ukuran</label>
                                <select name="accessories_size_id" class="form-control" required>
                                    @foreach($accessories_sizes as $size)
                                    <option value="{{$size->id}}">{{$size->product->name}} - Ukuran {{$size->size_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Stok</label>
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