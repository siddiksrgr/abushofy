<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Auth;
use App\Models\ClothingStock;
use App\Models\AccessoriesStock;
use App\Models\Province;
use App\Models\City;
use Carbon\Carbon;
use App\Models\Cart;

class TransactionController extends Controller 
{
    public function index()
    {
        $transactions = Transaction::where('user_id', Auth::user()->id)->where('description', '-')->latest()->get();
        return view('pages.transaction', [
            'transactions' => $transactions
        ]); 
    }

    public function store(Request $request)
    {
        $user = Auth::user(); 
        $code = 'AS-' . mt_rand(0000, 9999);
        $carts = Cart::with(['product', 'user'])->where('user_id', $user->id)->where('description', '-')->get();
        $expired_at = Carbon::now()->addDay();

        $province = app('App\Http\Controllers\API\CheckOngkirController')->province($request->province_destination_id);
        $city = app('App\Http\Controllers\API\CheckOngkirController')->city($request->city_destination_id);

        // Transaction create
        $transaction = Transaction::create([
            'code' => $code,
            'user_id' => $user->id,
            'shipping_price' => $request->ongkir,
            'total_price' => (int) $request->grand_total, 
            'transaction_status' => 'pending',
            'payment_status' => 'belum bayar',
            'shipping_status' => 'pending',
            'resi' => '', 
            'courier' => $request->courier,
            'address' => $request->address,
            'province' => $province,
            'city' => $city, 
            'zip_code' => $request->postal_code,
            'description' => '-',
            'expired_at' => $expired_at
        ]);

        $user->phone_number = $request->mobile;
        $user->save();
        
        foreach($carts as $cart){
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id' => $cart->product_id,
                'quantity' => $cart->quantity,
                'clothing_size_id' => $cart->clothing_size_id,
                'accessories_size_id' => $cart->accessories_size_id,
                'price' =>  $cart->product->price,
                'material' => $cart->material
            ]);
        } 
        // Hapus data cart
        Cart::where('user_id', $user->id)->where('description', '-')->delete();
        return redirect()->route('confirm.show', $transaction->id);
    }

    public function pre_orders()
    {
        $transactions = Transaction::where('user_id', Auth::user()->id)->where('description', 'pre-order')->latest()->get();
        return view('pages.pre-order', [
            'transactions' => $transactions
        ]); 
    }

    public function show($id) 
    {
        $transaction = Transaction::where('id', $id)->firstOrFail();
        return view('pages.transaction-details', [
            'transaction' => $transaction
        ]); 
    } 

    public function expired($id)
    {
        $transaction = Transaction::where('id', $id)->firstOrFail();
       
        $transaction->update([
            'transaction_status' => 'batal',
            'resi' => null,
            'payment_status' => 'batal',
            'shipping_status' => 'batal'
        ]);

        foreach($transaction->transactions as $transaction)
        {
            // update stok untuk clothing
            if($transaction->clothing_size_id){
                $stock = $transaction->clothing_size->stock;
                $stock->update([
                    'stock' => $stock->stock + $transaction->quantity
                ]);

            // update stok untuk accessories
            } if ($transaction->accessories_size_id) {
                $stock = $transaction->accessories_size->stock;
                $stock->update([
                    'stock' => $stock->stock + $transaction->quantity
                ]);
            }
        }
        return redirect('/transaction');
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction_detail = TransactionDetail::where('transaction_id', $transaction->id)->delete();
        $transaction->delete();
        return redirect('/pre-orders')->with(['message' => 'Pre Order berhasil dihapus']);
    }
}
