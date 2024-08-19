@extends('layouts.app')

@section('title')
Detail Produk
@endsection

@section('content')
<div class="container" data-aos="fade-down">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$product->name}}</li>
      </ol>
    </nav>
    @if(session()->has('message'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <i class="bi bi-x-circle-fill"></i> {{ session('message') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    @endif
</div>

<div class="container" id="gallery">
  <div class="row">
    <!-- foto -->
    <div class="col-lg-6 mb-3" data-aos="fade-right">
      <div class="card">
          <div class="card-body card-product text-center">
              <transition name="slide-fade" mode="out-in">
                <img :src="photos[activePhoto].url" :key="photos[activePhoto].id" class="w-75 main-image" alt="">
              </transition>
          </div>
      </div>
      <div class="col-lg-12 p-0">
        <div class="row">
          <div class="col-3 mt-2" v-for="(photo, index) in photos" :key="photo.id">
            <a href="#" @click="changeActive(index)">
              <div class="card thumbnail-image" :class="{ active: index == activePhoto }">
                <div class="card-body">
                  <img :src="photo.url" class="w-100" alt="">
                </div>
              </div>   
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-6" data-aos="fade-left">
      <h5 class="card-text text-dark mb-3">{{ $product->name }}</h5>
      <h5 class="card-text text-danger mb-3">@currency($product->price)</h5>

      <!-- form add to cart -->
      <form action="{{ route('cart.store') }}" method="POST">
        @csrf 
        <div class="row my-2">
          <div class="col-lg-6 d-flex form-group">
            <label class="py-1">Ukuran</label>
            @if($product->category->main_category == "pakaian")
            <select class="form-control ml-2" name="clothing_size_id" required>
              <option selected disabled value="">Pilih Ukuran..</option>
              @foreach($product->clothing_sizes as $size)
                @if($size->stock)
                <option value="{{ $size->id }}">{{ $size->size_name }} - Stok {{$size->stock->stock}}</option>
                @endif
              @endforeach 
            </select>
            @endif 

            @if($product->category->main_category == "aksesoris")
            <select class="form-control ml-2" name="accessories_size_id" required>
              <option selected disabled value="">Pilih Ukuran..</option>
              @foreach($product->accessories_sizes as $size)
                @if($size->stock)
                <option value="{{ $size->id }}">{{ $size->size_name }} - Stok {{$size->stock->stock}}</option>
                @endif
              @endforeach 
            </select>
            @endif
            <input type="hidden" name="product_id" value="{{$product->id}}"/>
          </div>
          <div class="col-lg-6 d-flex form-group">
            <label class="py-1">Jumlah</label> 
            <input type="number" min="1" class="form-control ml-2" name="quantity" placeholder="0" required/>                     
          </div>
        </div>

        @auth
        <div class="row">
          <div class="col-lg-12 mb-3">
            <button type="submit" class="btn btn-success btn-block text-white">Tambah Ke Cart</button>
          </div>
          <div class="col-lg-12">
            <!-- Button trigger modal -->
            <button type="button" class="btn bg-white border-success btn-block text-success font-weight-bold" data-toggle="modal" data-target="#staticBackdrop">
              Pre Order
            </button>
          </div>
        </div> 
        @else
        <a href="{{ route('login') }}" class="btn btn-block btn-success text-white mb-3">Sign In Untuk Beli</a>
        @endauth
      </form>
    </div>
  </div>
      
  <hr>

  <div class="mt-4">
    <!-- description -->
    <div class="row" data-aos="fade-right">
      <div class="col-lg-12">
        <h6 class="mb-3">Deskripsi Produk</h6>
        <div class="mt-3">
          {!! $product->description !!}
        </div>
        <div class="mb-3">
          <p>Terbuat dari {{$product->material}}.</p>
          <p>Berat/pcs : {{ $product->weight }} gram.</p>
          <p>Panduan Ukuran :</p>
          @if($product->clothing_sizes)
            @foreach($product->clothing_sizes as $size)
              <p> - {{$size->size_name}} = Panjang Badan {{$size->body_length}} cm | 
                Lebar Badan {{$size->body_width}} cm | Panjang Tangan {{$size->slevee_length}} cm</p>
            @endforeach 
          @endif

          @if($product->accessories_sizes)
            @foreach($product->accessories_sizes as $size)
              <p> - {{$size->size_name}} = Panjang {{$size->length}} cm | Lebar {{$size->width}} cm</p>
            @endforeach 
          @endif
        </div>
      </div>
    </div>

    <hr> 

    <!-- reviews -->
    <div data-aos="fade-left">
      <h6 class="mb-3">Review Pembeli ({{ $product->reviews->count() }})</h6> 
      @forelse($product->reviews->sortDesc() as $review)
      <div class="row">
        <div class="col-lg-12">
          <div class="media my-2"> 
            <img src="{{ asset('storage/'. $review->transaction_detail->transaction->user->photo) }}" class="align-self-start user-review mr-3 rounded-circle profile-picture" alt="...">
            <div class="media-body">
              <span class="mt-0 font-weight-bold">{{$review->transaction_detail->transaction->user->name}}</span>
              @if($review->transaction_detail->clothing_size)
              <span class="text-secondary">
                - Ukuran {{$review->transaction_detail->clothing_size->size_name}}
              </span>
              @else
              <span class="text-secondary">
                - Ukuran {{$review->transaction_detail->accessories_size->size_name}}
              </span>
              @endif
              <span class="text-secondary">
              - {{ $review->transaction_detail->quantity }} pcs
              </span>
              <p>"{{$review->review}}"</p>
            </div>
          </div>
        </div>
      </div>
      @empty
      <p>Belum ada review</p>
      @endforelse
    </div>

    <!-- Modal Pre Order -->
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Pre Order</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <!-- form Pre Order -->
          <form action="{{ route('pre-order-cart.store') }}" method="POST">
            @csrf
            <div class="modal-body">
              <div class="alert alert-primary" role="alert">
                <i class="bi bi-info-circle"></i> Keterangan :
                <ul class="mb-0">
                  <li>Jumlah minimal pre order adalah 1 kodi (20 pcs), maksimal 3 kodi (60 pcs).</li>
                  <li>Pengerjaan produk pre order maksimal 1 bulan.</li>
                  <li>Pembayaran pre order 50% dari total.</li>
                  <li>Pre order akan melalui proses pengajuan terlebih dahulu, jika diterima maka bisa diproses.</li>
                </ul>
              </div>
              <h5 class="mb-3">{{$product->name}} - 
                <span class="card-text text-danger mb-3">@currency($product->pre_order_price)</span>
                <span class="card-text text-secondary">/pcs</span>
              </h5>            
              <div class="d-flex justify-content-center">
                <img src="{{ asset('storage/'.$product->galleries->first()->photo) }}" style="width: 100px; height:100px" class="my-3">
              </div>

              <div class="row">
                <div class="col-4">
                  <div class="form-group">
                    <label class="py-1">Ukuran :</label>
                    @if($product->category->main_category == "pakaian")
                    <select class="form-control" name="clothing_size_id" required>
                      <option selected disabled value="">Pilih Ukuran..</option>
                      @foreach($product->clothing_sizes as $size)
                        <option value="{{ $size->id }}">{{ $size->size_name }}</option>
                      @endforeach
                    </select>
                    @endif

                    @if($product->category->main_category == "aksesoris")
                    <select class="form-control" name="accessories_size_id" required>
                      <option selected disabled value="">Pilih Ukuran..</option>
                      @foreach($product->accessories_sizes as $size)
                        <option value="{{ $size->id }}">{{ $size->size_name }}</option>
                      @endforeach 
                    </select>
                    @endif
                  </div>
                </div>

                <div class="col-4">
                  <div class="form-group">
                    <label class="py-1">Jumlah :</label> 
                    <select class="form-control" name="quantity" required>
                      <option selected disabled value="">Pilih Jumlah..</option>
                      <option value="20">20 pcs (1 Kodi)</option>
                      <option value="40">40 pcs (2 Kodi)</option>
                      <option value="60">60 pcs (3 Kodi)</option>
                    </select>
                  </div>
                </div>

                <div class="col-4">
                  <div class="form-group">
                    <label class="py-1">Bahan :</label> 
                    <select class="form-control" name="material" required>
                      <option selected disabled value="">Pilih Bahan..</option>
                      @if($product->category->name_category != "Tasbih")
                      <option value="Katun">Katun</option>
                      <option value="Sutra">Sutra</option>
                      <option value="Polyester">Polyester</option>
                      <option value="Wolfis">Wolfis</option>
                      @else
                      <option value="{{$product->material}}">{{$product->material}}</option>
                      @endif
                    </select>
                  </div>
                </div>
              </div>
                <input type="hidden" name="product_id" value="{{$product->id}}"/>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success btn-block">Tambah Ke Cart Pre Order</button>
            </div>
          </form> 

        </div>
      </div>
    </div>
  </div>
</div>
@endsection
 
@push('addon-script') 
<script src="/vendor/vue/vue.js"></script>
<script>
      var gallery = new Vue({
          el: "#gallery",
          mounted() {
              AOS.init();
          },
          data: {
              activePhoto: 0,
              photos: [
                @foreach($product->galleries as $gallery)
                {
                    id: {{ $gallery->id }},
                    url: "{{ asset('storage/'.$gallery->photo) }}",
                },
                @endforeach
              ],
          },
          methods: {
              changeActive(id) {
                  this.activePhoto = id;
              }
          },
      });
</script>
@endpush