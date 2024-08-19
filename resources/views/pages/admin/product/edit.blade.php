@extends('layouts.admin')

@section('title')
Edit Produk
@endsection

@section('content')
<!-- Page Content -->
<div class="col-md-9 ml-sm-auto col-lg-10 px-md-4 bg-light">
    <div class="container">
        <div class="dashboard-heading mt-3">
            <h2 class="dashboard-tittle">Produk</h2>
            <p class="dashboard-subtittle">Edit Produk</p>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('product.update', $product->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="row"  id="product">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nama Produk</label>
                                <input type="text" name="name" class="form-control" value="{{ $product->name }}" autofocus required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                            <label>Kategori</label>
                                <select name="category_id" v-model="category_id" class="form-control" required>
                                    <option selected value="{{$product->category_id}}">{{ $product->category->name_category }} ( {{ $product->category->main_category }} {{ $product->category->gender_category }} )</option>
                                    <option disabled value="">----------------------------</option>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" >{{ $category->name_category }} ( {{ $category->main_category }} {{ $category->gender_category }} )</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Bahan</label>
                                <input type="text" name="material" class="form-control" value="{{$product->material}}" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Harga</label>
                                <input type="number" class="form-control" name="price" value="{{ $product->price }}" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Harga Pre Order</label>
                                <input type="number" class="form-control" name="pre_order_price" value="{{ $product->pre_order_price }}" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Berat (gram)</label>
                                <input type="number" class="form-control" name="weight" value="{{ $product->weight }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="description" id="editor">{!! $product->description !!}</textarea>
                            </div>
                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-success btn-block px-5 mt-3">Simpan</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body"> 
                <h6 class="text-dark">Foto Produk</h6>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="row">
                                @foreach($product->galleries as $gallery)
                                <div class="col-md-2 my-2">
                                    <div class="gallery-container border border-secondary rounded">
                                        <img src="{{ asset('storage/'. $gallery->photo) ?? '' }}" alt="" class="w-100">

                                        <form action="/admin/gallery/{{$gallery->id}}" method="POST">
                                        @csrf
                                        @method('delete')
                                            <button type="submit" class="delete-gallery" data-toggle="tooltip" data-placement="top" title="Hapus Foto" onclick="return confirm('Apakah anda yakin hapus foto?')">
                                                <img src="{{ asset('storage/product-card-remove.svg') }}" alt="">
                                            </button>
                                        </form> 

                                    </div>
                                </div>
                                @endforeach
                           
                                <div class="col-md-2">
                                    <div class="card border-0">
                                        <div class="card-body">
                                            <form action="/admin/gallery" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <input type="file" id="file" name="photos[]" style="display: none;" onchange="form.submit()" multiple>
                                                <a type="button" onclick="thisFileUpload()" data-toggle="tooltip" data-placement="top" title="Tambah Foto">
                                                    <img src="{{ asset('storage/add.jpg') }}" class="w-50 py-4" alt=""> 
                                                </a>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               
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
<script>
    function thisFileUpload() {
        document.getElementById("file").click()
    };
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
</script>
@endpush

