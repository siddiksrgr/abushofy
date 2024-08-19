@extends('layouts.admin')

@section('title')
Transaksi
@endsection

@section('content')
<!-- Page Content -->
<div class="col-md-9 ml-sm-auto col-lg-10 px-md-4 bg-light">
    <div class="container">
        <div class="dashboard-heading mt-3">
            <h2 class="dashboard-tittle">Transaksi</h2>
            <p class="dashboard-subtittle">Data Transaksi</p>
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
            <a href="/admin/transaction/exportPDF" class="btn btn-secondary btn-sm mb-3"><i class="bi bi-printer"></i> Print</a>
                    <div class="table-responsive">
                        <table class="table table-hover scroll-horizontal-vertical w-100" id="dataTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th scope="col">Kode Transaksi</th>
                                    <th scope="col">User</th>
                                    <th scope="col">Total Harga</th>
                                    <th scope="col">Status Bayar</th>
                                    <th scope="col">Status Transaksi</th>
                                    <th scope="col">Status Kirim</th>
                                    <th scope="col">Aksi</th> 
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $transaction)
                                <tr>
                                    <td class="text-bold">{{$loop->iteration}}</td>
                                    <td>{{$transaction->code}}</td>
                                    <td>{{$transaction->user->name}}</td>
                                    <td>@currency($transaction->total_price)</td>

                                    <!-- status bayar -->
                                    <td>{{$transaction->payment_status}}</td>
                    
                                    <!-- status transaksi -->
                                    <td>
                                        <span class="{{ $transaction->transaction_status == 'menunggu validasi admin' ? 'text-danger font-weight-bold' : 
                                            ($transaction->transaction_status == 'sedang dikerjakan' ?  'text-danger font-weight-bold' :
                                            ($transaction->transaction_status == 'pending' ?  'text-danger font-weight-bold' : '')) }}">
                                        {{$transaction->transaction_status}}
                                        </span>
                                    </td>

                                    <!-- status kirim -->
                                    <td>{{$transaction->shipping_status}}</td>

                                    <td class="row">
                                        <div class="dropdown">
                                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                Pilih Aksi
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item text-warning font-weight-bold"  href="{{ route('transactions.show', $transaction->id) }}">Detail</a>
                                                @if(auth()->user()->role == 'pemilik' && $transaction->description == 'pre-order' && $transaction->transaction_status == 'menunggu validasi admin')
                                                <form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
                                                    @method('PUT')
                                                    @csrf
                                                    <button type="submit" name="status" value="pre-order diterima" onclick="return confirm('Apakah anda yakin terima pre order?')" class="dropdown-item text-primary font-weight-bold">Terima PO</button>
                                                    <button type="submit" name="status" value="pre-order ditolak" onclick="return confirm('Apakah anda yakin tolak pre order?')" class="dropdown-item text-danger font-weight-bold">Tolak PO</button>
                                                </form>
                                                @elseif(auth()->user()->role == 'pegawai' && $transaction->description == 'pre-order' && $transaction->transaction_status == 'sedang dikerjakan')
                                                <form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
                                                    @method('PUT')
                                                    @csrf
                                                    <button type="submit" name="status" value="siap dikirim" onclick="return confirm('Apakah anda yakin pesanan pre order siap kirim? Jika iya maka pembeli dapat membayar sisa pelunasan.')" 
                                                        class="dropdown-item text-success font-weight-bold">
                                                        Siap Kirim
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