<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Confirmation;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ConfirmController extends Controller
{
    public function index(){}

    public function create(){}

    public function show($id) 
    {
        //create
        $transaction = Transaction::where('id', $id)->firstOrFail();
        if($transaction->transaction_status == "batal" || $transaction->confirmation){
            return abort(404);
        } else {
            return view('pages.confirm', ['transaction' => $transaction]); 
        }
    }
  
    public function store(Request $request) 
    {
        $transaction = Transaction::findOrFail($request->transaction_id);
        if($transaction->description == 'pre-order' && $request->down_payment) {
            $transaction->payment_status = "baru DP";
            $transaction->transaction_status = "menunggu Validasi";
            $transaction->save(); 
        } else{
            $transaction->payment_status = "lunas";
            $transaction->transaction_status = "menunggu validasi";
            $transaction->save();
        }

        if($request->down_payment){
            $down_payment = $request->down_payment->store('confirmations' , 'public');
            $paid_off = null;
            $down_payment_date = Carbon::now();
            $paid_off_date = null;
        } elseif ($request->paid_off){
            $paid_off = $request->paid_off->store('confirmations' , 'public');
            $down_payment = null;
            $down_payment_date = null;
            $paid_off_date = Carbon::now();
        }

        Confirmation::create([
            'transaction_id' => $request->transaction_id,
            'down_payment' => $down_payment,
            'paid_off' => $paid_off,
            'status' => 0,
            'down_payment_date' => $down_payment_date,
            'paid_off_date' => $paid_off_date 
        ]);
        if($transaction->description == 'pre-order'){
            return redirect('/pre-orders')->with(['message' => 'Pembayaran DP pre order dengan kode ' .$transaction->code. ' berhasil dikirim, silahkan menunggu validasi.']);
        } else {
            return redirect('/transaction')->with(['message' => 'Pembayaran transaksi dengan kode ' .$transaction->code. ' berhasil dikirim, silahkan menunggu validasi.']);
        }
    }

    public function edit($id)
    { 
        // bayar pelunasan po
        $transaction = Transaction::where('id', $id)->firstOrFail();
        if($transaction->transaction_status == "batal" || $transaction->payment_status == "lunas" ){
            return abort(404);
        } else {
            return view('pages.pre-order-confirm', ['transaction' => $transaction]); 
        } 
    }

    public function update(Request $request, $id)
    {
        // update pelunasan po
        $confirmation = Confirmation::findOrFail($id);
        $paid_off = $request->paid_off->store('confirmations' , 'public'); 
        $confirmation->paid_off = $paid_off;
        $confirmation->status = 0;
        $confirmation->paid_off_date = Carbon::now();
        $confirmation->save();

        $transaction = Transaction::findOrFail($confirmation->transaction_id);
        $transaction->payment_status = "lunas";
        $transaction->transaction_status = "menunggu validasi";
        $transaction->save();
        return redirect('/pre-orders')->with(['message' => 'Pelunasan pre order dengan kode ' .$confirmation->transaction->code. ' berhasil dikirim, silahkan menunggu validasi Admin.']);
    }
}
