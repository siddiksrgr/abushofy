<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Complain;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ComplainController extends Controller
{
    public function index() 
    {
        $complains = Complain::where('user_id', Auth::user()->id)->latest()->get();
        return view('pages.complain-index', ['complains' => $complains]);
    }

    public function create($id) 
    {
        $transaction = TransactionDetail::findOrFail($id);
        if($transaction->complain){
            return redirect()->back();
        } else {
            return view('pages.complain-create', ['transaction' => $transaction]); 
        }
    }
 
    public function store(Request $request, $id) 
    { 
        $data = $request->all();
        $transaction = Transaction::findOrFail($id);
        $data['photo'] = $data['photo']->store('complains' , 'public'); 
        $data['complain_code'] = 'COM-' . mt_rand(0000, 9999);
        Complain::create($data);
        return redirect()->route('transaction.show', $transaction->id)
        ->with(['message' => 'Komplain berhasil dikirim, silahkan menunggu validasi.']);
    }

    public function shipping_create($id)
    {
        $complain = Complain::findOrFail($id);
        if($complain->user_shipping_date){
            return abort(404);
        } else {
            return view('pages.complain-shipping', ['complain' => $complain]);
        }
    }

    public function shipping_store(Request $request, $id)
    {
        $complain = Complain::findOrFail($id);
        $complain->user_resi = $request->user_resi;
        $complain->user_shipping_date = Carbon::now();
        $complain->status = 'barang dikirim dari pembeli';
        $complain->save();
        return redirect('/complains')
        ->with(['message' => 'Barang yang dikomplain dengan kode ' .$complain->transaction_detail->transaction->code. ' berhasil dikirim,
        menunggu barang yang baru dikirim dari toko.']);
    }

    public function accept($id) 
    {
        $complain = Complain::findOrFail($id);
        if($complain->status == 'barang diterima pembeli'){
            return abort(404);
        } else {
            $complain->status = 'barang diterima pembeli';
            $complain->user_shipping_date = Carbon::now();
            $complain->save();

            $complain->shipping->status = 'terkirim';
            $complain->shipping->save();
            
            return redirect('/complains')
            ->with(['message' => 'Barang yang dikomplain dengan kode ' .$complain->transaction_detail->transaction->code. ' berhasil diterima.']);
        }
    }

    public function show($id) 
    {
        $complain = Complain::findOrFail($id);
        return view('pages.complain-detail', ['complain' => $complain]);
    }
}
