@extends('layouts.app') 

@section('title')
Komplain
@endsection

@section('content')
<div class="container" data-aos="fade-down">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          @if($transaction->transaction->description == 'pre-order')
          <li class="breadcrumb-item"><a href="/pre-orders">Pre Order</a></li>
          @else
          <li class="breadcrumb-item"><a href="/transaction">Transaksi</a></li>
          @endif
          <li class="breadcrumb-item"><a href="{{ route('transaction.show', $transaction->transaction->id) }}">Detail</a></li>
          <li class="breadcrumb-item active" aria-current="page">Komplain</li>
        </ol>
    </nav>

    <div class="my-3" data-aos="fade-right">
        <i class="bi bi-info-circle"></i><span class="text-secondary"> Barang yang dikomplain akan dikirim dengan yang baru jika komplain diterima, tidak melayani pengembalian uang.</span>
    </div>

    <div class="row" data-aos="zoom-in" data-aos="fade-up">
        <div class="col-lg-6">

            @if($transaction->clothing_size_id)
            <h6>{{ $transaction->product->name }} - Size {{ $transaction->clothing_size->size_name }} - {{$transaction->quantity}} pcs 
            </h6>
            @elseif($transaction->accessories_size_id)
            <h6>{{ $transaction->product->name }} - Size {{ $transaction->accessories_size->size_name }} - {{$transaction->quantity}} pcs
            </h6>
            @endif

            <img src="{{ asset('storage/'.$transaction->product->galleries->first()->photo) }}" style="width: 100px; height:100px" class="my-4">

            <form action="/complain/{{$transaction->transaction->id}}}') }}" method="post" enctype="multipart/form-data" class="mt-2">
                @csrf
                <div class="form-group">
                    <label>Komplain :</label>
                    <select name="complain" class="form-control" required>
                        <option value="rusak/robek">Barang Rusak/Robek</option>
                    </select>
                    <input type="hidden" name="transaction_detail_id" value="{{$transaction->id}}" />
                </div>
                <div class="form-group">
                    <label>Jumlah :</label>
                    <input type="number" min="1" max="{{$transaction->quantity}}" class="form-control" name="quantity" placeholder="Jumlah yang dikomplain" required>
                </div>
                <div class="form-group">
                    <label>Alamat Pengirim:</label>
                    <textarea class="form-control text-capitalize" rows="2" name="address" type="text" placeholder="Alamat lengkap .." required>{{$transaction->transaction->address}}, {{$transaction->transaction->city}}, {{$transaction->transaction->province}}, {{$transaction->transaction->zip_code}}, ({{auth()->user()->phone_number}})</textarea>
                </div>
                <div class="form-group">
                    <label>Bukti Foto :</label>
                    <div class="form-group">
                        <input type="file" class="form-control-file" id="photo" name="photo" required>
                    </div>
                </div>
                <input type="hidden" name="user_id" value="{{Auth::user()->id}}" />
                <input type="hidden" name="status" value="menunggu validasi" />
                <div class="float-left mt-4">
                    <a href="{{ route('transaction.show', $transaction->transaction->id) }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection