@extends('layouts.admin')

@section('title')
Detail Komplain
@endsection

@section('content')
<!-- Page Content -->
<div class="col-md-9 ml-sm-auto col-lg-10 px-md-4 bg-light">
    <div class="container">
        <div class="dashboard-heading mt-3">
            <h2 class="dashboard-tittle">Detail Komplain</h2>
            <p class="dashboard-subtittle">Detail Komplain</p>
        </div>

        <div class="card">
            <div class="card-body"> 
                <div class="row mb-3">
                    <div class="col-lg-12"> 
                        <h6>Kode Transaksi: <span class="font-weight-normal">{{ $complain->transaction_detail->transaction->code }}</span></h6>
                        <h6>Kode Komplain: <span class="font-weight-normal">{{ $complain->complain_code }}</span></h6>

                        <h6>Status: <span class="font-weight-normal text-capitalize">{{ $complain->status }}</span></h6>
                        <h6>Produk: <span class="font-weight-normal">{{ $complain->transaction_detail->product->name }}</span></h6>
                        <h6>Jumlah: <span class="font-weight-normal">{{ $complain->quantity }} pcs</span></h6>
                        <h6>Ukuran: 
                            <span class="font-weight-normal">
                                @if($complain->transaction_detail->clothing_size != null)
                                    <td>{{ $complain->transaction_detail->clothing_size->size_name }}</td>
                                    @else 
                                    <td>{{ $complain->transaction_detail->accessories_size->size_name }}</td>
                                @endif
                            </span>
                        </h6>
                        <h6>Bahan: <span class="font-weight-normal text-capitalize">{{ $complain->transaction_detail->material }}</span></h6>
                        <h6>Alasan: <span class="font-weight-normal text-capitalize">{{ $complain->complain }}</span></h6>
                        <h6 class="my-3">Bukti: 
                            <span class="font-weight-normal">
                                <a href="{{ asset('storage/'.$complain->photo) }}"> 
                                    <img src="{{ asset('storage/'.$complain->photo) }}" style="width: 70px; height:70px" alt="">
                                </a>
                            </span>
                        </h6>

                        <h6>Tanggal Komplain: <span class="font-weight-normal">{{ \Carbon\Carbon::parse($complain->created_at)->format('d-m-Y, H:i') }}</span></h6>
                        <h6>Status : <span class="font-weight-normal text-capitalize">{{ $complain->status }}</span></h6>
                        <h6>Tanggal Kirim Dari Pembeli : 
                            @if($complain->user_shipping_date)
                            <span class="font-weight-normal">{{ \Carbon\Carbon::parse($complain->user_shipping_date)->format('d-m-Y, H:i') }}</span>
                            @else
                            <span> - </span>
                            @endif
                        </h6>
                        <h6>Resi Dari Pembeli : 
                            @if($complain->user_shipping_date)
                            <span class="font-weight-normal">{{ $complain->user_resi }}</span>
                            @else
                            <span> - </span>
                            @endif
                        </h6>
                        <h6>Tanggal Kirim Dari Toko : 
                            @if($complain->store_shipping_date)
                            <span class="font-weight-normal">{{ \Carbon\Carbon::parse($complain->store_shipping_date)->format('d-m-Y, H:i') }}</span>
                            @else
                            <span> - </span>
                            @endif
                        </h6>
                        <h6>Resi Dari Toko : 
                            @if($complain->store_shipping_date)
                            <span class="font-weight-normal">{{ $complain->store_resi }}</span>
                            @else
                            <span> - </span>
                            @endif
                        </h6>
                        <h6>Alamat Kirim Ke Pembeli : 
                            <span class="font-weight-normal text-capitalize">{{ $complain->address }}</span>
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection