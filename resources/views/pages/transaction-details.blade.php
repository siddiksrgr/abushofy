@extends('layouts.app')

@section('title')
Detail
@endsection

@section('content')
<div class="container" data-aos="fade-down">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          @if($transaction->description == 'pre-order')
          <li class="breadcrumb-item"><a href="/pre-orders">Pre Order</a></li>
          @else
          <li class="breadcrumb-item"><a href="/transaction">Transaksi</a></li>
          @endif
          <li class="breadcrumb-item active" aria-current="page">Detail</li>
        </ol>
        @if(session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill"></i> {{ session('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
      </nav> 

      <div class="row mb-3"> 
        <div class="col-lg-4">
          <h6>Kode Transaksi: <span class="font-weight-normal">{{ $transaction->code }}</span></h6>
          <h6>Tanggal Transaksi: <span class="font-weight-normal">{{ \Carbon\Carbon::parse($transaction->created_at)->format('d-m-Y, H:i') }}</span></h6>
          @if($transaction->transaction_status == "batal")
          <h6>Tanggal Expired : <span class="font-weight-normal">{{ \Carbon\Carbon::parse($transaction->expired_at)->format('d-m-Y, H:i') }}</span></h6>
          @endif

          @if($transaction->payment_status == "baru DP" || $transaction->payment_status == "lunas")
            @if($transaction->confirmation->down_payment_date)
            <h6>Bayar DP : <span class="font-weight-normal">{{ \Carbon\Carbon::parse($transaction->confirmation->down_payment_date)->format('d-m-Y, H:i') }}</span></h6>
            @endif

            @if($transaction->confirmation->paid_off_date)
            <h6>Bayar Lunas : <span class="font-weight-normal">{{ \Carbon\Carbon::parse($transaction->confirmation->paid_off_date)->format('d-m-Y, H:i') }}</span></h6>
            @endif 
          @endif

        </div>
        <div class="col-lg-3">
          <h6>Ongkir : <span class="font-weight-normal">@currency($transaction->shipping_price)</span></h6>
          <h6>Kurir : <span class="font-weight-normal">{{strtoupper($transaction->courier)}}</span></h6>
          <h6>Total Harga : <span class="font-weight-normal">@currency($transaction->total_price)</span></h6>
        </div>
        <div class="col-lg-5">
          <h6>Alamat Kirim : <span class="font-weight-normal text-capitalize">{{$transaction->address}}, {{$transaction->city}}, {{$transaction->province}}, {{$transaction->zip_code}}, ({{ auth()->user()->phone_number }})</span>
          </h6>
          
          @if($transaction->confirmation && $transaction->confirmation->shipping)
          <h6>Tanggal Dikirim : <span class="font-weight-normal">{{ \Carbon\Carbon::parse($transaction->confirmation->shipping->created_at)->format('d-m-Y, H:i') }}</span></h6>
          @endif

          @if($transaction->confirmation && $transaction->confirmation->shipping && $transaction->confirmation->shipping->status == 'terkirim')
          <h6>Tanggal Terkirim : <span class="font-weight-normal">{{ \Carbon\Carbon::parse($transaction->confirmation->shipping->updated_at)->format('d-m-Y, H:i') }}</span></h6>
          @endif
        </div>
      </div>
      <div class="row" data-aos="zoom-in">
            <div class="col-lg-12  table-responsive">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Foto</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Berat</th> 
                        <th scope="col">Ukuran</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Bahan</th>
                        <th scope="col">Subtotal</th>
                        <th scope="col">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                     
                    @forelse($transaction->transactions as $transaction)
                      <tr>
                        <td><img src="{{ asset('storage/'.$transaction->product->galleries->first()->photo) }}" style="width: 100px; height:100px" alt=""></td>
                        <td class="cart-detail">{{ $transaction->product->name }}</td>
                        <td class="cart-detail">@currency($transaction->price)</td>
                        <td class="cart-detail">{{ $transaction->product->weight }} gr</td>
                        @if($transaction->clothing_size != null)
                        <td class="cart-detail">{{ $transaction->clothing_size->size_name }}</td>
                        @else 
                        <td class="cart-detail">{{ $transaction->accessories_size->size_name }}</td>
                        @endif

                        <td class="cart-detail">{{ $transaction->quantity }} pcs</td>
                        <td class="cart-detail">{{ $transaction->material }}</td>

                        <td class="cart-detail">@currency($transaction->price * $transaction->quantity)</td>
                        <td class="cart-detail row mx-1">
                        @if($transaction->transaction->shipping_status == 'terkirim')
                            <a href="/review/{{$transaction->id}}" class="btn btn-sm btn-success mr-1">Review</a> 
                            @if($transaction->complain == null)
                            <form action="/complain/create/{{$transaction->id}}" method="POST">
                              @csrf
                              <button class="btn btn-sm btn-danger">Komplain/Pengembalian</button>
                            </form>
                            @endif
                        @endif
                        </td>
                      </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-danger">Kosong</td>
                    </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
</div>
@endsection