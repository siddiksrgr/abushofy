@extends('layouts.admin')

@section('title')
Tambah Data Pengiriman Barang Komplain
@endsection

@section('content')
<!-- Page Content -->
<div class="col-md-9 ml-sm-auto col-lg-10 px-md-4 bg-light">
    <div class="container">
        <div class="dashboard-heading mt-3">
            <h2 class="dashboard-tittle">Pengiriman Barang Komplain</h2>
            <p class="dashboard-subtittle">Tambah Data Pengiriman Barang Komplain</p>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="/admin/complain/shipping/{{$complain->id}}" method="POST">
                    @csrf 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Kode</label>
                                <input class="form-control" type="text" placeholder="{{ $complain->transaction_detail->transaction->code }}" readonly>
                            </div>
                        </div> 
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Keterangan</label>
                                <input class="form-control" type="text" placeholder="Pengembalian Barang Komplain" readonly>
                            </div>
                        </div> 
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Status</label>
                                <input name="status" class="form-control" type="text" value="dikirim dari toko" readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Alamat Pembeli:</label>
                                <input class="form-control text-capitalize" placeholder="{{$complain->address}}" readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Resi</label>
                                <input type="number" class="form-control" name="store_resi" placeholder="Input resi.." autofocus required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <button type="submit" class="btn btn-success px-5 mt-3">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection