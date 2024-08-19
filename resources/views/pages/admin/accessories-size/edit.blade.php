@extends('layouts.admin')

@section('title')
Edit Ukuran Aksesoris
@endsection

@section('content')
<!-- Page Content -->
<div class="col-md-9 ml-sm-auto col-lg-10 px-md-4 bg-light">
    <div class="container">
        <div class="dashboard-heading mt-3">
            <h2 class="dashboard-tittle">Ukuran Aksesoris</h2>
            <p class="dashboard-subtittle">Edit Ukuran Aksesoris</p>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('accessories-size.update', $accessories_size->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Produk</label>
                                <select name="product_id" class="form-control" autofocus required>
                                    <option selected value="{{$accessories_size->product_id}}">{{ $accessories_size->product->name }} ({{$accessories_size->product->category->main_category}} {{$accessories_size->product->category->gender_category}})</option>
                                    <option disabled value="">----------------------------</option>
                                    @foreach($products as $product)
                                        @if($product->category->main_category == 'Aksesoris')
                                        <option value="{{$product->id}}">{{$product->name}} ({{$product->category->main_category}} {{$product->category->gender_category}})</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Nama Ukuran</label>
                                <input type="text" name="size_name" value="{{$accessories_size->size_name}}" class="form-control" placeholder="Nama Ukuran.." required>
                            </div>
                            <div class="form-group">
                                <label>Panjang (cm)</label>
                                <input type="text" name="length" value="{{$accessories_size->length}}" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Lebar (cm)</label>
                                <input type="text" name="width" value="{{$accessories_size->width}}" class="form-control" required>
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