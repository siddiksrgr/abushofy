@extends('layouts.admin')

@section('title')
Tambah Ukuran Aksesoris
@endsection

@section('content')
<!-- Page Content -->
<div class="col-md-9 ml-sm-auto col-lg-10 px-md-4 bg-light">
    <div class="container">
        <div class="dashboard-heading mt-3">
            <h2 class="dashboard-tittle">Ukuran Aksesoris</h2>
            <p class="dashboard-subtittle">Tambah Ukuran Aksesoris</p>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('accessories-size.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Produk</label>
                                <select name="product_id" class="form-control" autofocus required>
                                    <option selected disabled value="">Pilih Produk..</option>
                                    @foreach($products as $product)
                                        @if($product->category->main_category == 'aksesoris')
                                            <option value="{{$product->id}}">{{$product->name}} ({{$product->category->main_category}} {{$product->category->gender_category}})</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Nama Ukuran</label>
                                <input type="text" name="size_name" class="form-control" placeholder="Nama Ukuran.." required>
                            </div>
                            <div class="form-group">
                                <label>Panjang (cm)</label>
                                <input type="text" name="length" class="form-control" placeholder="Panjang.." required>
                            </div>
                            <div class="form-group">
                                <label>Lebar (cm)</label>
                                <input type="text" name="width" class="form-control" placeholder="Lebar.." required>
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