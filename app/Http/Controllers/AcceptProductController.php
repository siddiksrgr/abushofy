<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Shipping;

class AcceptProductController extends Controller
{
    public function store(Request $request)
    {
        $transaction = Transaction::findOrFail($request->transaction_id);
        $transaction->shipping_status = "terkirim";
        $transaction->save();
        $shipping = Shipping::find($transaction->confirmation->shipping->id);
        $shipping->status = "terkirim";
        $shipping->save(); 
        if($transaction->description == 'pre-order'){
            return redirect('/pre-orders')->with(['message' => 'Transaksi dengan kode ' .$transaction->code. ' berhasil diterima.']);
        } else {
            return redirect('/transaction')->with(['message' => 'Transaksi dengan kode ' .$transaction->code. ' berhasil diterima.']);
        }
    }
}
