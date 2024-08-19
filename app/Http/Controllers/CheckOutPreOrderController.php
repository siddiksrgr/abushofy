<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\Cart;
use App\Models\TransactionDetail;
use App\Models\Province;
use App\Models\City;
use Carbon\Carbon;

class CheckoutPreOrderController extends Controller
{
    public function checkout(Request $request)
    {
        $user = Auth::user(); 
        $code = 'PO-' . mt_rand(0000, 9999);
        $carts = Cart::with(['product', 'user'])->where('user_id', $user->id)->where('description', 'pre-order')->get();
        $province = app('App\Http\Controllers\API\CheckOngkirController')->province($request->province_destination_id);
        $city = app('App\Http\Controllers\API\CheckOngkirController')->city($request->city_destination_id);

        // Pre Order create
        $transaction = Transaction::create([
            'code' => $code,
            'user_id' => $user->id,
            'shipping_price' => $request->ongkir,
            'total_price' => (int) $request->grand_total, 
            'transaction_status' => 'menunggu validasi admin', 
            'payment_status' => 'belum bayar',
            'resi' => '', 
            'shipping_status' => 'pending',
            'courier' => $request->courier,
            'address' => $request->address,
            'province' => $province,
            'city' => $city,
            'zip_code' => $request->postal_code,
            'description' => 'pre-order'
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
                'price' =>  $cart->product->pre_order_price,
                'material' => $cart->material
            ]);
        } 
        // Hapus data pre order cart
        Cart::where('user_id', $user->id)->where('description', 'pre-order')->delete();
        return redirect('/pre-orders')->with(['message' => 'Pre Order berhasil dipesan, menunggu pihak admin untuk terima/tolak.']);
    }
}
