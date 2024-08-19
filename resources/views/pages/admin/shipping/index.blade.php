@extends('layouts.admin')

@section('title')
Pengiriman
@endsection

@section('content')
<!-- Page Content -->
<div class="col-md-9 ml-sm-auto col-lg-10 px-md-4 bg-light">
    <div class="container">
        <div class="dashboard-heading mt-3">
            <h2 class="dashboard-tittle">Pengiriman</h2>
            <p class="dashboard-subtittle">Data Pengiriman</p>
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
            <a href="/admin/shipping/exportPDF" class="btn btn-secondary btn-sm mb-3"><i class="bi bi-printer"></i> Print</a>
                    <div class="table-responsive">
                        <table class="table table-hover scroll-horizontal-vertical w-100" id="dataTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th scope="col">Kode Transaksi</th>
                                    <th scope="col">Kode Komplain</th>
                                    <th scope="col">Resi</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Tanggal Dikirim</th>
                                    <th scope="col">Tanggal Terkirim</th>
                                </tr>
                            </thead>
                        <tbody>
                            @foreach($shipping as $shipping)
                            <tr>
                                <td class="text-bold">{{$loop->iteration}}</td>
                                <td class="transaction-code">
                                    <a href="{{ route('transactions.show', $shipping->confirmation->transaction->id) }}">
                                        {{$shipping->confirmation->transaction->code}}
                                    </a>  
                                </td>
                                
                                @if($shipping->complain)
                                <td class="transaction-code">
                                    <a href="{{ route('complains.show', $shipping->complain->id) }}">
                                        {{$shipping->complain->complain_code}}
                                    </a>  
                                </td>
                                @else
                                <td> - </td>
                                @endif

                                <td>{{$shipping->resi}}</td>
                                <td>{{$shipping->status}}</td> 
                                <td>{{ \Carbon\Carbon::parse($shipping->created_at)->format('d-m-Y, H:i') }}</td> 
                                
                                @if($shipping->status == 'terkirim')
                                <td>{{ \Carbon\Carbon::parse($shipping->updated_at)->format('d-m-Y, H:i') }}</td>
                                @else
                                <td>-</td>
                                @endif
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