<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccessoriesSize;
use App\Models\Category;
use App\Models\Product;

class AccessoriesSizeController extends Controller
{
    public function index()
    {
        $accessories_sizes = AccessoriesSize::all();
        return view('pages.admin.accessories-size.index', ['accessories_sizes' => $accessories_sizes]);
    }

    public function create()
    {
        $categories = Category::where('main_category', 'aksesoris')->get('id')->toArray();
        $products = Product::whereIn('category_id', $categories)->get();
        return view('pages.admin.accessories-size.create', ['products' => $products]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        AccessoriesSize::create($data);
        return redirect()->route('accessories-size.index')->with(['message' => 'Ukuran Aksesoris berhasil ditambah']);
    }

    public function edit($id)
    {
        $accessories_size = AccessoriesSize::findOrFail($id);
        $categories = Category::where('main_category', 'aksesoris')->get('id')->toArray();
        $products = Product::whereIn('category_id', $categories)->get();
        return view('pages.admin.accessories-size.edit', ['products' => $products, 'accessories_size' => $accessories_size]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $accessories_size = AccessoriesSize::findOrFail($id);
        $accessories_size->update($data);
        return redirect()->route('accessories-size.index')->with(['message' => 'Ukuran Aksesoris berhasil diedit']);
    }

    public function destroy($id)
    {
        $accessories_size = AccessoriesSize::findOrFail($id);
        $accessories_size->delete();
        return redirect()->route('accessories-size.index')->with(['message' => 'Ukuran Aksesoris berhasil dihapus']);
    }
}
