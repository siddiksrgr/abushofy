<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PreOrderCartController extends Controller
{
    public function index()
    {
        $carts = Cart::where('user_id', Auth::user()->id)->where('description', 'pre-order')->latest()->get();
        $weightTotal = 0; 

        foreach($carts as $cart)
        {
            $weightTotal += $cart->product->weight * $cart->quantity;
        }
        return view('pages.pre-order-cart', ['carts' => $carts, 'weightTotal' => $weightTotal]);
    }

    public function store(Request $request) 
    {
        $carts = Cart::where('user_id', Auth::user()->id)->where('description', 'pre-order')->latest()->get();
        $product = Product::findOrFail($request->product_id);
        $carts_quantity = $carts->sum('quantity');
        $total_quantity = $carts_quantity + $request->quantity; 

        // check jika produk dan size yang sama sudah ada di cart
        if($carts){
            if($total_quantity > 60 ){
                return redirect('/pre-order-cart')->with(['danger' => 'Jumlah yang anda masukkan melebihi 60, maksimal pre order dalam sekali pemesanan adalah 60']);
            }
            foreach($carts as $cart)
            {
                // check untuk clothing
                if($cart->clothing_size != null && $cart->clothing_size_id == $request->clothing_size_id && $cart->material == $request->material){
                    $quantity = $cart->quantity += $request->quantity;
                    if($quantity > 60){
                        return redirect('/pre-order-cart')->with(['danger' => ''.$product->name. ' dengan ukuran dan bahan yang sama sudah ada dalam pre order cart, maksimal pre order adalah 60']);
                    } else {
                        $cart->update(['quantity' => $quantity]);
                        return redirect('/pre-order-cart')->with(['message' => ''.$product->name. ' dengan ukuran dan bahan yang sama berhasil masuk ke pre order cart.']);
                    }

                // check untuk accessories
                } elseif ($cart->accessories_size != null && $cart->accessories_size_id == $request->accessories_size_id && $cart->material == $request->material) {
                    $quantity = $cart->quantity += $request->quantity;
                    if($quantity > 60){
                        return redirect('/pre-order-cart')->with(['danger' => ''.$product->name. ' dengan ukuran dan bahan yang sama sudah ada dalam pre order cart, maksimal pre order adalah 60']);
                    } else {
                        $cart->update(['quantity' => $quantity]);
                        return redirect('/pre-order-cart')->with(['message' =>''.$product->name. ' dengan ukuran dan bahan yang sama berhasil masuk ke pre order cart.']);
                    }
                }
            }
        }
        $data = [
            'product_id' => $product->id,
            'user_id' => Auth::user()->id,
            'clothing_size_id' => $request->clothing_size_id,
            'accessories_size_id' => $request->accessories_size_id,
            'quantity' => $request->quantity,
            'description' => 'pre-order',
            'material' => $request->material
        ];
        Cart::create($data);
        return redirect('/pre-order-cart')->with(['message' => 'Produk '.$product->name. ' berhasil masuk ke pre order cart.']);      
    }

    public function update(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);
        $carts = Cart::where('user_id', Auth::user()->id)->where('description', 'pre-order')->latest()->get();
        $carts_quantity = $carts->sum('quantity');
        $total_quantity = $carts_quantity + $request->tambah; 

        // check jika quantity sudah 60
        if($total_quantity > 60 ){
            return redirect('/pre-order-cart')->with(['danger' => 'Jumlah pre order cart sudah 60, maksimal pre order dalam sekali pemesanan adalah 60']);
        }
        // tambah
        if($request->tambah)
        {
            if($cart->quantity == 60){
                return redirect()->back()->with(['danger' => 'Maksimal pre order ' .$cart->product->name. ' adalah 60']);
            } else {
                // tambah quantity
                $cart->quantity += $request->tambah;
                $cart->save();
                return redirect('/pre-order-cart')->with(['message' => 'Jumlah ' .$cart->product->name. ' berhasil ditambah']);
            }
            
        } else 
        // kurang
        {
            if($cart->quantity == 20){
                return redirect()->back()->with(['danger' => 'Minimal pre order ' .$cart->product->name. ' adalah 20']);
            } else { 
                // kurang quantity
                $cart->quantity -= $request->kurang;
                $cart->save();
                return redirect('/pre-order-cart')->with(['message' => 'Jumlah ' .$cart->product->name. ' berhasil dikurang']);
            }
        }
    }

    public function destroy($id) 
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();
        return redirect('/pre-order-cart')->with(['message' => 'Pre order cart berhasil dihapus']);
    } 

    public function show($id)
    {
        // 
    }
}
