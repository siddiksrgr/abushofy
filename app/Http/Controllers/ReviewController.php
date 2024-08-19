<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use App\Models\Transaction;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index(){}
    public function edit(){}
    public function update(){}
    public function destroy(){}

    public function show($id)  
    {
        $transaction = TransactionDetail::findOrFail($id);
        if($transaction->transaction->shipping_status == 'terkirim'){
            return view('pages.review', ['transaction' => $transaction]);
        } else {
            return abort(404);
        }
    }

    public function store(Request $request)
    {
        $transaction = Transaction::findOrFail($request->transaction_id);
        Review::create([
            'product_id' => $request->product_id,
            'transaction_detail_id' => $request->transaction_detail_id,
            'review' => $request->review
        ]);
        return redirect()->route('transaction.show', $transaction->id)
        ->with(['message' => 'Produk berhasil diberi review']);
    }
}
