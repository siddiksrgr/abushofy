@extends('layouts.admin')

@section('title')
Detail Transaksi
@endsection

@section('content')
<!-- Page Content -->
<div class="col-md-9 ml-sm-auto col-lg-10 px-md-4 bg-light">
    <div class="container">
        <div class="dashboard-heading mt-3">
            <h2 class="dashboard-tittle">Detail Transaksi</h2>
            <p class="dashboard-subtittle">Detail Transaksi</p>
        </div>

        <div class="card">
            <div class="card-body"> 
                <div class="row mb-3">
                    <div class="col-lg-4"> 
                        <h6>Kode Transaksi: <span class="font-weight-normal">{{ $transaction->code }}</span></h6>
                        <h6>Tanggal Transaksi : <span class="font-weight-normal">{{ \Carbon\Carbon::parse($transaction->created_at)->format('d-m-Y, H:i') }}</span></h6>
                        @if($transaction->transaction_status == "batal")
                        <h6>Tanggal Batal : <span class="font-weight-normal">{{ \Carbon\Carbon::parse($transaction->expired_at)->format('d-m-Y, H:i') }}</span></h6>
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
                        <h6>Alamat Kirim : <span class="font-weight-normal text-capitalize">{{$transaction->address}}, 
                            {{$transaction->city}}, {{$transaction->province}}, {{$transaction->zip_code}}, {{$transaction->user->phone_number}}</span>
                        </h6>
                        
                        @if($transaction->confirmation && $transaction->confirmation->shipping)
                        <h6>Tanggal Dikirim : <span class="font-weight-normal">{{ \Carbon\Carbon::parse($transaction->confirmation->shipping->created_at)->format('d-m-Y, H:i') }}</span></h6>
                        @endif

                        @if($transaction->confirmation && $transaction->confirmation->shipping && $transaction->confirmation->shipping->status == 'terkirim')
                        <h6>Tanggal Terkirim : <span class="font-weight-normal">{{ \Carbon\Carbon::parse($transaction->confirmation->shipping->updated_at)->format('d-m-Y, H:i') }}</span></h6>
                        @endif
                    </div>
                </div>
                    <div class="table-responsive">
                        <table class="table table-hover scroll-horizontal-vertical w-100" id="dataTable">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Foto</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Ukuran</th>
                                    <th scope="col">Bahan</th>
                                    <th scope="col">Subtotal</th>
                                </tr>
                            </thead>
                        <tbody>
                            @forelse($transaction->transactions as $transaction)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    <a href="{{ asset('storage/'.$transaction->product->galleries->first()->photo) }}">
                                        <img src="{{ asset('storage/'.$transaction->product->galleries->first()->photo) }}" style="width: 90px; height:90px" alt="">
                                    </a>
                                </td>
                                <td>{{ $transaction->product->name }}</td>
                                <td>{{ $transaction->quantity }} pcs</td>
                                <td>@currency($transaction->price)</td>

                                @if($transaction->clothing_size_id != null)
                                <td>{{ $transaction->clothing_size->size_name }}</td>
                                @else 
                                <td>{{ $transaction->accessories_size->size_name }}</td>
                                @endif

                                <td>{{ $transaction->material }}</td>
                                <td>@currency($transaction->price * $transaction->quantity)</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-danger">No Transaction Found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection