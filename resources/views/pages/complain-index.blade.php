@extends('layouts.app')

@section('title')
Komplain
@endsection

@section('content')
<div class="container" data-aos="fade-down">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Komplain</li>
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
       
        <div class="my-3" data-aos="fade-right">
            <i class="bi bi-info-circle"></i><span class="text-secondary"> Komplain yang diterima dapat melakukan pengiriman.</span>
        </div>

        <div class="row" data-aos="zoom-in"> 
            <div class="col-lg-12  table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                          <th scope="col">Kode Transaksi</th>
                          <th scope="col">Kode Komplain</th>
                          <th scope="col">Status</th>
                          <th scope="col">Aksi</th> 
                        </tr>
                    </thead>
                    <tbody>
                
                    @forelse($complains as $complain)
                      <tr> 
                        <td class="cart-detail">
                            <a href="/transaction/{{$complain->transaction_detail->transaction->id}}" data-toggle="tooltip" data-placement="top" title="Lihat Detail Pesanan">
                                {{ $complain->transaction_detail->transaction->code }}
                            </a>
                        </td>
                        <td class="cart-detail">{{ $complain->complain_code }}</td>
                        <td class="cart-detail text-capitalize font-weight-bold {{ $complain->status == 'komplain ditolak' ? 'text-danger' : 'text-primary' }}">
                            {{ $complain->status }}
                        </td>
                        <td class="cart-detail">
                          <div class="row">
                            @if($complain->status == 'komplain diterima') 
                              <a href="/complain/shipping/{{$complain->id}}" class="btn btn-sm btn-primary mr-1" >Kirim</a>
                            @endif
  
                            @if($complain->status == 'barang dikirim dari toko') 
                              <a href="/complain/shipping/accept/{{$complain->id}}" class="btn btn-sm btn-success mr-1" 
                                onclick="return confirm('Apakah anda yakin terima barang? Pastikan barang sudah diterima.')">Terima
                              </a>
                            @endif
                            <a href="/complain/details/{{$complain->id}}" class="btn btn-sm btn-warning">Detail</a>
                          </div>
                        </td>
                    @empty
                    <tr><td colspan="8" class="text-center text-danger">Komplain kosong</td></tr>
                    @endforelse
                    
                    </tbody>
                </table>
            </div>
        </div>
</div>
@endsection