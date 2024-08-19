@extends('layouts.app')

@section('title')
Kategori
@endsection

@section('content')
<div class="container" data-aos="fade-down">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Kategori</li>
        </ol>
    </nav> 
</div>

<div class="container my-3" data-aos="fade-up">
    <h6>Kategori {{$category->name_category}} ({{ $products->count() }})</h6>
</div>

<div class="container" data-aos="fade-up">
    <div class="row">
        @forelse($products as $product)
            <div class="col-md-3">
              <a href="/detail/{{$product->slug}}">
                <div class="card mb-4">
                    <div class="card-body text-center zoom-product">
                        <img src="{{ asset('storage/'.$product->galleries->first()->photo) }}" style="width: 200px;height: 200px;" alt="">
                        <h5 class="card-text text-dark">{{ $product->name }}</h5>
                        <h5 class="card-text text-danger">@currency($product->price)</h5> 
                    </div>
                </div>
              </a>
            </div>
        @empty
        <div class="container my-3" data-aos="fade-up">
            <p class="text-center text-danger">Produk kosong</p>
        </div>
        @endforelse
    </div>
</div>
@endsection