@extends('layouts.app')

@section('title')
Pre Order
@endsection

@section('content')
<div class="container" data-aos="fade-down">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Pre Order</li>
        </ol>
      </nav> 

        @if(session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill"></i> {{ session('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        <div class="my-3">
          <i class="bi bi-info-circle"></i><span class="text-muted"> Pengerjaan pre order maksimal 1 bulan, 
            tombol bayar akan muncul jika pre order diterima dan tombol pelunasan akan muncul jika status transaksi siap kirim.
          </span>
        </div>
       
        <div class="row" data-aos="zoom-in"> 
            <div class="col-lg-12  table-responsive">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Kode Transaksi</th>
                        <th scope="col">Total Harga</th>
                        <th scope="col">Status Bayar</th>
                        <th scope="col">Status Transaksi</th>
                        <th scope="col">Status Kirim</th>
                        <th scope="col">Selesai Dikerjakan</th>
                        <th scope="col">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                
                    @forelse($transactions as $transaction)
                      <tr>
                        <td class="cart-detail">{{ $transaction->code }}</td>
                        <td class="cart-detail">@currency($transaction->total_price)</td>
                        <td class="cart-detail text-capitalize font-weight-bold"><p class="{{ $transaction->payment_status == 'belum bayar' ? 'text-danger' : 'text-primary' }}">
                          {{$transaction->payment_status}}</p>
                        </td>

                        <td class="cart-detail text-capitalize font-weight-bold {{ $transaction->transaction_status == 'pre-order ditolak' ? 'text-danger' : 'text-primary' }}">
                          {{ $transaction->transaction_status }}
                        </td>

                        <td class="cart-detail text-capitalize font-weight-bold {{ $transaction->shipping_status == 'pending' ? 'text-danger' : 'text-primary' }}">
                          {{ $transaction->shipping_status }}
                        </td>

                        <td class="cart-detail">{{ \Carbon\Carbon::parse($transaction->created_at)->addMonth()->format('d-m-Y') }}</td>

                        <td class="cart-detail row text-capitalize">
                          @if($transaction->transaction_status == 'pre-order diterima')
                            <a href="{{ route('confirm.show', $transaction->id) }}" class="btn btn-sm btn-primary mr-1">Bayar DP</a>
                          @endif

                          @if($transaction->payment_status == 'baru DP' && $transaction->transaction_status == 'siap dikirim')
                            <a href="{{ route('confirm.edit', $transaction->id) }}" class="btn btn-sm btn-success mr-1">Bayar Lunas</a>
                          @endif

                          @if($transaction->shipping_status == 'dikirim') 
                          <form action="/accept/store" method="POST">
                            @csrf
                            <button type="submit" name="transaction_id" value="{{$transaction->id}}" onclick="return confirm('Apakah anda yakin Terima Pesanan? Pastikan pesanan sudah diterima.')" class="btn btn-sm btn-success mr-1">
                              Terima Pesanan
                            </button>
                          </form>
                          @endif

                          <a href="{{ route('transaction.show', $transaction->id) }}" class="btn btn-sm btn-warning mr-1">Detail</a>
 
                          @if($transaction->payment_status == 'belum bayar')
                            <form action="{{ route('transaction.destroy' , $transaction->id) }}" method="POST">
                                @method("DELETE")
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin hapus pesanan pre order?')">Hapus</button>
                            </form>
                          @endif

                        </td>
                      </tr>
                    @empty
                    <tr><td colspan="8" class="text-center text-danger">Pre order kosong</td></tr>
                    @endforelse
                    
                    </tbody>
                </table>
            </div>
        </div>
</div>
@endsection