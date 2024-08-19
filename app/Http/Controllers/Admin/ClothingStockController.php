<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ClothingStock;
use App\Models\ClothingSize;

class ClothingStockController extends Controller
{
    public function index()
    { 
        $clothing_stocks = ClothingStock::all();
        return view('pages.admin.clothing-stock.index', ['clothing_stocks' => $clothing_stocks]);
    }

    public function create()
    {
        $clothing_stock_id = ClothingStock::get('clothing_size_id')->toArray();
        $clothing_sizes = ClothingSize::whereNotIn('id', $clothing_stock_id)->get();
        return view('pages.admin.clothing-stock.create', ['clothing_sizes' => $clothing_sizes]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        ClothingStock::create($data);
        return redirect()->route('clothing-stock.index')->with(['message' => 'Stok pakaian baru berhasil ditambah']);
    }

    public function edit($id)
    {
        $clothing_stock = ClothingStock::findOrFail($id);
        return view('pages.admin.clothing-stock.edit', ['clothing_stock' => $clothing_stock]);
    }

    public function update(Request $request, $id)
    {
        $clothing_stock = ClothingStock::findOrFail($id);
        $clothing_stock->stock += $request->stock; 
        $clothing_stock->clothing_size_id = $request->clothing_size_id;
        $clothing_stock->save();
        return redirect()->route('clothing-stock.index')->with(['message' => 'Stok pakaian berhasil ditambah']);
    }

    public function destroy($id)
    {
        $clothing_stock = ClothingStock::findOrFail($id);
        $clothing_stock->delete();
        return redirect()->route('clothing-stock.index')->with(['message' => 'Stok pakaian berhasil dihapus']);
    }

}
