<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables; 
use App\Models\Transaction;
use App\Models\TransactionDetail;

class AdminTransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::latest()->get();
        return view('pages.admin.transaction.index', ['transactions' => $transactions]); 
    }

    public function show($id)
    {
        $transaction = Transaction::findOrFail($id);
        return view('pages.admin.transaction.details', ['transaction' => $transaction]);
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->transaction_status = $request->status;
        $transaction->save();
        return redirect()->route('transactions.index')
        ->with(['message' => 'Transaksi pre order dengan kode ' .$transaction->code. ' ' .$request->status. '']);
    }
}
