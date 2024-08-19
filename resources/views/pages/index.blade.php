@extends('layouts.app')

@section('title')
Home
@endsection

@section('content')
    <div class="container my-2" data-aos="zoom-in">
      <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="container text-center" style="height:400px;background:url({{asset('storage/a.png')}});background-size: cover;">
              <div class="row d-flex justify-content-center"  style="padding:100px">
                <div class="col-10 rounded-pill mt-5" style="background-color: rgba(240, 240, 240, 0.5);">
                  <h3 class="font-italic py-2">"Menjual berbagai jenis pakaian muslim dan aksesoris"</h3>
                  <h3 class="font-italic py-2">"Bisa langsung beli maupun pre order"</h3>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container my-3" data-aos="fade-up">
        <h5>Semua Produk ({{ $products->count() }})</h5>
    </div>

    <div class="product-list">
      <div class="container" data-aos="fade-up">
        <div class="row">
          @foreach($products as $product)
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
          @endforeach
        </div>
      </div>
    </div>
@endsection