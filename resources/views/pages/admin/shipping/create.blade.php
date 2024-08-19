@extends('layouts.admin')

@section('title')
Tambah Data Pengiriman
@endsection

@section('content')
<!-- Page Content -->
<div class="col-md-9 ml-sm-auto col-lg-10 px-md-4 bg-light">
    <div class="container">
        <div class="dashboard-heading mt-3">
            <h2 class="dashboard-tittle">Pengiriman</h2>
            <p class="dashboard-subtittle">Tambah Data Pengiriman</p>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('shippings.store') }}" method="POST">
                    @csrf 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Kode</label>
                                <select name="confirmation_id" class="form-control" readonly>
                                    <option value="{{ $confirmation->id }}">{{ $confirmation->transaction->code }}</option>
                                </select>
                            </div>
                        </div> 
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Kurir</label>
                                <input class="form-control" value="{{ strtoupper($confirmation->transaction->courier) }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Alamat Pembeli:</label>
                                <input class="form-control" placeholder="{{$confirmation->transaction->address}}, {{$confirmation->transaction->city}}, {{$confirmation->transaction->province}}, {{$confirmation->transaction->zip_code}}, {{$confirmation->transaction->user->phone_number}}" readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control" readonly>
                                    <option value="dikirim">Dikirim</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Resi</label>
                                <input type="number" class="form-control" name="resi" placeholder="Input resi.." autofocus required>
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