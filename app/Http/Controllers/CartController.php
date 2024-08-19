<?php

namespace App\Http\Controllers;

use  App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\ClothingStock;
use App\Models\AccessoriesStock;

class CartController extends Controller
{ 
    public function index()
    {
        $carts = Cart::where('user_id', Auth::user()->id)->where('description', '-')->latest()->get(); 
        $weightTotal = 0;

        foreach($carts as $cart)
        {
            $weightTotal += $cart->product->weight * $cart->quantity;
        }
        return view('pages.cart', ['carts' => $carts, 'weightTotal' => $weightTotal]);
    }

    public function store(Request $request)
    {
        if($request->clothing_size_id) {
            $clothing_stock = ClothingStock::where('clothing_size_id', $request->clothing_size_id)->first();            
            if($request->quantity > $clothing_stock->stock){
                return redirect()->back()->with(['message' => 'Maaf, jumlah yang anda masukkan melebihi stok']);
            }
            // update stok
            $clothing_stock->stock -= $request->quantity;
            $clothing_stock->save();
        } else {
            $accessories_stock = AccessoriesStock::where('accessories_size_id', $request->accessories_size_id)->first();
            if($request->quantity > $accessories_stock->stock){
                return redirect()->back()->with(['message' => 'Maaf, jumlah yang anda masukkan melebihi stok']);
            }
            // update stok
            $accessories_stock->stock -= $request->quantity;
            $accessories_stock->save();
        }

        $product = Product::find($request->product_id);
        $carts = Cart::where('user_id', Auth::user()->id)->where('description', '-')->latest()->get();
 
        // check jika produk dan size yang sama sudah ada di cart
        if($carts){
            foreach($carts as $cart)
            {
                // check untuk clothing
                if($cart->clothing_size != null && $cart->clothing_size_id == $request->clothing_size_id){
                    $quantity = $cart->quantity += $request->quantity;
                    $cart->update(['quantity' => $quantity]);
                    return redirect('/cart')->with(['message' => ''.$product->name.' dengan ukuran yang sama berhasil masuk ke cart']);

                // check untuk accessories
                } elseif ($cart->accessories_size != null && $cart->accessories_size_id == $request->accessories_size_id) {
                    $quantity = $cart->quantity += $request->quantity;
                    $cart->update(['quantity' => $quantity]);
                    return redirect('/cart')->with(['message' => ''.$product->name.' dengan ukuran yang sama berhasil masuk ke cart']);
                }
            }
        }

        $data = [
            'product_id' => $request->product_id,
            'user_id' => Auth::user()->id,
            'clothing_size_id' => $request->clothing_size_id,
            'accessories_size_id' => $request->accessories_size_id,
            'quantity' => $request->quantity,
            'description' => '-',
            'material' => $product->material
        ];
        Cart::create($data);
        return redirect('/cart')->with(['message' => 'Produk '.$product->name.' berhasil masuk ke cart']);          
    }

    public function update(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);
        // tambah
        if($request->tambah)
        {
            if($cart->clothing_size_id != null){
                $clothing_stock = ClothingStock::where('clothing_size_id', $cart->clothing_size_id)->first();
                if($clothing_stock->stock == 0){
                    return redirect()->back()->with(['danger' => 'Stok ' .$cart->product->name. ' tidak cukup untuk tambah']);
                } else {
                    // tambah quantity
                    $cart->quantity += $request->tambah;
                    $cart->save();
                    // update stok
                    $clothing_stock->stock -= $request->tambah;
                    $clothing_stock->save();
                }
            } else {
                $accessories_stock = AccessoriesStock::where('accessories_size_id', $cart->accessories_size_id)->first();
                if($accessories_stock->stock == 0){
                    return redirect()->back()->with(['danger' => 'Stok ' .$cart->product->name. ' tidak cukup untuk tambah']);
                } else {
                    // tambah quantity
                    $cart->quantity += $request->tambah;
                    $cart->save();
                    // update stok
                    $accessories_stock->stock -= $request->tambah;
                    $accessories_stock->save();
                }
            }
            return redirect('/cart')->with(['message' => 'Jumlah ' .$cart->product->name. ' berhasil ditambah']);
            
        } else 
        // kurang
        {
            if($cart->quantity == 1){
                return redirect()->back()->with(['danger' => 'Jumlah ' .$cart->product->name. ' tidak bisa dikurangi']);
            }
            if($cart->clothing_size_id != null){
                $clothing_stock = ClothingStock::where('clothing_size_id', $cart->clothing_size_id)->first();
                // kurang quantity
                $cart->quantity -= $request->kurang;
                $cart->save();
                // update stok
                    $clothing_stock->stock += $request->kurang;
                    $clothing_stock->save();
            } else {
                $accessories_stock = AccessoriesStock::where('accessories_size_id', $cart->accessories_size_id)->first();
                // kurang quantity
                $cart->quantity -= $request->kurang;
                $cart->save();
                // update stok
                $accessories_stock->stock += $request->kurang;
                $accessories_stock->save();
            }
            return redirect('/cart')->with(['message' => 'Jumlah ' .$cart->product->name. ' berhasil dikurang']);
        }
    }

    public function destroy($id) 
    {
        $cart = Cart::findOrFail($id);
        if($cart->clothing_size_id != null){
            $clothing_stock = ClothingStock::where('clothing_size_id', $cart->clothing_size_id)->first();
            // update stok
            $clothing_stock->stock += $cart->quantity;
            $clothing_stock->save();
        } else {
            $accessories_stock = AccessoriesStock::where('accessories_size_id', $cart->accessories_size_id)->first();
            // update stok
            $accessories_stock->stock += $cart->quantity;
            $accessories_stock->save();
        }
        $cart->delete();
        return redirect('/cart')->with(['message' => 'Cart ' .$cart->product->name. ' berhasil dihapus']); 
    }    

    public function show($id)
    {
        // 
    }
}
 