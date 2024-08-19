@extends('layouts.admin')

@section('title')
Komplain
@endsection

@section('content')
<!-- Page Content -->
<div class="col-md-10 ml-sm-auto col-lg-10 px-md-4 bg-light">
    <div class="container">
        <div class="dashboard-heading mt-3">
            <h2 class="dashboard-tittle">Komplain</h2>
            <p class="dashboard-subtittle">Data Komplain</p>
        </div>

        @if(session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill"></i> {{ session('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        @if(session()->has('danger'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-x-circle-fill"></i> {{ session('danger') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        <div class="card">
            <div class="card-body"> 
            <a href="/admin/complain/exportPDF" class="btn btn-secondary btn-sm mb-3"><i class="bi bi-printer"></i> Print</a>
                    <div class="table-responsive">
                        <table class="table table-hover scroll-horizontal-vertical w-100" id="dataTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th scope="col">Kode Transaksi</th>
                                    <th scope="col">Kode Komplain</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Aksi</th> 
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($complains as $complain)
                                <tr>
                                    <td class="text-bold">{{$loop->iteration}}</td>
                                    <td class="transaction-code">
                                        <a href="{{ route('transactions.show', $complain->transaction_detail->transaction->id) }}">
                                            {{ $complain->transaction_detail->transaction->code }}
                                        </a>
                                    </td> 
                                    <td>{{ $complain->complain_code }}</td>
                                    <td class="@if($complain->status == 'menunggu validasi' || $complain->status == 'barang dikirim dari pembeli' 
                                    || $complain->status == 'barang diterima toko') text-danger font-weight-bold @endif">{{ $complain->status }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                Pilih Aksi
                                            </button>
                                            <div class="dropdown-menu">
                                                <a href="{{ route('complains.show', $complain->id) }}" class="dropdown-item text-warning font-weight-bold">Detail</a>
                                                @if(auth()->user()->role == 'pemilik' && $complain->status == 'menunggu validasi')
                                                <form action="{{ route('complains.update', $complain->id) }}" method="POST">
                                                    @method('PUT')
                                                    @csrf
                                                    <button type="submit" name="status" value="komplain diterima" onclick="return confirm('Apakah anda yakin terima komplain?')" class="dropdown-item text-primary font-weight-bold">Terima</button>
                                                    <button type="submit" name="status" value="komplain ditolak" onclick="return confirm('Apakah anda yakin tolak komplain?')" class="dropdown-item text-danger font-weight-bold">Tolak</button>
                                                </form>
                                                @elseif(auth()->user()->role == 'pegawai' && $complain->status == 'barang dikirim dari pembeli')
                                                <form action="{{ route('complains.update', $complain->id) }}" method="POST">
                                                    @method('PUT')
                                                    @csrf
                                                    <button type="submit" name="status" value="barang diterima toko" onclick="return confirm('Apakah anda yakin terima barang yang dikomplain?')" class="text-primary dropdown-item font-weight-bold">
                                                        Terima
                                                    </button>
                                                </form>
                                                @endif
                                                @if(auth()->user()->role == 'pegawai' && $complain->status == 'barang diterima toko')
                                                <form action="complain/shipping/create/{{ $complain->id }}" method="POST">
                                                    @csrf
                                                    <button type="submit" value="barang diterima toko" class="dropdown-item text-success font-weight-bold" onclick="return confirm('Apakah anda yakin akan kirim? Barang yang dikirim akan mengurangi stok')">
                                                        Kirim
                                                    </button>
                                                </form>
                                                @endif
                                            </div>
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