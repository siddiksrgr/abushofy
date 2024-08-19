<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shipping;
use App\Models\Confirmation;

class ShippingController extends Controller
{
    public function index()
    {
        $shipping = Shipping::all();
        return view('pages.admin.shipping.index', ['shipping' => $shipping]);
    }

    public function create($id)
    {  
        $confirmation = Confirmation::findOrFail($id); 
        if($confirmation->shipping || $confirmation->transaction->transaction_status == 'sedang dikerjakan'){
            return abort(404);
        } else{
            return view('pages.admin.shipping.create', ['confirmation' => $confirmation]);
        }
    }

    public function store(Request $request)
    {
        $confirmation = Confirmation::findOrFail($request->confirmation_id);
        $transaction = $confirmation->transaction->update([
            'resi' => $request->resi,
            'shipping_status' => 'dikirim'
        ]);
        Shipping::create($request->all());
        return redirect('admin/shippings')->with(['message' => 'Transaksi dengan kode ' .$confirmation->transaction->code. ' berhasil dikirim']); 
    }
}
