@extends('layouts.confirm') 

@section('title')
Konfirmasi Pembayaran Pre Order
@endsection

@push('addon-style')
<style>
    .verikal_center{
     border: 1px solid #E9ECEF;
     height: 50vh;
     margin-left: 30px;
    }
    .form{
        margin-top: 15px;
        margin-bottom: 15px;
    }
</style>
@endpush

@section('content')
<div class="container mt-1" data-aos="fade-down">
    <div class="row justify-content-center">
        <h5 class="text-secondary">Konfirmasi Pembayaran Pelunasan</h5>
    </div>
</div>

<div class="container my-3"> 
        <div class="row justify-content-center">
            <div class="col-lg-5 confirm" data-aos="fade-right">
                <p>Kode : {{$transaction->code}}</p>
                <p>Total : <span class="text-danger font-weight-bold">@currency($transaction->total_price)</span></p>

                <p>Sisa 50% : <span class="text-danger font-weight-bold">@currency($transaction->total_price / 2)</span></p>
                <p class="font-weight-bold">Silahkan transfer sesuai Sisa.</pc> <br>

                <p>Transfer ke rekening berikut :</p>
                <div class="row mb-4 mt-3">
                    <div class="col-lg-2">
                        <img src="{{ asset('storage/bca.png') }}" style="width:70px; height:40px">
                    </div>
                    <div class="col-lg-10">
                        <p>Bank Central Asia</p>
                        <p>2209 8776</p>
                        <p>Abu Shofy</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-2">
                        <img src="{{ asset('storage/mandiri.jpg') }}" style="width:70px; height:40px">
                    </div>
                    <div class="col-lg-10">
                        <p>Bank Mandiri</p>
                        <p>2209 8776</p>
                        <p>Abu Shofy</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-1 d-lg-flex d-sm-none d-none">
                <div class="verikal_center"></div>
            </div>

            <div class="col-lg-5" data-aos="fade-left"> 
                <form action="{{ route('confirm.update', $transaction->confirmation->id) }}" method="POST" enctype="multipart/form-data">
                @method('PUT') 
                @csrf
                    <div class="form-group">
                        <label for="photo">Upload Bukti Transfer</label>
                        <input type="file" class="form-control-file" id="photo" name="paid_off" required>
                    </div>
                </div>
                    <div data-aos="fade-up">
                        <div class="row justify-content-center mt-5">
                            <button type="submit" class="btn btn-primary px-5">Submit</button>
                        </div> 
                </form>
                        <div class="row justify-content-center mt-2">
                            <a href="/pre-orders" class="btn text-primary border-primary px-5">Cancel</a>
                        </div>
                    </div>
        </div>
</div>
@endsection
