<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccessoriesStock;
use App\Models\AccessoriesSize;

class AccessoriesStockController extends Controller
{
    public function index()
    {
        $accessories_stocks = AccessoriesStock::all();
        return view('pages.admin.accessories-stock.index', ['accessories_stocks' => $accessories_stocks]);
    }

    public function create()
    {
        $accessories_stock_id = AccessoriesStock::get('accessories_size_id')->toArray();
        $accessories_sizes = AccessoriesSize::whereNotIn('id', $accessories_stock_id)->get();
        return view('pages.admin.accessories-stock.create', ['accessories_sizes' => $accessories_sizes]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        AccessoriesStock::create($data);
        return redirect()->route('accessories-stock.index')->with(['message' => 'Stok Aksesoris baru berhasil ditambah']);
    }

    public function edit($id)
    {
        $accessories_stock = AccessoriesStock::findOrFail($id);
        return view('pages.admin.accessories-stock.edit', ['accessories_stock' => $accessories_stock]);
    }

    public function update(Request $request, $id)
    {
        $accessories_stock = AccessoriesStock::findOrFail($id);
        $accessories_stock->stock += $request->stock; 
        $accessories_stock->accessories_size_id = $request->accessories_size_id;
        $accessories_stock->save();
        return redirect()->route('accessories-stock.index')->with(['message' => 'Stok Aksesoris berhasil ditambah']);
    }

    public function destroy($id)
    {
        $accessories_stock = AccessoriesStock::findOrFail($id);
        $accessories_stock->delete();
        return redirect()->route('accessories-stock.index')->with(['message' => 'Stok Aksesoris berhasil dihapus']);
    }
}
