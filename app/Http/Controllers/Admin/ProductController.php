<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('pages.admin.product.index', ['products' => $products]);
    }

    public function create()
    {
        $categories = Category::all();
        return view('pages.admin.product.create', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $product = Product::create($data);

        foreach ($request->file('photos') as $photo) {
            ProductGallery::create([
                'product_id' => $product->id,
                'photo' => $photo->store('products', 'public')
            ]);
        }
        return redirect()->route('product.index')->with(['message' => 'Produk berhasil ditambah']);
    }

    public function edit($id)
    {
        $categories = Category::all();
        $product = Product::findOrFail($id);
        return view('pages.admin.product.edit', [
            'product' => $product, 
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $product = Product::findOrFail($id);
        $product->update($data);
        return redirect()->route('product.index')->with(['message' => 'Produk berhasil diedit']);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('product.index')->with(['message' => 'Produk berhasil dihapus']);
    }
}
