<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Complain;
use App\Models\AccessoriesStock;
use App\Models\ClothingStock;
use App\Models\Shipping;
use Carbon\Carbon;

class AdminComplainController extends Controller
{
    public function index() 
    {
        $complains = Complain::latest()->get();
        return view('pages.admin.complain.index', ['complains' => $complains]);
    }

    public function update(Request $request, $id)
    {
        $complain = Complain::findOrFail($id);
        $complain->status = $request->status;
        $complain->save();
        
        if($request->status == 'barang diterima toko'){
            return redirect('admin/complains')
            ->with(['message' => 'Barang komplain dengan kode ' .$complain->transaction_detail->transaction->code. ' berhasil diterima']);
        }

        if($request->status == 'komplain diterima'){
            return redirect('admin/complains')
            ->with(['message' => 'Komplain dengan kode ' .$complain->transaction_detail->transaction->code. ' berhasil diterima,
            menunggu pembeli mengirim barang komplain']);

        } else {
            return redirect('admin/complains')
            ->with(['message' => 'Komplain dengan kode ' .$complain->transaction_detail->transaction->code. ' berhasil ditolak']);
        }
    }

    public function shipping_create($id) 
    {
        $complain = Complain::findOrFail($id);
        // check stok
        if($complain->transaction_detail->accessories_size_id){
            $accessories_stock = AccessoriesStock::where('accessories_size_id', $complain->transaction_detail->accessories_size_id)->first();
            if($accessories_stock->stock < $complain->quantity){
                return redirect()->back()->with(['danger' => 'Maaf, stok tidak mencukupi untuk dikirim']);
            } else {
                return view('pages.admin.complain.shipping', ['complain' => $complain]);
            }
        } else {
            $clothing_stock = ClothingStock::where('clothing_size_id', $complain->transaction_detail->clothing_size_id)->first();
            if($clothing_stock->stock < $complain->quantity){
                return redirect()->back()->with(['danger' => 'Maaf, stok tidak mencukupi untuk dikirim']);   
            } else {
                return view('pages.admin.complain.shipping', ['complain' => $complain]);
            }
        }
    }

    public function shipping_store(Request $request, $id)
    {
        $complain = Complain::findOrFail($id);
        
        // update stok
        if($complain->transaction_detail->accessories_size_id){
            $accessories_stock = AccessoriesStock::where('accessories_size_id', $complain->transaction_detail->accessories_size_id)->first();
            $accessories_stock->stock -= $complain->quantity; 
            $accessories_stock->save();
        } else {
            $clothing_stock = ClothingStock::where('clothing_size_id', $complain->transaction_detail->clothing_size_id)->first();
            $clothing_stock->stock -= $complain->quantity;
            $clothing_stock->save();
        }

        $complain->store_resi = $request->store_resi;
        $complain->status = 'barang dikirim dari toko';
        $complain->store_shipping_date = Carbon::now();
        $complain->save();

        Shipping::create([
            'confirmation_id' => $complain->transaction_detail->transaction->confirmation->id,
            'complain_id' => $complain->id,
            'status' => 'dikirim',
            'resi' => $request->store_resi
        ]);
        return redirect('admin/complains')
        ->with(['message' => 'Barang yang dikomplain dengan kode komplain ' .$complain->complain_code. ' berhasil dikirim dari toko']);
    }

    public function show($id)
    {
        $complain = Complain::findOrFail($id);
        return view('pages.admin.complain.detail', ['complain' => $complain]);
    }
}
