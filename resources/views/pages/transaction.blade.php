@extends('layouts.app')

@section('title')
Transaksi
@endsection

@section('content')
<div class="container" data-aos="fade-down">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Transaksi</li>
        </ol>
      </nav> 

        @if(session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill"></i> {{ session('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
       
        <div class="my-3">
          <i class="bi bi-info-circle"></i><span class="text-secondary"> Timer akan menghitung mundur 24 Jam, 
            jika timer berhenti dan transaksi belum dibayar maka status transaksi otomatis menjadi batal.</span>
        </div>

        <div class="row" data-aos="zoom-in"> 
            <div class="col-lg-12  table-responsive">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Kode Transaksi</th>
                        <th scope="col">Total Harga</th>
                        <th scope="col">Status Bayar</th>
                        <th scope="col">Status Transaksi</th>
                        <th scope="col">Status Kirim</th>
                        <th scope="col">Timer</th>
                        <th scope="col">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                
                    @forelse($transactions as $transaction)
                      <tr>
                        <td class="cart-detail">{{ $transaction->code }}</td>
                        <td class="cart-detail">@currency($transaction->total_price)</td>
                        
                        <td class="cart-detail text-capitalize font-weight-bold {{ $transaction->payment_status == 'belum bayar' ? 'text-danger' :
                          ($transaction->payment_status == 'batal' ? 'text-danger' : 'text-primary') }}">
                        {{ $transaction->payment_status }}</td>
                        
                        <td class="cart-detail text-capitalize font-weight-bold {{ $transaction->transaction_status == 'pending' ? 'text-danger' : 
                          ($transaction->transaction_status == 'batal' ? 'text-danger' : 'text-primary') }}">
                          {{ $transaction->transaction_status }}
                        </td>

                        <td class="cart-detail text-capitalize font-weight-bold {{ $transaction->shipping_status == 'pending' ? 'text-danger' : 
                          ($transaction->shipping_status == 'batal' ? 'text-danger' : 'text-primary') }}">
                          {{ $transaction->shipping_status }}
                        </td>

                        <td  id="timeLapse{{$transaction->id}}" class="cart-detail {{ $transaction->transaction_status == 'pending' ? 'text-danger' : 'text-primary' }}"></td>

                        <td class="cart-detail row">
                          @if($transaction->payment_status == 'belum bayar') 
                            <a href="{{ route('confirm.show', $transaction->id) }}" class="btn btn-sm btn-primary mr-1">Bayar</a>
                          @endif
                          @if($transaction->shipping_status == 'dikirim')
                          <form action="/accept/store" method="POST">
                            @csrf
                            <button type="submit" name="transaction_id" value="{{$transaction->id}}" onclick="return confirm('Apakah anda yakin Terima Pesanan? Pastikan pesanan sudah diterima.')" class="btn btn-sm btn-success mr-1">
                              Terima Pesanan
                            </button>
                          </form>
                          @endif
                            <a href="{{ route('transaction.show', $transaction->id) }}" class="btn btn-sm btn-warning">Detail</a>
                        </td>
                      </tr>
                    @empty
                    <tr><td colspan="8" class="text-center text-danger">Transaksi kosong</td></tr>
                    @endforelse
                    
                    </tbody>
                </table>
            </div>
        </div>
</div>
@endsection

@push('addon-script')
<script>
  var countdowns = [
  @foreach ($transactions as $transaction)
  {
    id: {{$transaction->id}},
    date: new Date("{{ \Carbon\Carbon::parse($transaction->expired_at)->format('M, j Y H:i:s') }}").getTime(),
    status: "{{$transaction->transaction_status}}",
    confirm: @if($transaction->confirmation) 1 @else 0 @endif
  }, 
  @endforeach
  ];

  // Update the count down every 1 second
  var timer = setInterval(function() {
    // Get todays date and time
    var now = Date.now();

    var index = countdowns.length - 1;

    // we have to loop backwards since we will be removing
    // countdowns when they are finished
    while(index >= 0) {
      var countdown = countdowns[index];

      // Find the distance between now and the count down date
      var distance = countdown.date - now;

      // Time calculations for days, hours, minutes and seconds
      var days = Math.floor(distance / (1000 * 60 * 60 * 24));
      var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);

      var timerElement = document.getElementById("timeLapse" + countdown.id);
      // If the count down is over, write some text 
      if (distance < 0 && countdown.confirm == 0) {
        timerElement.innerHTML = "- : - : -";
        // this timer is done, remove it
        countdowns.splice(index, 1);

        if(countdown.status == 'pending'){
          window.location.href = "/transaction-expired/" + countdown.id;
        }

      } else if (countdown.confirm == 1) {
        timerElement.innerHTML = " -  :  -  :  -";
        // this timer is done, remove it
        countdowns.splice(index, 1);
      } else {
        timerElement.innerHTML =  hours + " : " + minutes + " : " + seconds; 
      }
      index -= 1;
    }

    // if all countdowns have finished, stop timer
    if (countdowns.length < 1) {
      clearInterval(timer);
    }
  }, 1000);
</script>
@endpush