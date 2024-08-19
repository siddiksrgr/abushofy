@extends('layouts.app') 

@section('title')
Review
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
          <li class="breadcrumb-item active" aria-current="page">Review</li>
        </ol>
    </nav> 

    <div class="row" data-aos="zoom-in">
        <div class="col-lg-6">

            @if($transaction->clothing_size_id)
            <h6>{{ $transaction->product->name }} - Ukuran {{ $transaction->clothing_size->size_name }} - {{$transaction->quantity}} pcs</h6>
            @elseif($transaction->accessories_size_id)
            <h6>{{ $transaction->product->name }} - Ukuran {{ $transaction->accessories_size->size_name }} - {{$transaction->quantity}} pcs</h6>
            @endif

            <img src="{{ asset('storage/'.$transaction->product->galleries->first()->photo) }}" style="width: 100px; height:100px" class="my-4">

            @if($transaction->review)
            <div class="form-group">
                <label>Review :</label>
                <textarea class="form-control" rows="2" readonly>{{ $transaction->review->review }}</textarea>
            </div>
            <a href="{{ route('transaction.show', $transaction->transaction->id) }}" class="btn mt-5 btn-secondary">Kembali</a>
            @else
            <form action="{{ route('review.store') }}" method="post" class="mt-2">
                @csrf
                <div class="form-group">
                    <label>Review :</label>
                    <textarea class="form-control" rows="2" name="review" type="text" placeholder="Beri penilaian anda.." autofocus required></textarea>
                    <input type="hidden" name="product_id" value="{{$transaction->product_id}}" />
                    <input type="hidden" name="transaction_detail_id" value="{{$transaction->id}}" />
                    <input type="hidden" name="transaction_id" value="{{$transaction->transaction->id}}" />
                </div>
                <div class="float-left">
                    <a href="{{ route('transaction.show', $transaction->transaction->id) }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
            @endif 
        </div>
    </div>
</div>
@endsection
