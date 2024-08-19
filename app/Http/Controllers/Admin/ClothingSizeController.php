<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClothingSize;
use App\Models\Product;

class ClothingSizeController extends Controller
{
    public function index()
    {
        $clothing_sizes = ClothingSize::all();
        return view('pages.admin.clothing-size.index', ['clothing_sizes' => $clothing_sizes]);
    }

    public function create()
    {
        $products = Product::all();
        return view('pages.admin.clothing-size.create', ['products' => $products]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        ClothingSize::create($data);
        return redirect()->route('clothing-size.index')->with(['message' => 'Ukuran Pakaian berhasil ditambah']);
    }

    public function edit($id)
    {
        $clothing_size = ClothingSize::findOrFail($id);
        $products = Product::all();
        return view('pages.admin.clothing-size.edit', ['products' => $products, 'clothing_size' => $clothing_size]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $clothing_size = ClothingSize::findOrFail($id);
        $clothing_size->update($data);
        return redirect()->route('clothing-size.index')->with(['message' => 'Ukuran Pakaian berhasil diedit']);
    }

    public function destroy($id)
    {
        $clothing_size = ClothingSize::findOrFail($id);
        $clothing_size->delete();
        return redirect()->route('clothing-size.index')->with(['message' => 'Ukuran Pakaian berhasil dihapus']);
    }

}
