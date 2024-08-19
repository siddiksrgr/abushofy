@extends('layouts.admin')

@section('title')
Tambah Produk 
@endsection

@section('content')
<!-- Page Content -->
<div class="col-md-9 ml-sm-auto col-lg-10 px-md-4 bg-light">
    <div class="container">
        <div class="dashboard-heading mt-3">
            <h2 class="dashboard-tittle">Produk</h2>
            <p class="dashboard-subtittle">Tambah Produk</p>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                            <label>Kategori</label>
                                <select name="category_id" class="form-control" autofocus required>
                                    <option selected disabled value="">Pilih Kategori..</option>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name_category }} ( {{ $category->main_category }} {{ $category->gender_category }} )</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Bahan</label>
                                <input type="text" name="material" class="form-control" placeholder="Nama Bahan.." required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nama Produk</label>
                                <input type="text" name="name" class="form-control" placeholder="Nama Produk.." required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Harga</label>
                                <input type="number" class="form-control" name="price" placeholder="Harga.." required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Harga Pre Order</label>
                                <input type="number" class="form-control" name="pre_order_price" placeholder="Harga Pre Order.." required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Berat (gram)</label>
                                <input type="number" class="form-control" name="weight" placeholder="Berat.." required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="description" id="editor"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Foto Produk</label>
                                <input type="file" name="photos[]" class="form-control" multiple required>
                                <p class="text-muted">
                                    Kamu dapat memilih lebih dari satu file
                                </p>
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

@push('addon-script')
<script src="https://cdn.ckeditor.com/4.19.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor');
</script>
@endpush