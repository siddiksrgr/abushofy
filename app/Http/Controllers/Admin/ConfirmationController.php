<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Confirmation;

class ConfirmationController extends Controller
{
    public function index()
    {
        $confirmations = Confirmation::latest()->get();
        return view('pages.admin.confirmation.index', ['confirmations' => $confirmations]);
    }
 
    public function show($id)
    {
        $confirmation = Confirmation::findOrFail($id);
        return view('pages.admin.confirmation.details', ['confirmation' => $confirmation]);
    }

    public function update($id)
    {   
        $confirmation = Confirmation::findOrFail($id);
        $transaction = $confirmation->transaction;

        if($transaction->description == 'pre-order'){
            if($transaction->payment_status == "baru DP"){
                // terima DP
                $confirmation->status = 1;
                $confirmation->save();
                $transaction->transaction_status = "sedang dikerjakan";
                $transaction->save();
                return redirect('admin/confirmations')->with(
                    ['message' => 'Konfirmasi pembayaran transaksi pre order dengan kode ' .$transaction->code. ' berhasil terima DP'
                ]);
            } else {
                // terima pelunasan
                $confirmation->status = 1; 
                $confirmation->save();
                $transaction->transaction_status = "sukses";
                $transaction->shipping_status = "siap dikirim";
                $transaction->save();
                return redirect('admin/confirmations')->with(
                    ['message' => 'Konfirmasi pembayaran transaksi pre order dengan kode ' .$transaction->code. ' berhasil terima pelunasan'
                ]);
            }
        } else {
            $confirmation->status = 1;
            $confirmation->save();
            $transaction->transaction_status = "sukses";
            $transaction->shipping_status = "siap dikirim";
            $transaction->save();
            return redirect('admin/confirmations')->with(
                ['message' => 'Pembayaran transaksi dengan kode ' .$transaction->code. ' berhasil diterima'
            ]);
        }
    }
}
