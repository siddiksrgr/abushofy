@extends('layouts.admin')

@section('title')
Pembayaran
@endsection

@section('content')
<!-- Page Content -->
<div class="col-md-9 ml-sm-auto col-lg-10 px-md-4 bg-light">
    <div class="container">
        <div class="dashboard-heading mt-3">
            <h2 class="dashboard-tittle">Pembayaran</h2>
            <p class="dashboard-subtittle">Data Pembayaran</p>
        </div>

        @if(session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill"></i> {{ session('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        <div class="card">
            <div class="card-body">
            <a href="/admin/payment/exportPDF" class="btn btn-secondary btn-sm mb-3"><i class="bi bi-printer"></i> Print</a>
                    <div class="table-responsive">
                        <table class="table table-hover scroll-horizontal-vertical w-100" id="dataTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th scope="col">Kode Transaksi</th>
                                    <th scope="col">Total Harga</th>
                                    <th scope="col">DP</th>
                                    <th scope="col">Pelunasan</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                        <tbody>
                            @foreach($confirmations as $confirmation)
                            <tr>
                                <td class="text-bold">{{$loop->iteration}}</td>
                                <td class="transaction-code">
                                    <a href="{{ route('transactions.show', $confirmation->transaction->id) }}">
                                        {{$confirmation->transaction->code}}
                                    </a>  
                                </td>
                                <td>@currency($confirmation->transaction->total_price)</td>

                                <!-- DP -->
                                @if($confirmation->transaction->description == 'pre-order' && $confirmation->down_payment != null)
                                <td>
                                    <a href="{{ asset('storage/'. $confirmation->down_payment) }}">
                                        <img src="{{ asset('storage/'. $confirmation->down_payment) }}" style="max-height: 48px;">
                                    </a>
                                </td>
                                @else
                                <td> - </td>
                                @endif

                                <!-- pelunasan -->
                                @if($confirmation->paid_off != null)
                                <td>
                                    <a href="{{ asset('storage/'. $confirmation->paid_off) }}">
                                        <img src="{{ asset('storage/'. $confirmation->paid_off) }}" style="max-height: 48px;">
                                    </a>
                                </td>
                                @else
                                <td> - </td>
                                @endif

                                <!-- payment status -->
                                <td>{{ $confirmation->transaction->payment_status }}</td>

                                <td>
                                    <div class="row pl-3">
                                        @if(auth()->user()->role == 'pemilik' && $confirmation->status == 0)
                                        <form action="{{route('confirmations.update', $confirmation->id)}}" method="POST">
                                            @method('put') 
                                            @csrf()
                                            <button type="submit" class="btn btn-primary btn-sm mr-1" onclick="return confirm('Apakah anda yakin Terima?')">Terima</button>
                                        </form>
                                        @endif

                                        @if(auth()->user()->role == 'pegawai' && $confirmation->transaction->shipping_status == "siap dikirim" && $confirmation->transaction->payment_status == "lunas")
                                        <a href="shippings/create/{{ $confirmation->id }}" class="btn btn-success btn-sm mr-1">Kirim Pesanan</a>
                                        @endif  
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection