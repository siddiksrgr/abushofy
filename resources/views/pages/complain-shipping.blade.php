@extends('layouts.app') 

@section('title')
Kirim Barang Komplain
@endsection

@section('content')
<div class="container" data-aos="fade-down">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          <li class="breadcrumb-item"><a href="/complains">Komplain</a></li>
          <li class="breadcrumb-item active" aria-current="page">Kirim</li>
        </ol>
    </nav>

    <div class="row" data-aos="zoom-in" data-aos="fade-up">
        <div class="col-lg-6">

            @if($complain->transaction_detail->clothing_size_id)
            <h6>{{ $complain->transaction_detail->product->name }} - Size {{ $complain->transaction_detail->clothing_size->size_name }} - {{$complain->quantity}} pcs </h6>
            @elseif($complain->transaction_detail->accessories_size_id)
            <h6>{{ $complain->transaction_detail->product->name }} - Size {{ $complain->transaction_detail->accessories_size->size_name }} - {{$complain->quantity}} pcs</h6>
            @endif

            <img src="{{ asset('storage/'.$complain->transaction_detail->product->galleries->first()->photo) }}" style="width: 100px; height:100px" class="my-4">

            <div class="form-group">
                <label>Alamat Kirim :</label>
                <textarea class="form-control" rows="2" placeholder="Jl. Raya Tonjong No.24, Tonjong, Kec. Tajur Halang, Kabupaten Bogor, Jawa Barat 16320" readonly></textarea>
            </div>
            
            <form action="/complain/shipping/{{$complain->id}}" method="post" class="mt-2"> 
                @csrf
                <div class="form-group">
                    <label>Resi :</label>
                    <input class="form-control" name="user_resi" type="number" placeholder="Masukkan nomor resi pengiriman.." autofocus required></input>
                </div>
                <div class="float-left mt-4">
                    <a href="/complains" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection